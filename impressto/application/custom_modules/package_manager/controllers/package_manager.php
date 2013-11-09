<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Package access right manager for all remote package updates. 
*
*/


class package_manager extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		$this->benchmark->mark('code_start');
		
		$this->load->helper('auth');
							
		is_logged_in();
		
		
		$this->load->model('package_manager_model');
		
	}
	
	/**
	* manage packages and which API keys can access them
	*
	*/
	public function index()
	{
		
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		
		$this->load->library('asset_loader');
		$this->load->helper('form');
		
		$this->load->helper('im_helper');
				
			
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/package_manager/js/package_manager.js");
				
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/ajaxfileuploader/ajaxfileupload.js");
		$this->asset_loader->add_header_js("vendor/bootstrap/js/bootstrap-fileupload.js");
		

		$data['main_content'] = 'layout';
		
		$data['package_list'] = $this->package_manager_model->get_packages();
	
	
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}
	
	
	/**
	* API repsonce methods
	*
	*/
	
	public function check_licence($module, $version){
	
	
			$api_key_variable = config_item('rest_key_name');
	
			if($this->input->get_post($api_key_variable) != ""){
				$api_key = $this->input->get_post($api_key_variable);
			}
			
			
			//if($api_key == "") return FALSE;
			
			
			// use $api_key and the module $version to check if this update is allowed..
			
			/*
			Here we will return the max version number allowable for the user with the cupplied
			API key. 
			
			If the requested module has no licence restrictions we return latest version number.
			If the requested module licence carries a licence, we return the max version number allowable for the user
			*/
			
			//echo "wow $module, $version, $client_api_key ";
			
			return array("one","two"); 
			
			
		
	}


	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
	
	
		$this->load->library('module_installer');

		$data['dbprefix'] = $this->db->dbprefix;
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		include(dirname(dirname(__FILE__)) . "/install/install.php");		
		
	}
		
	
	
}

