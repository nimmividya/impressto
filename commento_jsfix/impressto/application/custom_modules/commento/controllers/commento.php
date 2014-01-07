<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class commento extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
			
		$this->load->helper('auth');
							
		is_logged_in();
		
		
		$this->load->model("commento/commento_model");
		
		
	}
	
	/**
	* default management page
	*
	*/
	public function index($area = "", $subarea = ""){
	
		$data = array();
				
		$this->load->helper('im_helper');
		$this->load->library('template_loader');
		$this->load->library('asset_loader');

		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/custom_modules/commento/css/admin_style.css");
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME  . "/default/vendor/jquery/plugins/mincolors/jquery.miniColors.css");
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/commento/js/commento_admin_engine.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/jquery/plugins/mincolors/jquery.miniColors.js");
				
		//$site_settings = $this->site_settings_model->get_settings();
				
		$data['infobar_help_section'] = ""; //getinfobarcontent('website_estimatorHELP');
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
				

		// Get what area are we in
		if ($area == "")  $area = "comments";
		if ($subarea == "")  $subarea = "main";


	
		$data['area'] = $area;
		$data['subarea'] = $subarea;
		
		$data['configurations'] = $this->commento_model->getConfigurations();
		
				
		$template = isset($data['configurations']['template']) ? $data['configurations']['template'] : '';
						
		$templateselectordata = array(
		
		'selector_name'=>'template',
		'selector_label'=>'Template',
		'showlabels' => FALSE,
		'module'=>'commento',
		'value'=> $template,
		'is_widget' => TRUE,	
		'widgettype' => 'commento'
				
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
	//public function save_settings(){
	
		//$this->load->helper('im_helper');
					
		//$saveoptions['template'] = $this->input->post('website_estimator_template');
				
		//ps_savemoduleoptions('commento',$saveoptions);
				
	
	///}
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
	
		$this->load->library('widget_utils');
	
		$data['dbprefix'] = $this->db->dbprefix;
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
				
		$this->widget_utils->register_widget("commento","commento");
		
		
		
		
	}	
	
	public function uninstall(){
	
		$this->load->library('widget_utils');
					
		$this->widget_utils->un_register_widget("commento","commento");
	}	
	
}