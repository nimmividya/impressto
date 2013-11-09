<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tubepress extends PSAdmin_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		
		
		$this->load->model('tubepress_model');
		$this->load->library('asset_loader');
		
		
		
		
		if(!$this->db->table_exists('tubepress')) $this->install();
		
		
	}
	
	
	/**
	* Index Page for this controller.
	*
	*/
	public function index(){
		

		$this->load->helper('im_helper');
		$this->load->library('template_loader');
		$this->load->library('asset_loader');
		
		$this->asset_loader->add_header_js("/vendor/bootstrap/js/bootstrap-tooltip.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/custom_modules/tubepress/js/tubepress_manager.js");
			
	
		$data = array();

		
		$data['infobar_help_section'] = getinfobarcontent('TUBEPRESSHELP','custom_modules');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
		
		
			
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		

		
		$templateselectordata = array(
		
		'selector_name'=>'template',
		'selector_id'=>'template',
		'selector_label'=>'Wrapper Template',
		'module'=>'tubepress',
		'value'=>'',
		'is_widget' => TRUE,	
		'widgettype' => 'gallery'
		
		);
		
		$data['template_selector'] = $this->template_loader->template_selector($templateselectordata);
		
		
		$fielddata = array(
		'name'        => "theme",
		'type'          => 'select',
		'id'          => "theme",
		'label'          => "TubePress Theme",
		'width'          => "200",
		'options' => $this->tubepress_model->get_tubepress_themes(),
		'value'  => '',
		
		
		);
		
		$data['theme_selector'] = $this->formelement->generate($fielddata);
		
		
		
		
		$fielddata = array(
		'name'        => "widget_name",
		'type'          => 'text',
		'id'          => "widget_name",
		'label'          => "Widget Name",
		'width'          => "200"
		
		);
		
		$data['new_widget_name'] = $this->formelement->generate($fielddata);
	
	
		$data['widget_list_data'] = $this->tubepress_model->getwidgetlistdata();
		
		$data['widgetlist'] = $this->load->view('partials/widgetlist', $data, TRUE);
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		
		
		$data['main_content'] = 'settings';
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);		
		
	}
	
	
	

	/**
	*
	*
	*/
	public function getwidgetdata($widget_id){
	
		$this->load->library('widget_utils');
				
		$widget_data = $this->widget_utils->get_widget_options($widget_id);
		
		echo json_encode($widget_data);

		
	
	}
	
	
	
	/**
	*
	*
	*/
	public function loadwidgetlist(){
	
		$data['widget_list_data'] = $this->tubepress_model->getwidgetlistdata();
		
		echo $this->load->view('partials/widgetlist', $data, TRUE);
		
	
	}
	
	/**
	*
	*
	*/
	public function load_widget_settings($widget_id){
	
		$settings = $this->tubepress_model->get_settings($widget_id);
						
		$data = array('tubepress'=>array());
		
		
		foreach ($settings as $key => $val){
		
			$data['tubepress'][strtolower($key)] = $val;
		}
		
		
		
		echo $this->load->view('partials/widget_settings', $data, TRUE);
		
	
	}	
	/**
	*
	*
	*/
	public function deletewidget($id){
		
		//$return_array = array();
		
		$this->load->library('widget_utils');
				
		$this->widget_utils->delete_widget($id);
		
		$this->tubepress_model->delete_tubepress_widget_settings($id);
				
		echo "deleted";

		
	}
	
	
	public function savewidget(){
	
		$return_array = array();
		
	
		// all we need is thethe widget name
		$widget_instance_name = trim($this->input->get_post('widget_name'));
		$widget_template = $this->input->get_post('template'); 
		$widget_theme = $this->input->get_post('theme'); 
				
			
		if($widget_template == "" || $widget_instance_name == ""){
		
			echo "missing data";
			return;
			
		}
	
		
		$widget_id = $this->input->get_post('widget_id');
	
		
		$this->load->library('widget_utils');
		
		if($widget_id == ""){
		
			// fist thing is to create the widget instance
			$widget_id = $this->widget_utils->register_widget('gallery', 'tubepress', $widget_instance_name);
			
		}
		
		// update the name in case it was changed
		$sql = "UPDATE {$this->db->dbprefix}widgets SET instance = '{$widget_instance_name}' WHERE widget_id = '{$widget_id}'";
		$this->db->query($sql);

		
		$this->widget_utils->set_widget_option($widget_id, 'template',$widget_template);
		$this->widget_utils->set_widget_option($widget_id, 'theme',$widget_theme);
		
		$widget_data = array(
		
		'mode' => $this->input->post('mode'),
		'favoritesValue' => $this->input->post('favoritesValue'),
		'recently_featured' => $this->input->post('recently_featured'),
		'userValue' => $this->input->post('userValue'),
		'playlistValue' => $this->input->post('playlistValue'),
		'tagValue' => $this->input->post('tagValue'),
		'most_viewedValue' => $this->input->post('most_viewedValue'),
		'top_ratedValue' => $this->input->post('top_ratedValue'),
		'youtubeTopFavoritesValue' => $this->input->post('youtubeTopFavoritesValue'),
		'most_discussedValue' => $this->input->post('most_discussedValue'),
		'most_recentValue' => $this->input->post('most_recentValue'),
		'most_respondedValue' => $this->input->post('most_respondedValue'),
		'thumbHeight' => $this->input->post('thumbHeight'),
		'thumbWidth' => $this->input->post('thumbWidth'),
		'resultsPerPage' => $this->input->post('resultsPerPage'),
		'playerLocation' => $this->input->post('playerLocation'),
		'playerImplementation' => $this->input->post('playerImplementation'),
		'embeddedHeight' => $this->input->post('embeddedHeight'),
		'embeddedWidth' => $this->input->post('embeddedWidth'),
		'playerColor' => $this->input->post('playerColor'),
		'playerHighlight' => $this->input->post('playerHighlight'),
		'showRelated' => $this->input->post('showRelated'),
		'metadropdown' => $this->input->post(''), // array
		'dateFormat' => $this->input->post('dateFormat'),
		'descriptionLimit' => $this->input->post('descriptionLimit'),
		'theme' => $this->input->post('theme'),
		'orderBy' => $this->input->post('orderBy'),
		'perPageSort' => $this->input->post('perPageSort'),
		'resultCountCap' => $this->input->post('resultCountCap'),
		'developerKey' => $this->input->post('developerKey'),
		'videoBlacklist' => $this->input->post('videoBlacklist'),
		'searchResultsRestrictedToUser' => $this->input->post('searchResultsRestrictedToUser'),
		'cacheLifetimeSeconds' => $this->input->post('cacheLifetimeSeconds'),
		'cacheCleaningFactor' => $this->input->post('cacheCleaningFactor'),
		'keyword' => $this->input->post('keyword'),
		'disableHttpTransportCurl' => $this->input->post('disableHttpTransportCurl'),
		'disableHttpTransportExtHttp' => $this->input->post('disableHttpTransportExtHttp'),
		'disableHttpTransportFopen' => $this->input->post('disableHttpTransportFopen'),
		'disableHttpTransportFsockOpen' => $this->input->post('disableHttpTransportFsockOpen'),
		'disableHttpTransportStreams' => $this->input->post('disableHttpTransportStreams'),

		);
		
		if($this->input->post('cacheEnabled') == "true")$widget_data['cacheEnabled'] = "true";
		else $widget_data['cacheEnabled'] = "false";
				
		if($this->input->post('embeddableOnly') == "true")$widget_data['embeddableOnly'] = "true";
		else $widget_data['embeddableOnly'] = "false";
		
		if($this->input->post('debugging_enabled') == "true")$widget_data['debugging_enabled'] = "true";
		else $widget_data['debugging_enabled'] = "false";

		if($this->input->post('relativeDates') == "true")$widget_data['relativeDates'] = "true";
		else $widget_data['relativeDates'] = "false";


		if($this->input->post('enableJsApi') == "true")$widget_data['enableJsApi'] = "true";
		else $widget_data['enableJsApi'] = "false";
		
		if($this->input->post('modestBranding') == "true")$widget_data['modestBranding'] = "true";
		else $widget_data['modestBranding'] = "false";
		
		if($this->input->post('autoHide') == "true")$widget_data['autoHide'] = "true";
		else $widget_data['autoHide'] = "false";
			
		
		
		if($this->input->post('showRelated') == "true")$widget_data['showRelated'] = "true";
		else $widget_data['showRelated'] = "false";
		
		
		if($this->input->post('loop') == "true")$widget_data['loop'] = "true";
		else $widget_data['loop'] = "false";
		
		
		if($this->input->post('autoplay') == "true")$widget_data['autoplay'] = "true";
		else $widget_data['autoplay'] = "false";
		
		
		if($this->input->post('autoNext') == "true")$widget_data['autoNext'] = "true";
		else $widget_data['autoNext'] = "false";

		
		if($this->input->post('hd') == "true")$widget_data['hd'] = "true";
		else $widget_data['hd'] = "false";
		
		
		
		if($this->input->post('fullscreen') == "true")$widget_data['fullscreen'] = "true";
		else $widget_data['fullscreen'] = "false";
		
		
		if($this->input->post('showInfo') == "true")$widget_data['showInfo'] = "true";
		else $widget_data['showInfo'] = "false";

		
		if($this->input->post('lazyPlay') == "true")$widget_data['lazyPlay'] = "true";
		else $widget_data['lazyPlay'] = "false";

		
		
		if($this->input->post('randomize_thumbnails') == "true")$widget_data['randomize_thumbnails'] = "true";
		else $widget_data['randomize_thumbnails'] = "false";

	
		if($this->input->post('hqThumbs') == "true")$widget_data['hqThumbs'] = "true";
		else $widget_data['hqThumbs'] = "false";
		
		
		if($this->input->post('paginationBelow') == "true")$widget_data['paginationBelow'] = "true";
		else $widget_data['paginationBelow'] = "false";
		
		
		if($this->input->post('paginationAbove') == "true")$widget_data['paginationAbove'] = "true";
		else $widget_data['paginationAbove'] = "false";
		
		
		if($this->input->post('fluidThumbs') == "true")$widget_data['fluidThumbs'] = "true";
		else $widget_data['fluidThumbs'] = "false";
		
		
		if($this->input->post('ajaxPagination') == "true")$widget_data['ajaxPagination'] = "true";
		else $widget_data['ajaxPagination'] = "false";
		

		$widget_data['cacheDirectory'] = "";
		
		// we will make sure the cachedirectory is legit and if so make sure the directory exists
		if($this->input->post('cacheDirectory') != "") {
		
			$cacheDirectory = trim($this->input->post('cacheDirectory'));
			
			if($cacheDirectory != "" && $cacheDirectory != "/" && $cacheDirectory != "\\"){
				
				$this->load->library('file_tools');
				$this->file_tools->create_dirpath( $cacheDirectory );
				$widget_data['cacheDirectory'] = $cacheDirectory;
			}
		
		}
		
		$data['widget_id'] = $widget_id;
		$data['widget_settings'] = $widget_data;
		
	
		$this->tubepress_model->save_tubepress_widget_settings($data);
		
		

		
		
	
		
		$return_array['widget_id'] = $widget_id;
		
		echo json_encode($return_array);
		
	
	}
	
	
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
	
	
		$this->load->library('module_installer');
		$this->load->library('widget_utils');
	
		$data['dbprefix'] = $this->db->dbprefix;
		
		//$this->module_installer->process_file(APPPATH . "/custom_modules/admin_news/install/structure.sql");
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);


		
		// this is the full screen news article widget
	
		$this->widget_utils->register_widget("player","tubepress");
		
		
		
		
	}
	
	

	

	
	
}