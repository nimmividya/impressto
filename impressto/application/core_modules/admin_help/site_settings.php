<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This is called by the hooks as a post_controller_constructor
*
* peterdrinnan - some of this stuff should be coming from the CI config but for now ... I AM A BAD PROGRAMMER!
*
*/
function initiate(){

	
	$CI =& get_instance();
	
	$CI->benchmark->mark('code_start');
		
	$query = $CI->db->get_where('options', array('module' => 'core'));
	
	$site_options = array();
	
	foreach ($query->result() as $row){
	
		$site_options[$row->name] = $row->value;
			
	}
	

	
	$CI->config->set_item('languages', array_keys($CI->config->item('lang_avail')) );
		
	
	// make all the site configs globally accessible
	$CI->config->set_item('site_options',$site_options);
		
	// for now we will set the default languiage to en
	$CI->config->set_item('language','english');
	
	if( isset($site_options['splash_page_id']) && $site_options['splash_page_id'] != ""){
		$CI->config->set_item('splash_page_id',$site_options['splash_page_id']);
	}
	
	if( isset($site_options['debugmode']) && $site_options['debugmode'] == 1){
		$CI->config->set_item('debugmode',TRUE);
	}
	if( isset($site_options['debug_profiling']) && $site_options['debug_profiling'] == 1){
		$CI->config->set_item('debug_profiling',TRUE);
	}
	
	
	//if($this->config->item('debug_profiling')) $this->output->enable_profiler(TRUE);
	
		
	
	$CI->lang->load('core', $CI->config->item('language') );
	
	// we use widgets for all views except for ajax calls 
	if(!$CI->input->isAjax()) { 
		$CI->load->plugin('widget');
	}
		

	
}



