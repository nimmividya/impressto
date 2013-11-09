<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class form_builder extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		$this->load->helper('auth');
		
		is_logged_in();
		
		$this->load->model('form_builder_model');
		
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
		
		// we need to load up the correct version. This will preserve older versions of assets if we are doing auto updates on modules.
		$module_version = $this->_get_module_version();
		$file_version_tag = "";
		if($module_version) $file_version_tag = "." . $module_version;
				
				
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/custom_modules/form_builder/css/manager{$file_version_tag}.css");
		$this->asset_loader->add_header_css("vendor/bootstrap/css/bootstrap-wysihtml.css");
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME  . "/default/vendor/markitup/skins/markitup/style.css");
		$this->asset_loader->add_header_css(ASSETURL .PROJECTNAME."/custom_modules/form_builder/css/markitup_style.css");	
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/vendor/bvalidator/bvalidator.css"); 
		

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/form_builder/js/form_builder_manager{$file_version_tag}.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/jquery/jquery.tablednd.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/markitup/jquery.markitup.js");		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/form_builder/js/markitup_set.js");	
		
		// used on the settings page
		$this->asset_loader->add_header_js("vendor/bootstrap/js/wysihtml5.js"); // this is the core wysiwyg library from Christopher Blum
		$this->asset_loader->add_header_js("vendor/bootstrap/js/bootstrap-wysihtml5.js"); // this is the extended, prettified version from James Hollingworth
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/bvalidator/jquery.bvalidator.js"); 

		
		$site_settings = $this->site_settings_model->get_settings();
		
		$data['infobar_help_section'] = getinfobarcontent('CONTACTFORMHELP');
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
		$settings = ps_getmoduleoptions("form_builder");
		

		
		
		if(!isset($settings['template']))  $settings['template'] = "";
		if(!isset($settings['email_account']))  $settings['email_account'] = "";
		if(!isset($settings['small_desc']))  $settings['small_desc'] = "";
		if(!isset($settings['title']))  $settings['title'] = "";
		if(!isset($settings['button_value']))  $settings['button_value'] = "";
		if(!isset($settings['captcha']))  $settings['captcha'] = "";
		if(!isset($settings['captcha_theme']))  $settings['captcha_theme'] = "";
		
		
		if(!isset($settings['successful_message']))  $settings['successful_message'] = "";
		if(!isset($settings['from_a']))  $settings['from_a'] = "";
		if(!isset($settings['page_title']))  $settings['page_title'] = "";
		if(!isset($settings['mapcode']))  $settings['mapcode'] = "";
		if(!isset($settings['form_javascript']))  $settings['form_javascript'] = "";
		
		
		$data['settings'] = $settings;
		//print_r($settings);
				
		$template = isset($moduleoptions['template']) ? $moduleoptions['template'] : '';
						
		$templateselectordata = array(
		
		'selector_name'=>'form_builder_template',
		'selector_label'=>'Template',
		'module'=>'form_builder',
		'value'=> $settings['template'],
		'is_widget' => TRUE,	
		'widgettype' => 'form_builder',
		'usewrapper' => FALSE,
		'showlabels' => FALSE,
				
		);
		
		
		$data['form_list_data'] = $this->form_builder_model->get_form_list_data();
		
	
		$data['formlist'] = $this->load->view('partials/formlist', $data, TRUE); 
			
		
				
		$data['template_selector'] = $this->template_loader->template_selector($templateselectordata);
		
		
		$data['visualcaptcha_themes'] = $this->form_builder_model->get_visualcaptcha_themes();

		
		$data['fieldlist'] = $this->load->view('partials/fieldlist', $data, TRUE); 
		
		$data['parsedcontent'] = $this->load->view('manager', $data, TRUE); 
		
		$data['data'] = $data; // Alice in Wonderland stuff here!
		
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
	}
	
	
	
	/**
	* default management page
	*
	*/
	public function build($form_id){
		
		$data = array();

		$data['form_id'] = $form_id;
		
		$this->load->helper('im_helper');
		$this->load->library('template_loader');
		$this->load->library('asset_loader');
		$this->load->library('edittools');
		
		// we need to load up the correct version. This will preserve older versions of assets if we are doing auto updates on modules.
		$module_version = $this->_get_module_version();
		$file_version_tag = "";
		if($module_version) $file_version_tag = "." . $module_version;
				
				
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/custom_modules/form_builder/css/manager{$file_version_tag}.css");
		$this->asset_loader->add_header_css("vendor/bootstrap/css/bootstrap-wysihtml.css");
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME  . "/default/vendor/markitup/skins/markitup/style.css");
		$this->asset_loader->add_header_css(ASSETURL .PROJECTNAME."/custom_modules/form_builder/css/markitup_style.css");	
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/vendor/bvalidator/bvalidator.css"); 
		

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/form_builder/js/form_builder_manager{$file_version_tag}.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/jquery/jquery.tablednd.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/markitup/jquery.markitup.js");		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/form_builder/js/markitup_set.js");	
		
		// used on the settings page
		$this->asset_loader->add_header_js("vendor/bootstrap/js/wysihtml5.js"); // this is the core wysiwyg library from Christopher Blum
		$this->asset_loader->add_header_js("vendor/bootstrap/js/bootstrap-wysihtml5.js"); // this is the extended, prettified version from James Hollingworth
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/bvalidator/jquery.bvalidator.js"); 

		
		$site_settings = $this->site_settings_model->get_settings();
		
		$data['infobar_help_section'] = getinfobarcontent('CONTACTFORMHELP');
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
		
		$settings = $this->form_builder_model->get_form_settings($form_id);
		
	
		
		
		
		
		
		if(!isset($settings['template']))  $settings['template'] = "";
		if(!isset($settings['email_account']))  $settings['email_account'] = "";
		if(!isset($settings['small_desc']))  $settings['small_desc'] = "";
		if(!isset($settings['title']))  $settings['title'] = "";
		if(!isset($settings['button_value']))  $settings['button_value'] = "";
		if(!isset($settings['captcha']))  $settings['captcha'] = "";
		if(!isset($settings['captcha_theme']))  $settings['captcha_theme'] = "";
		
		
		if(!isset($settings['success_message']))  $settings['success_message'] = "";
		if(!isset($settings['from_a']))  $settings['from_a'] = "";
		if(!isset($settings['page_title']))  $settings['page_title'] = "";
		if(!isset($settings['mapcode']))  $settings['mapcode'] = "";
		if(!isset($settings['javascript']))  $settings['javascript'] = "";
		
	
		
		$data['settings'] = $settings;
		
					
		$template = isset($moduleoptions['template']) ? $moduleoptions['template'] : '';
						
		$templateselectordata = array(
		
		'selector_name'=>'form_builder_template',
		'selector_label'=>'Template',
		'module'=>'form_builder',
		'value'=> $settings['template'],
		'is_widget' => TRUE,	
		'widgettype' => 'form_builder',
		'usewrapper' => FALSE,
		'showlabels' => FALSE,
				
		);
		
		
		//$settings['form_name'] = $settings['form_name'] 
		
		
		$data['breadcrumbs'] = array("Form Builder"=>"/form_builder/","Form Edit - " . $settings['form_name'] =>"");
		
		//if(isset($data['contentdata']['CO_seoTitle'])) {
		
		//	$data['breadcrumbs'][$data['contentdata']['CO_seoTitle']] = "";
	
			
		//}
		
				
		$data['template_selector'] = $this->template_loader->template_selector($templateselectordata);
		
		
		$data['visualcaptcha_themes'] = $this->form_builder_model->get_visualcaptcha_themes();

		
		$data['fieldlist'] = $this->load->view('partials/fieldlist', $data, TRUE); 
		
		$data['parsedcontent'] = $this->load->view('build', $data, TRUE); 
		
		$data['data'] = $data; // Alice in Wonderland stuff here!
		
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
	}
	
	
	
	/**
	* Save setting from the management page
	*
	*/
	public function save_settings(){
		
		$this->load->helper('im_helper');
		
		$saveoptions['template'] = $this->input->post('language_toggle_template');
		
		ps_savemoduleoptions('form_builder',$saveoptions);
		
		
	}
	
	/**
	*
	*
	*/
	public function sentmail(){
		
		//include_once ('config.php');
		mysql_query('SET NAMES utf8');
		mysql_query('SET CHARACTER_SET utf8');
		
		$form = "<center><h1>New email from your website</h1><br><table style='border:2px double #45829f;background:#CDE5FD;font-family:Arial, Helvetica, sans-serif;font-size:12px'>";
		
		$settings = mysql_fetch_array(mysql_query("SELECT * FROM {$this->db->dbprefix}form_builder_settings"));;

		foreach ($_POST as $key => $formdata){
			$file = '';
			if (is_array($formdata)){
				$data = '';
				foreach ($formdata as $options){
					$data .= $options .'<br>';
				}
			}else{
				$data = $formdata;
			}
			if ($key == "subject"){
				$fields = mysql_query("SELECT * FROM {$this->db->dbprefix}form_builder_fields WHERE flexible_enabled = 1 AND flexible_type='subject'");
			}else{
				$fields = mysql_query("SELECT * FROM {$this->db->dbprefix}form_builder_fields WHERE flexible_enabled = 1 AND flexible_alias='".$key."'"); }
			$sqldata = mysql_fetch_array($fields);
			$name = $sqldata['flexible_field_name'];
			if ($sqldata[flexible_type] != 'file'){
				
				if ($sqldata['flexible_choices'] != $data){
					$form .= '<tr><td style="border-bottom:1px solid #c8c8c8"><b>'.$name.'</b></td><td style="border-bottom:1px solid #c8c8c8">'.$data.'</td></tr>';
				}
			}else{
				if (substr($_SERVER[HTTP_HOST],0,3) == 'www'){
					$domain = substr($_SERVER[HTTP_HOST],4);
				}else{
					$domain = $_SERVER[HTTP_HOST];
				}
				$domain = 'http://www.'.$domain;
				if ($data != 'blank'){
					$form .= '<tr><td style="border-bottom:1px solid #c8c8c8"><b>'.$name.'</b></td><td style="border-bottom:1px solid #c8c8c8">'.$domain.$data.'</td></tr>';
				}
			}	
		}
		$form .= '<tr><td style="border-bottom:1px solid #c8c8c8"><b>IP</b></td><td style="border-bottom:1px solid #c8c8c8">'.$_SERVER['REMOTE_ADDR'].'</td></tr></table></center>';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= "From: Customer <".$settings['from_a'].">\r\n";
		$headers .= 'To: Admin <'.$settings[email].'>' . "\r\n";
		mail($settings['email'],$_POST['subject'],$form,$headers); 


		
	}
	
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
		
		$this->load->library('widget_utils');
		
		$data['dbprefix'] = $this->db->dbprefix;
		
		// loop for each language
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		
		
		
	}	
	
	public function uninstall(){


	}	
	
}