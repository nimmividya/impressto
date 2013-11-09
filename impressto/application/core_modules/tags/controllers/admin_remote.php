<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_remote extends PSBase_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		
		
				
		
	}
	
	
	
	/**
	* Save setting from the management page
	*
	*/
	public function save_settings(){
	
		$this->load->helper('im_helper');
					
		$saveoptions['tag_cloud_template'] = $this->input->post('tag_cloud_template');
		$saveoptions['tag_list_template'] = $this->input->post('tag_list_template');
	
		$tag_targets  = $this->input->post('tag_targets');
	
		if(is_array($tag_targets)){
		
			foreach($tag_targets AS $key => $val){
			
				$saveoptions[$key . '_tag_target'] = $val;
				
			}
		
			
		}
		
		ps_savemoduleoptions('tags',$saveoptions);
				
	
	}
	
	
	
	/**
	*
	*
	*/
	public function save_widget(){
		
		$return_array = array();
		
	
		// all we need is thethe widget name
		$widget_instance_name = trim($this->input->get_post('tag_cloud_name'));
		$widget_template = $this->input->get_post('tag_cloud_template');
		$widget_content_module = $this->input->get_post('tag_cloud_content_module');
	
		if($widget_template == "" || $widget_instance_name == "" || $widget_content_module == ""){
		
			echo "missing data";
			return;
			
		}
			
		
		$widget_id = $this->input->get_post('tag_cloud_widget_id');
				
		$return_array['widget_template'] = $widget_template;
				
		
		$this->load->library('widget_utils');
		
		if($widget_id == ""){
		
			// fist thing is to create the widget instance
			$widget_id = $this->widget_utils->register_widget('tag_cloud', 'tags', $widget_instance_name);
			
		}
		
		// update the name in case it was changed
		$sql = "UPDATE {$this->db->dbprefix}widgets SET instance = '{$widget_instance_name}' WHERE widget_id = '{$widget_id}'";
		$this->db->query($sql);

		
		$this->widget_utils->set_widget_option($widget_id, 'template',$widget_template);
		$this->widget_utils->set_widget_option($widget_id, 'content_module',$widget_content_module);

		
		
		$return_array['widget_id'] = $widget_id;
		
		echo json_encode($return_array);
		
	
	
	}
	
	/**
	*
	*
	*/
	public function reload_widgetlist(){
	
		$this->load->library('widget_utils');
				

		$data['widget_list'] = $this->widget_utils->get_widgets_attributes_by_module('tags','tag_cloud');
		
		echo $this->load->view('partials/widgetlist', $data, TRUE); 
		
				
	
	
	}

	/**
	*
	*
	*/
	public function delete_widget($widget_id){
	
	
		$this->load->library('widget_utils');
				
		$this->widget_utils->delete_widget($widget_id);
		
		echo "deleted";
	
	
	}
	
	
	
	
	
	
	
}