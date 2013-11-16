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
		
		$this->load->helper('widget_helper');
				
		
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
		
		

		
		

		$this->load->helper('mobile');

		

		
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
		

		/////////////////////////////////////
		// get the cache file 
		$uri = $_SERVER['REQUEST_URI'];
				
		$uri = rtrim( ltrim($uri, '/'),'/');
			
		$cachefile = APPPATH . PROJECTNUM . "/cache/pages/".urlencode($uri).".html";
					
		// now we will see if the user is an admin or editor. If not we will load the cached version of the page
		if($this->session->userdata('role') != 1){
				
			$page_cache_timeout = $this->config->item('page_cache_timeout');
						
				
			if($page_cache_timeout == 0) $page_cache_timeout = 3600; // 3600 = one hour
							

			if(file_exists($cachefile) && ((time() - filemtime($cachefile)) < $page_cache_timeout)) {
								
				echo file_get_contents($cachefile);
				
				// final thing it to record the hit
				$this->_record_hit();
				
				$this->benchmark->mark('code_end');
		
				// in case you need some metrics
				//echo $this->benchmark->elapsed_time('code_start', 'code_end');

				die(); // nothing more to do so get the fuck outta dodge
		
			}
		}		
		//
		///////////////////

				
		$this->load->helper('im_helper');
		$this->load->plugin('widget');
		$this->load->library('template_loader');
		$this->load->library('asset_loader');
		
				
		
	
		
		if($this->archive_id){
			
			$this->load->helper('auth');
			
			// only authorized users can see archives
			is_logged_in();
			
			
			$myrow = $this->ps_content->get_archivedcontent_data($this->archive_id);
			$page_data = $myrow[0];
			
			
			if($page_data['CO_externalLink'] != ""){
				
				$alias_info = $this->ps_content->find_alias($page_data['CO_externalLink']);
				
				if($alias_info['extenal_link']){

					$page_data['CO_Body'] = $page_data['CO_MobileBody'] = "LINK: <a href=\"{$alias_info['extenal_link']}\">{$alias_info['extenal_link']}</a>";
					
				}else if($alias_info['module']){
					
					$page_data['CO_Body'] = $page_data['CO_MobileBody'] = "MODULE CALL: {$alias_info['module']}";
									
				}else if($alias_info['page']){
									
					$page_data['CO_Body'] = $page_data['CO_MobileBody'] = "PAGE ALIAS : {$alias_info['page']}";
								
				}			
				
			}
			
		}else if($this->draft_id){
			
			$this->load->helper('auth');
			
			is_logged_in();
			
			// we are going to show a draft copy of the page. If no draft exists, just show the current page
			
			$myrow = $this->ps_content->get_draftcontent_data($this->draft_id);
			$page_data = $myrow[0];
			
			if($page_data['CO_externalLink'] != ""){
				
				$alias_info = $this->ps_content->find_alias($page_data['CO_externalLink']);
				
				if($alias_info['extenal_link']){

					$page_data['CO_Body'] = $page_data['CO_MobileBody'] = "LINK: <a href=\"{$alias_info['extenal_link']}\">{$alias_info['extenal_link']}</a>";

					
				}else if($alias_info['module']){
					
					$page_data['CO_Body'] = $page_data['CO_MobileBody'] = "MODULE CALL: {$alias_info['module']}";
					
				}else if($alias_info['page']){
				
					$page_data['CO_Body'] = $page_data['CO_MobileBody'] = "PAGE ALIAS : {$alias_info['page']}";
					
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
			$page_data = $myrow[0];
			
			$page_data['content_lang'] = $this->language;
			
			$page_data['admin_widgets'] = "";
						
						
			$triggerdata = Events::trigger('public_page_view', $page_data, 'array', TRUE); // this is where we will hook the postits....
			
			if($triggerdata) $page_data = $triggerdata[0];
			
			
		}


			
		
		// Make basic MyApp constants available within the page templates
		$page_data['environment'] = ENVIRONMENT;
		$page_data['appseries'] = APPSERIES;
		$page_data['projectnum'] = PROJECTNUM;
		$page_data['projectname'] = PROJECTNAME;
		$page_data['vendor'] = VENDOR;
		$page_data['vendorurl'] = VENDORURL;
		$page_data['asseturl'] = ASSETURL;
				


		
		
		// 404 Handler
		if(!isset($page_data['CO_Node'])){
			
			$page_data['CO_seoTitle'] = lang('missing_page');
						
			$template = "404.tpl.php"; //use page not found
			$data['template'] = $template;
			
			$populate = false;
			
			$data['my_cache_id'] = 404;
			
			$data['is_page'] = TRUE; 
			
			$page_data['site_keywords'] = "404";		
			$page_data['site_title'] = "404";
			$page_data['page_title'] = "404";		
			$page_data['site_description'] = "";
									
					
			$page_data['lang'] = $this->config->item('lang_selected');	
					
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
			
		
			$this->asset_loader->add_header_js_string_top($js_string);
			
			
			$this->asset_loader->add_header_js_top("public/js/script.js");
			$this->asset_loader->add_header_css_top("public/default/css/reset.css","","all");		
			$this->asset_loader->add_header_css_top("public/default/css/style.css","","screen");
		

			$page_data['CO_Body'] = "404 Page Missing";
		
			$data['page_data'] = $page_data;
	
			echo $this->template_loader->render_template($data);
			
			return; // bail out here
			
			
		}

		

		
		
		if(!$this->archive_id && $page_data['CO_externalLink'] != ""){
			
			
			$alias_info = $this->ps_content->find_alias($page_data['CO_externalLink']);

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
						$page_data['CO_Body'] = modules::run("$controller/$method",$args);
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
				$page_data = $myrow[0];
				
				$this->page_id = $page_data['CO_Node'];
				
				
			}
			
			
		}
		
		
		
		$this->config->set_item( 'page_id' , $this->page_id );
		// This is the same thing as page_id but we are trying to phase out the refernece to page_id and replace it with page_node_id 
		$this->config->set_item( 'page_node_id' , $this->page_id );
		
		
		if ( ! defined('PS_PAGEID')) define('PS_PAGEID',$this->page_id);
		
		
		
		
		// set this variable so we can use if for custom conditionals in templates or whatever ...
		$this->config->set_item('page_slug',$page_identifier ); 
		
		$page_data['lang'] = $this->config->item('lang_selected');
		
		
		

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
					
		
		
		$this->asset_loader->add_header_js_string_top($js_string);

		
		$this->asset_loader->add_header_js_string_top("ps_base.ismobile = '{$ismobile}';");	
		

		// should this stuff really be here or more conveniently defined in the page tempate?
		$this->asset_loader->add_header_js_top("public/js/script.js");
		$this->asset_loader->add_header_css_top("public/default/css/reset.css","","all");		
		$this->asset_loader->add_header_css_top("public/default/css/style.css","","screen");
		
		
				
		
		// if this is a mobile use custom javascript and css if available
		if($data['ps_domobile']){

			if($page_data['CO_MobileJavascript'] != "")
			$page_data['CO_Javascript'] = $page_data['CO_MobileJavascript'];
			
			if($page_data['CO_MobileCSS'] != "")
			$page_data['CO_CSS'] = $page_data['CO_MobileCSS'];
			
		}
		
		if($this->archive_id || ( isset($page_data['CO_Active']) && $page_data['CO_Active'] == 0 ) ){
			
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
		
		
		$page_data['current_url'] = current_url();
		$page_data['uri_string'] = uri_string();
		$page_data['index_page'] = index_page();
		
		$page_data['appname'] = PROJECTNAME;
		$page_data['projectname'] = PROJECTNAME;
		$page_data['projectnum'] = $this->config->item('projectnum');
		
		$page_data['ps_domobile'] = $data['ps_domobile'];
		$page_data['ps_ismobile'] = $data['ps_ismobile'];
		
		

		if($page_data['CO_seoKeywords'] != "") $site_keywords = $page_data['CO_seoKeywords'];	
		else $site_keywords = $site_settings['site_keywords_' . $this->language];
		
		
		if($page_data['CO_seoDesc'] != "") $site_description = $page_data['CO_seoDesc'];
		else $site_description = $site_settings['site_description_' . $this->language];
		
		
		$page_title = ($page_data['CO_seoTitle'] != "") ? $page_data['CO_seoTitle'] : ""; 


		$page_data['site_keywords'] = $site_keywords;
		$page_data['site_title'] = $site_settings['site_title_' . $this->language];
		$page_data['page_title'] = $page_title;
		$page_data['meta_page_title'] = strip_tags($page_title);
		$page_data['site_description'] = $site_description;
		
		$page_data['prevpage_slug'] = ($page_data['prevpage'] == "") ? "" : $this->ps_content->getslug($page_data['prevpage']); 
		$page_data['nextpage_slug'] = ($page_data['nextpage'] == "") ? "" : $this->ps_content->getslug($page_data['nextpage']); 
		$page_data['mobile_prevpage_slug'] = ($page_data['mobile_prevpage'] == "") ? "" : $this->ps_content->getslug($page_data['mobile_prevpage']); 
		$page_data['mobile_nextpage_slug'] = ($page_data['mobile_nextpage'] == "") ? "" : $this->ps_content->getslug($page_data['mobile_nextpage']); 
		
		// stolen straight from Wordpress :)
		$page_data['featured_image'] = ($page_data['featured_image'] == "") ? "" : $page_data['featured_image']; 
		$page_data['mobile_featured_image'] = ($page_data['mobile_featured_image'] == "") ? "" : $page_data['mobile_featured_image']; 
		

		
		
		if(!isset($page_data['CO_Body'])) $page_data['CO_Body'] = '';

		if(!isset($page_data['CO_MobileBody'])) $page_data['CO_MobileBody'] = '';
		
		
		$data['my_cache_id'] = md5($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); //use the url to create a unique cache id for caching pages

		
		
		if ($this->page_id == ""){ //if p is empty or an error flag
			
			$page_data['CO_seoTitle'] = $page_data['CO_seoTitle'] =  lang('missing_page');
			$template = "404.tpl.php"; //use page not found
			$populate = false;
			

		} else { 
			
			
			if($data['ps_domobile'] 
					&& $page_data['CO_MobileTemplate'] != "" 
					&& ($page_data['CO_MobileTemplate'] != $page_data['CO_Template'])
					){
				
				$template = $page_data['CO_MobileTemplate'];
				
				
			}else{
				$template = $page_data['CO_Template'];
			}
		
			$populate = true;
		

		}	
		
		
		if ($populate) {

			
			$params = array(
			'local_init_id'=>$this->page_id
			,'local_lang'=>$this->language
			);
			
			
			$this->load->helper('formvalidation');
						
			
			$page_data['lang'] = $this->language;
			
			
		}

		// set the content according to the device
		if($data['ps_domobile']  && $page_data['CO_MobileBody'] != ""){
			$page_data['CO_Body'] = $page_data['CO_MobileBody'];
		}

	
		// load the page data into a config so the widgets can mess with it
		$this->config->set_item('page_data', $page_data);
		
							
		$CO_Body = $this->process_widgets($page_data['CO_Body']);	
		

		$data['template'] = $template;
		
		
		if(isset($page_data['CO_Javascript']) && $page_data['CO_Javascript'] != "") $this->asset_loader->add_header_js_string($page_data['CO_Javascript']);
		if(isset($page_data['CO_CSS']) && $page_data['CO_CSS'] != "") $this->asset_loader->add_header_css_string($page_data['CO_CSS']);

		
		// Basically tells template loader that this is not a widget
		$data['is_page'] = TRUE; 
			
		$data['page_data'] = $this->config->item('page_data');
		
		$data['page_data']['CO_Body'] = $CO_Body;
		
		
		$bodycontent = $this->template_loader->render_template($data);
	
		$page_data = $this->config->item('page_data');
		$page_data['CO_Body'] = $CO_Body;
		$page_data['bodycontent'] =  $bodycontent;
		
	
		// peterdrinnan - this seems WRONG. Should come from a config value ...
		$master_template = "index.tpl.php";
		
		$data['template'] = $master_template;
		

		// Basically tells template loader that this is not a widget
		$data['is_page'] = TRUE; 

		$data['page_data'] = $page_data; 
		
		//var_dump($data);
		
		
		// now we will see if the user is an admin or editor. If not we will load the cached version of the page
		if($this->session->userdata('role') != 1){

			$data['lang'] = $this->config->item('lang_selected');
			$data['CO_Url'] = $page_identifier;
			
			$urlparts = parse_url($_SERVER['REQUEST_URI']);
			if(isset($urlparts['query'])) $data['query'] = $urlparts['query'];
			
			
			if($this->config->item('no_cache_write') != TRUE){ // in some cases we have dynamic page elements so need to prevent the page from caching
				
				$data['cachefile'] = $cachefile;				
				echo Events::trigger('rebuild_cache', $data, 'string' );
			}else{
				// smarty is somehow triggering a rerender of the vcaptcha widget???
				echo $this->template_loader->render_template($data);
			}
	
		}else{
				
			echo $this->template_loader->render_template($data);
		}
		
	
		// final thing it to record the hit
		$this->_record_hit();
		
		
	}///////////////

	
	
}

