<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_help extends PSBase_Controller {

	public function __construct(){
		
		parent::__construct();
		
		$this->benchmark->mark('code_start');
		
		$this->load->helper('auth');
							
		is_logged_in();
		
		

	}
	
	
	public function index(){
		
		$args = func_get_args();
		
		if(isset($args[1])) $refdoc = $args[1];
		else $refdoc ="";
		
		if(isset($args[2])) $section = $args[2];
		else $section = "";
	

	
		
		$this->load->library('impressto');
		
		$prevdir = $this->impressto->getDir();
		
		$helpdir = INSTALL_ROOT . "help/";
		
		$data['asset_url'] = ASSETURL;
		$data['appname'] = PROJECTNAME;
		
		$this->impressto->setDir($helpdir);
		
		$content = array();
		
		
		if($refdoc == ""){
		
			$sections = array(
			
			"General Overview"=>"GENERAL_OVERVIEW",
			"Content Administration"=>"ADMIN_CONTENT__ADMIN_CONTENT__INDEX__HELP",
			"Content Editing"=>"CONTENTEDITHELP",
			"Content Previewing"=>"PREVIEWWHELP",
			"Content Blocks"=>"CONTENTBLOCKSHELP",
			"Assets"=>"ASSETSHELP",
			"Modules"=>"MODULESHELP",
			"Widgets"=>"WIDGETSHELP",
			"Configuration"=>"CONFIGURATIONHELP",			
			
			);
		
			$refdoc = "core_modules";
			
			foreach($sections AS $label => $section){
		
				$content[$label] = $this->impressto->showpartial("{$refdoc}.tpl.php",strtoupper($section),$data);
			}
			
			
		}else{
		
		
			if($section == ""){
			
				$content[$section] = $this->impressto->show("{$refdoc}.tpl.php",$data);
		
			}else{
		
				$content[$section] = $this->impressto->showpartial("{$refdoc}.tpl.php",strtoupper($section),$data);
		
			}
			
		}
		
		

		$data['content'] = $content; //$this->impressto->show("core_modules.tpl.php",$data);
				
		
		// restore the directry
		if($prevdir != "") $this->impressto->setDir($prevdir);
			
		
		$data['main_content'] = 'admin_help';
		
	
		$site_settings = $this->site_settings_model->get_settings();
				
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}
	

	
	
}

