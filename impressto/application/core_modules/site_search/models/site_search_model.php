<?php

class site_search_model extends MY_Model{



	/**
	* returns a filtered list of all content that is currently indexed
	* @param array
	* @return $array 
	*
	*/  
	function get_indexed_content_list($filters){  
		
		
		if(!isset($filters['lang'])) $filters['lang'] = "en";

		if(!isset($filters['return_fields'])) $filters['return_fields'] = null;
		
	
	
		$return_array = array();

		$sql = "SELECT ";
			
		if($filters['return_fields']){
		
			$sql .= implode(", ", $filters['return_fields']);
		 		
		}else{
		
		 $sql .= " * ";
		 
		}
		
		$sql .= " FROM {$this->db->dbprefix}searchindex_{$filters['lang']} AS SINDEX ORDER BY  SINDEX.updated ";
		
		
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			
			foreach ($query->result() as $row)
			{
				
				$this_record = array();
				
				if($filters['return_fields']){
				
					foreach($filters['return_fields'] AS $val){
					
						$this_record[$val] = $row->$val;
					}
				
				
				}else{
				
					$this_record['title'] = $row->title;
					$this_record['content_id'] = $row->content_id;
					$this_record['content_module'] =  $row->content_module;
					$this_record['content'] =  $row->content;
					$this_record['contentlength'] =  $row->contentlength;
					$this_record['expiration'] =  $row->expiration;
					$this_record['updated'] =  $row->updated;
					
				}
				
				$return_array[] = $this_record;
			}
		} 
		
		
		return $return_array;
		
		
		
	}


	/**
	* Select a single record if it exists and return the attributes as an array
	* @param string content_type
	* @param string content_id
	* @return array on success, bool false on fail
	* @since 2.10
	*
	*/
	public function get_search_record($content_id, $content_module, $lang){
			
		$sql = "SELECT id, title, priority, change_frequency, slug, expiration, updated, contentlength ";
		$sql .= " FROM {$this->db->dbprefix}searchindex_{$lang} WHERE content_module = '{$content_module}' AND content_id = '{$content_id}' ";
						
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) return $query->row_array(); 
		else return FALSE;
		
		
				
	}
	
	
	/**
	* get an array of all the modules that are currently classied
	* as searchable 
	*
	*/	
	public function get_active_content_types(){
		
		$return_array = array();
		
		$this->load->helper('language');
		
		
		$query = $this->db->get_where('modules', array('searchable' => 'Y'));
		
		if ($query->num_rows() > 0)
		{
			
			foreach ($query->result() as $row)
			{
				
				$name = $row->name;
				
				// this trick came form the bonfire guy. It deos not take much to impress me
				$file_path = $name . "/" . $name;
				
				$this->load->language($file_path);  

				
				$label = lang($name . '_label');
				
				if($label == "") $label = $name;
				
				$return_array[$label] = $name;
				
			}
			
		} 
		
		
		return $return_array;
		
		
		
		
	}
	
	
	
	/**
	* process the actual search and return 
	*
	* DEV NOTES: Make sure the title and content field have separate Fulltext indexes
	* in the DB table and make sure the DB table is using the MyISAM engine of FULLTEXT will not work
	*/	
	function get_search_results($data){ 
		
		$this->load->helper('text');
		
		
		$return_array = array(
		
		'numrecords' => 0,
		'records' => array(),
		
		);
		
		
		$keyterms = isset($data['keyterms']) ? $data['keyterms'] : "";
		$page = isset($data['page']) ? $data['page'] : 1;
		$listings_per_page = (isset($data['listings_per_page']) && $data['listings_per_page'] > 0) ? $data['listings_per_page'] : 10;
		$traillength = (isset($data['traillength']) && $data['traillength'] > 0) ? $data['traillength'] : 50;
		
		
		$content_filters = $data['content_filters'];
		
		
		$booleanseach = (isset($data['booleanseach']) && $data['booleanseach']) ? TRUE : FALSE;
		
		
		$lang = isset($data['lang']) ? $data['lang'] : "en";
		
		// purge the key terms here
		$passed_terms = array();
		
		foreach($keyterms as $val){
			
			$val = trim($val);
			
			if($val != ""){
				
				$passed_terms[] = $val;
				
			}
			
		}
		
		

		$searchindex_table = "{$this->db->dbprefix}searchindex_{$lang}";
		
		$conditional = 	"WHERE ";
		
		$conditional .=  " ( MATCH (title) AGAINST (";
		
		if($booleanseach) $conditional .= "'+" . implode(" +",$passed_terms) . "' IN BOOLEAN MODE)"; 
		else  $conditional .= "'" . implode(" ",$passed_terms) . "' IN BOOLEAN MODE)"; // always in boolean mode of #$%$ FULLTEXT search does not work
		
		$conditional .=  " OR MATCH (content) AGAINST (";
		
		if($booleanseach) $conditional .= "'+" . implode(" +",$passed_terms) . "' IN BOOLEAN MODE)";
		else  $conditional .= "'" . implode(" ",$passed_terms) . "' IN BOOLEAN MODE)"; // always in boolean mode of #$%$ FULLTEXT search does not work
		
		
		$conditional .= "  ) ";
		
		
		if(count($content_filters) > 0){
			
			$conditional .= " AND ";
			
			$conditional .= "( content_module='";
			
			$conditional .= implode("' OR content_module='",$content_filters) . "'";
			
			$conditional .= " ) ";
			
		}
		
		
		$relmatch[] = " MATCH (title) AGAINST ('+" . implode(" +",$passed_terms) . "' IN BOOLEAN MODE) AS rel1 ";
		$relmatch[] = " MATCH (content) AGAINST ('+" . implode(" +",$passed_terms) . "' IN BOOLEAN MODE) AS rel2 ";
		
		$sql = "SELECT COUNT(*) AS numrecords, " . implode(", ", $relmatch) . " FROM {$searchindex_table} {$conditional} ";
		
		$query = $this->db->query($sql);
		

		
		$row = $this->site_search_model->fetch_row($query);
		
		$return_array['numrecords'] = $row['numrecords'];
		$return_array['count_from'] = (($page -1) * $listings_per_page) + 1;
		$return_array['count_to'] = (($page -1) * $listings_per_page) + $listings_per_page;
		if($return_array['count_to'] > $return_array['numrecords']) $return_array['count_to'] = $return_array['numrecords'];
		
		
		$sql = "SELECT *, " . implode(", ", $relmatch) . " FROM {$searchindex_table} {$conditional} ";
		
		$sql .= " ORDER BY (rel1*1.5)+(rel2) DESC  ";
		
		$sql .= " LIMIT ".(($page -1) * $listings_per_page).",$listings_per_page";
		

			
		
		$query = $this->db->query($sql);
	
	
		
		if ($query->num_rows() > 0){
		
				
			foreach ($query->result() as $row)
			{
			
			
	
			
				
				$rowdata = array();
				
				$rowdata['title'] = $row->title;
				$rowdata['content_module'] = $row->content_module;
				$rowdata['content_id'] = $row->content_id;
				$rowdata['expiration'] = $row->expiration;
				$rowdata['contentlength'] = $row->contentlength;
				$rowdata['updated'] = $this->_timeinttowords($row->updated);
				$rowdata['lang'] = $lang;
			

				// this was intended to obtain the correc url for the page based on the module looks incomplete. What was the plan?
				
				$search_module_url[$rowdata['content_module']]  = modules::run("{$rowdata['content_module']}/search_module_url",$rowdata);
			
										
				
				$rowdata['tags'] = $this->get_search_tags($row->content_id, $row->content_module, $lang);
				

			
					
				
				$rowdata['source_url'] = $search_module_url[$rowdata['content_module']];
				
				// the search may just be returning a title match so nothing would therefore highlight
				foreach($passed_terms as $term){

					
					$keypos = stripos($row->content, $term);
					
					if($keypos !== false){
						
						$rowdata['content'] = $this->_pad_search_result($row->content, $term, $keypos, $traillength);
						break;
						
					}
					
				}
				
				if(!isset($rowdata['content']) || $rowdata['content'] == "") $rowdata['content'] = $row->content;
				
				

				foreach($passed_terms as $term){
					
					$rowdata['title'] = highlight_phrase($rowdata['title'], $term, '<span class="site_search_highlight">', '</span>'); 
					$rowdata['content'] = highlight_phrase($rowdata['content'], $term, '<span class="site_search_highlight">', '</span>'); 
					
				}
				
				
				
				
				
				
				$return_array['records'][] = $rowdata;
				
			}
			
		}
		
		
		
		return $return_array;
		
		
	}
	
	
	
	
	
	/**
	* process the tags search 
	*
	*/	
	function get_tag_results($data){ 
		
		$this->load->helper('text');

		$searchindex_table = "{$this->db->dbprefix}searchindex_{$data['lang']}";
		$searchtags_table = "{$this->db->dbprefix}searchtags_{$data['lang']}";
		$searchtags_bridge_table = "{$this->db->dbprefix}searchtags_bridge_{$data['lang']}";
		
		
		$return_array = array(
		
		'numrecords' => 0,
		'records' => array(),
		
		);
		
		
		$tag = isset($data['tag']) ? $data['tag'] : "";
		$page = isset($data['page']) ? $data['page'] : 1;
		$listings_per_page = (isset($data['listings_per_page']) && $data['listings_per_page'] > 0) ? $data['listings_per_page'] : 10;
		$traillength = (isset($data['traillength']) && $data['traillength'] > 0) ? $data['traillength'] : 50;
		
		
		
		$content_filters = $data['content_filters'];
		

		$lang = isset($data['lang']) ? $data['lang'] : "en";

		// need to get all the page ids and content types that match the tag, then obtain the matching records from the search table
		
		$selectfieldssql = "SELECT DISTINCT(searchindex.id) AS numrecords ";

	
		$selectfromsql = " FROM {$searchtags_bridge_table} AS searchtags_bridge JOIN {$searchindex_table} AS searchindex 
		ON (searchindex.content_id = searchtags_bridge.content_id AND searchindex.content_module = searchtags_bridge.content_module)
		JOIN {$searchtags_table} AS searchtags ON searchtags.id = searchtags_bridge.tag_id ";
	
		
		$conditionsql = " WHERE searchtags.tag = '{$tag}'";

		$groupbysql = " GROUP BY searchindex.id ";
		
		
		if(count($content_filters) > 0){
			
			$conditionsql .= " AND ";
			
			$conditionsql .= "( searchindex.content_module='";
			
			$conditionsql .= implode("' OR searchindex.content_module='",$content_filters) . "'";
			
			$conditionsql .= " ) ";
			
		}
		

		$sql = $selectfieldssql . $selectfromsql . $conditionsql . $groupbysql;

		
		$return_array['numrecords'] = $this->db->query($sql)->num_rows();

		$return_array['count_from'] = (($page -1) * $listings_per_page) + 1;
		$return_array['count_to'] = (($page -1) * $listings_per_page) + $listings_per_page;
		if($return_array['count_to'] > $return_array['numrecords']) $return_array['count_to'] = $return_array['numrecords'];
		

		
		$selectfieldssql = "SELECT searchindex.* ";
				
		
		$limitsql = " LIMIT ".(($page -1) * $listings_per_page).",$listings_per_page";

		
		$query = $this->db->query($selectfieldssql . $selectfromsql . $conditionsql . $groupbysql . $limitsql );
		
		
		
		if ($query->num_rows() > 0){

			
			foreach ($query->result() as $row)
			{
				
				$rowdata = array();
				
				$rowdata['title'] = $row->title;
				$rowdata['content_module'] = $row->content_module;
				$rowdata['content_id'] = $row->content_id;
				$rowdata['expiration'] = $row->expiration;
				$rowdata['contentlength'] = $row->contentlength;
				$rowdata['updated'] = $this->_timeinttowords($row->updated);
				$rowdata['lang'] = $lang;
				
				
				$search_module_url[$rowdata['content_module']] = modules::run("{$rowdata['content_module']}/search_module_url",$rowdata);
				
				$rowdata['tags'] = $this->get_search_tags($row->content_id, $row->content_module, $lang);
				

				
				$rowdata['source_url'] = $search_module_url[$rowdata['content_module']];
				
				if(!isset($rowdata['content']) || $rowdata['content'] == "") $rowdata['content'] = $row->content;
				
				
				$words = explode(" ",$rowdata['content']);
				$rowdata['content'] = implode(" ",array_splice($words,0,($traillength + 1)));
				
				
				

				
				
				
				
				
				$return_array['records'][] = $rowdata;
				
			}
			
		}

		
		
		return $return_array;
		
		
	}
	
	
	/**
	* Simply retrieves the tags for the selected item
	* @param integer - content_id
	* @param string - content_module
	* @param string - lang
	* @return array
	*/
	public function get_search_tags($content_id, $content_module, $lang){
		
		$return_array = array();
		
		$sql = "SELECT tag FROM {$this->db->dbprefix}searchtags_bridge_{$lang} AS bridgetable 
		LEFT JOIN {$this->db->dbprefix}searchtags_{$lang} AS tagtable ON bridgetable.tag_id = tagtable.id 
		WHERE bridgetable.content_module = '{$content_module}' AND bridgetable.content_id = '{$content_id}' ";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row){
				
				$return_array[] = $row->tag;
			}	
		} 
		
		return $return_array;

		
	}

	/**
* reduce the leading and trailing portions of search result excerpts
* @author - peterdrinnan
* @param string $input text to trim
* @param string $term test that is being highlighted
* @param int $keypos location of found term in string
* @param int $traillength how far to trim front and back
* @param bool $strip_html if html tags are to be stripped
* @return string
*/
	private function _pad_search_result($input, $term, $keypos, $traillength = 20, $strip_html = true) {

		if ($strip_html)  $input = strip_tags($input);
		
		if($keypos > $traillength) $startpos = ($keypos - $traillength);
		else $startpos = 0;
		
		if($startpos > 0){
			$leading_string = substr($input, $startpos, ($keypos - $startpos) );
			$leading_string = "..." . substr($leading_string, strpos($leading_string, ' '));
		}else{
			$leading_string = substr($input, 0, $keypos);
		}
		
		if(($keypos + $traillength) < strlen($input)){
			$trailing_string = substr($input, $keypos + strlen($term), ($keypos + strlen($term) + $traillength));
			$trailing_string = substr($trailing_string, 0, strrpos($trailing_string, ' ')) . "...";
		}else{
			$trailing_string = substr($input, $keypos + strlen($term));
		}
		
		return $leading_string . $term . $trailing_string;
		
		
	}


	
	
	private function _timeinttowords($timeint){


		
		$this_year = substr($timeint,0,4);
		$this_month = substr($timeint,4,2);
		$this_day = substr($timeint,6,2);
		$this_hour = substr($timeint,8,2);
		$this_minute = substr($timeint,10,2);
		
		$months = $this->lang->line('months');
		
		//print_r($months);
		
		
		return 	$months[($this_month * 1)]. " " . $this_day . " " . $this_year . "  " . $this_hour . ":" . $this_minute;
		


	}
	

	
	
} //end class











