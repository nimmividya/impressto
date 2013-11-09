<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_remote extends PSBase_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		
		
		
		$this->load->model('admin_news_model');
		
		$this->load->library("formelement");
		
		$this->load->config('config');
		
		
		
		
	}
	
	
	/**
	*
	*
	*/
	public function getwidgetdata($widget_id){
		
		$this->load->library('widget_utils');
		
		$widget_data = $this->widget_utils->get_widget_options($widget_id);
		
		echo json_encode($widget_data);

		
		
	}
	
	
	
	/**
	*
	*
	*/
	public function loadwidgetlist(){
		
		$data['widget_list_data'] = $this->admin_news_model->getwidgetlistdata();
		
		echo $this->load->view('partials/widgetlist', $data, TRUE);
		
		
	}
	
	
	
	/**
	*
	*
	*/
	public function deletewidget($id){
		
		//$return_array = array();
		
		$this->load->library('widget_utils');
		
		$this->widget_utils->delete_widget($id);
		
		echo "deleted";

		
	}
	
	
	public function savewidget(){
		
		$return_array = array();
		
		
		// all we need is thethe widget name
		$widget_instance_name = trim($this->input->get_post('widget_name'));
		$widget_type = $this->input->get_post('widget_type');
		
		$widget_template = $this->input->get_post($widget_type . '_template'); 
		
		
		
		if($widget_type == "" || $widget_template == "" || $widget_instance_name == ""){
			
			echo "missing data";
			return;
			
		}
		
		
		
		$widget_id = $this->input->get_post('widget_id');
		
		$return_array['widget_template'] = $widget_template;
		
		
		$this->load->library('widget_utils');
		
		if($widget_id == ""){
			
			// fist thing is to create the widget instance
			$widget_id = $this->widget_utils->register_widget($widget_type, 'admin_news', $widget_instance_name);
			
		}
		
		// update the name in case it was changed
		$sql = "UPDATE {$this->db->dbprefix}widgets SET instance = '{$widget_instance_name}' WHERE widget_id = '{$widget_id}'";
		$this->db->query($sql);

		
		$this->widget_utils->set_widget_option($widget_id, 'template',$widget_template);
		
		$return_array['widget_id'] = $widget_id;
		
		echo json_encode($return_array);
		
		
	}
	
	
	/**
	*
	*
	*/
	public function delete_news($id){

		$this->load->library('edittools');

		$this->db->delete('news', array('news_id' => $id)); 
		
		// grab the option so we can get the page wrappers
		$moduleoptions = ps_getmoduleoptions('admin_news');
		
		// remove it from the search index too.
		// this really should be a trigger to /core_modules/search/events.php	

		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
			
			$data = array(
			'lang' => $langcode,
			'content_id' =>  $id,
			'content_module' => 'news', 
			);
			
			$this->edittools->deletesearchindex($data);
			
			if(isset($moduleoptions['admin_news_page_' . $langcode]) && $moduleoptions['admin_news_page_' . $langcode] != ""){
				
				$url = rtrim( ltrim($moduleoptions['admin_news_page_' . $langcode], '/'),'/');
				$url = str_replace($langcode . "/", "", $url);
				$eventdata['CO_Url'] = 	rtrim( ltrim($url, '/'),'/');
				
				$eventdata['lang'] = $langcode;
				$eventdata['query'] = "news_id={$id}";
				
				Events::trigger('delete_content', $eventdata);
				
				
			}
			
			
		}

		echo "deleted";

		
	}

	
	
	
	/**
	* standard save function
	* 
	*/
	public function save_news(){
		
		
		$today = date('Y-m-d H:i:s');
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
			
			${"news_tags_" . $langcode} = "";		
			if($this->input->post('news_tags_'.$langcode) != "") ${"news_tags_" . $langcode} = explode(",",$this->input->post('news_tags_'.$langcode));
			
		}
		
		
		$data = array(
		'news_id' => $this->input->post('news_id')
		,'active' => ($this->input->post('newsactive') == 1 ? "1" : "0")
		,'archived' => ($this->input->post('newsarchived') == 1 ? "1" : "0")
		,'opennewwindow' => ($this->input->post('opennewwindow') == 1 ? "1" : "0")
		,'modified' => $today
		,'published' => $this->input->post('publishdate')			
		);
		
		foreach($lang_avail AS $langcode=>$language){ 

			$data['newstitle_'.$langcode] = $this->input->post('newstitle_'.$langcode);		

			$data['newsshortdescription_'.$langcode] = $this->input->post('newsshortdescription_'.$langcode);
			$data['newscontent_'.$langcode] = $this->input->post('newscontent_'.$langcode);		

			
			$data['newslink_'.$langcode] = $this->input->post('newslink_'.$langcode);			
			$data['tags_'.$langcode] = ${"news_tags_" . $langcode};		
			
		}
		
		$news_id = $this->admin_news_model->save_news($data);
		
		echo json_encode(array("news_id"=>$news_id));
		

	}
	
	/**
	* Called from blog list to quickly toggle publish state
	*
	*/
	public function toggle_active($id, $state){
		
		if($state == 1) $data['active'] = 0;
		else $data['active'] = 1;
		
		$this->db->where('news_id', $id);
		$this->db->update('news', $data);
		
		echo $this->db->last_query();
		
	}
	
	
	/**
	* Called from blog list to quickly toggle archived state
	*
	*/
	public function toggle_archived($id, $state){
		
		if($state == 1) $data['archived'] = 0;
		else $data['archived'] = 1;
		
		$this->db->where('news_id', $id);
		$this->db->update('news', $data);
		
		echo $this->db->last_query();
		
	}
	
	
	
	/**
	* this saves settings for the news 
	*
	*/
	public function savesettings(){
		
		$this->load->helper('im_helper');
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
			
			$saveoptions['news_title_'.$langcode] = $this->input->get_post('news_title_'.$langcode);
			$saveoptions['news_description_'.$langcode] = $this->input->get_post('news_description_'.$langcode);
			$saveoptions['admin_news_page_'.$langcode] = $this->input->get_post('news_page_'.$langcode);
			
		}
		
		$saveoptions['news_listlimit'] = $this->input->get_post('news_listlimit');		
		
		ps_savemoduleoptions('admin_news',$saveoptions);
		
		
		
		
	}
	
	
	/**
	*
	*
	*/	
	public function getwidgetselector(){
		
		echo $this->admin_news_model->widget_selector();
		
	}
	
	/*
function ae_nocache() 
{
	header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
}
*/
	
	
	
}