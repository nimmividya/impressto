<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*
*/
class Page_Manager extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		


		$this->load->helper('auth');
							

		
		$this->benchmark->mark('code_start');
					
		$this->load->model('madmincontent');
		
		
		$this->load->library('edittools');
		
		// we will try to link the pm events to other modules here...
		$this->load->library('events');
		
	
		$this->load->plugin('widget');
		$this->load->plugin('admin_widget');
		
		
		
	}
	
	/**
	* default management page
	*
	*/
	public function index($lang = 'en'){
		
		is_logged_in();
		
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		
		$this->load->library('asset_loader');
		
		$this->load->helper('im_helper');
		
		$data['pagemanager_menulinks'] = array();
		
		$data['pagemanager_listicons'] = array();
		
		$data['lang'] = $lang;
			
		$this->load->model('admin_users/mUsers');
		
	
				
		// this will load any plugin functions
		$triggerdata = Events::trigger('page_manager', $data, 'array');
				
		foreach($triggerdata as $plugindata){
		
			if(isset($plugindata['pagemanager_menulink']))
				$data['pagemanager_menulinks'][] = $plugindata['pagemanager_menulink'];
			
			if(isset($plugindata['pagemanager_listicons']))
				$data['pagemanager_listicons'] = $plugindata['pagemanager_listicons'];
		}
		
		
		
		// we need to load up the correct version. This will preserve older versions of assets if we are doing auto updates on modules.
		$module_version = $this->_get_module_version();
		$file_version_tag = "";
		if($module_version) $file_version_tag = "." . $module_version;
		

			
		$this->asset_loader->add_header_css("default/core_modules/page_manager/css/page_manager{$file_version_tag}.css");						
		
		//$this->asset_loader->add_header_css("default/vendor/jquery/plugins/contextmenu/css/jquery.contextmenu.css");		
		//$this->asset_loader->add_header_js("default/vendor/jquery/plugins/contextmenu/js/jquery.contextmenu.js");


		
		$this->asset_loader->add_header_css("default/vendor/jquery/plugins/contextmenu/css/jquery.contextMenu.css");			
		$this->asset_loader->add_header_js("default/vendor/jquery/plugins/contextmenu/js/jquery.ui.position.js");
		$this->asset_loader->add_header_js("default/vendor/jquery/plugins/contextmenu/js/jquery.contextMenu.js");
		
				
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/jquery/plugins/markitup/jquery.markitup.js");		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/page_manager/js/markitup_set.js");		
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME  . "/default/vendor/jquery/plugins/markitup/skins/markitup/style.css");
		
		// used for wysiwyg toggle
		$this->asset_loader->add_header_css("default/vendor/jquery/plugins/ibutton/css/jquery.ibutton.css");
		$this->asset_loader->add_header_js("default/vendor/jquery/plugins/ibutton/js/jquery.ibutton.js");
		
		

		
		$this->asset_loader->add_header_js(ASSETURL.PROJECTNAME."/default/core_modules/page_manager/js/ps_content_manager{$file_version_tag}.js");		
		
		
		Events::trigger('page_manager_assets');
		
		
		
			
		$site_settings = $this->site_settings_model->get_settings();
		
		
		
		$baserootid = 1; //$this->madmincontent->getbaserootid();
	
		$data['site_settings'] = $site_settings;
					
		$data['baserootid'] = $baserootid;
		
		

		
				
		$orderlist = $this->madmincontent->get_orderlist( array("lang"=>$lang, 'pagemanager_listicons'=>$data['pagemanager_listicons'] ) );
				
		$data['aj_pagelist'] = "<ul id=\"u_{$baserootid}\"><li>{$orderlist['pageitems']}</li></ul>";
					
		
		$data['infobar_help_section'] = getinfobarcontent('ADMIN_CONTENT__ADMIN_CONTENT__INDEX__HELP');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);

						
	
		$data['main_content'] = 'index';
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		//$this->config->item('admin_theme')
				
		
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);		
		
		

		
	}
	
	
	/**
	* load the edit method but sets a flag to identify this a s copy of an exitsint page
	* @returns null
	*/
	public function copy($lang='en', $node_id){
	
		is_logged_in();
			
		$this->edit($lang, $node_id, null, TRUE);
		
		
	}
	
	
	
	
	/**
	* Load the page edit data and load the edit view
	*
	* @param varchar $lang - determines what tables to poll for data
	* @node_id int  node id of page (not page id)
	* @param int $parent_id - used when creating new page as child of another
	* @param varchar $added_action - hack for now to prevent code duplication when copying a page
	* @returns null
	
	*/
	public function edit($lang='en', $node_id = '', $parent_id = null, $cloning = FALSE){
				
		is_logged_in();
			
		global $_SESSION;
		
		$this->load->library('asset_loader');
		$this->load->library('formelement');

		//get an array of the page templates
		$this->load->helper('im_helper');

		$this->load->library('template_loader');
		
		$this->load->library("image_color");
		
		$this->load->model('site_search/site_search_model');
				
		
		
		// we need to load up the correct version. This will preserve older versions of assets if we are doing auto updates on modules.
		$module_version = $this->_get_module_version();
		$file_version_tag = "";
		if($module_version) $file_version_tag = "." . $module_version;
		
		
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME  . "/default/vendor/jquery/plugins/markitup/skins/markitup/style.css");
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME  . "/default/vendor/jquery/plugins/mincolors/jquery.miniColors.css");
		$this->asset_loader->add_header_css("default/vendor/jquery/plugins/uniform/Aristo/uniform.aristo.css");

		$this->asset_loader->add_header_css("default/vendor/jquery/plugins/uniform/Aristo/uniform.aristo.css");
		$this->asset_loader->add_header_css("default/vendor/jquery/plugins/uniform/Aristo/uniform.aristo.css");

		$this->asset_loader->add_header_css("vendor/bootstrap/css/bootstrap-wysihtml.css");
		


		$this->asset_loader->add_header_css("core_modules/page_manager/css/markitup_style{$file_version_tag}.css");	
		$this->asset_loader->add_header_css("core_modules/page_manager/css/page_manager{$file_version_tag}.css");	
		


	
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/jquery/plugins/markitup/jquery.markitup.js");


		

		$this->asset_loader->add_header_js("vendor/jquery/plugins/jquery.popupwindow.js");

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/jquery/plugins/mincolors/jquery.miniColors.js");
		$this->asset_loader->add_header_js("default/vendor/jquery/plugins/uniform/jquery.uniform.min.js");
		
		$this->asset_loader->add_header_js("vendor/bootstrap/lib/wysihtml5/wysihtml5.js"); // this is the core wysiwyg library from Christopher Blum
		$this->asset_loader->add_header_js("vendor/bootstrap/lib/wysihtml5/bootstrap-wysihtml5.js"); // this is the extended, prettified version from James Hollingworth
		$this->asset_loader->add_header_css("vendor/bootstrap/lib/wysihtml5/style.css.css");	
		
		
		$this->asset_loader->add_header_js("core_modules/page_manager/js/markitup_set{$file_version_tag}.js");				
		$this->asset_loader->add_header_js("core_modules/page_manager/js/ps_content_edit{$file_version_tag}.js");	

				
		// Not sure if we need this anymore since the admin widgets can load their own assets when the get called
		Events::trigger('page_editor_assets');
		
						
		
		$site_settings = $this->site_settings_model->get_settings();
		

		
		$content_table = "{$this->db->dbprefix}content_" . $lang;
		$draft_table = "{$this->db->dbprefix}contentdrafts_" . $lang;
		
		// this is legacy PS 
		$this->load->helper('formCreation');
		
		// this is the regular CI version
		$this->load->helper('form');
		
		if($node_id == 0) $node_id = "";
			
		$contentdata = $this->madmincontent->getcontentdata($node_id, $lang);
		
					
		if(!$contentdata){
			
			$contentdata['CO_externalLink'] = "";
		
		}else{
		
			// Nimmitha Vidyathilaka - Dev 14, 2102
			// convert any special characters so they can be seen as code in the editor
			$contentdata['CO_seoTitle'] = htmlspecialchars($contentdata['CO_seoTitle'],ENT_NOQUOTES); 
			if(isset($contentdata['CO_Body'])) $contentdata['CO_Body'] = htmlspecialchars($contentdata['CO_Body'],ENT_NOQUOTES); 
			if(isset($contentdata['CO_MobileBody'])) $contentdata['CO_MobileBody'] = htmlspecialchars($contentdata['CO_MobileBody'],ENT_NOQUOTES); 
		
		}
		
		
		if(!$node_id && $parent_id){

			$contentdata['node_parent'] = $parent_id;
			$contentdata['CO_externalLink'] = "";
		
		}
			
				
		$template_select_options = $this->template_loader->find_templates(array('device'=>'standard','lang'=>$lang));
		
		// remove the index template file because it is a master wrapper
		//unset($template_select_options['index.tpl.php']);
		
		if(($key = array_search('index.tpl.php', $template_select_options)) !== false) {
			unset($template_select_options[$key]);
		}

				
	
		$mobile_template_select_options = $this->template_loader->find_templates(array('device'=>'mobile','lang'=>$lang));		
		
		// remove the index template file because it is a master wrapper
		//unset($template_select_options['index.tpl.php']);
		if(($key = array_search('index.tpl.php', $mobile_template_select_options)) !== false) {
			unset($mobile_template_select_options[$key]);
		}

		
		$user_session_data = $this->session->all_userdata();	
	
	
		$user_role = isset($user_session_data['username']) ? $user_session_data['role'] : ""; 
		$user_name = isset($user_session_data['username']) ? $user_session_data['username'] : ""; 
				
		$permissions = load_module_permissions("page_manager");
		
		$content_rights = $this->madmincontent->get_content_rights($node_id);	
		

		$data = array(
			'page_id' => $node_id
			,'content_lang' => $lang					
			,'contentdata' => $contentdata
			,'checkdata' => ""
			,'template_select_options' => $template_select_options
			,'mobile_template_select_options' => $mobile_template_select_options
			,'mobilized' => $this->config->item('mobilized')
			,'onlymobile' => $this->config->item('onlymobile')
			,'site_settings' => $site_settings
			,'user_role' => $user_role
			,'user_name' => $user_name 	
			,'permissions' => $permissions 		
			,'content_rights' => $content_rights 		
		);
			
		
		
		$search_record = $this->site_search_model->get_search_record($node_id, "page_manager", $lang);
		
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
				
		
		
				

		$triggerdata = Events::trigger('page_manager_edit_page', $data, 'array');
		
		// make sure the triggerdata is valid before assigning to data
		if($triggerdata && count($triggerdata[0]) > 1) $data = $triggerdata[0];
		
		//print_r($data); //page_manager_edit_page
		
			
		
		$data['infobar_help_section'] = getinfobarcontent('CONTENTEDITHELP');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);

	
		
		$fielddata = array(
		'name'        => "wm_collection_selector",
		'type'          => 'select',
		'id'          => "wm_collection_selector",
		'label'          => "",
		'usewrapper'          => false,
		'options' =>  $this->madmincontent->getwidgetcollections(),
		'value'       => $this->madmincontent->getassignedwidgetcollection($node_id)
		);
				
		$data['wm_collection_selector'] = $this->formelement->generate($fielddata);
				
		
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		
	
		$data['is_published'] = $this->madmincontent->is_published($node_id, $lang);

		
		$this->load->library('adjacencytree');
		$this->load->helper('content_orderlist');
		
		$this->adjacencytree->init();
		$this->adjacencytree->setidfield('node_id');
		$this->adjacencytree->setparentidfield('node_parent');
		$this->adjacencytree->setpositionfield('node_position');
		$this->adjacencytree->setdbtable("{$this->db->dbprefix}content_nodes");
		$this->adjacencytree->setDBConnectionID($this->db->conn_id);
		
	
		$this->adjacencytree->setjointable($content_table,"CO_node", array("CO_MenuTitle","CO_WhenModified", "CO_Color", "CO_ModifiedBy"));
		
		$fullnodes = $this->adjacencytree->getFullNodes();
		
		 
		if(isset($contentdata['CO_Node']) && $contentdata['CO_Node']){

			$children_ids = $this->adjacencytree->getChildNodeIDs($contentdata['CO_Node']);
			$children_ids[] = $contentdata['CO_Node'];
		
		}else{
			$children_ids  = array();
		}
			

		$data['page_parent_options'] =  selectororderlist($fullnodes,$children_ids);

		// if we are cloning a page, nullify some basic varialbes before we go out the gate.
		if($cloning){
				
			$contentdata['node_id'] = "";
			$contentdata['CO_ID'] = "";
			$contentdata['CO_Node'] = "";
			$contentdata['CO_seoTitle'] = "";
			//$contentdata['CO_seoTitle']  = "";
			$contentdata['CO_MenuTitle']  = "";
			$contentdata['CO_Url']  = "";
			$contentdata['CO_Active'] = 0;
			$contentdata['CO_Searchable'] = 0;
			$contentdata['CO_WhenModified'] = "";
			$contentdata['CO_ModifiedBy'] = 0;
			$contentdata['CO_Public'] = 0;
			$contentdata['hits'] = 0;
			
			$data['contentdata'] = $contentdata;
				
			$data['page_id'] = '';
			
		}

		
		$data['parsedcontent'] = $this->load->view('edit', $data, TRUE); 
		
		
		$site_settings = $this->site_settings_model->get_settings();
		
		$data['breadcrumbs'] = array("Page Admin"=>"/page_manager/index/{$lang}/","Page Edit"=>"");
		
		if(isset($data['contentdata']['CO_seoTitle'])) {
		
			$data['breadcrumbs'][$data['contentdata']['CO_seoTitle']] = "";
			
		}
		
		
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
		
		$data['dbprefix'] = $this->db->dbprefix;
		
		$lang_avail = $this->config->item('lang_avail');
											
		foreach($lang_avail AS $key=>$val){ 
		
		
			if(!$this->db->table_exists($this->db->dbprefix('content_' . $key))){

				$data['lang'] = $key;
				$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
			
			}
		}	
	
		include(dirname(dirname(__FILE__)) . "/install/install.php");
			
		$this->module_installer->set_searchable('page_manager');
		
		// finally copy any required css or js files to the assets folder
		$this->module_installer->copy_assets("/core_modules/page_manager", "/core_modules/page_manager/");	
		
		
		
		
		
	} // install
	
	
	
	/**
	*
	*
	*/	
	public function delete($item_id){

		is_logged_in();
		
		$this->madmincontent->deletecontent($item_id);
		
		Events::trigger('page_manager_delete', $item_id);
		
		echo "done";
		
	}
	
	
	/**
	* save as a draft version replacing any draft versions that preceded it
	*
	*/	
	public function savedraft(){
		

		is_logged_in();
				
		// if the page_id = nul, it means there is no liv epage yet so this page will be saves in the dradt table,
		// and in the live table as an inacitve record and in the node table too
		
		$this->load->helper('htmlpurifier');
			
	
		$node_id = $this->input->post('page_id');
		$lang = $this->input->post('content_lang');
		
		$bodycontent = $this->input->post('bodycontent');
		$mobilebodycontent = $this->input->post('mobilebodycontent');
		
		// If using TinyMCE, we can get the data with the real field name
		if($bodycontent == "") 	$bodycontent = $this->input->post('Body');
		if($mobilebodycontent == "") $mobilebodycontent = $this->input->post('MobileBody');
		
		
		$bodycontent = stripslashes($bodycontent);
		$mobilebodycontent = stripslashes($mobilebodycontent);
		
		
		$bodycontent = purify($bodycontent);
		$mobilebodycontent = purify($mobilebodycontent);
		
		
		
		$content_table = "content_" . $lang;
						

		// remove the characted from the key value. numeric keys cause wierd shit to happen with arrays ....
		$_POST['Parent'] = str_replace("node_","",$this->input->post('Parent'));
		
	
		$content_fieldnames = array(
			'seoTitle'
			,'seoDesc'
			,'seoKeywords'
			,'MenuTitle'
			,'Url'
			,'Template'
			,'MobileTemplate'
			,'Active'
			,'ModifiedBy'
			,'Searchable'	
			,'Public'	
			,'Javascript'
			,'MobileJavascript'
			,'CSS'
			,'MobileCSS'
			,'Color'
			,'externalLink'
						
		);
		
				
	
		
		foreach($content_fieldnames as $val){
		
			$content_data["CO_" . $val] = $this->input->post($val);

		}
		
	
		$content_data['CO_Public'] = '1';

		$content_data['CO_WhenModified'] = date("Y-m-d H:i:s");
		
		$content_data['CO_ModifiedBy'] = $this->session->userdata('id');	
						
		
		$content_data['CO_Body'] = $bodycontent;
		$content_data['CO_MobileBody'] = $mobilebodycontent;
		
		
		$content_data['CO_Searchable'] = ($this->input->post('searchable') == "") ? 0 : 1;
		
	
		if(!preg_match('/^#[a-f0-9]{6}$/i', $content_data['CO_Color'])){
			$content_data['CO_Color'] = "";
		}

		$content_data["prevpage"] = $this->input->post('prevpage');
		$content_data["nextpage"] = $this->input->post('nextpage');
		$content_data["mobile_prevpage"] = $this->input->post('mobile_prevpage');
		$content_data["mobile_nextpage"] = $this->input->post('mobile_nextpage');
		
		$content_data["featured_image"] = $this->input->post('featured_image');
		$content_data["mobile_featured_image"] = $this->input->post('mobile_featured_image');
		
		
		$node_data['node_parent'] = $this->input->post('Parent');
		//$node_data['node_parent'] = str_replace("node_","",$node_data['node_parent']);
		
		//we need to ge the page_id form the nodes table is this is to be saved properly
		
		if($node_id == ""){
		
			// it is a new page so add it to the notes table and also to the live table as an inactive record
			$this->db->insert("content_nodes",$node_data); 
			$content_data['CO_Node'] = $this->db->insert_id();
			
			// now add an inactive record to the live table so it appears in the edit list 
			$content_data["CO_Active"] = 0;
			$this->db->insert($content_table, $content_data); 
			
		
		}else{
		
		
			$this->db->where('node_id',$node_id);
			$this->db->update("content_nodes",$node_data); 
			
			$content_data['CO_Node']  = $node_id;
					
					
		}
		

				
		// save the draft copy
		$co_node = $this->madmincontent->savedraft($lang,$node_id,$content_data); 
		
		
		// this launches event triggers. See example file in /appname/application/custom_modules/top_banners/events.php
		//echo 
		$content_data['lang'] = $lang;
		
				
		Events::trigger('page_manager_save_draft', $content_data);
		
				
		// Set some headers for our JSON
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		
		echo json_encode(array('node_id'=>$content_data['CO_Node']));
						
		

		
	}
	
	/**
	*
	*
	*/
	public function save(){
		
		is_logged_in();
		
		$returnarray = array();
		
		$this->load->helper('htmlpurifier');
		
		$this->load->library("events");
				
		
		$node_id = $this->input->post('page_id');
		$lang = $this->input->post('content_lang');
		$parent = $this->input->post('Parent');
		
		
		//$content_data[] = 
		
		// remove the characted from the key value. numeric keys cause wierd shit to happen with arrays ....
		$parent = str_replace("node_","",$parent);		

		// when going live  add the old artivle to the archives
		$this->madmincontent->savearchive($node_id,$lang);
						


		$bodycontent = $this->input->post('bodycontent');
		$mobilebodycontent = $this->input->post('mobilebodycontent');
		
		// If using TinyMCE, we can get the data with the real field name
		if($bodycontent == "") 	$bodycontent = $this->input->post('Body');
		if($mobilebodycontent == "") $mobilebodycontent = $this->input->post('MobileBody');
		

		$content_fieldnames = array(
		'seoTitle'
		,'seoDesc'
		,'seoKeywords'
		,'MenuTitle'
		,'Url'
		,'Body'
		,'MobileBody'
		,'Template'
		,'MobileTemplate'
		,'Active'
		,'ModifiedBy'
		,'Searchable'			
		,'Public'
		,'Javascript'
		,'CSS'
		,'MobileJavascript'
		,'MobileCSS'
		,'Color'
		,'externalLink'
		
		);
		
		
		
		// need to initialize some variables first
		$content_data['CO_Active'] = 0;
		$content_data['CO_Public'] = 0;		
		$content_data['CO_Searchable'] = 0;	
		
		$content_data['CO_Javascript'] = "";	
		$content_data['CO_CSS'] = "";	
		$content_data['CO_MobileJavascript'] = "";	
		$content_data['CO_MobileCSS'] = "";	
		$content_data['CO_externalLink'] = "";	
		$content_data['CO_Color'] = "";	
		$content_data['CO_seoDesc'] = "";	
		$content_data['CO_seoKeywords'] = "";	
		$content_data['CO_Url'] = "";	
		$content_data['CO_MenuTitle'] = "";	
		
		$content_data['prevpage'] = "";	
		$content_data['nextpage'] = "";	
						
		
		
		foreach($content_fieldnames as $val){
			$content_data["CO_" . $val] = $this->input->post($val);
		}
		
		
		$content_data['CO_ModifiedBy'] = $this->session->userdata('id');	
						
		
		if($content_data["CO_MenuTitle"] == "") $content_data["CO_MenuTitle"] = strip_tags($content_data["CO_seoTitle"]);
		
		$content_data["CO_MenuTitle"] = trim($content_data["CO_MenuTitle"]);
					
		
		if($content_data["CO_Url"] == "") $friendly_url = trim(strtolower(strip_tags($content_data["CO_seoTitle"])));
		else $friendly_url = trim(strtolower($content_data["CO_Url"]));
		
			
		$friendly_url = str_replace(" ","-",$friendly_url );
			
		$friendly_url = preg_replace('/[^a-zA-Z0-9\-_%\[().\]\\/-]/s', '', $friendly_url);

		$content_data["CO_Url"] = $friendly_url;

		$content_data["prevpage"] = $this->input->post('prevpage');
		$content_data["nextpage"] = $this->input->post('nextpage');
		$content_data["mobile_prevpage"] = $this->input->post('mobile_prevpage');
		$content_data["mobile_nextpage"] = $this->input->post('mobile_nextpage');
		
		$content_data["featured_image"] = $this->input->post('featured_image');
		$content_data["mobile_featured_image"] = $this->input->post('mobile_featured_image');
		
		
		
		
		
		// now we have to check that this friendly url is not conflicting with an existing duplicate
		// if it is, we will appent a number to the end.
		$content_data["CO_Url"] = $this->madmincontent->get_unique_furl($content_data["CO_Url"], $lang, $node_id);
			


		
		
		// we need to get the old page title in cae the page is being rranmed so we can pass the old title along to
		// any plugins that may need the old value
		
		$old_data = null;
		
		if($node_id != "") $old_data = $this->madmincontent->getcontentdata($node_id, $lang);
		
		
						
		
		if(!isset($content_data['CO_seoTitle'])) $content_data['CO_seoTitle'] = "page title";		
				
		// something really wierd happens with windows characters.
		$content_data["CO_Javascript"] = str_replace("\n","",$content_data["CO_Javascript"] );
				
		$content_data['CO_Active'] =  ($content_data["CO_Active"] == "1") ? '1' : '0';
		$content_data['CO_Public'] =  ($content_data["CO_Public"] == "1") ? '1' : '0';
		
		$content_data['CO_WhenModified'] = date("Y-m-d H:i:s");
				
		// NOTE - when submitting from CKEditor, you need to fix the single quotes and other special chars
		
		
		$bodycontent = stripslashes($bodycontent);
		$mobilebodycontent = stripslashes($mobilebodycontent);
		
		$content_data['CO_Body'] = str_replace("&#39;","'",$bodycontent);
		$content_data['CO_MobileBody'] = str_replace("&#39;","'",$mobilebodycontent);
		
		
		// now clean up the rest of it if the purify checkbox has been selected
		
		if($this->input->post('purify_co_body')== "1") $content_data['CO_Body'] = purify($content_data['CO_Body']);
		if($this->input->post('purify_co_mobilebody')== "1") $content_data['CO_MobileBody'] = purify($content_data['CO_MobileBody']);
		
		
		$returnarray['node_id'] = $this->madmincontent->savecontent($content_data, $node_id, $parent, $lang);
		
		
		
		$content_rights = $this->input->post('content_rights');
		
		if(isset($content_rights) && is_array($content_rights)){
		
			$this->madmincontent->set_content_rights($returnarray['node_id'],$content_rights);
	
		}
		
		
		
		
		
		// now we havw an id save the widget collection
		$widget_collection = $this->input->post('wm_collection_selector');
		
		$this->madmincontent->setwidgetcollection($returnarray['node_id'], $widget_collection);
		
		// this launches event triggers. 
		// See: http://kb.central.bitheads.ca/index.php?action=artikel&cat=20&id=4
		// Example file in /appname/application/custom_modules/top_banners/events.php
		// NOTE: June 16, 2012 - Nimmitha Vidyathilaka - This may be soon replaced with a generic trigger call
		// once the trigger manager is setup
		// would look like $this->triggers->trigger('page_manager_save', $data);
		
		
		$content_data['lang'] = $lang;
		$content_data['CO_Node'] = $returnarray['node_id'];
		
		$content_data['old_data'] = $old_data;
		
		// this is where modules linked specifically to the page manage get called
		Events::trigger('page_manager_save', $content_data);
		
		// this is where generic calls like tag saving happens	
		$content_data['content_module'] = "page_manager";
		$content_data['content_id'] = $content_data['CO_Node'];
		
		$tags = "";		
		if($this->input->post('hiddenTagList_'.$lang) != "") $tags = explode(",",$this->input->post('hiddenTagList_'.$lang));	
		
		$content_data['tags'] = $tags;
		
		if($content_data["CO_Searchable"] == 1) $content_data['delink_tags'] = FALSE;
		else $content_data['delink_tags'] = TRUE;
		
		Events::trigger('save_content', $content_data);
		
		
				
		
		// Set some headers for our JSON
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
	
		echo json_encode($returnarray);
		
			
	}	
	
	
	public function setpublishedstate($lang, $node_id, $state){
	
		is_logged_in();
			
		$content_table = "{$this->db->dbprefix}content_" . $lang;
		
		$sql = "UPDATE $content_table SET CO_Active = '{$state}' WHERE CO_Node = '{$node_id}'";
		
		$this->db->query($sql);
		
	
	
	}
	
	
	/**
	* Ajax responder to get friendly url from id and lang
	* @param int id
	* @param varchar lang
	*/
	public function get_friendly_url($node_id, $lang){
	
		$data = array(
	
			'url' => '',
			'id' => '',

		);
		
		$query = $this->db->get_where('content_' . $lang, array('CO_Node' => $node_id));
		
		if ($query->num_rows() > 0)
		{
		
			$row = $query->row();
			
			if($row->CO_Url != "") 	$data['url'] = $row->CO_Url;
			else $data['id'] = $row->CO_Node;
						
			 
		} else{
			
			$data['id'] = $node_id;
						
		}
		
		echo json_encode($data);
				
		
	
	
	}
	
	
	/**
	*
	*
	*/
	public function getarchivelist($node_id,$lang){
	
		is_logged_in();
		
		$data['archivelist'] = $this->madmincontent->getarchivelist($node_id,$lang);
		$data['lang'] = $lang;
		
		echo $this->load->view('archive_list', $data, TRUE);
			
	
	
	}
	
	
	/**
	*
	*
	*/
	public function restore_archive($id, $lang){
			
		is_logged_in();
		
		$this->madmincontent->restore_archive($id, $lang);
		
	}
	
	
	public function reset_draft($node_id, $lang){
	
		
		$sql = "DELETE FROM {$this->db->dbprefix}contentdrafts_{$lang} WHERE CO_Node = '{$node_id}'";
				
		$this->db->query($sql);
		
		echo "OK";
	
	
	}
	
	

	
	
	/**
	* reposition pages in their parent nodes from AJAX request
	*
	*/	
	public function reorder($parent_id){
	
		is_logged_in();
			
		$order_array = $_POST['item_'];
		
		if(is_array($_POST['item_'])){
			
			
			
			for($i=0; $i < count($order_array); $i++){
				
				$sql = "UPDATE {$this->db->dbprefix}content_nodes SET node_position='{$i}' WHERE node_id='".$order_array[$i]."'";
				$this->db->query($sql);
	
			}
			
			echo "success";
			
		}else{
			
			echo "fail";
			
		}
		
		
		
	}	
	
	
	
	/**
	* This is a standard function that is called from the search module to obtain the correct url for searchable items
	* 
	* @param string route - the current controller/method call
	* @param mixed data - all the search criteria
 	*
	@author Nimmitha Vidyathilaka 
	*/
	public function search_module_url($route, $data){
	
	
		if(!isset($data['lang']) 
		|| $data['lang'] == ""){
			$data['lang'] = "en";
		}
		
		
		$query = $this->db->get_where('content_' . $data['lang'], array('CO_Node' => $data['content_id']));
		
		if ($query->num_rows() > 0)
		{
		
			$row = $query->row();
			
			if($row->CO_Url != "") 	$page_id = $row->CO_Url;
			else $page_id = $row->CO_Node;
						
			 
		} else{
			
			$page_id = $data['content_id'];
						
		}

		return "/{$data['lang']}/{$page_id}";

		
	}
	
	
	
	

} //end class