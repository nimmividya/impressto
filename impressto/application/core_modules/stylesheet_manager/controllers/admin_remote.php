<?php

class admin_remote extends PSBase_Controller {

	private $template_folder;


	
	public function __construct(){
		
		parent::__construct();

		$this->load->helper('auth');
		
		is_logged_in();
		
		$this->load->model('stylesheet_manager_model');
		
		
		
		
	}
	
	/**
	* default management page
	*
	*/
	public function setmodule($module){
		
		$this->load->library('formelement');
		
		$css_dirs = array();
		$loaded_css = array();
		
		// return a css selector with all the css files for the selected module

		$projectnum = $this->config->item('projectnum');
		
		$css_array = array("Select"=>"");
		
		if($module == "public"){
			
			$css_dirs[] = ASSET_ROOT . "public/default/css/";	
			
			if( $projectnum != "" && file_exists(ASSET_ROOT . "public/{$projectnum}/css/")  ){
				
				$css_dirs[] = ASSET_ROOT . "public/{$projectnum}/css/";
				
			}	

			
		}else{
			
						
			$cssdir = ASSET_ROOT . PROJECTNAME."/default/core_modules/{$module}/css/";
			
			
			if(file_exists($cssdir)){
				$css_dirs[] = $cssdir;
			}
			
			$cssdir = ASSET_ROOT . PROJECTNAME."/default/custom_modules/{$module}/css/";
			
			if(file_exists($cssdir)){
				$css_dirs[] = $cssdir;
			}
			
			$cssdir = ASSET_ROOT . PROJECTNAME ."/{$projectnum}/core_modules/{$module}/css/";
			
			if(file_exists($cssdir)){
				$css_dirs[] = $cssdir;
			}
			
			$cssdir = ASSET_ROOT . PROJECTNAME ."/{$projectnum}/custom_modules/{$module}/css/";
			
			if(file_exists($cssdir)){
				$css_dirs[] = $cssdir;
			}
	
			
		}
		

		foreach($css_dirs as $css_dir){
			

			if(file_exists($css_dir)){
				
				if ($files_handle = opendir($css_dir)) {

					while (false !== ($file = readdir($files_handle))) {
						
						if(!is_dir($css_dir . "/". $file)){
													
							if ($file != "." && $file != ".." && $file != "index.htm" && $file != "index.html") {
								
												
								// do not load minified css. BitHeads Central will auto compress recently changed css files at runtime.
								$is_min = $this->_check_min_extention($file);
								
								if(!$is_min && !in_array($file,$loaded_css)){
						
									
									if($module == "core") $loaded_css[] = $file;
									else $loaded_css[] = $module . "/" . $file;
									
									
									$css_label = $file;
									$css_label = str_replace(" ","_",$css_label);
									$css_label = str_replace(".css","",$css_label);
									
									if(is_numeric($css_label))  $css_label = "_" . $css_label; // can't use numb ers as keys
									
																				
									
									$css_array[$css_label] = str_replace(getenv("DOCUMENT_ROOT"),"",$css_dir) . $file;
									
								}
								
							}
						}
					}
				}
			}
		}
		
		
		$fielddata = array(
		'name'        => "css_selector",
		'type'          => 'select',
		'id'          => "css_selector",
		'label'          => "CSS",
		'onchange' => "ps_stylesheetmanager.getstyle(this)",
		'options' =>  $css_array,
		'value'       => ''
		);
		
		echo $this->formelement->generate($fielddata);
		
		
		
		
	} ///////////////////
	
	
	/**
	*
	*
	*/	
	public function getstyle(){
		
		$css = $this->input->get_post('css');
		 
		$return_array = array();
		
		$return_array['error'] = "";
				
		$css_file = getenv("DOCUMENT_ROOT") . $css;
		
		if(file_exists($css_file)){
		
		    $last_updated = date ("Y/m/d H:i", filemtime($css_file));
			
			$return_array['last_updated'] = $last_updated;
			$return_array['css_file'] = $css;
			$return_array['css'] = file_get_contents($css_file);
			
		}else{
			
			$return_array['last_updated'] = "N/A";
			$return_array['css_file'] = "N/A";
			$return_array['css'] = "/**  */";
			$return_array['error'] = "error loading {$css}";
			
		}

		echo json_encode($return_array);

		
	}
	
	
	
	/**
	*
	*
	*/	
	public function savecss(){
		
		
		$css = $this->input->post('css');
		$module = $this->input->post('module');
		$style_file = $this->input->post('style_file');

		
		$css_file = getenv("DOCUMENT_ROOT") . $style_file;

		
		if(file_exists($css_file)){
			
			file_put_contents($css_file, $css);
			
		}else{
			
			echo "{$style_file} does not exist";
			
		}
		
		
		
	}	
	
	
	private function _check_min_extention($filename) {
	
		if(stristr($filename, ".min.")  === FALSE) return FALSE;
		else return TRUE;
				
				
	}
	

	
	

} //end class