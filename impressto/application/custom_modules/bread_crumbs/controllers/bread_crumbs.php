<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bread_crumbs extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
			
		$this->load->helper('auth');
							
		is_logged_in();
		
		$this->load->model('bread_crumbs_model');
		
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

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/bread_crumbs/js/bread_crumbs_manager.js");

		$site_settings = $this->site_settings_model->get_settings();
				
		$data['infobar_help_section'] = ""; //getinfobarcontent('bread_crumbsHELP');
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
				
		$settings = ps_getmoduleoptions("bread_crumbs");
		
		if(!isset($settings['template'])) $settings['template'] = "";
	
		$data['settings'] = $settings;

		$data['main_content'] = 'manager';
				
		$template = isset($moduleoptions['template']) ? $moduleoptions['template'] : '';
						
		$templateselectordata = array(
		
		'selector_name'=>'bread_crumbs_template',
		'selector_label'=>'Template',
		'module'=>'bread_crumbs',
		'value'=> $settings['template'],
		'is_widget' => TRUE,	
		'widgettype' => 'bread_crumbs'
				
		);
		
		$data['template_selector'] = $this->template_loader->template_selector($templateselectordata);
				
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
					
		$saveoptions['template'] = $this->input->post('bread_crumbs_template');
				
		ps_savemoduleoptions('bread_crumbs',$saveoptions);
				
	
	}
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
	
		$this->load->library('widget_utils');
	
		$data['dbprefix'] = $this->db->dbprefix;
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		$this->widget_utils->register_widget("bread_crumbs","bread_crumbs");
		
		
		
		
	}	
	
	public function uninstall(){
	
		$this->load->library('widget_utils');
					
		$this->widget_utils->un_register_widget("bread_crumbs","bread_crumbs");
	}	
	
}