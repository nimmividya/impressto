<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_bar extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
			
		$this->load->helper('auth');
							
		is_logged_in();
		
		$this->load->model('admin_bar_model');
		
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

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/admin_bar/js/admin_bar_manager.js");

		$site_settings = $this->site_settings_model->get_settings();
				
		$data['infobar_help_section'] = ""; //getinfobarcontent('admin_barHELP');
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
				
		$settings = ps_getmoduleoptions("admin_bar");
		
		if(!isset($settings['template'])) $settings['template'] = "";
	
		$data['settings'] = $settings;

		//$data['main_content'] = 'manager';
		


				
		$template = isset($moduleoptions['template']) ? $moduleoptions['template'] : '';
						
		$templateselectordata = array(
		
		'selector_name'=>'admin_bar_template',
		'selector_label'=>'Template',
		'module'=>'admin_bar',
		'value'=> $settings['template'],
		'is_widget' => TRUE,	
		'widgettype' => 'admin_bar'
				
		);
		
		$data['template_selector'] = $this->template_loader->template_selector($templateselectordata);
		
		$data['parsedcontent'] = $this->load->view('manager', $data, TRUE); 
		
		
				
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
					
		$saveoptions['template'] = $this->input->post('admin_bar_template');
				
		ps_savemoduleoptions('admin_bar',$saveoptions);
				
	
	}
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
	
		$this->load->library('widget_utils');
	
		$data['dbprefix'] = $this->db->dbprefix;
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		$this->widget_utils->register_widget("admin_bar","admin_bar");
		
		
		
	}	
	
	public function uninstall(){
	
		$this->load->library('widget_utils');
					
		$this->widget_utils->un_register_widget("admin_bar","admin_bar");
	}	
	
}