<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class xtra_content extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->helper('auth');
		$this->load->library('impressto');
				
		is_logged_in();
		
		if(!$this->db->table_exists('ps_top_banners')) $this->install();
				
		$this->load->model('xtra_content_model');
	
		
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

		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/xtra_content/js/xtra_content_manager.js");
		
		// SEE http://www.ericmmartin.com/projects/simplemodal/
		
		$this->asset_loader->add_header_js("/assets/vendor/simplemodal/js/jquery.simplemodal.js");
		$this->asset_loader->add_header_css("/assets/vendor/simplemodal/css/style.css");	
		
		

		//$site_settings = $this->site_settings_model->get_settings();
					
		$data['infobar_help_section'] = getinfobarcontent('XTRACONTENTHELP','custom_modules');
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
				
		//$settings = ps_getmoduleoptions("admin_bar");
		
		$data['fields'] = $this->xtra_content_model->get_table_fields("standard");
		$data['field_media'] = "standard";
		$data['field_media_prefix'] = "xtra_";
		$data['standard_fieldlist'] = $this->load->view('partials/field_list', $data, TRUE); 
		
		
		$data['fields'] = $this->xtra_content_model->get_table_fields("mobile");
		$data['field_media'] = "mobile";
		$data['field_media_prefix'] = "xtra_mobile_";
		$data['mobile_fieldlist'] = $this->load->view('partials/field_list', $data, TRUE); 
		
		
		$data['parsedcontent'] = $this->load->view('manager', $data, TRUE); 
		
		
				
		$data['data'] = $data; // Alice in Wonderland shit here!
					
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}
	
	
	/**
	*
	*
	*/	
	function reloadlist($media){
	
		$data = array();
		
		$data['fields'] = $this->xtra_content_model->get_table_fields($media);
		
		if($media != "mobile") $data['field_media_prefix'] = "xtra_mobile_";
		else $data['field_media_prefix'] = "xtra_";
		
			
		$data['field_media'] = $media;
		
		echo $this->load->view('partials/field_list', $data, TRUE);
		
		

	}
	
	
	/**
	*
	*
	*/
	public function rename_field(){
	
		$old_field_name = $this->input->post('old_rename_field_name');
		$new_field_name = $this->input->post('new_rename_field_name');
		$media = $this->input->post('rename_field_media');
	
	
		$this->xtra_content_model->rename_field($old_field_name,$new_field_name,$media);
		
		
		
	}
	
	function add_field(){
	
		$field_name = $this->input->post('new_field_name');
		$type = $this->input->post('field_type');
		
		if($type == "varchar_250") $length = 250;
		else $length = null;
		
		$media = $this->input->post('new_field_media');
	
	
		$this->xtra_content_model->add_field($field_name,$type,$length,$media);
		
		
	}
	
	
	/**
	*
	*
	*/	
	function delete_field($field_name, $media){
	
		$this->xtra_content_model->delete_field($field_name, $media,$this->config->item('lang_default'));
		
		

	}
	
	
		
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){

		$this->load->library('module_installer');

		$lang_avail = $this->config->item('lang_avail');
		
		$data['dbprefix'] = $this->db->dbprefix;
			
		
		//echo " FLAG1 ";
				
		foreach($lang_avail AS $langcode=>$language){ 
		
			$data['langcode'] = $langcode;
		
			$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
			
		}

		// now copy any required css or js fles to the assets folder
		$this->module_installer->copy_assets("/custom_modules/" . $this->router->class);

		
	}
	
	public function uninstall(){


	}	
	











} //end class