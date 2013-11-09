<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class navigation_menu extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
			
		$this->load->helper('auth');
							
		is_logged_in();
		
		$this->load->model('navigation_menu_model');
		
	}
	
	/**
	* default management page
	*
	*/
	public function index(){
	
		$data = array();
		
		
		$this->load->helper('im_helper');
		$this->load->library('template_loader');
		$this->load->library('asset_loader');

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/navigation_menu/js/navigation_menu_manager.js");
				

		$site_settings = $this->site_settings_model->get_settings();
		
		$data['infobar_help_section'] = ""; 
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
		
		$settings = ps_getmoduleoptions("navigation_menu");
		
		if(!isset($settings['template'])) $settings['template'] = "";
	
		$data['settings'] = $settings;


		$data['main_content'] = 'manager';
		

						
		$templateselectordata = array(
		
		'selector_name'=>'navigation_menu_template',
		'selector_label'=>'Template',
		'module'=>'navigation_menu',
		'value'=> $settings['template'],
		'is_widget' => TRUE,	
		'widgettype' => 'navigation_menu'
				
		);
		
		$data['template_selector'] = $this->template_loader->template_selector($templateselectordata); // add TRUE var at end for debug;
						
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
	}
	
	
	/**
	* Save setting from the management page
	*
	*/
	public function save_settings(){
	
		$this->load->helper('im_helper');
	
				
		$saveoptions['template'] = $this->input->post('navigation_menu_template');
				
		ps_savemoduleoptions('navigation_menu',$saveoptions);
				
	
	}
	
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
	
		$this->load->library('widget_utils');
	
		$data['dbprefix'] = $this->db->dbprefix;
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		$this->widget_utils->register_widget("navigation_menu","navigation_menu");
		
		
		
		
	}	
	
	public function uninstall(){
	
		$this->load->library('widget_utils');
					
		$this->widget_utils->un_register_widget("navigation_menu","navigation_menu");
	}	
	
}