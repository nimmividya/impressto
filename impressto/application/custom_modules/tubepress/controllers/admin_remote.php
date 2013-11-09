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
				
		//$widget_data["widget_name"] = $this->widget_utils->get_widget_name($widget_id);
		
		
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
		
		if($widget_type == "newsarticle") $widget_template = $this->input->get_post('newsarticle_template'); 
		if($widget_type == "newsticker") $widget_template = $this->input->get_post('newsticker_template');
		
			
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
		$sql = "UPDATE ps_widgets SET instance = '{$widget_instance_name}' WHERE widget_id = '{$widget_id}'";
		$this->db->query($sql);

		
		$this->widget_utils->set_widget_option($widget_id, 'template',$widget_template);
		
		$return_array['widget_id'] = $widget_id;
		
		echo json_encode($return_array);
		
	
	}
	
	/**
	* standard save function
	* 
	*/
	public function save_news(){
	
		
		$today = date('Y-m-d H:i:s');
		
		
		$news_tags_en = "";		
		if($this->input->post('news_tags_en') != "") $news_tags_en = explode(",",$this->input->post('news_tags_en'));
		
		$news_tags_fr = "";		
		if($this->input->post('news_tags_fr') != "") $news_tags_fr = explode(",",$this->input->post('news_tags_fr'));		
		
				
		
		$data = array(

			'news_id' => $this->input->post('news_id')
			,'newstitle_en' => $this->input->post('newstitle_en')
			,'newsshortdescription_en' => $this->input->post('newsshortdescription_en')
			,'newscontent_en' => $this->input->post('editor_en')
			,'newslink_en' => $this->input->post('newslink_en')
			,'active' => ($this->input->post('newsactive') == 1 ? "1" : "0")
			,'newstitle_fr' => $this->input->post('newstitle_fr')
			,'newsshortdescription_fr' => $this->input->post('newsshortdescription_fr')
			,'newscontent_fr' => $this->input->post('editor_fr')
			,'newslink_fr' => $this->input->post('newslink_fr')
			,'modified' => $today
			,'published' => $this->input->post('published')
			,'tags_en' => $news_tags_en
			,'tags_fr' => $news_tags_fr
			
		);
		
	
		
		
		$news_id = $this->admin_news_model->save_news($data);
		
		echo json_encode(array("news_id"=>$news_id));
							

	}
	
	
	
	/**
	* this saves settings for the news 
	*
	*/
	public function savesettings(){
	
		$this->load->helper('im_helper');
		
		$saveoptions['news_title_en'] = $this->input->get_post('news_title_en');
		$saveoptions['news_description_en'] = $this->input->get_post('news_description_en');
		$saveoptions['news_page_en'] = $this->input->get_post('news_page_en');

		$saveoptions['news_title_fr'] = $this->input->get_post('news_title_fr');
		$saveoptions['news_description_fr'] = $this->input->get_post('news_description_fr');
		$saveoptions['news_page_fr'] = $this->input->get_post('news_page_fr');

		$saveoptions['news_listlimit'] = $this->input->get_post('news_listlimit');		
		
		ps_savemoduleoptions('admin_news',$saveoptions);
		
		//echo "done";
				
				
		
		
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