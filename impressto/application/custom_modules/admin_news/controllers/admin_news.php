<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_news extends PSAdmin_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');

				
		$this->load->model('admin_news_model');
		$this->load->model('news_model');
		
		$this->load->library("formelement");
		
		if(!$this->db->table_exists('news')) $this->install();
				
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
				
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/admin_news/js/news_manager.js");
		
		
		$data['newsrecords'] = $this->admin_news_model->get_news_items();
				
		
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		

		
		$templateselectordata = array(
		
		'selector_name'=>'newsarticle_template',
		'selector_label'=>'Template',
		'module'=>'admin_news',
		'value'=>'',
		'is_widget' => TRUE,	
		'widgettype' => 'newsarticle',
		
		);
		
		$data['newsarticle_template_selector'] = $this->template_loader->template_selector($templateselectordata);
		

		$templateselectordata = array(
		
		'selector_name'=>'newsarchives_template',
		'selector_label'=>'Template',
		'module'=>'admin_news',
		'value'=>'',
		'is_widget' => TRUE,
		'widgettype' => 'newsarchives',
		
		);
		
		$data['newsarchives_template_selector'] = $this->template_loader->template_selector($templateselectordata);
		
		
		
		$templateselectordata = array(
		
		'selector_name'=>'newsticker_template',
		'selector_label'=>'Template',
		'module'=>'admin_news',
		'value'=>'',
		'is_widget' => TRUE,	
		'widgettype' => 'newsticker',
		
		);
		
		$data['newsticker_template_selector'] = $this->template_loader->template_selector($templateselectordata);
		
		
		$fielddata = array(
		'name'        => "widget_type",
		'type'          => "select",
		'id'          => "widget_type",
		'label'          => "Widget Type",
		'options'          => array("Select"=>"","News Article"=>"newsarticle","News Archives"=>"newsarchives", "News Ticker"=>"newsticker"),
		'onchange'          => "ps_newsmanager.switch_new_widget_type(this)"		
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
	
	

		
		
		
		$data['widget_selector'] = ""; //$this->admin_news_model->widget_selector();
		
							
		$this->load->helper("im_helper");
		
		$data['moduleoptions'] = ps_getmoduleoptions('admin_news');
		

		
		
		
		$data['infobar_help_section'] = getinfobarcontent('NEWSHELP');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
		
		$data['widget_list_data'] = $this->admin_news_model->getwidgetlistdata();
		
		$data['widgetlist'] = $this->load->view('partials/widgetlist', $data, TRUE);
		
		
		
		$doc_path ="/";
		$psTitle ="";
		$data['doc_path'] = $doc_path;
		$data['psTitle'] = $psTitle;
		$data['newsmanager_header'] = $this->load->view('newsmanager_header', $data, TRUE);
		
		$data['main_content'] = 'newsmanager';
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}

	
	/**
	*
	*
	*/
	public function delete($news_id = ''){
		
		is_logged_in();
				
		$sql = "DELETE FROM {$this->db->dbprefix}news WHERE news_id = '$news_id'";
		
		mysql_query($sql);
		echo'<script>window.location="/admin/news"</script>';
		
	}
	

	/**
	* Edit the news record. If none exists load an empty edit form
	*
	*
	*/
	public function edit($news_id = ''){

		is_logged_in();
			
		$this->load->library('asset_loader');
		$this->load->library('edittools');
		$this->load->library('events');
		$this->load->helper('im_helper');
		
		$this->load->model('site_search/site_search_model');
				
		
		$this->load->plugin('widget');
		$this->load->plugin('admin_widget');
		
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/admin_news/js/news_manager.js");
		
		$this->asset_loader->add_header_js("/default/vendor/jquery/jquery.validate.min.js");
		
		$this->asset_loader->add_header_css("/default/core/css/jquery/validate/style.css");		
		
		
		
		$data['newsdata'] = array(
			'news_id' => ''
			,'opennewwindow' => ''
			,'added' => ''
			,'modified' => ''
			,'published' => ''
			,'active' => ''
			,'archived' => ''			
						
		);
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
		
			$data['newsdata']['newstitle_' . $langcode] = '';
			$data['newsdata']['newsshortdescription_' . $langcode] = '';
			$data['newsdata']['newscontent_' . $langcode] = '';
			$data['newsdata']['newslink_' . $langcode] = '';
			$data['newsdata']['news_tags_' . $langcode] = '';
		
		}
		
	
		

		if($news_id != ""){
			$data['newsdata'] = $this->admin_news_model->get_news_item($news_id);
		}
				
				
		if($data['newsdata']['published'] == "" || $data['newsdata']['published'] == "0000-00-00"){
			$data['newsdata']['published'] = date("Y-m-d");
		}
		
		
		
		// we will just use en as the default for search attribs
		$search_record = $this->site_search_model->get_search_record($news_id, "admin_news", "en"); 
		
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
		
		$data['breadcrumbs'] = array("News Manager"=>"/admin_news/","News Edit - " . $data['newsdata']['newstitle_en'] =>"");
				
		
		$data['newsmanager_header'] = $this->load->view('newsmanager_header', $data, TRUE);
		
		//$data['main_content'] = 'edit';		

		$data['parsedcontent'] = $this->load->view('edit', $data, TRUE); 
				
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
	
		is_logged_in();
	
		$this->load->library('module_installer');
		$this->load->library('widget_utils');
		
	
		$data['dbprefix'] = $this->db->dbprefix;
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		include(dirname(dirname(__FILE__)) . "/install/install.php");
		
		$this->module_installer->set_searchable('admin_news');
			
		
		
	}

	/**
	* This is a standard function that is called from the search module to obtain the correct url for searchable items
	* @author peterdrinnan 
	*/
	public function search_module_url($route, $data){
	
		static $moduleoptions;
			
		$this->load->helper("im_helper");
		
		if(!isset($data['lang']) || $data['lang'] == "") $data['lang'] = "en";
		
		if(!isset($moduleoptions)) $moduleoptions = ps_getmoduleoptions('admin_news');

		return $moduleoptions["news_page_" . $data['lang']] . "/?news_id=" . $data['content_id'];

		
	}
	
}