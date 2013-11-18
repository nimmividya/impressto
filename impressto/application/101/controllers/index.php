<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Index extends PSFront_Controller {

	public $language = 'en';
	public $page_id = null;
	public $archive_id = null;
	
	
	
	public function __construct(){
		
		parent::__construct();
		
		// this fixes the issue of wrong models being loaded
		$this->load->add_package_path(APPPATH . $this->config->item('projectnum') );
		
		$this->load->model('public/ps_content');
		
	}
	
	/**
	* NOTE: we do not use the $lang parameter anymore. It is legacy only
	*/	
	public function index($page_identifier = null)
	{
			
		// splash page loader
		if(!$page_identifier && (getenv("REQUEST_URI") == "/" || getenv("REQUEST_URI") == "")){
		
			$page_identifier = $this->config->item('splash_page_id');
		
		}

		
		// if the page has arguments, don't let them get used as a page identifier
		if(!$page_identifier && stripos ( getenv("REQUEST_URI") , "/?") !== FALSE){
			
			$page_identifier = substr(getenv("REQUEST_URI"),1);
			$page_identifier = substr($page_identifier,0,stripos ($page_identifier , "/?"));
			
		}
		
		
		
		// If we did not have a language prefix (/en/, or /fr/) in the url and the router did not find 
		// any modules that match the url, we can have a last try at trying to match the url to a page
		// in the system. This is dangerous because it can cause a spider trap 
		if(!$page_identifier){ 
			$sample_uri = substr(getenv("REQUEST_URI"),1,strlen(getenv("REQUEST_URI")));
			if(strpos($sample_uri,"/") === false) $page_identifier = $sample_uri;
		}
		
		// if the page has arguments, don't let them get used as a page identifier
		if(stripos ( $page_identifier , "?") !== FALSE){
			$page_identifier = substr($page_identifier,0,stripos ($page_identifier , "?"));
		}
		
		
		
		
		// here is a hack to allow us to "spoof" users into thinking this 
		// stuff is coming from another platform. Also useful for SWA (Standard on Web Accessibility) projects
		$page_file_extensions = array(".aspx",".asp",".html",".htm",".php");
		foreach($page_file_extensions as $extension){
			$page_identifier = str_replace($extension,"",$page_identifier);
		}
		
		
		
		$this->config->set_item('page_identifier', $page_identifier);
		
		if($this->config->item('page_cache_timeout') == "") $this->config->set_item('page_cache_timeout', 3600); // default to 1 hour timeout
		
		

		/////////////////////////////////////
		// get the cache file 
		$uri = $_SERVER['REQUEST_URI'];
				
		$uri = rtrim( ltrim($uri, '/'),'/');
		
	
		
		$cachefile = APPPATH . PROJECTNUM . "/cache/pages/".urlencode($uri).".html";
		
	
	
			
		// now we will see if the user is an admin or editor. If not we will load the cached version of the page
		if($this->session->userdata('role') != 1){
		

			$maxLockFileAge = 	$this->config->item('page_cache_timeout'); // 3600 = one hour
	
			if(file_exists($cachefile)){
	
				if ((time() - filemtime($cachefile)) < $maxLockFileAge) {
		
					echo file_get_contents($cachefile);
					return; // no point going beyond here
					
				}
			}
		}		
		//
		///////////////////
		
		
		
		$this->load->plugin('widget');
		$this->load->helper('mobile');
		$this->load->helper('im_helper');
		
		
		$this->load->library('template_loader');
		$this->load->library('asset_loader');
		
		$data['ps_domobile'] = ps_domobile();
		
		// if we are forcing the device to mobile we will treat everyone as a mobile
		if($data['ps_domobile'])$data['ps_ismobile'] = TRUE;
		else $data['ps_ismobile'] = ps_ismobile();
		
	
		if(ps_domobile()) $this->output->enable_profiler(FALSE); // this messes up real estate on small phone. To small to read anyway.
		

		$ismobile = ($data['ps_domobile'] == true) ? 'true' : 'false';
		
		$lang_avail = $this->config->item('lang_avail');
		
		$this->archive_id = null;
		$this->draft_id = null;

		// the language is auto detected now
		$this->config->set_item('language', $lang_avail[$this->config->item('lang_selected')]); 
		
		$this->language = $this->config->item('lang_selected');
		
		
		$this->config->set_item('site_lang', $this->config->item('lang_selected'));
		$this->config->set_item('domobile', $data['ps_domobile']);
		
		
		$this->ps_content->set_content_table("{$this->db->dbprefix}content_" . $this->config->item('lang_selected'));
		$this->ps_content->set_contentarchives_table("{$this->db->dbprefix}contentarchives_" . $this->config->item('lang_selected'));
		$this->ps_content->set_contentdrafts_table("{$this->db->dbprefix}contentdrafts_" . $this->config->item('lang_selected'));
		
		if($page_identifier == "fr" || $page_identifier == "en") $page_identifier = null; // little hack to fix lang bug here


		
		if($page_identifier == null){
		
	
			if(strrpos(getenv("REQUEST_URI"),$this->language ."/") !== false){
				
				$this->page_id = $this->ps_content->gethomepageid($this->language);
								
			}else if( strrpos(getenv("REQUEST_URI"),"/") === false
					
			){ // prevent spider trap here

				$this->page_id = $this->ps_content->gethomepageid($this->language);
					
			}
				
			
			
		}else if(is_numeric($page_identifier)){
			
			$this->page_id = $page_identifier;
			
		}else{
			
			if(preg_match("/::/",$page_identifier)){
				

				list($parameter,$paramval) = explode("::",$page_identifier);
				
				if($parameter == "archive_preview"){
					
					$this->archive_id = $paramval;
					
					$this->page_id = $this->ps_content->get_archive_pageid($this->archive_id);
					
					
				}else if($parameter == "draft_preview"){
					
					$this->draft_id = $this->page_id = $paramval;
					
				}
				
				
			}else{
			
						
				$this->page_id = $this->ps_content->get_pageid_by_friendly_url($page_identifier);
				
			}
			
		}
		
		// added spet 19, 2012
		$this->config->set_item('page_id', $this->page_id);
		
		
	
		
		if($this->archive_id){
			
			$this->load->helper('auth');
			
			is_logged_in();
			
			
			$myrow = $this->ps_content->get_archivedcontent_data($this->archive_id);
			
			if($myrow[0]['CO_externalLink'] != ""){
				
				$alias_info = $this->ps_content->find_alias($myrow[0]['CO_externalLink']);
				
				if($alias_info['extenal_link']){

					$myrow[0]['CO_Body'] = $myrow[0]['CO_MobileBody'] = "LINK: <a href=\"{$alias_info['extenal_link']}\">{$alias_info['extenal_link']}</a>";

					
				}else if($alias_info['module']){
					
					$myrow[0]['CO_Body'] = $myrow[0]['CO_MobileBody'] = "MODULE CALL: {$alias_info['module']}";
					
					
					
				}else if($alias_info['page']){
					
					
					$myrow[0]['CO_Body'] = $myrow[0]['CO_MobileBody'] = "PAGE ALIAS : {$alias_info['page']}";
					
					
				}
				
				
				
			}
			
		}else if($this->draft_id){
			
			$this->load->helper('auth');
			
			is_logged_in();
			
			// we are going to show a draft copy of the page. If no draft exists, just show the current page
			
			$myrow = $this->ps_content->get_draftcontent_data($this->draft_id);
			
			if($myrow[0]['CO_externalLink'] != ""){
				
				$alias_info = $this->ps_content->find_alias($myrow[0]['CO_externalLink']);
				
				if($alias_info['extenal_link']){

					$myrow[0]['CO_Body'] = $myrow[0]['CO_MobileBody'] = "LINK: <a href=\"{$alias_info['extenal_link']}\">{$alias_info['extenal_link']}</a>";

					
				}else if($alias_info['module']){
					
					$myrow[0]['CO_Body'] = $myrow[0]['CO_MobileBody'] = "MODULE CALL: {$alias_info['module']}";
					
				}else if($alias_info['page']){
					
					$myrow[0]['CO_Body'] = $myrow[0]['CO_MobileBody'] = "PAGE ALIAS : {$alias_info['page']}";
					
				}
				
			}
			
			
		}else{
			
			// we need to check if this page is accessible
			$user_role = $this->session->userdata('role');
			if($user_role == "") $user_role = 0;
			
			$page_rights = $this->ps_content->get_page_rights($this->page_id);
			
			if(count($page_rights) > 0 && !in_array($user_role, $page_rights)){
				
				$this->load->helper('auth');
				is_logged_in();
				return;
			}
			
			$this->load->library('events');
			
			$myrow = $this->ps_content->getcontentdata($this->page_id, $this->language);
			
			$myrow[0]['content_lang'] = $this->language;
			
			$myrow[0]['admin_widgets'] = "";
						
						
			$triggerdata = Events::trigger('public_page_view', $myrow[0], 'array', TRUE); // this is where we will hook the postits....
			
			if($triggerdata) $myrow[0] = $triggerdata[0];
			
			
		}


			
		
		// Make basic MyApp constants available within the page templates
		$myrow[0]['environment'] = ENVIRONMENT;
		$myrow[0]['appseries'] = APPSERIES;
		$myrow[0]['projectnum'] = PROJECTNUM;
		$myrow[0]['projectname'] = PROJECTNAME;
		$myrow[0]['vendor'] = VENDOR;
		$myrow[0]['vendorurl'] = VENDORURL;
		$myrow[0]['asseturl'] =  ASSETURL;
				


		
		
		// 404 Handler
		if(!isset($myrow[0]['CO_Node'])){
			
			$myrow[0]['CO_seoTitle'] = lang('missing_page');
						
			$template = "404.tpl.php"; //use page not found
			$data['template'] = $template;
			
			$populate = false;
			
			$data['my_cache_id'] = 404;
			
			$data['is_page'] = TRUE; 
			
			$myrow[0]['site_keywords'] = "404";		
			$myrow[0]['site_title'] = "404";
			$myrow[0]['page_title'] = "404";		
			$myrow[0]['site_description'] = "";
									
					
			$myrow[0]['lang'] = $this->config->item('lang_selected');	
					
			$this->asset_loader->add_header_js_top("core/js/jquery.cookie.js");		
			$this->asset_loader->add_header_js_top("core/js/appclass.js");
			$this->asset_loader->add_header_js_top("core/js/appbase.js");		
		
			// setup for javascript mobile specific functionality		
			$js_string = " ps_base.ismobile = '{$data['ps_ismobile']}';\n";
			$js_string .= "ps_base.domobile = '{$data['ps_domobile']}';\n";
			$js_string .= "ps_base.lang = '{$this->config->item('lang_selected')}';\n";		
			$js_string .= "ps_base.appname = '" . PROJECTNAME . "';\n";	
			$js_string .= "ps_base.asseturl = '" . ASSETURL . "';\n";	
			$js_string .= "ps_base.projectnum = '" . PROJECTNUM . "';\n";
			$js_string .= "ps_base.templateurl = '" . TEMPLATEURL . "';\n";
			
		
					
			
		
			$this->asset_loader->add_header_js_string_top($js_string);
			
			
			$this->asset_loader->add_header_js_top("public/js/script.js");
			$this->asset_loader->add_header_css_top("public/default/css/reset.css","","all");		
			$this->asset_loader->add_header_css_top("public/default/css/style.css","","screen");
		

			$myrow[0]['CO_Body'] = "404 Page Missing";
		
			$data['page_data'] = $myrow[0];
	
			echo $this->template_loader->render_template($data);
			
			return; // bail out here
			
			
		}

		

		
		
		if(!$this->archive_id && $myrow[0]['CO_externalLink'] != ""){
			
			
			$alias_info = $this->ps_content->find_alias($myrow[0]['CO_externalLink']);

			if($alias_info['extenal_link']){
				
				header("Location: {$alias_info['extenal_link']}"); 			
				return;
				
			}else if($alias_info['module']){
				
				$module = $alias_info['module'];
				
				
				$args = null;
				$argstring = "";
				
				$wrap = FALSE;
				
				if(strpos($module, "WRAP>>") !== FALSE) { // wrap the module with this page's wrapper
					
					$wrap =  true;					
					$module = str_replace("WRAP>>","",$module);
					
				}
				
				
				if(($pos1 = strpos($module, '/')) !== FALSE) {
					
					$controller = substr($module, 0, $pos1);
					$method = substr($module, $pos1 + 1);		
					
					$pos2 = strrpos ($method, '/');
					
					if( $pos2 !== FALSE ) {
						
						$pos3 = strrpos ($method, '?');
						
						if( $pos3 !== FALSE ) {
							
							$argstring = substr($method, $pos3 + 1);
							$method = substr($method, 0, $pos3 -1);	
							
						}
						
					}
					
					if($argstring != "") parse_str($argstring, $args);
					
					if($wrap){
						$myrow[0]['CO_Body'] = modules::run("$controller/$method",$args);
					}else{
						
						echo modules::run("$controller/$method",$args);
						return;
						
					}
					
					
				}else{
					
					// we trid and failed to load a module
					echo "FAILED TO LOAD ALIAS MODULE";
					return;
					
					
				}
				
				
				
				
			}else if($alias_info['page']){
				
				$myrow = $this->ps_content->getcontentdata($alias_info['page']);
				$this->page_id = $myrow[0]['CO_Node'];
				
				
			}
			
			
		}
		
		
		
		$this->config->set_item( 'page_id' , $this->page_id );
		// This is the same thing as page_id but we are trying to phase out the refernece to page_id and replace it with page_node_id 
		$this->config->set_item( 'page_node_id' , $this->page_id );
		
		
		if ( ! defined('PS_PAGEID')) define('PS_PAGEID',$this->page_id);
		
		
		
		
		// set this variable so we can use if for custom conditionals in templates or whatever ...
		$this->config->set_item('page_slug',$page_identifier ); 
		
		$myrow[0]['lang'] = $this->config->item('lang_selected');
		
		
		

		$this->asset_loader->add_header_js_top("core/js/jquery.cookie.js");		
		$this->asset_loader->add_header_js_top("core/js/appbase.js");		
		
		// setup for javascript mobile specific functionality		
		$js_string = " ps_base.ismobile = '{$data['ps_ismobile']}';\n";
		$js_string .= "ps_base.domobile = '{$data['ps_domobile']}';\n";
		$js_string .= "ps_base.lang = '{$this->config->item('lang_selected')}';\n";		
		$js_string .= "ps_base.appname = '" . PROJECTNAME . "';\n";	
		$js_string .= "ps_base.asseturl = '" . ASSETURL . "';\n";	
		$js_string .= "ps_base.projectnum = '" . PROJECTNUM . "';\n";
		$js_string .= "ps_base.templateurl = '" . TEMPLATEURL . "';\n";
		
					
		
		
		$this->asset_loader->add_header_js_string_top($js_string);

		
		$this->asset_loader->add_header_js_string_top("ps_base.ismobile = '{$ismobile}';");	
		

		// should this stuff really be here or more conveniently defined in the page tempate?
		$this->asset_loader->add_header_js_top("public/js/script.js");
		$this->asset_loader->add_header_css_top("public/default/css/reset.css","","all");		
		$this->asset_loader->add_header_css_top("public/default/css/style.css","","screen");
		
		
		
		
		
		// if this is a mobile use custom javascript and css if available
		if($data['ps_domobile']){

			if($myrow[0]['CO_MobileJavascript'] != "")
			$myrow[0]['CO_Javascript']  = $myrow[0]['CO_MobileJavascript'];
			
			if($myrow[0]['CO_MobileCSS'] != "")
			$myrow[0]['CO_CSS']  = $myrow[0]['CO_MobileCSS'];
			
		}
		
		if($this->archive_id || ( isset($myrow[0]['CO_Active']) && $myrow[0]['CO_Active'] == 0 ) ){
			
			// check the Active status so nobody slips past the goal line  here
			$this->load->helper('auth');
			is_logged_in();
			
		}
		
		/**
		*	Determining if a page is English or French and what setting Variable to Spit out
		*/
		$site_settings = $this->ps_content->get_site_settings();
		
		//print_r($site_settings);
		
		
		if( !isset($site_settings['site_title_' . $this->language])) $site_settings['site_title_' . $this->language] = "";
		if( !isset($site_settings['site_keywords_' . $this->language])) $site_settings['site_keywords_' . $this->language] = "";
		if( !isset($site_settings['site_description_' . $this->language])) $site_settings['site_description_' . $this->language] = "";
		
		

		
		
		$myrow[0]['current_url'] = current_url();
		$myrow[0]['uri_string'] = uri_string();
		$myrow[0]['index_page'] = index_page();
		
		$myrow[0]['appname'] = PROJECTNAME;
		$myrow[0]['projectname'] = PROJECTNAME;
		$myrow[0]['projectnum'] = $this->config->item('projectnum');
		
		$myrow[0]['ps_domobile'] = $data['ps_domobile'];
		$myrow[0]['ps_ismobile'] = $data['ps_ismobile'];
		
		

		if($myrow[0]['CO_seoKeywords'] != "") $site_keywords = $myrow[0]['CO_seoKeywords'];	
		else $site_keywords = $site_settings['site_keywords_' . $this->language];
		
		
		if($myrow[0]['CO_seoDesc'] != "") $site_description = $myrow[0]['CO_seoDesc'];
		else $site_description = $site_settings['site_description_' . $this->language];
		
		
		$page_title = ($myrow[0]['CO_seoTitle'] != "") ? $myrow[0]['CO_seoTitle'] : ""; 


		$myrow[0]['site_keywords'] = $site_keywords;
		$myrow[0]['site_title'] = $site_settings['site_title_' . $this->language];
		$myrow[0]['page_title'] = $page_title;
		$myrow[0]['meta_page_title'] = strip_tags($page_title);
		$myrow[0]['site_description'] = $site_description;
		
		$myrow[0]['prevpage_slug'] = ($myrow[0]['prevpage'] == "") ? "" : $this->ps_content->getslug($myrow[0]['prevpage']); 
		$myrow[0]['nextpage_slug'] = ($myrow[0]['nextpage'] == "") ? "" : $this->ps_content->getslug($myrow[0]['nextpage']); 
		$myrow[0]['mobile_prevpage_slug'] = ($myrow[0]['mobile_prevpage'] == "") ? "" : $this->ps_content->getslug($myrow[0]['mobile_prevpage']); 
		$myrow[0]['mobile_nextpage_slug'] = ($myrow[0]['mobile_nextpage'] == "") ? "" : $this->ps_content->getslug($myrow[0]['mobile_nextpage']); 
		
		// stolen straight from Wordpress :)
		$myrow[0]['featured_image'] = ($myrow[0]['featured_image'] == "") ? "" : $myrow[0]['featured_image']; 
		$myrow[0]['mobile_featured_image'] = ($myrow[0]['mobile_featured_image'] == "") ? "" : $myrow[0]['mobile_featured_image']; 
		

		
		
		if(!isset($myrow[0]['CO_Body'])) $myrow[0]['CO_Body'] = '';

		if(!isset($myrow[0]['CO_MobileBody'])) $myrow[0]['CO_MobileBody'] = '';
		
		
		$data['my_cache_id'] = md5($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); //use the url to create a unique cache id for caching pages

		
		
		if ($this->page_id == ""){ //if p is empty or an error flag
			
			$myrow[0]['CO_seoTitle'] =  lang('missing_page');
			$template = "404.tpl.php"; //use page not found
			$populate = false;
			

		} else { 
			
			
			if($data['ps_domobile'] 
					&& $myrow[0]['CO_MobileTemplate'] != "" 
					&& ($myrow[0]['CO_MobileTemplate'] != $myrow[0]['CO_Template'])
					){
				
				$template = $myrow[0]['CO_MobileTemplate'];
				
				
			}else{
				$template = $myrow[0]['CO_Template'];
			}
		
			$populate = true;
		

		}	
		
		
		if ($populate) {

			
			$params = array(
			'local_init_id'=>$this->page_id
			,'local_lang'=>$this->language
			);
			
			
			$this->load->helper('formvalidation');
						
			
			$myrow[0]['lang'] = $this->language;
			
			
		}

		// we run the widgets simply to get all the asset registrations
		//$this->config->set_item('processing_widgets', TRUE);
		

		
		//$this->config->set_item('processing_widgets', FALSE);
		
	
		
		// set the content according to the device
		if($data['ps_domobile']  && $myrow[0]['CO_MobileBody'] != ""){
			$myrow[0]['CO_Body'] = $myrow[0]['CO_MobileBody'];
		}else{
			$myrow[0]['CO_Body'] = $myrow[0]['CO_Body'];
		}
				
				
						
		$myrow[0]['CO_Body'] = $this->process_widgets($myrow[0]['CO_Body']);	
		
		

		$data['template'] = $template;
		
		
		if(isset($myrow[0]['CO_Javascript']) && $myrow[0]['CO_Javascript'] != "") $this->asset_loader->add_header_js_string($myrow[0]['CO_Javascript']);
		if(isset($myrow[0]['CO_CSS']) && $myrow[0]['CO_CSS'] != "") $this->asset_loader->add_header_css_string($myrow[0]['CO_CSS']);

		
		// Basically tells template loader that this is not a widget
		$data['is_page'] = TRUE; 
		
		// we are rendering the content template first		
		$data['page_data'] = $myrow[0];
		
		$bodycontent = $this->template_loader->render_template($data);
				
		$myrow[0]['bodycontent'] = $bodycontent;
		
	
		$master_template = "index.tpl.php";
		// Nimmitha Vidyathilaka - this seems WRONG. Should come from a config value ...
		//$master_template = "master.tpl.php";
		
		$data['template'] = $master_template;
		

		// Basically tells template loader that this is not a widget
		$data['is_page'] = TRUE; 

		$data['page_data'] = $myrow[0];
			
		
		// now we will see if the user is an admin or editor. If not we will load the cached version of the page
		if($this->session->userdata('role') != 1){

			$data['lang'] = $this->config->item('lang_selected');
			$data['CO_Url'] = $page_identifier;
			
			$urlparts = parse_url($_SERVER['REQUEST_URI']);
			if(isset($urlparts['query'])) $data['query'] = $urlparts['query'];
			
			
			if($this->config->item('no_cache_write') != TRUE){ // in some cases we have dynamic page elements so need to prevent the page from caching
				echo Events::trigger('rebuild_cache', $data, 'string' );
			}else{
				// smarty is somehow triggering a rerender of the vcaptcha widget???
				echo $this->template_loader->render_template($data);
			}
	
		}else{
				
			echo $this->template_loader->render_template($data);
		}
		
	
		// final thing it to recortd the hit
		$this->_record_hit();
		
		
	}///////////////

	
	
}

