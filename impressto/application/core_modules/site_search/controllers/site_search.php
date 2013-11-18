<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class site_search extends PSBase_Controller {


	public function __construct(){
		
		parent::__construct();
		
		$this->load->helper('auth');
		is_logged_in();
	
		$this->load->model('site_search_model');
		
	
		
	}
	
	
	/**
	* Index Page for this controller.
	*
	*/
	public function index(){
	
		$this->load->library('asset_loader');
		$this->load->helper('im_helper');
		$this->load->library('template_loader');
		$this->load->library('formelement');
		
				
				
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/site_search/js/search_settings.js");
		
						
		$data['search_templates'] = array_merge(array("Select"=>""),$this->template_loader->find_templates(array("module"=>"site_search","is_widget"=>TRUE)));
		
		
		
		
		$data['searchoptions'] = ps_getmoduleoptions('site_search');
		
		
		if(isset($data['searchoptions']['content_filters']) && $data['searchoptions']['content_filters'] != ""){
			
			$data['searchoptions']['content_filters'] = unserialize( $data['searchoptions']['content_filters'] );
					
		}
		
		
		$data['active_content_types'] = $this->site_search_model->get_active_content_types();
		
		
			
			
		$data['infobar_help_section'] = getinfobarcontent('SITESEARCHHELP');
		//$data['infobar'] = $this->load->view('infobar', $data, true);
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);

		

		
		$data['main_content'] = 'layouts/search_settings';
		
		$site_settings = $this->site_settings_model->get_settings();
		$this->config->set_item('admin_theme', isset($site_settings['admin_theme']) ? $site_settings['admin_theme'] : "classic");
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
	
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		

	
	}
	
	
	
	/**
	* Index Page for this controller.
	*
	*/
	public function search_records(){
	
		$this->load->library('asset_loader');
		$this->load->helper('im_helper');
		$this->load->library('template_loader');
		$this->load->library('formelement');
		
				
				
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/site_search/js/search_settings.js");
		
						
		$data['search_templates'] = array_merge(array("Select"=>""),$this->template_loader->find_templates(array("module"=>"site_search","is_widget"=>TRUE)));
		
		
		$data['searchoptions'] = ps_getmoduleoptions('site_search');
			
			
		$data['infobar_help_section'] = getinfobarcontent('SITESEARCHHELP');
		//$data['infobar'] = $this->load->view('infobar', $data, true);
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);

		
		$data['main_content'] = 'layouts/search_records';
		
		$site_settings = $this->site_settings_model->get_settings();
		$this->config->set_item('admin_theme', isset($site_settings['admin_theme']) ? $site_settings['admin_theme'] : "classic");
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		

	
	}
	
	
	/**
	* Index Page for this controller.
	*
	*/
	public function search_indexes(){
	
		$this->load->library('asset_loader');
		$this->load->helper('im_helper');
		$this->load->library('template_loader');
		$this->load->library('formelement');
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/site_search/js/search_settings.js");
		
		$data['search_templates'] = array_merge(array("Select"=>""),$this->template_loader->find_templates(array("module"=>"search","is_widget"=>TRUE)));
		
		$data['searchoptions'] = ps_getmoduleoptions('site_search');
			
			
		$data['infobar_help_section'] = getinfobarcontent('SITESEARCHHELP');
		//$data['infobar'] = $this->load->view('infobar', $data, true);
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);

		
		$data['main_content'] = 'layouts/search_indexes';
		
		$site_settings = $this->site_settings_model->get_settings();
		$this->config->set_item('admin_theme', isset($site_settings['admin_theme']) ? $site_settings['admin_theme'] : "classic");
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);		
		
	}
	

	/**
	* ajax responder
	*
	*/  
    function savesettings()  
    {  
	
		$this->load->helper('im_helper');
	
		$lang_avail = $this->config->item('lang_avail');
					

		foreach($lang_avail AS $langcode=>$language){

			$saveoptions['search_page_' .$langcode] = $this->input->post('search_page_' . $langcode);
		
		}		
		
		
		$saveoptions['search_template'] = $this->input->post('search_template');
		$saveoptions['sortmethod'] = $this->input->post('sortmethod');
		$saveoptions['listings_per_page'] = $this->input->post('listings_per_page');
		$saveoptions['pagination_method'] = $this->input->post('pagination_method');
		$saveoptions['traillength'] = $this->input->post('traillength');
		
		$content_filters = $this->input->post('content_filters');
		
		if(is_array($content_filters)) $saveoptions['content_filters'] = serialize($content_filters);
		
							
		ps_savemoduleoptions('site_search',$saveoptions);
		

    }  
	
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){


		$this->load->library('widget_utils');
		
		$data['dbprefix'] = $this->db->dbprefix;
		
		$lang_avail = $this->config->item('lang_avail');
											
		foreach($lang_avail AS $key=>$val){ 
		
		
			if(!$this->db->table_exists($this->db->dbprefix('searchindex_' . $key))){

				$data['lang'] = $key;
				
				$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
			}
		}
		
		include(dirname(dirname(__FILE__)) . "/install/install.php");
		

		$this->widget_utils->register_widget("site_search","site_search");
		
		
		
	}
	
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function uninstall(){


		$this->load->library('widget_utils');
		
		
		
		$this->widget_utils->un_register_widget("search","search");
		
		
		
	}
	
		
	

	

	
	
}