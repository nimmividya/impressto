<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
* Provides responders to widgets using JSON 
*
*/
class public_remote extends PSBase_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		
				
		$this->load->model('blog_model');
		
		$this->load->library("formelement");
		
		$this->load->config('config');
		
		
				
		
	}
	
	
	/**
	*
	*
	*/
	public function get_blog_list($page=1){
	
		$this->load->library('widget_utils');
				
		$widget_data = $this->widget_utils->get_widget_options($widget_id);
				
		//$widget_data["widget_name"] = $this->widget_utils->get_widget_name($widget_id);
		
		
		echo json_encode($widget_data);

		
	
	}
	
	
	
	
	
	
}