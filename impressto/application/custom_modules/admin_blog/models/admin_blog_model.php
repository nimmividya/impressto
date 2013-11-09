<?php

class admin_blog_model extends My_Model{





	/**
*
*
*/
	public function get_widget_settings(){

		
		$return_array = array();
		
		$widget_id = $this->get_widget_id();
		
		
		$sql = "SELECT * FROM {$this->db->dbprefix}widget_options WHERE widget_id = '{$widget_id}'";
		
		$query = $this->db->query($sql);

		
		foreach ($query->result() as $row)
		{
			
			$return_array[$row->name] = $row->value;
			
		}
		
		return $return_array;
		

	}



	/**
* return the full recordset for a blog item
*
*/
	public function get_blog_item($blog_id){
	
		//$lang_avail = $this->config->item('lang_avail');
			

		//$this->load->library('edittools');
			
		$record_array = array();
		
		$query = $this->db->get_where('blog', array('blog_id' => $blog_id));
		
		if ($query->num_rows() > 0){
			
			$record_array = $query->row_array(); 
			
	
		}

		return $record_array;

		
	}



	/**
	* list or search the blog table and return all relevant records
	* NOTE: This function will be replaced by the generic
	* PageShaper search function once that is complete 
	*
	*/
	function get_blog_items($keywords = '', $page = 1, $limit = NULL){
		
		$return_array = array();

		// need to get the language we're calling 
		$lang_selected = $this->config->item('lang_selected');
		
		$lang_avail = $this->config->item('lang_avail');
			
		
		
		if($limit){
			
			$min = (($page -1) * $limit);
			$max = ($page * $limit);
			
			$this->db->limit($min, $max);
			
		}
		
		$this->db->order_by("publish_date_en", "desc"); 
			
		

		if($keywords != ""){
			$this->db->like('blogtitle_' . $lang_selected, $keywords); 
			$this->db->like('blogcontent_' . $lang_selected, $keywords); 
		}
		
		
		$query = $this->db->get('blog');
		
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result_array() as $row){
				
				$record_array = array();
				
				$record_array['blog_id'] = $row['blog_id'];
				
				
				foreach($lang_avail AS $langcode=>$language){ 
				
								
					$record_array['blogtitle_'.$langcode] = $row['blogtitle_'.$langcode];
					$record_array['author_'.$langcode] = $row['author_'.$langcode];
					$record_array['publish_date_'.$langcode] = $row['publish_date_'.$langcode];
					$record_array['blogshortdescription_'.$langcode] = $row['blogshortdescription_'.$langcode];
					$record_array['blogcontent_'.$langcode] = $row['blogcontent_'.$langcode];
				
				
				}
							
			
				$record_array['active'] = $row['active'];
				$record_array['archived'] = $row['archived'];
				
				$record_array['opennewwindow'] = $row['opennewwindow'];
				$record_array['added'] = $row['added'];
				$record_array['modified'] = $row['modified'];
				
				
				$return_array[] = $record_array;
				
				
			}
			
		}
		

		return $return_array;
		
		
		
	}
	
	

	/**
* save blog to db
*
*/
	public function save_blog($data){

		$this->load->library('edittools');
		$this->load->library("events");
		
		
		$session_username = $this->get_username( $this->session->userdata('id') );
				
		
		$lang_avail = $this->config->item('lang_avail');
		
			
		$blogdata = array(
			'active' => $data['active'],
			'archived' => $data['archived'],
			'modified' => $data['modified'],
			
		);
		
		foreach($lang_avail AS $langcode=>$language){ 
		
			$blogdata['blogtitle_'.$langcode] = $data['blogtitle_'.$langcode];
			
			$blogdata['author_'.$langcode] = ($data['author_'.$langcode] != "") ? $data['author_'.$langcode] : $session_username;
			
			$blogdata['publish_date_'.$langcode] = $data['publish_date_'.$langcode];
			$blogdata['blogshortdescription_'.$langcode] = $data['blogshortdescription_'.$langcode];
			$blogdata['blogcontent_'.$langcode] = $data['blogcontent_'.$langcode];
			$blogdata['featured_image_'.$langcode] = $data['featured_image_'.$langcode];
		}
		
			
		


		if($data['blog_id'] == ''){
			
			$this->db->insert('blog', $blogdata); 	
			$data['blog_id'] = $this->db->insert_id();
			
		}else{
			
			$this->db->where('blog_id', $data['blog_id']);
			$this->db->update('blog', $blogdata); 
			
		}
		

		
		$content_data['content_module'] = "admin_blog";
		$content_data['content_id'] = $data['blog_id'];
		
		
		// grab the option so we can get the page wrappers
		$moduleoptions = ps_getmoduleoptions('admin_blog');
		
		//print_r($moduleoptions);
		
		
		$content_data['priority'] = $this->input->post('search_priority');
		$content_data['change_frequency'] = $this->input->post('change_frequency');

		
		
		foreach($lang_avail AS $langcode=>$language){ 
	
			$content_data['title'] = $data["blogtitle_".$langcode];
			
			if($data['blogcontent_'.$langcode] == "") $content_data['content'] = $data['blogshortdescription_'.$langcode];
			else $content_data['content'] = $data["blogcontent_".$langcode];
			
			$content_data['lang'] = $langcode;
	

			$content_data['slug'] = $moduleoptions['admin_blog_page_'.$langcode]."?blog_id=".$content_data['content_id']; 
			
		
			$content_data['slug'] = str_replace("/{$langcode}/","",$content_data['slug']);	
			
			$this->edittools->addsearchindex($content_data);
			
			//$content_data['tags'] = $data["tags_".$langcode];
			//$this->edittools->write_tags($content_data);
			
			$eventdata['content_module'] = "admin_blog";
			$eventdata['content_id'] = $data['blog_id'];
			$eventdata['lang'] = $langcode;
			
			$eventdata['tags']  = "";		
			if($this->input->post('hiddenTagList_'.$langcode) != "") $eventdata['tags'] = explode(",",$this->input->post('hiddenTagList_'.$langcode));	
		
	
			
			if(isset($moduleoptions['admin_blog_page_' . $langcode]) && $moduleoptions['admin_blog_page_' . $langcode] != ""){
				
				$url = rtrim( ltrim($moduleoptions['admin_blog_page_' . $langcode], '/'),'/');
				$url = str_replace($langcode . "/", "", $url);
				$eventdata['CO_Url'] = 	rtrim( ltrim($url, '/'),'/');
				
				$eventdata['lang'] = $langcode;
				$eventdata['query'] = "blog_id={$content_data['content_id']}";
				
				Events::trigger('save_content', $eventdata);
				
				
			}
		
			

		
	
		}
		
		return $data['blog_id'];

	}

	
	/**
* 
*
*/
	public function get_widget_id(){

		$sql = "SELECT widget_id FROM {$this->db->dbprefix}widgets WHERE module = 'admin_blog' AND widget = 'admin_blog' AND instance = '' ";
		
		$query = $this->db->query($sql);
		
		$widget_id = false;
		
		if ($query->num_rows() > 0){
			
			$row = $query->row();
			$widget_id = $row->widget_id;
			
		}
		
		return $widget_id;
		
		

	}///////////


	
	
	/**
	* 
	*
	*/
	public function getwidgetlistdata(){
		
		$this->load->library('widget_utils');
		
		$return_array = array();
		
		
		$this->db->where('module', 'admin_blog');
		$query = $this->db->get('widgets');

		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
				
				
				$subdata = array();
				
				$subdata['widget_id'] = $row->widget_id;
				$subdata['widget_module'] = $row->module;
				$subdata['widget_type'] = $row->widget;
				$subdata['widget_instance'] = $row->instance;
				
				$query2 = $this->db->select('name, value')
					->where('widget_id', $subdata['widget_id'])
					->get('widget_options');
				
				if ($query2->num_rows() > 0){
					
					foreach ($query2->result() as $q2row){
						
						$subdata["widget_" . $q2row->name] = $q2row->value;
						
					}
					
				}
				
				$return_array[] = $subdata;
				
			}
			
		}
		
		return $return_array;
		
		
	}
	


	
	/**
	* 
	*
	*/
	function getDistinctWidgetNames(){

		$sql = "SELECT DISTINCT instance FROM {$this->db->dbprefix}widgets WHERE module = 'admin_blog' AND widget = 'admin_blog'";
		
		$result = mysql_query($sql);
		
		$widget_names = array();
		
		
		while($row = mysql_fetch_assoc($result)){
			
			$widget_names[] = $row['instance'];
			
		}
		
		return $widget_names;
		

	}///////////


	public function getBlogWidgets(){

		$return_array = array();
		

		$sql = "SELECT widget_id, instance FROM {$this->db->dbprefix}widgets WHERE module = 'admin_blog' AND widget = 'admin_blog'";
		
		$query = $this->db->query($sql);
		
		
		foreach ($query->result() as $row)
		{

			$return_array[$row->instance] = $row->widget_id;
			
		}
		
		
		return $return_array;

	}
	
	

		

		
	/**
	* return the full name or username of a user based on id
	*
	*/	
	private function get_username($user_id){
	
		
		$sql = "SELECT username ";
		$sql .= " FROM {$this->db->dbprefix}users ";
		$sql .= " WHERE user_id='{$user_id}'";
	
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
		
			$row = $query->row();
			
			//if($row->first_name != "" && $row->last_name != ""){
			
				//return $row->first_name  . " " . $row->last_name;
				
			//}else{
				return  $row->username;;
			//}
	
		
		} 
		
		return "";
		
	
	}


	
	
	
	
	
	/**
	* remove the featured image
	*
	*/
	public function remove_featured_image($data){


		if($data['blog_id'] != '' && $data['lang'] != ''){
			
			$blogdata = array("featured_image_" . $data['lang'] => "");
						
			$this->db->where('blog_id', $data['blog_id']);
			$this->db->update('blog', $blogdata); 
			
			
			return TRUE;
			
		}
		
		return FALSE;


	}
	
	
	
	
} //end class