<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __skeleton_name__ extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
			
		$this->load->helper('auth');
							
		is_logged_in();
		
		$this->load->model('__skeleton_name___model');
		
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

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/__skeleton_name__/js/__skeleton_name___manager.js");

		$site_settings = $this->site_settings_model->get_settings();
				
		$data['infobar_help_section'] = ""; //getinfobarcontent('__skeleton_name__HELP');
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
				
		$settings = ps_getmoduleoptions("__skeleton_name__");
		
		if(!isset($settings['template'])) $settings['template'] = "";
	
		$data['settings'] = $settings;

		//$data['main_content'] = 'manager';
		


				
		$template = isset($moduleoptions['template']) ? $moduleoptions['template'] : '';
						
		$templateselectordata = array(
		
		'selector_name'=>'__skeleton_name___template',
		'selector_label'=>'Template',
		'module'=>'__skeleton_name__',
		'value'=> $settings['template'],
		'is_widget' => TRUE,	
		'widgettype' => '__skeleton_name__'
				
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
					
		$saveoptions['template'] = $this->input->post('__skeleton_name___template');
				
		ps_savemoduleoptions('__skeleton_name__',$saveoptions);
				
	
	}
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
	
		$this->load->library('widget_utils');
	
		$data['dbprefix'] = $this->db->dbprefix;
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		$this->widget_utils->register_widget("__skeleton_name__","__skeleton_name__");
		
		
		
		
	}	
	
	public function uninstall(){
	
		$this->load->library('widget_utils');
					
		$this->widget_utils->un_register_widget("__skeleton_name__","__skeleton_name__");
	}	
	
}