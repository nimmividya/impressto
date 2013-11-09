<?php

class blog_model extends My_Model{


	public function get_archived_items($keywords = '', $tag = '', $page = 1, $limit = NULL){
	
		$data = array(
			'keywords' =>  $keywords,
			'tag' =>  $tag,
			'page' => $page,
			'limit' => $limit,
			'filter' => array('archived' =>1),
		);
				
		return $this->select_items($data);
		
	}
	

	public function get_active_items($keywords = '', $tag = '', $page = 1, $limit = NULL){
	
		$data = array(
			'keywords' =>  $keywords,
			'tag' =>  $tag,
			'page' => $page,
			'limit' => $limit,
			'filter' => array('archived' =>0),
		);
				
					
		return $this->select_items($data);
	
	}
	
	

	/**
	* list or search the blog table and return all relevant records
	* NOTE: This function will be replaced by the generic
	* PageShaper search function once that is complete 
	*
	*/
	private function select_items($data){
		
		$keywords = $data['keywords'];
		$tag = $data['tag'];
				
		$page = $data['page'];
		$limit = $data['limit'];
		
		if(isset($data['filter']) && is_array($data['filter'])) $sqlfilter = $data['filter'];
		else $sqlfilter = NULL;
		
	
		$lang_avail = $this->config->item('lang_avail');
		
		
		
		//$this->load->library('edittools');
		
		$this->load->model('tags/tags_model');
						
				
		$limitedrecords = array();
		
		$totalrowcount = 0;
		
		
	
		// need to get the language we're calling 
		$lang_selected = $this->config->item('lang_selected');
		

		if($keywords != ""){  // if keywords it's a new ballgame. We will use a join with the search index table
			
			$searchindex_table = $this->db->dbprefix . 'searchindex_' . $lang_selected;
			$blogtable = $this->db->dbprefix . 'blog';
			
			$booleankeywords = preg_replace('/(\S+)/', '+$1*', $this->stripand($keywords));
			
	
			$sql = "SELECT COUNT(*) AS numRecs FROM {$searchindex_table} AS SEARCHTABLE ";
			$sql .= " LEFT JOIN $blogtable AS BLOGTABLE ON BLOGTABLE.blog_id = SEARCHTABLE.content_id ";
			$sql .= " WHERE SEARCHTABLE.content_module = 'blog' ";
			$sql .= " AND MATCH (SEARCHTABLE.title, SEARCHTABLE.content) AGAINST ('{$booleankeywords}' IN BOOLEAN MODE) AND BLOGTABLE.active = '1'; ";
			
			if($sqlfilter){
				
				foreach($sqlfilter as $key => $val){
				
					$sql .= " AND  BLOGTABLE.{$key} =  '{$val}'";
				
				}
			}
			
			$sql .= ";";
			

			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0){
				
				$row = $query->row();
				$totalrowcount = $row->numRecs;
				
	
				
				// Now get the actual records we are going to show
				$sql = "SELECT BLOGTABLE.* FROM {$searchindex_table} AS SEARCHTABLE ";
				$sql .= " LEFT JOIN $blogtable AS BLOGTABLE ON BLOGTABLE.blog_id = SEARCHTABLE.content_id ";
				$sql .= " WHERE content_module = 'blog' ";
				$sql .= " AND MATCH (title, content) AGAINST ('{$booleankeywords}' IN BOOLEAN MODE) AND BLOGTABLE.active = '1' ";

				if($sqlfilter){
				
					foreach($sqlfilter AS $key => $val){
				
						$sql .= " AND  NEWSTABLE.{$key} =  '{$val}'";
				
					}
				}

				$sql .= " ORDER BY BLOGTABLE.publish_date_{$lang_selected} ASC";
				
			
				if($limit && $limit > 0){
					
					
					$min = (($page -1) * $limit);
					$max = ($page * $limit);
					
					$sql .= " LIMIT $min, $max";
						
				}

				$query = $this->db->query($sql);

				
			}else{
				
				return array('totalrowcount' => 0, 'limitedrecords' => array());
								
			}
			
			
			
		}else if($tag != ""){
		
		
			$tags_table = $this->db->dbprefix . 'searchtags_' . $lang_selected;
			$tagbridge_table = $this->db->dbprefix . 'searchtags_bridge_' . $lang_selected;
			
			$blogtable = $this->db->dbprefix . 'blog';
			
			$sql = "SELECT COUNT(*) AS numRecs FROM {$tagbridge_table} AS TAGBRIDGE ";
				$sql .= " LEFT JOIN {$blogtable} AS BLOGTABLE ON BLOGTABLE.blog_id = TAGBRIDGE.content_id ";
					$sql .= " LEFT JOIN {$tags_table} AS TAGS ON TAGBRIDGE.tag_id = TAGS.id ";
					$sql .= " WHERE TAGBRIDGE.content_module = 'admin_blog' ";
					$sql .= " AND TAGS.tag = '{$tag}' ";
					$sql .= " AND BLOGTABLE.active = '1'";
					
					if($sqlfilter){
				
						foreach($sqlfilter as $key => $val){
				
							$sql .= " AND  BLOGTABLE.{$key} =  '{$val}'";
				
						}
					}
			
					$sql .= ";";
					
							
					$query = $this->db->query($sql);

			
					if ($query->num_rows() > 0){
				
						$row = $query->row();
						$totalrowcount = $row->numRecs;
				
	
						// Now get the actual records we are going to show
						$sql = "SELECT BLOGTABLE.* FROM {$tagbridge_table} AS TAGBRIDGE ";
						$sql .= " LEFT JOIN {$blogtable} AS BLOGTABLE ON BLOGTABLE.blog_id = TAGBRIDGE.content_id ";
						$sql .= " LEFT JOIN {$tags_table} AS TAGS ON TAGBRIDGE.tag_id = TAGS.id ";
						$sql .= " WHERE TAGBRIDGE.content_module = 'admin_blog' ";
						$sql .= " AND TAGS.tag = '{$tag}' ";
						$sql .= " AND BLOGTABLE.active = '1'";
						
						if($sqlfilter){
				
						foreach($sqlfilter AS $key => $val){
				
							$sql .= " AND  BLOGTABLE.{$key} =  '{$val}'";
				
						}
					}
			
					$sql .= " ORDER BY BLOGTABLE.published ASC";
				
			
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
			
			
				
			$this->db->where('blogtitle_' . $lang_selected . ' !=','');
			
			$this->db->where('active',1);
			
			if($sqlfilter){
				
				foreach($sqlfilter as $key => $val){
					$this->db->where($key,$val);
				}
			}
		
					
			
			if($limit && $limit > 0){
				
				$query = $this->db->get('blog');
				
				$totalrowcount = $query->num_rows();
				
						
				$min = (($page -1) * $limit);
				$max = ($page * $limit);
		
				// have to redo these after each get
				$this->db->where('blogtitle_' . $lang_selected . ' !=','');
				$this->db->where('active',1);
				$this->db->limit($limit, ($max - $limit));
				
				
			}
			
			//$this->db->where('active',1);
			
			if($sqlfilter){
							
				foreach($sqlfilter as $key => $val){
					$this->db->where($key,$val);
				}
				
			}
			
			
			$this->db->order_by('publish_date_' . $lang_selected, "desc"); 
			$query = $this->db->get('blog');
			
			//echo $this->db->last_query();
			
			
		}
		
		

		
		if($totalrowcount == 0) $totalrowcount = $query->num_rows();
		
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result_array() as $row){
				
				$record_array = array();
				
				$record_array['blog_id'] = $row['blog_id'];
				
				$record_array['blogtitle'] = $row['blogtitle_' . $lang_selected];
				$record_array['blogshortdescription'] = $row['blogshortdescription_' . $lang_selected];
				$record_array['blogcontent'] = $row['blogcontent_' . $lang_selected];

		
				$record_array['opennewwindow'] = $row['opennewwindow'];
				$record_array['added'] = $row['added'];
				$record_array['modified'] = $row['modified'];
				$record_array['published'] = $row['publish_date_' . $lang_selected];
				
				$record_array['featured_image'] = $row['featured_image_' . $lang_selected];
				
				$record_array['archived'] = $row['archived'];
				$record_array['active'] = $row['active'];
				
				$record_array['author'] = $row['author_' . $lang_selected];
				
				

				
				foreach($lang_avail AS $langcode=>$language){ 
							
					${"tags_".$langcode} = $this->tags_model->get_tags($langcode, 'admin_blog', $row['blog_id']);

					if(${"tags_".$langcode}) $record_array['blog_tags_'.$langcode] = implode(",", ${"tags_".$langcode});
					else $record_array['blog_tags_'.$langcode] = "";
				
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
	function get_blog_item($blog_id){
	
		//$this->load->library('edittools');
		
		$this->load->model('tags/tags_model');
				
		
		$lang_avail = $this->config->item('lang_avail');
				
			
		
		$record_array = array();
		
		// need to get the language we're calling 
		$lang_selected = $this->config->item('lang_selected');
		
		$query = $this->db->get_where('blog', array('blog_id' => $blog_id, 'active' => 1));
		
		if ($query->num_rows() > 0){
			
			$row = $query->row_array(); 
			
			$record_array['blog_id'] = $row['blog_id'];
			$record_array['blogtitle'] = $row['blogtitle_' . $lang_selected];
			$record_array['author'] = $row['author_' . $lang_selected];
				
			$record_array['blogshortdescription'] = $row['blogshortdescription_' . $lang_selected];
			$record_array['blogcontent'] = $row['blogcontent_' . $lang_selected];
			$record_array['active'] = $row['active'];
			$record_array['archived'] = $row['archived'];
		
			$record_array['opennewwindow'] = $row['opennewwindow'];
			$record_array['added'] = $row['added'];
			$record_array['modified'] = $row['modified'];
			$record_array['published'] = $row['publish_date_' . $lang_selected];
			
			
			foreach($lang_avail AS $langcode=>$language){ 
							
				${"tags_".$langcode} = $this->tags_model->get_tags($langcode, 'admin_blog', $row['blog_id']);
				if(${"tags_".$langcode}) $record_array['blog_tags_'.$langcode] = implode(",", ${"tags_".$langcode});
				else $record_array['blog_tags_'.$langcode] = "";
				
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



