<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news_model extends My_Model{



	public function get_archived_items($keywords = '', $tag = '', $page = 1, $limit = NULL){
	
		$data = array(
			'keywords' =>  $keywords,
			'tag' =>  $tag,
			'page' => $page,
			'limit' => $limit,
			'filter' => array('archived' =>1),
		);
				
		return $this->select_news_items($data);
		
	}
	

	public function get_news_items($keywords = '', $tag = '', $page = 1, $limit = NULL){
	
	
		$data = array(
			'keywords' =>  $keywords,
			'tag' =>  $tag,
			'page' => $page,
			'limit' => $limit,
			'filter' => array('archived' =>0),
		);
				
		return $this->select_news_items($data);
	
	}
	
	/**
	* list or search the news table and return all relevant records
	* NOTE: This function will be replaced by the generic
	* PageShaper search function once that is complete 
	*
	*/
	private function select_news_items($data){ 
	
		$lang_avail = $this->config->item('lang_avail');
			
		$keywords = $data['keywords'];
		$tag = $data['tag'];
				
		$page = $data['page'];
		$limit = $data['limit'];
		
		if(isset($data['filter']) && is_array($data['filter'])) $sqlfilter = $data['filter'];
		else $sqlfilter = NULL;
				

		$this->load->model('tags/tags_model');
		
		
				
		$limitedrecords = array();
		
		$totalrowcount = 0;
		
		// need to get the language we're calling 
		$lang_selected = $this->config->item('lang_selected');
		

		if($keywords != ""){  // if keywords it's a new ballgame. We will use a join with the search index table
			
			$searchindex_table = $this->db->dbprefix . 'searchindex_' . $lang_selected;
			$newstable = $this->db->dbprefix . 'news';
			
			$booleankeywords = preg_replace('/(\S+)/', '+$1*', $this->stripand($keywords));
			
	
			$sql = "SELECT COUNT(*) AS numRecs FROM {$searchindex_table} AS SEARCHTABLE ";
			$sql .= " LEFT JOIN $newstable AS NEWSTABLE ON NEWSTABLE.news_id = SEARCHTABLE.content_id ";
			$sql .= " WHERE SEARCHTABLE.content_module = 'news' ";
			$sql .= " AND MATCH (SEARCHTABLE.title, SEARCHTABLE.content) AGAINST ('{$booleankeywords}' IN BOOLEAN MODE) AND NEWSTABLE.active = '1'";
			
			if($sqlfilter){
				
				foreach($sqlfilter as $key => $val){
				
					$sql .= " AND  NEWSTABLE.{$key} =  '{$val}'";
				
				}
			}
			
			$sql .= ";";
					
			
			$query = $this->db->query($sql);

			
			if ($query->num_rows() > 0){
				
				$row = $query->row();
				$totalrowcount = $row->numRecs;
				
	
				
				// Now get the actual records we are going to show
				$sql = "SELECT NEWSTABLE.* FROM {$searchindex_table} AS SEARCHTABLE ";
				$sql .= " LEFT JOIN $newstable AS NEWSTABLE ON NEWSTABLE.news_id = SEARCHTABLE.content_id ";
				$sql .= " WHERE content_module = 'news' AND MATCH (title, content) AGAINST ('{$booleankeywords}' IN BOOLEAN MODE) AND NEWSTABLE.active = '1' ";

				if($sqlfilter){
				
					foreach($sqlfilter AS $key => $val){
				
						$sql .= " AND  NEWSTABLE.{$key} =  '{$val}'";
				
					}
				}
			
				$sql .= " ORDER BY NEWSTABLE.published ASC";
				
			
				if($limit && $limit > 0){
					
					
					$min = (($page -1) * $limit);
					$max = ($page * $limit);
					
					$sql .= " LIMIT $min, $max";

					
				}

				$query = $this->db->query($sql);
				
			}
			
		}else if($tag != ""){
			
			
					$tags_table = $this->db->dbprefix . 'searchtags_' . $lang_selected;
					$tagbridge_table = $this->db->dbprefix . 'searchtags_bridge_' . $lang_selected;
					$newstable = $this->db->dbprefix . 'news';
					
					$sql = "SELECT COUNT(*) AS numRecs FROM {$tagbridge_table} AS TAGBRIDGE ";
					$sql .= " LEFT JOIN {$newstable} AS NEWSTABLE ON NEWSTABLE.news_id = TAGBRIDGE.content_id ";
					$sql .= " LEFT JOIN {$tags_table} AS TAGS ON TAGBRIDGE.tag_id = TAGS.id ";
					$sql .= " WHERE TAGBRIDGE.content_module = 'admin_news' ";
					$sql .= " AND TAGS.tag = '{$tag}' ";
					$sql .= " AND NEWSTABLE.active = '1'";
					
					if($sqlfilter){
				
						foreach($sqlfilter as $key => $val){
				
							$sql .= " AND  NEWSTABLE.{$key} =  '{$val}'";
				
						}
					}
			
					$sql .= ";";
					
							
					$query = $this->db->query($sql);

			
					if ($query->num_rows() > 0){
				
						$row = $query->row();
						$totalrowcount = $row->numRecs;
				
	
						// Now get the actual records we are going to show
						$sql = "SELECT NEWSTABLE.* FROM {$tagbridge_table} AS TAGBRIDGE ";
						$sql .= " LEFT JOIN {$newstable} AS NEWSTABLE ON NEWSTABLE.news_id = TAGBRIDGE.content_id ";
						$sql .= " LEFT JOIN {$tags_table} AS TAGS ON TAGBRIDGE.tag_id = TAGS.id ";
						$sql .= " WHERE TAGBRIDGE.content_module = 'admin_news' ";
						$sql .= " AND TAGS.tag = '{$tag}' ";
						$sql .= " AND NEWSTABLE.active = '1'";
						
						if($sqlfilter){
				
						foreach($sqlfilter AS $key => $val){
				
							$sql .= " AND  NEWSTABLE.{$key} =  '{$val}'";
				
						}
					}
			
					$sql .= " ORDER BY NEWSTABLE.published ASC";
				
			
					if($limit && $limit > 0){
					
					
						$min = (($page -1) * $limit);
						$max = ($page * $limit);
						
						$sql .= " LIMIT $min, $max";
					
					}

					$query = $this->db->query($sql);
								
			
				
			}else{
				
				return array('totalrowcount' => 0, 'limitedrecords' => array());
								
			}
			
			
			
		}else{
			
			$this->db->where('newstitle_' . $lang_selected . ' !=','');
						
			$this->db->where('active',1);
			
			if($sqlfilter){
				
				foreach($sqlfilter as $key => $val){
				
					$this->db->where($key,$val);
					
				}
			}
			
			
			if($limit && $limit > 0){
				
				//echo "HUH";
				
			
				
				$query = $this->db->get('news');
				
				$totalrowcount = $query->num_rows();

				
				$min = (($page -1) * $limit);
				$max = ($page * $limit);
				
				//$this->db->limit($limit, $max);
				
				$this->db->limit($limit, ($max - $limit));
								
				
	
			}
			
			$this->db->where('active',1);
			
			if($sqlfilter){
				
				foreach($sqlfilter as $key => $val){
				
					$this->db->where($key,$val);
					
				}
			}
			
			
			$this->db->order_by('published', "asc"); 
			$query = $this->db->get('news');
			
			//echo $this->db->last_query();
			
			
		}
		
		

		
		if($totalrowcount == 0) $totalrowcount = $query->num_rows();
		
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result_array() as $row){
				
				$record_array = array();
				
				$record_array['news_id'] = $row['news_id'];
				
				$record_array['newstitle'] = $row['newstitle_' . $lang_selected];
				$record_array['newsshortdescription'] = $row['newsshortdescription_' . $lang_selected];
				$record_array['newscontent'] = $row['newscontent_' . $lang_selected];
				$record_array['newslink'] = $row['newslink_' . $lang_selected];
				$record_array['active'] = $row['active'];
				$record_array['opennewwindow'] = $row['opennewwindow'];
				$record_array['added'] = $row['added'];
				$record_array['modified'] = $row['modified'];
				$record_array['published'] = $row['published'];
				
					
						
				foreach($lang_avail AS $langcode=>$language){ 
				
					${"tags_" . $langcode} = $this->tags_model->get_tags($langcode, 'admin_news', $row['news_id']);
					
					
					if(${"tags_".$langcode}) $record_array['news_tags_'.$langcode] = implode(",", ${"tags_" .$langcode});
					else $record_array['news_tags_'.$langcode] = "";
				}
				
				
			
		
				

			
								
				$limitedrecords[] = $record_array;
				
				
				
				
			}
			
		}
		
		//echo $this->db->last_query();
		

		return array('totalrowcount' => $totalrowcount, 'limitedrecords' => $limitedrecords);
		
		
		
	}
	
	
	
	
	/**
	* Return a single record for display
	*
	*/
	function get_news_item($news_id){
	
	
		$lang_avail = $this->config->item('lang_avail');
		
		
		$this->load->model('tags/tags_model');
			
			
		
		$record_array = array();
		
		// need to get the language we're calling 
		$lang_selected = $this->config->item('lang_selected');
		
		$query = $this->db->get_where('news', array('news_id' => $news_id, 'active' => 1));
		
		if ($query->num_rows() > 0){
			
			$row = $query->row_array(); 
			
			$record_array['news_id'] = $row['news_id'];
			$record_array['newstitle'] = $row['newstitle_' . $lang_selected];
			$record_array['newsshortdescription'] = $row['newsshortdescription_' . $lang_selected];
			$record_array['newscontent'] = $row['newscontent_' . $lang_selected];
			$record_array['newslink'] = $row['newslink_' . $lang_selected];
			$record_array['active'] = $row['active'];
			$record_array['opennewwindow'] = $row['opennewwindow'];
			$record_array['added'] = $row['added'];
			$record_array['modified'] = $row['modified'];
			$record_array['published'] = $row['published'];
			
			
			foreach($lang_avail AS $langcode=>$language){ 
				
				${"tags_" . $langcode} = $this->tags_model->get_tags($langcode, 'admin_news', $row['news_id']);
				
					
						
				if(${"tags_".$langcode}) $record_array['news_tags_'.$langcode] = implode(",", ${"tags_" .$langcode});
				else $record_array['news_tags_'.$langcode] = "";
			}
				
			
				

		}
		
		
		

		return $record_array;

	}
	
	/**
	*
	*
	*/
	function stripand($inputtext){
		
		$chars_match =   array(' and ');
		$chars_replace = array(' ');
		for ($i = 0; $i < count($chars_match); $i++) {

			$inputtext = preg_replace('/{$chars_match[$i]}/',$chars_replace[$i],$inputtext); 
			
		}
		
		
		return $inputtext;
		
		
	}///////////////
	
	


	
	
} //end class











