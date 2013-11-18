<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This is called by the hooks as a post_controller_constructor
*
* Nimmitha Vidyathilaka - some of this stuff should be coming from the CI config but for now ... 
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
	
	// DO NOT REMOVE	
	$CI->config->set_item('languages', array_keys($CI->config->item('lang_avail')) );
	
	
	// make all the site configs globally accessible
	$CI->config->set_item('site_options',$site_options);
			
	if( isset($site_options['splash_page_id']) && $site_options['splash_page_id'] != ""){
		$CI->config->set_item('splash_page_id',$site_options['splash_page_id']);
	}
	
	if( isset($site_options['debugmode']) && $site_options['debugmode'] == 1){
		$CI->config->set_item('debugmode',TRUE);
		$CI->config->set_item('no_cache_write',TRUE); //prevent the parent page from writing a cache file
				
	}
	
	
	// only enable profiling if this is NOT an ajax call
	if(
		!$CI->input->isAjax() 
		&& isset($site_options['debug_profiling']) 
		&& $site_options['debug_profiling'] == 1
	){
		$CI->config->set_item('debug_profiling',TRUE);
		$CI->output->enable_profiler(TRUE);
	}
	
	
	if( isset($site_options['unit_testing']) && $site_options['unit_testing'] == 1){
		$CI->config->set_item('unit_testing',TRUE);
		$CI->load->library('unit_test');
	}
	
	if( isset($site_options['api_key']) && $site_options['api_key'] != ""){
		$CI->config->set_item('api_key',$site_options['api_key']);
	}

	if( isset($site_options['page_cache_timeout']) ){
		$CI->config->set_item('page_cache_timeout',$site_options['page_cache_timeout']);
	}
	

	$block_wysiwyg_editing = $CI->input->cookie('block_wysiwyg_editing', FALSE);
			
	if($block_wysiwyg_editing == "true"){
	
		$CI->config->set_item('wysiwyg_editor','');
			
	
	}else{
	
		// universal setting for WYSIWYG Editors throughout the site - front and backend
		if(!isset($site_options['wysiwyg_editor']) || $site_options['wysiwyg_editor'] == "") $site_options['wysiwyg_editor'] = "none";
		$CI->config->set_item('wysiwyg_editor',$site_options['wysiwyg_editor']);
	
	}
	
		
	
	// This gives us the correct theme for the user
	$user_role = $CI->session->userdata('role');

	if($user_role != ""){

		$query = $CI->db->select('role_theme')
			->from('user_roles')
			->where('id', $user_role)
			->get();
			
			
		if($query->num_rows() > 0){
		
			if($query->row()->role_theme != ""){
				$site_options['admin_theme'] = $query->row()->role_theme;
			}
		}
	}
	

	$CI->config->set_item('admin_theme', isset($site_options['admin_theme']) ? $site_options['admin_theme'] : "classic");
	
	
	$CI->config->set_item('jquery_ui_theme', isset($site_options['jquery_ui_theme']) ? $site_options['jquery_ui_theme'] : "smoothness");
	$CI->config->set_item('jquery_ui_version', isset($site_options['jquery_ui_version']) ? $site_options['jquery_ui_version'] : "1.9.1"); 
	$CI->config->set_item('jquery_version', isset($site_options['jquery_version']) ? $site_options['jquery_version'] : "1.8.2");

	
	$CI->lang->load('core', $CI->config->item('language') );
	
	// we use widgets for all views except for ajax calls 
	if(!$CI->input->isAjax()) { 
		$CI->load->plugin('widget');
	}
		

	
}



