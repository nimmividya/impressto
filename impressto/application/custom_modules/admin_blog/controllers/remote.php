<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class remote extends PSBase_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		
		
		
		$this->load->model('admin_blog_model');
		
		
				
		
	}
	
	
	public function createwidget(){
	
		// all we need is thethe widget name
		$instance_name = $this->input->post('instance_name');
		
		$this->load->library('widget_utils');
			
		echo $this->widget_utils->register_widget('admin_blog','admin_blog',$instance_name);
		
	
	}
	
	
	
	
	
}