<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class widget_call extends PSBase_Controller {
		
	public function __construct(){
		
		parent::__construct();
		
		
	}
	
	public function index(){
				
		
	}


	public function run($widget_name){
	
		$this->config->set_item('debug_profiling',FALSE);
		$this->output->enable_profiler(FALSE);

		$this->load->plugin('widget');
		
						
		echo Widget::run($widget_name, array() );
		
				
		
	}
	

	

}