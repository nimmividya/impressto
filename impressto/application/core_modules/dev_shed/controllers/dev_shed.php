<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dev_shed extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
	
		$this->load->helper('auth');
							
		is_logged_in();
		

		
	}
	
	
	public function index()
	{
		
	
		$data = array();
		
		$this->load->library('asset_loader');
		$this->load->helper('im_helper');
		$this->load->library('formelement');
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/dev_shed/js/dev_shed.js");
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/third_party/bootstrap/js/bootstrap-lightbox.js");
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/third_party/bootstrap/css/bootstrap-lightbox.css");
								
		$data['parsedcontent'] = $this->load->view('dev_shed', $data, TRUE); 
		

		$site_settings = $this->site_settings_model->get_settings();
		
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}
	
	
	

	
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){


		$data['dbprefix'] = $this->db->dbprefix;
		
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		
		
	}	
	
	


	
	
}