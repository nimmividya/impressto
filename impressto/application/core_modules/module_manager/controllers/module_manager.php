<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class module_manager extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		$this->benchmark->mark('code_start');
		
		$this->load->helper('auth');
							
		is_logged_in();
				
		$this->load->model('module_manager_model');
		
	}
		
	
	public function index()
	{
		
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		
		$this->load->library('asset_loader');
		$this->load->helper('form');
		
		$this->load->helper('im_helper');
				
			
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/module_manager/js/module_manager.js");

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/module_manager/css/module_manager.css");
		
		$this->asset_loader->add_header_js("/vendor/bootstrap/js/bootstrap-tooltip.js");
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/xtras/ajaxfileuploader/ajaxfileupload.js");
		$this->asset_loader->add_header_js("vendor/bootstrap/js/bootstrap-fileupload.js");
		
				
			
		$module_list = get_modules();

		
		
		$data['infobar_help_section'] = getinfobarcontent('MODULEMANAGERHELP');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);


		$data['curl_enabled'] = $this->cURL_check();
			
		
		
		$data['main_content'] = 'layout';
		
		$data['module_list'] = $module_list;
		//$data['widget_list'] = $widget_list;
		
		$data['modulestable'] = $this->load->view('partials/module_table', $data, TRUE);
		

		$site_settings = $this->site_settings_model->get_settings();
		
		//$file_to_open = "http://www.pdvictor.com/sitemap.xml";
		//$client = curl_init($file_to_open);
		
		$data['breadcrumbs'] = array("Configuration"=>"","Modules"=>"");
		

		
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}
	
	
	private function cURL_check() 
	{

		if (!function_exists('curl_version'))
        {
			return FALSE;
	
		}
		
		return TRUE;
    }
	

	
}

