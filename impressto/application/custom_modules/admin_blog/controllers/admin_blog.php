<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_blog extends PSAdmin_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');

				
		$this->load->model('admin_blog_model');
		$this->load->model('blog_model');
		
		$this->load->library("formelement");
		
		if(!$this->db->table_exists('blog')) $this->install();
		
			
	}
	
	
	/**
	* Index Page for this controller.
	*
	* Maps to the following URL
	* 		http://example.com/index.php/welcome
	*	- or -  
	* 		http://example.com/index.php/welcome/index
	*	- or -
	* Since this controller is set as the default controller in 
	* config/routes.php, it's displayed at http://example.com/
	*
	* So any other public methods not prefixed with an underscore will
	* map to /index.php/welcome/<method_name>
	* @see http://codeigniter.com/user_guide/general/urls.html
	*/
	public function index(){
				
		is_logged_in();
			
		$this->load->library('asset_loader');
		$this->load->helper('im_helper');
		$this->load->library('template_loader');
				
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/admin_blog/js/blog_manager.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/jquery.popupwindow.js");
	

		
		
		
		$data['blogrecords'] = $this->admin_blog_model->get_blog_items();
				
		
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		

		
		$templateselectordata = array(
		
		'selector_name'=>'blogarticle_template',
		'selector_label'=>'Template',
		'module'=>'admin_blog',
		'value'=>'',
		'is_widget' => TRUE,	
		'widgettype' => 'blogarticle'
		
		);
		
		$data['blogarticle_template_selector'] = $this->template_loader->template_selector($templateselectordata);
		

		$templateselectordata = array(
		
		'selector_name'=>'blogarchive_template',
		'selector_label'=>'Template',
		'module'=>'admin_blog',
		'value'=>'',
		'is_widget' => TRUE,	
		'widgettype' => 'blogarchive'
		
		);
		
		$data['blogarchive_template_selector'] = $this->template_loader->template_selector($templateselectordata);
		
		
		
		$templateselectordata = array(
		
		'selector_name'=>'blogticker_template',
		'selector_label'=>'Template',
		'module'=>'admin_blog',
		'value'=>'',
		'is_widget' => TRUE,	
		'widgettype' => 'blogticker'
		
		);
		
		$data['blogticker_template_selector'] = $this->template_loader->template_selector($templateselectordata);
		
		
		$fielddata = array(
		'name'        => "widget_type",
		'type'          => "select",
		'id'          => "widget_type",
		'label'          => "Widget Type",
		'options'          => array("Select"=>"","blogarticle"=>"blogarticle","blogarchive"=>"blogarchive","blogticker"=>"blogticker"),
		'onchange'          => "ps_blogmanager.switch_new_widget_type(this)"		
		);
		
		$data['widget_type_selector'] = $this->formelement->generate($fielddata);
		
		
		
		
		$fielddata = array(
		'name'        => "widget_name",
		'type'          => 'text',
		'id'          => "widget_name",
		'label'          => "Widget Name",
		'width'          => "200"
		
		);
		
		$data['new_widget_name'] = $this->formelement->generate($fielddata);
	
		
		$data['widget_selector'] = ""; //$this->admin_blog_model->widget_selector();
		
							
		$this->load->helper("im_helper");
		
		$data['moduleoptions'] = ps_getmoduleoptions('admin_blog');
		
				
		
		$data['infobar_help_section'] = getinfobarcontent('BLOGHELP','custom_modules');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
		
		$data['widget_list_data'] = $this->admin_blog_model->getwidgetlistdata();
		
		$data['widgetlist'] = $this->load->view('partials/widgetlist', $data, TRUE);
		
		
		
		$doc_path ="/";
		$psTitle ="";
		$data['doc_path'] = $doc_path;
		$data['psTitle'] = $psTitle;
		$data['blogmanager_header'] = $this->load->view('blogmanager_header', $data, TRUE);
		
		$data['main_content'] = 'blogmanager';
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}

	
	/**
	*
	*
	*/
	public function delete($blog_id = ''){
		
		is_logged_in();
		
		
		$sql = "DELETE FROM {$this->db->dbprefix}blog WHERE blog_id = '$blog_id'";
		
		mysql_query($sql);
		echo'<script>window.location="/admin/blog"</script>';
		
	}
	

	/**
	* Edit the blog record. If none exists load an empty edit form
	*
	*
	*/
	public function edit($blog_id = ''){
	
	
		is_logged_in();
		
		
		$this->load->library('asset_loader');
		$this->load->library('edittools');
		$this->load->helper('im_helper');
		$this->load->library('events');
		$this->load->model('site_search/site_search_model');
			
		
		
		$this->load->plugin('widget');
		$this->load->plugin('admin_widget');
		
		
		$lang_avail = $this->config->item('lang_avail');
				
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/admin_blog/js/blog_manager.js");

		$this->asset_loader->add_header_js("/default/vendor/jquery/jquery.validate.min.js");
		
		$this->asset_loader->add_header_js("/default/vendor/jquery.popupwindow.js");
	

	
		$this->asset_loader->add_header_css("/default/core/css/jquery/validate/style.css");		
		
		
		
	
		// used for new record only
		$data['blogdata'] = array(
			'blog_id' => ''
			,'opennewwindow' => ''
			,'added' => ''
			,'modified' => ''
			,'active' => '0'
			,'archived' => '0'

						
		);
		
		
		foreach($lang_avail AS $langcode=>$language){ 

			$data['blogdata']['blogtitle_'.$langcode] = '';
			$data['blogdata']['author_'.$langcode] = '';
			
			
			$data['blogdata']['publish_date_'.$langcode] = '';
			$data['blogdata']['blogshortdescription_'.$langcode] = '';
			$data['blogdata']['blogcontent_'.$langcode] = '';
			$data['blogdata']['blog_tags_'.$langcode] = '';
			

		}
		
		
		

		if($blog_id != ""){
			$data['blogdata'] = $this->admin_blog_model->get_blog_item($blog_id);
		}
				
		
		foreach($lang_avail AS $langcode=>$language){ 

			if($data['blogdata']['publish_date_'.$langcode] == ""){
				$data['blogdata']['publish_date_'.$langcode] = date("Y-m-d");
			}
		
		}
	
		// we will just use en as the default for search attribs
		$search_record = $this->site_search_model->get_search_record($blog_id, "admin_blog", "en"); 
		
		if($search_record){
			
			$data['search_priority'] = $search_record['priority']; 
			$data['change_frequency'] = $search_record['change_frequency']; 
					
		}else{
		
			$data['search_priority'] = 8; 
			$data['change_frequency'] = 1; 

		}
		
		
		switch($data['change_frequency']){
				
			case 0 : $data['change_frequency_label'] = "hourly";
			break;
			case 1 : $data['change_frequency_label'] = "daily";
			break;
			case 2 : $data['change_frequency_label'] = "weekly";
			break;
			case 3 : $data['change_frequency_label'] = "monthly";
			break;
			case 4 : $data['change_frequency_label'] = "yearly";
			break;
		}
		
		

		
		$doc_path ="/";
		$psTitle ="";
		
		$data['doc_path'] = $doc_path;
		$data['psTitle'] = $psTitle;
		
		$data['breadcrumbs'] = array("Blog Manager"=>"/admin_blog/","Blog Edit - " . $data['blogdata']['blogtitle_en'] =>"");
		
		
		
		$data['blogmanager_header'] = $this->load->view('blogmanager_header', $data, TRUE);
		
		
		//$data['main_content'] = 'edit';		

				
		$data['parsedcontent'] = $this->load->view('edit', $data, TRUE); 
		
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
	}
	
	
	/**
	*  forget this , it should be a widget
	*
	*/
	public function showblogitem(){
		$this->load->view('showblogitem');
	}
	
	
	

	
	
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
	
		
		is_logged_in();
		
		$this->load->library('module_installer');
		$this->load->library('widget_utils');
	
		$data['dbprefix'] = $this->db->dbprefix;
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		include(dirname(dirname(__FILE__)) . "/install/install.php");

		$this->module_installer->set_searchable('admin_blog');
		
		
		
	}

	
	/**
	* remove the module
	*	 
	*/
	public function uninstall(){
	
	
			
		is_logged_in();
		
		
		
	}
	
	/**
	* This is a standard function that is called from the search module to obtain the correct url for searchable items
	* @author peterdrinnan 
	*/
	public function search_module_url($route, $data){
	
		static $moduleoptions;
			
		$this->load->helper("im_helper");
		
		if(!isset($data['lang']) || $data['lang'] == "") $data['lang'] = "en";
		
		if(!isset($moduleoptions)) $moduleoptions = ps_getmoduleoptions('admin_blog');

		return $moduleoptions["blog_page_" . $data['lang']] . "/?blog_id=" . $data['content_id'];

		
	}
	
}