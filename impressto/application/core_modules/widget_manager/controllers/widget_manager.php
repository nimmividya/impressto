<?php

class widget_manager extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->helper('auth');
		$this->load->library('impressto');
		$this->load->library('widget_utils');
		
		
		$this->impressto->setDir(APPPATH . "/core_modules/widget_manager/views/ps_templates");
		
		
		is_logged_in();
		
		//if(!$this->db->table_exists('ps_image_slider')) $this->install();
		
		$this->load->model('widget_manager_model');
		
		
	}
	
	/**
	* default management page
	*
	*/
	public function index($param = ''){
		
		// this is necessary for the left nav bar to work
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 

		$this->load->helper('im_helper');
		
		
		$this->load->library('asset_loader');
		$this->load->library('formelement');
		
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/core_modules/widget_manager/js/widget_manager.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/third_party/mincolors/jquery.miniColors.js");
		
		
		

		$this->asset_loader->add_header_js('/third_party/bootstrap/js/bootstrap-tooltip.js');
		$this->asset_loader->add_header_js('/third_party/bootstrap/js/bootstrap/bootstrap-alert.js');
		
		
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . '/default/core_modules/widget_manager/css/style.css');
	
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . '/default/third_party/mincolors/jquery.miniColors.css');
		
		$fielddata = array(
			'name'     =>  "wm_zone_selector",
			'type'     =>  'select',
			'id'       =>  "wm_zone_selector",
			'width'    =>  "150",
			'options'  =>  $this->widget_manager_model->getzones(),
			'onchange' =>  "ps_widget_manager.selectzone(this);"
		);
				
		$data['zone_selector'] = $this->formelement->generate($fielddata);

		
		$this->widget_manager_model->scan_adhoc_widgets();
		
		
		
		$data['widget_collection_options'] = $this->widget_manager_model->getwidgetcollections();
		
		$data['active_widgets'] = $this->widget_manager_model->get_active_widgets();
		
		$data['infobar_help_section'] = getinfobarcontent('WIDGETMANAGERHELP');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);

		
		
		$data['main_content'] = 'widget_manager';
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}

	
	/**
	* default management page
	*
	*/
	public function loadzonelist(){
		

		$this->load->library('formelement');
		
			
		$page = $this->input->post('page');
		$zone = $this->input->post('zone');
		
		
		$data['page_options'] = $this->widget_manager_model->getpagelist('top');
		
			
		$fielddata = array(
			'name'      =>  "wm_zone_selector",
			'type'      =>  'select',
			'id'        =>  "wm_zone_selector",
			'width'     =>  "150",
			'options'   =>  $this->widget_manager_model->getzones(),
			'onchange'  =>  "ps_widget_manager.selectzone(this);"
		);
		$data['zone_selector'] = $this->formelement->generate($fielddata);
		$data['core_widgets'] = $this->widget_manager_model->get_core_widgets();
		$data['main_content'] = 'widget_manager';
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}
} //end class