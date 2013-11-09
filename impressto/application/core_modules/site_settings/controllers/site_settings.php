<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_Settings extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		$this->benchmark->mark('code_start');
		
		$this->load->helper('auth');
							
		is_logged_in();
		
		
		$this->load->model('site_settings_model');
		
		
		
	}
	
	
	public function index()
	{
		
		$user_session_data = $this->session->all_userdata();	
		
		$data['user_role'] = $user_session_data['role']; 

		$this->load->helper('im_helper');
		$this->load->helper('html');

		$this->load->library('formelement');	
		$this->load->library('template_loader');	
		
		
		
		$this->load->library('asset_loader');
		$this->load->helper('form');
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/core_modules/site_settings/js/site_settings.js");		
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/core_modules/site_settings/css/style.css");	


		
		
		
		//$option_data = $this->site_settings_model->get_settings();

		$option_data  = $site_settings = $this->site_settings_model->get_settings();
		
		$this->config->set_item('admin_theme', isset($site_settings['admin_theme']) ? $site_settings['admin_theme'] : "classic");
		
		$data['potential_admin_list'] = array_merge(array("Select"=>""),$this->site_settings_model->potential_admin_list());

		$data['infobar_help_section'] = getinfobarcontent('SITE_SETTINGS__HELP');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);


		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/themes/" . $this->config->item('admin_theme') . "/css/tables.css");	
		
		$this->load->library('table');
		
		$tmpl = array (
		  'table_open'          => '<table class="settings-table" id="box-table-a" style="width:100%">',
		  'heading_row_start'   => '<tr>',
		  'heading_row_end'     => '</tr>',
		  'heading_cell_start'  => '<th scope="col">',
		  'heading_cell_end'    => '</th>',
		  'row_start'           => '<tr>',
		  'row_end'             => '</tr>',
		  'cell_start'          => '<td>',
		  'cell_end'            => '</td>',
		  'table_close'         => '</table>'
		);
		
		$this->table->set_template($tmpl);      
		
		//-- Header Row
		$this->table->set_heading('Setting','Setting value' , 'Description');
	
		$this->table->add_row("Auto Activate", 
		anchor("/settings/",img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"To enable user accounts to be activated upon registration"
		);
		
		$this->table->add_row("Admin Activate", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"New user accounts to be activated only by admin"
		);
		
		$this->table->add_row("Signup", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"Enable/disable user registration"
		);
		
		$this->table->add_row("Facebook Connect", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"Allow users to login using facebook"
		);
		
		$this->table->add_row("Facebook AppID", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"The appID for the facebook application to used by the system"
		);
		
		$this->table->add_row("Facebook Secret Key", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"The appID for the facebook application to used by the system"
		);
		
		$this->table->add_row("Captcha", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"Enable/disable captcha during signup."
		);
		
		
		$data['user_settings_table'] = $this->table->generate(); 
		
		
		
		// notification setting for mail server setup
		$tmpl = array (
		  'table_open'          => '<table class="settings-table" id="box-table-a" style="width:100%">',
		  'heading_row_start'   => '<tr>',
		  'heading_row_end'     => '</tr>',
		  'heading_cell_start'  => '<th scope="col">',
		  'heading_cell_end'    => '</th>',
		  'row_start'           => '<tr>',
		  'row_end'             => '</tr>',
		  'cell_start'          => '<td>',
		  'cell_end'            => '</td>',
		  'table_close'         => '</table>'
		);
		
		$this->table->set_template($tmpl);      
		
		//-- Header Row
		$this->table->set_heading('Setting','Setting value' , 'Description');
	
		$this->table->add_row("Auto Activate", 
		anchor("/settings/",img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"To enable user accounts to be activated upon registration"
		);
		
		$this->table->add_row("Admin Activate", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"New user accounts to be activated only by admin"
		);
		
		$this->table->add_row("Signup", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"Enable/disable user registration"
		);
		
		$this->table->add_row("Facebook Connect", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"Allow users to login using facebook"
		);
		
		$this->table->add_row("Facebook AppID", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"The appID for the facebook application to used by the system"
		);
		
		$this->table->add_row("Facebook Secret Key", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"The appID for the facebook application to used by the system"
		);
		
		$this->table->add_row("Captcha", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"Enable/disable captcha during signup."
		);
		
		
		
		$data['notification_settings_table'] = $this->table->generate(); 
		
		$data['breadcrumbs'] = array("Configuration"=>"","Site Settings"=>"");
		

		$data['available_themes'] = $this->site_settings_model->get_themes();
		
	
		
		$data['main_content'] = 'site_settings_view';
		
		$data['option_data'] = $option_data;
		
				
		$data['data'] = $data; // Alice in Wonderland shit here!
			
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);		
		
	
		
	}
	

	function save_settings(){
		
		//$this->site_settings->save_settings();
		
		$toprocess = array();
		
		
		$toprocess ['site_title'] = $this->input->post('site_title');
	
		$toprocess ['homepage_en_id'] = $this->input->post('homepage_en_id');
		$toprocess ['homepage_fr_id'] = $this->input->post('homepage_fr_id');
		$toprocess ['splash_page_id'] = $this->input->post('splash_page_id');
		
		// developer settings
		$toprocess ['debugmode'] = $this->input->post('debugmode');
		$toprocess ['debug_profiling'] = $this->input->post('debug_profiling');
		$toprocess ['unit_testing'] = $this->input->post('unit_testing');
		$toprocess ['api_key'] = $this->input->post('api_key');
		
		$toprocess ['site_admin'] = $this->input->post('site_admin');
		

		$toprocess ['admin_theme'] = $this->input->post('admin_theme');
		
		
		$toprocess ['site_title_en'] = $this->input->post('site_title_en');
		$toprocess ['site_title_fr'] = $this->input->post('site_title_fr');
		$toprocess ['site_keywords_en'] = $this->input->post('site_keywords_en');
		$toprocess ['site_keywords_fr'] = $this->input->post('site_keywords_fr');
		$toprocess ['site_description_en'] = $this->input->post('site_description_en');		
		$toprocess ['site_description_fr'] = $this->input->post('site_description_fr');	

		$toprocess ['wysiwyg_editor'] = $this->input->post('wysiwyg_editor');
		$toprocess ['page_cache_timeout'] = $this->input->post('page_cache_timeout');
				
		$toprocess ['jquery_version'] = $this->input->post('jquery_version');
		$toprocess ['jquery_ui_theme'] = $this->input->post('jquery_ui_theme');
		$toprocess ['jquery_ui_version'] = $this->input->post('jquery_ui_version');
		
		
		
		if(is_array($this->input->post('languages'))){
		
			$toprocess ['languages'] = implode(",",$this->input->post('languages'));
			
		}
		
				
		$this->site_settings_model->save_settings($toprocess);
		
		
		$search_settings ['search_template'] = $this->input->post('search_template');
		$search_settings ['search_sortmethod'] = $this->input->post('search_sortmethod');
		
		$this->site_settings_model->save_search_settings($search_settings);
	
	}	

	
	
	
}

?>