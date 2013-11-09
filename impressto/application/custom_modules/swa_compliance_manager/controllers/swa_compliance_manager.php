<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class swa_compliance_manager extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		$this->load->helper('auth');
		
		is_logged_in();
		
		$this->load->model('swa_compliance_manager_model');
		
	}
	
	
	public function index()
	{
		
		// this is where the reporting tools will go
		
		// we will also have the development guide here
		
		$data = array();
				
		$this->load->helper('im_helper');
		$this->load->library('template_loader');
		$this->load->library('asset_loader');

		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/custom_modules/swa_compliance_manager/css/style.css");
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/flot/jquery.flot.min.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/flot/jquery.flot.resize.min.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/flot/jquery.flot.pie.min.js");

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/swa_compliance_manager/js/swa_compliance_manager.js");

			
		
						
		$site_settings = $this->site_settings_model->get_settings();
				
		$data['infobar_help_section'] = ""; //getinfobarcontent('admin_barHELP');
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
				
		$settings = ps_getmoduleoptions("swa_compliance_manager");
		
		if(!isset($settings['template'])) $settings['template'] = "";
	
		$data['settings'] = $settings;

		
		$data['parsedcontent'] = $this->load->view('manager', $data, TRUE); 
		
		
				
		$data['data'] = $data; // Alice in Wonderland shit here!
					
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
		
		
	}


	
	public function show_status($page_node, $lang)
	{
		
		$this->load->library('formelement');
		
		// this is needed for plugin widgets
		$this->load->plugin('widget'); 
		
		
		$data = $this->swa_compliance_manager_model->get_status($page_node, $lang);
		
		$data['page_node'] = $page_node;
		$data['lang'] = $lang;
		
		echo $this->load->view('status', $data, true);	
		
		
	}
	

	

	public function save_status()
	{
		
		$page_node = $this->input->post('page_node');
		$data['lang'] = $this->input->post('lang');
		
		$data['alt_tags'] = ($this->input->post('alt_tags') == "Y" ? "Y" : "N");
		$data['acronyms'] = ($this->input->post('acronyms') == "Y" ? "Y" : "N");
		$data['top_links'] = ($this->input->post('top_links') == "Y" ? "Y" : "N");
		$data['plain_html'] = ($this->input->post('plain_html') == "Y" ? "Y" : "N");
		$data['file_naming'] = ($this->input->post('file_naming') == "Y" ? "Y" : "N");
		$data['navigation'] = ($this->input->post('navigation') == "Y" ? "Y" : "N");
		$data['element_width'] = ($this->input->post('element_width') == "Y" ? "Y" : "N");

		
		$this->swa_compliance_manager_model->save_status($page_node, $data);
		
		
		
	}
	
	
	public function validate_content($node_id,$lang)
	{

		$this->load->helper('simple_html_dom/simple_html_dom');
		
		
		//add the path for the widgets module so we can locate the models	
		$this->load->_add_module_paths('page_manager');
		$this->load->model('madmincontent');

		$tagsearch_array = array(
		
		'anchors' => 'a',
		'images' => 'img',
		'tables' => 'table',		
		
		);
		
		
		$contentdata = $this->madmincontent->getcontentdata($node_id, $lang);
		
		

		//$content_to_analyze = trim($contentdata['CO_Body']);		
		
		
		//if($content_to_analyze == ""){ 
		
		$contentdata['content_lang'] = $lang;
		$contentdata['CO_Node'] = $node_id;
		$contentdata['CO_Node'] = $node_id;
		
		$static_data = $this->swa_compliance_manager_model->get_static_html($contentdata);

		$content_to_analyze = trim($static_data['CO_Body']);
		
		//}

		

		if($content_to_analyze != ""){
			
			$html = str_get_html($content_to_analyze);
			

			$lang = '';
			$l=$html->find('html', 0);
			if ($l!==null)
			$lang = $l->lang;
			
			if ($lang!='')
			$lang = 'lang="'.$lang.'"';
			
			$charset = $html->find('meta[http-equiv*=content-type]', 0);
			$target = array();
			

			echo "<div id=\"sidetreecontrol\"><a href=\"?#\">Collapse All</a> | <a href=\"?#\">Expand All</a></div><br>";


			
			foreach($tagsearch_array AS $tagname => $tag){
				
				$target = $html->find($tag);
				
				echo "<hr><strong>Scanning {$tagname}</strong> " . count($target) . " found.<br />\n";
				
				echo "<ul class=\"treeview\" id=\"html_tree\">";
				
				ob_start();
				
				//foreach($target as $e) echo get_html_tree($e, true);
				
				foreach($target as $e) $this->dump_my_html_tree($e, true);
				
				
				ob_end_flush();
				echo "</ul>";
				
				
				
				
			}
			
			
			
			
			
		}			
		
		

		
		
	}
	
	

	
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
	
	
		$this->load->library('file_tools');
				

		$data['dbprefix'] = $this->db->dbprefix;
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		$asset_target_folder = ASSET_ROOT . "upload/clf_compliance_manager/en/images/";
			
		$this->file_tools->create_dirpath($asset_target_folder); 
		
		$asset_target_folder = ASSET_ROOT . "upload/clf_compliance_manager/fr/images/";
			
		$this->file_tools->create_dirpath($asset_target_folder); 
		
		
		//echo "procesing";
		
	}	
	
	
	


	function dump_my_html_tree($node, $show_attr=true, $deep=0, $last=true) {

		$count = count($node->nodes);
		
		$illegaltags = array(
		
		"style", // no inline styles allows
		"frame",
		
		);
		
		$tags_array = array();
		
		
		$tags_array["a"] = array(
		"required" => array("title"),
		"illegal" => array("style")
		);
		
		
		//$tags_array["em"] = array(
		//"required" => array(),
		//"illegal" => array()
		//);
		
		$tags_array["img"] = array(
		
		"required" => array("alt"),
		"illegal" => array("style","title"),
		"failed_vals" => array("width"=>"> 600")
		);
		
		
		$tags_array["table"] = array(
		
		"illegal" => array("style"),
		"failed_vals" => array("width"=>"> 600")
		);
		



		
		$dosearch = TRUE;
		
		
		if(!array_key_exists($node->tag,$tags_array)) $dosearch = FALSE;

		
		$elementfailclass = "";
		
		
		if($dosearch){

			$targetpass = TRUE;

			$searchtagfound = FALSE;
			
			foreach($node->attr as $k=>$v) {
				
				if(in_array($k,$illegaltags)) $targetpass = FALSE;

				if(isset($tags_array[$node->tag]['failed_vals']) && is_array($tags_array[$node->tag]['failed_vals'])){
					
					foreach($tags_array[$node->tag]['failed_vals'] AS $k2 => $v2){
						
						if($k == $k2){
							eval("if($v  $v2) \$targetpass = FALSE;");
						}
						
					}
				}
				
				if(isset($tags_array[$node->tag]['illegal']) 
						&& is_array($tags_array[$node->tag]['illegal']) 
						&& in_array($k,$tags_array[$node->tag]['illegal'])){
					
					$targetpass = FALSE;
				}
				
				if(!isset($tags_array[$node->tag]['required']))  $searchtagfound = TRUE;
				
				if(isset($tags_array[$node->tag]['required']) 
						&& is_array($tags_array[$node->tag]['required']) 
						&& in_array($k,$tags_array[$node->tag]['required'])){
					
					$searchtagfound = TRUE;

					if($node->$k == ""){

						$targetpass = FALSE;
						
					}
					
				}			
				
			}
			
			if(!$searchtagfound || !$targetpass){
				$elementfailclass = "failed_clf_element";
			}
			
			
		}	
		
		if ($count>0) {
			if($last)
			echo '<li class="expandable lastExpandable ' . $elementfailclass . '"><div class="hitarea expandable-hitarea lastExpandable-hitarea"></div>&lt;<span class="tag">'.htmlspecialchars($node->tag).'</span>';
			else
			echo '<li class="expandable' . $elementfailclass . '"><div class="hitarea expandable-hitarea"></div>&lt;<span class="tag">'.htmlspecialchars($node->tag).'</span>';
		}
		else {
			$laststr = ($last===false) ? '' : ' class="last ' . $elementfailclass . '"';
			echo '<li'.$laststr.'>&lt;<span class="tag">'.htmlspecialchars($node->tag).'</span>';
		}
		
		

		if ($show_attr) {
			
			foreach($node->attr as $k=>$v) {
				
				$starttag = $endtag = "";

				
				if(in_array($k,$illegaltags)){
					
					$starttag = "<span style=\"text-decoration: line-through;\">";
					$endtag = "</span>";
					
				}
				
				if(isset($tags_array[$node->tag]['failed_vals']) && is_array($tags_array[$node->tag]['failed_vals'])){
					
					foreach($tags_array[$node->tag]['failed_vals'] AS $k2 => $v2){
						
						$failed = FALSE;
						
						if($k == $k2){
							eval("if($v  $v2) \$failed = TRUE;");
						}
						
						if($failed){
							$starttag = "<span style=\"background-color:#FB5725;\">";
							$endtag = "</span>";
						}
						
					}
				}
				
				if(isset($tags_array[$node->tag]['illegal']) 
						&& is_array($tags_array[$node->tag]['illegal']) 
						&& in_array($k,$tags_array[$node->tag]['illegal'])){
					
					$starttag = "<span style=\"text-decoration: line-through;\">";
					$endtag = "</span>";
				}

				echo ' '.$starttag.htmlspecialchars($k).'="<span class="attr">'.htmlspecialchars($node->$k).'</span>"' . $endtag;
				
			}
		}
		echo '&gt;';
		
		if ($node->tag==='text' || $node->tag==='comment') {
			echo htmlspecialchars($node->innertext);
			return;
		}

		if ($count>0) echo "\n<ul style=\"display: none;\">\n";
		$i=0;
		foreach($node->nodes as $c) {
			$last = (++$i==$count) ? true : false;
			$this->dump_my_html_tree($c, $show_attr, $deep+1, $last);
		}
		if ($count>0)
		echo "</ul>\n";

		echo "</li>\n";

	}

	
	
}



