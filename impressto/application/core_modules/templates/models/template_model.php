<?php

class template_model extends My_Model{


	
	public function init_impressto(){
		
		$this->load->library('impressto');
		
		$templatedir = dirname(__FILE__) . DS . "views" . DS . "ps_templates" . DS;
		
		$templatedir = str_replace("models" . DS, "", $templatedir);
		
		$this->impressto->setDir($templatedir);

		
	}
	
	
	public function getwidgettemplates(){
		
		// go threough template folder and locate impressto first
		
		
		// read through the application widget folders and list both views and impressto
		
		
	}
	
	
	
	function listtemplates($lang, $module = "", $widgettype = "", $device = "" ){

		$outbuf = "";
		
		$data =  array();
		
		$data['rowalt'] = "even";
			
		
		$this->load->library('template_loader');

		
		if($lang == "") $lang = "en";
		
		
		// a little hack here until main page templates get moved into the /modules/page_manager/ folder
		if($module == "" || $module == "page_manager"){ 
		
			$this->load->helper('im_helper');
			
			$config = array();
			
			$config['strippaths'] =  true;
			$config['lang'] =  $lang;
			
			// not sure if this is needed
			//if($device  == "mobile") $config['mobile'] =  TRUE;
			
			$config['device'] = $device;
			
			if($widgettype != ""){
				$config['widgettype'] =  $widgettype;
				$config['is_widget'] =  TRUE;
			}
			
			//print_r($config);
			
				
			$templatelist = $this->template_loader->find_templates($config, TRUE); // second parameter sets a full keys return

			
			if(count($templatelist) > 0){

	
				
				foreach($templatelist as $key => $templatedata){
					
					
					if($data['rowalt'] == "even") $data['rowalt'] = "odd";
					else $data['rowalt'] = "even";
					
					
					$data['templatedata'] = $templatedata;
					
					$outbuf .= $this->impressto->showpartial("admin.tpl.html",'LISTSMARTYROW', $data);
					
					
				}
				
				
			}
			
			
		}else{
			

			
			$config = array();
			
			$config['strippaths'] =  true;
			$config['lang'] =  $lang;
			$config['module'] =  $module;
			$config['widgettype'] =  $widgettype;
			$config['is_widget'] =  TRUE;
			
			if($device  == "mobile") $config['mobile'] =  TRUE;
			
			$templatelist = $this->template_loader->find_templates($config, TRUE); // second parameter sets a full keys return
			
		
			
			
			if(count($templatelist) > 0){

				
				foreach($templatelist as $key => $templatedata){
					
					
					if($data['rowalt'] == "even") $data['rowalt'] = "odd";
					else $data['rowalt'] = "even";
					
					
					$data['templatedata'] = $templatedata;
					
					$outbuf .= $this->impressto->showpartial("admin.tpl.html",'LISTSMARTYROW', $data);
					
					
				}
				
			}
			
			

		}
		
		return $outbuf;
		
		
	}
	
	
	
	
	/**
	* get the templates
	*
	*/	
	function get_smarty_data(){

		$this->load->helper("im_helper");
		$this->load->library('template_loader');
		
		
		$default_headers = array(
		
		'Name' => 'Name',
		'Filename' => 'Filename',
		'Docket' => 'Docket',
		'Author' => 'Author',
		'Status' => 'Status',
		'Date' => 'Date'
		);
		
		
		$lang = "en";
		
		$return_array = array();
		
		$projectnum = $this->config->item('projectnum');
		
		$smartypath = TEMPLATEPATH . "/smarty/";
		

		$template_folders = array(
		$smartypath .$projectnum . "/standard_{$lang}"
		,$smartypath .$projectnum . "/standard"
		, $smartypath. "default/standard_{$lang}"
		, $smartypath. "default/standard"
		
		);

		foreach($template_folders AS $folder){
			
			if(!file_exists($folder)){
				
				//echo "MISSING $folder <br />";
				continue;
			}
			
			if ($handle = opendir($folder)) {
				
				
				while (false !== ($entry = readdir($handle))) {
					
					if($entry != "." && $entry != ".." && $entry != "index.html" && $entry != ".htaccess" && $entry != "plugins" && $entry != "includes"){
						
						$template_file = $folder . "/" . $entry;
						
						$template_data = $this->template_loader->template_data($template_file, $default_headers);
						
						
						$template_data['Filename'] = str_replace($smartypath,"",$template_file);
						
						$template_data['shortfilename'] = $entry;
						
						$template_str = str_replace($smartypath,"",$template_file);
						
						$return_array[] = $template_data;
						
						
					}
				}		
			}
			
			closedir($handle);
		}
		

		
		return $return_array;
		
	}

	
	
} //end class