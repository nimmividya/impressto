<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tags extends PSBase_Controller {

	public $language = 'en';

	public function __construct(){
		
		parent::__construct();
		
		$this->load->helper('auth');
		
		is_logged_in();
		
		$this->load->model('tags_model');
		
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
		$this->load->library('widget_utils');
		$this->load->library('formelement');	
		
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/tags/js/tags_manager.js");
		
		
		$this->asset_loader->add_header_js("/default/vendor/jquery/plugins/validate/jquery.validate.min.js");
		$this->asset_loader->add_header_css("/default/core/css/jquery/validate/style.css");		
		

		$site_settings = $this->site_settings_model->get_settings();
		
		$data['infobar_help_section'] = getinfobarcontent('TAGSHELP','custom_modules');
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
		$settings = ps_getmoduleoptions("tags");
		
		if(!isset($settings['tag_cloud_template'])) $settings['tag_cloud_template'] = "";
		if(!isset($settings['tag_list_template'])) $settings['tag_list_template'] = "";
		
		$data['settings'] = $settings;
		
		
		$data['widget_list'] = $this->widget_utils->get_widgets_attributes_by_module('tags','tag_cloud');
		
		$data['cloud_widget_list'] = $this->load->view('partials/widgetlist', $data, TRUE); 
		
		
		
		$templateselectordata = array(
		
		'selector_name'=>'tag_cloud_template',
		'selector_label'=>'',
		'module'=>'tags',
		'value'=> $settings['tag_cloud_template'],
		'is_widget' => TRUE,	
		'widgettype' => 'tag_cloud',
		'usewrapper' => FALSE
		
		);
		
		$data['tag_cloud_template_selector'] = $this->template_loader->template_selector($templateselectordata);
		

		$tag_cloud_content_module_options = array("Select"=>"", "Standard"=>"page_manager");
		
		$sql = "SELECT DISTINCT content_module FROM {$this->db->dbprefix}searchtags_bridge_en WHERE content_module != 'page_manager' ";
		
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				
				$cm_label = ucwords(str_replace("_"," ",str_replace("admin_","",$row->content_module)));
				
				$tag_cloud_content_module_options[$cm_label] = $row->content_module;
			}
		} 

		
		$fielddata = array(
		'name'        => "tag_cloud_content_module",
		'type'          => 'select',
		'id'          => "tag_cloud_content_module",
		'label'          => "",
		'usewrapper'          => false,
		'width'   => 180,
		'options' =>  $tag_cloud_content_module_options,
		'value'       =>  ''
		);
		
		$data['tag_cloud_content_module_selector'] = $this->formelement->generate($fielddata);
		
		$data['content_module_page_selectors'] = array();
		

		
		
		
		
		foreach($tag_cloud_content_module_options AS $val){
			
			if($val != ""){
				
				
				$optionval = isset($settings[$val . '_tag_target']) ? $settings[$val . '_tag_target'] : "";
				
				$fielddata = array(	
				'name'        => "tag_targets[{$val}]",
				'id'          => $val . '_tag_target',
				'type'          => 'select',
				'showlabels'          => false,
				'width'          => 300,
				'label'          => "",
				'onchange' => "",
				'value'       => $optionval,
				'use_ids' => FALSE,
				);

				$data['content_module_page_selectors'][$val] = get_ps_page_slector($fielddata); 
			}	
		}
		
		
		
		$templateselectordata = array(
		
		'selector_name'=>'tag_list_template',
		'selector_label'=>'Tag List Template',
		'module'=>'tags',
		'value'=> $settings['tag_list_template'],
		'is_widget' => TRUE,	
		'widgettype' => 'tag_list'
		
		);
		
		$data['tag_list_template_selector'] = $this->template_loader->template_selector($templateselectordata);
		
		
		$data['parsedcontent'] = $this->load->view('manager', $data, TRUE); 
		
		$data['data'] = $data; // Alice in Wonderland shit here!
		
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
	}
	

	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
		
		$this->load->library('widget_utils');
		
		$data['dbprefix'] = $this->db->dbprefix;
		
		//$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		

		// widget, then module. a little backwards eh!
		$this->widget_utils->register_widget("tag_cloud","tags");
		
		
		
		
	}	
	
	public function uninstall(){
		
		$this->load->library('widget_utils');
		
		// widget, then module. a little backwards eh!
		$this->widget_utils->un_register_widget("tag_cloud","tags");
	}	
	


	



	
	
}