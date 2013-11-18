<?php

class templates extends PSBase_Controller {

	private $template_folder;


		
	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
			
		$this->template_folder = $_SERVER["DOCUMENT_ROOT"] . "/" . PROJECTNAME . "/templates/smarty/";
								
		is_logged_in();
		
		$this->load->model('template_model', 'model');
			
		$this->model->init_impressto();
	}
	
	/**
	* default management page
	*
	*/
	public function index(){
	
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		
		$this->load->library('asset_loader');
		$this->load->library('formelement');
		
	
		$this->load->helper('im_helper');

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/jquery/plugins/markitup/jquery.markitup.js");		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/templates/js/markitup_set.js");	
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/templates/js/template_manager.js");
		
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME  . "/default/vendor/jquery/plugins/markitup/skins/markitup/style.css");
		$this->asset_loader->add_header_css(ASSETURL .PROJECTNAME."/core_modules/templates/css/markitup_style.css");	
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/core_modules/templates/css/style.css");	

		

		
		
		
		$fielddata = array(
		
		'name'        => "template_type_selector",
		'type'          => 'radio',
		'id'          => "template_type_selector",
		'orientation'          => "horizontal",
		'label' => 'Type',
		'width'          => 100,
		'options' =>  array("Articles"=>"smarty","Widgets"=>"widgets"),
		'value' => "smarty",
		'onchange' =>  "ps_templatemanager.select_template_type(this);"

		);
				
		$data['template_type_selector'] = $this->formelement->generate($fielddata);
		
		$this->load->helper('templates');
		
		
		$data['infobar_help_section'] = getinfobarcontent('TEMPLATEMANAGERHELP');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);

			


		$widgets_array = get_widget_types();
		
		ksort($widgets_array);
		
		
		$fielddata = array(
		
		'name'        => "widget_type_selector",
		'type'          => 'select',
		'id'          => "widget_type_selector",
		'width'          => "150",
		'label'    => "Widget Type",
		'visible'          => false,
		'options' =>  array_merge(array("Select"=>""),$widgets_array),
		'onchange' =>  "ps_templatemanager.select_widget_type(this);"

		);
				
		$data['widget_type_selector'] = $this->formelement->generate($fielddata);
		
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		$data['main_content'] = 'index';
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);		
		

		
	}
	

	
	
	

} //end class