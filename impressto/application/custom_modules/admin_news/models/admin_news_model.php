<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class admin_news_model extends My_Model{





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
* return the full recordset for a news item
*
*/
	public function get_news_item($news_id){

		
		$record_array = array();
		
		$query = $this->db->get_where('news', array('news_id' => $news_id));
		
		if ($query->num_rows() > 0){
			
			$record_array = $query->row_array(); 
			
			

		}

		return $record_array;

		
	}



	/**
	* list or search the news table and return all relevant records
	* NOTE: This function will be replaced by the generic
	* PageShaper search function once that is complete 
	*
	*/
	function get_news_items($keywords = '', $page = 1, $limit = NULL){
		
		$return_array = array();

		// need to get the language we're calling 
		$lang_selected = $this->config->item('lang_selected');
		$lang_avail = $this->config->item('lang_avail');
		
		if($limit){
			
			$min = (($page -1) * $limit);
			$max = ($page * $limit);
			
			$this->db->limit($min, $max);
			
		}
		

		if($keywords != ""){
			$this->db->like('newstitle_' . $lang_selected, $keywords); 
			$this->db->like('newscontent_' . $lang_selected, $keywords); 
		}
		
		
		$query = $this->db->get('news');
		
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result_array() as $row){
				
				$record_array = array();
				
				$record_array['news_id'] = $row['news_id'];
				
				
				foreach($lang_avail AS $langcode=>$language){
					
					$record_array['newstitle_'.$langcode] = $row['newstitle_'.$langcode];
					$record_array['newsshortdescription_'.$langcode] = $row['newsshortdescription_'.$langcode];
					$record_array['newscontent_'.$langcode] = $row['newscontent_'.$langcode];
					$record_array['newslink_'.$langcode] = $row['newslink_'.$langcode];
					
				}
				
				//$record_array['newstitle_fr'] = $row['newstitle_fr'];
				//$record_array['newsshortdescription_fr'] = $row['newsshortdescription_fr'];
				//$record_array['newscontent_fr'] = $row['newscontent_fr'];
				//$record_array['newslink_fr'] = $row['newslink_fr'];
				
				$record_array['active'] = $row['active'];
				$record_array['archived'] = $row['archived'];
				
				
				$record_array['opennewwindow'] = $row['opennewwindow'];
				$record_array['added'] = $row['added'];
				$record_array['modified'] = $row['modified'];
				$record_array['published'] = $row['published'];
				
				
				$return_array[] = $record_array;
				
				
			}
			
		}
		

		return $return_array;
		
		
		
	}
	
	

	/**
* save news to db
*
*/
	public function save_news($data){

		$this->load->library('edittools');
		$this->load->library("events");

		$this->load->helper("im_helper");
		
		
		$lang_selected = $this->config->item('lang_selected');
		$lang_avail = $this->config->item('lang_avail');
		
		
		
		$newsdata = array(
		'active' => $data['active'],
		'archived' => $data['archived'],
		'opennewwindow' => $data['opennewwindow'],
		'modified' => $data['modified'],
		'published' => $data['published']
		);
		
		
		foreach($lang_avail AS $langcode=>$language){
			
			$newsdata['newstitle_'.$langcode] = $data['newstitle_'.$langcode];
			$newsdata['newsshortdescription_'.$langcode] = $data['newsshortdescription_'.$langcode];
			$newsdata['newscontent_'.$langcode] = $data['newscontent_'.$langcode];
			$newsdata['newslink_'.$langcode] = $data['newslink_'.$langcode];

			
		}
		


		if($data['news_id'] == ''){
			
			$this->db->insert('news', $newsdata); 	
			$data['news_id'] = $this->db->insert_id();
			
		}else{
			
			$this->db->where('news_id', $data['news_id']);
			$this->db->update('news', $newsdata); 
			
		}
		
		
		// grab the option so we can get the page wrappers
		$moduleoptions = ps_getmoduleoptions('admin_news');
		
		
		$content_data['priority'] = $this->input->post('search_priority');
		$content_data['change_frequency'] = $this->input->post('change_frequency');
		
		
		
		foreach($lang_avail AS $langcode=>$language){

			$content_data['content_module'] = "admin_news";
			$content_data['content_id'] = $data['news_id'];
			
			
			$content_data['title'] = $data["newstitle_".$langcode];
			
			if($data['newscontent_'.$langcode] == "") $content_data['content'] = $data['newsshortdescription_'.$langcode];
			else $content_data['content'] = $data["newscontent_".$langcode];
			
			$content_data['lang'] = $langcode;
			
			
			if($newsdata['newslink_' . $langcode] != ""){
				
				$this->edittools->deletesearchindex($content_data);
				
				
			}else{
				
				$content_data['slug'] = $moduleoptions['admin_news_page_'.$langcode]."?news_id=".$content_data['content_id']; 
				$content_data['slug'] = str_replace("/{$langcode}/","",$content_data['slug']);
				
				$this->edittools->addsearchindex($content_data);
				
			}
			
			
			$eventdata['content_module'] = "admin_news";
			$eventdata['content_id'] = $data['news_id'];
			$eventdata['lang'] = $langcode;
			
			$eventdata['tags']  = "";		
			
			if($this->input->post('hiddenTagList_'.$langcode) != "") $eventdata['tags'] = explode(",",$this->input->post('hiddenTagList_'.$langcode));	
			
			
			if(isset($moduleoptions['admin_news_page_' . $langcode]) && $moduleoptions['admin_news_page_' . $langcode] != ""){
				
				$url = rtrim( ltrim($moduleoptions['admin_news_page_' . $langcode], '/'),'/');
				$url = str_replace($langcode . "/", "", $url);
				$eventdata['CO_Url'] = 	rtrim( ltrim($url, '/'),'/');
				
				$eventdata['lang'] = $langcode;
				$eventdata['query'] = "news_id={$content_data['content_id']}";
				
				Events::trigger('save_content', $eventdata);
				
			}
			
			
			
		}
		
		
		return $data['news_id'];

	}

	
	/**
* 
*
*/
	public function get_widget_id(){

		$sql = "SELECT widget_id FROM {$this->db->dbprefix}widgets WHERE module = 'admin_news' AND widget = 'admin_news' AND instance = '' ";
		
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
		
		
		$this->db->where('module', 'admin_news');
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

		$sql = "SELECT DISTINCT instance FROM {$this->db->dbprefix}widgets WHERE module = 'admin_news' AND widget = 'admin_news'";
		
		$result = mysql_query($sql);
		
		$widget_names = array();
		
		
		while($row = mysql_fetch_assoc($result)){
			
			$widget_names[] = $row['instance'];
			
		}
		
		return $widget_names;
		

	}///////////


	public function getNewsWidgets(){

		$return_array = array();
		

		$sql = "SELECT widget_id, instance FROM {$this->db->dbprefix}widgets WHERE module = 'admin_news' AND widget = 'admin_news'";
		
		$query = $this->db->query($sql);
		
		
		foreach ($query->result() as $row)
		{

			$return_array[$row->instance] = $row->widget_id;
			
		}
		
		
		return $return_array;

	}


	
	
} //end class