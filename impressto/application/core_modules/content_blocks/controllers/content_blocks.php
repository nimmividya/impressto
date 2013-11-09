<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* standard content blocks
*
*/

class content_blocks extends PSAdmin_Controller {


	public function __construct(){
		
		parent::__construct();
		
		$this->benchmark->mark('code_start');
		
		$this->load->helper('auth');
		
		is_logged_in();
		
		if(!$this->db->table_exists($this->db->dbprefix('contentblocks_en'))) $this->install();
		
		$this->load->model('content_blocks_model','model');
						
		
		
	}
	
	
	/**
	* Index Page for this controller.
	*
	*/
	public function index(){
		
		
		$this->load->library('asset_loader');
		$this->load->helper('im_helper');
		$this->load->library('formelement');
		$this->load->library('template_loader');
		$this->load->library('edittools');
						
		$data['blocklistdata'] = $this->model->getblocklist();
		
						
		$data['blocklist'] = $this->load->view('blocklist', $data, true);	
				
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/third_party/markitup/jquery.markitup.js");		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/page_manager/js/markitup_set.js");		
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME  . "/default/third_party/markitup/skins/markitup/style.css");
		$this->asset_loader->add_header_css(ASSETURL .PROJECTNAME."/core_modules/page_manager/css/markitup_style.css");	
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/content_blocks/js/content_blocks_manager.js");
	
	

		
		$data['template_select_options'] = array(); 
		
		$data['current_template'] = "index";
		
	
		$data['template_options'] = array_merge(array("Select"=>""),$this->template_loader->find_templates(array("module"=>"content_blocks","is_widget"=>TRUE)));
				
			
		
		$data['infobar_help_section'] = getinfobarcontent('CONTENTBLOCKSHELP');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);


		
		//$data['main_content'] = 'manager';
		

		$data['parsedcontent'] = $this->load->view('manager', $data, TRUE); 
		
		
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
	

		$this->load->library('module_installer');
		
		$data['dbprefix'] = $this->db->dbprefix;
		
		
		$lang_avail = $this->config->item('lang_avail');
											
		foreach($lang_avail AS $key=>$val){ 
		
		
			if(!$this->db->table_exists($this->db->dbprefix('contentblocks_' . $key))){

				$data['lang'] = $key;
				
				$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
			}
		}
			


		
		
	}
	
	
	
}