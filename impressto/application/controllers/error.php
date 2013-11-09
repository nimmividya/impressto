<?php

class Error extends CI_Controller {

	public $page_id;
	public $language;	

 
	/**
	* There is a vierd bug here where calling a controller with bogu sparamenter it fails to load libraries
	*
	*/ 
	function error_404()
	{
		$this->output->set_status_header('404');
					
		$this->load->library('mysmarty');
		
		$this->load->plugin('widget');
		
		$template =  "404.tpl.php";
				
				
		$myrow = array(
		
		'CO_Body'=>''
		,'CO_seoDesc'=>''
		,'page_id'=>''
		
		
		
		);
		
		
		
		$this->page_id = "";
		$this->language = "en";
		
		
		//$my_cache_id = 

		//********** display smarty template of that particular page **********
		
		$projectnum = $this->config->item('projectnum');
			
		if($projectnum){
		
			$templatedir = GETENV("DOCUMENT_ROOT") . "/" . PROJECTNAME . "/templates/smarty/" . $projectnum . "/";
			if(file_exists($templatedir)){
				$docketdir = $projectnum;
			}else{
				$docketdir = "default";
			}
		}else{
			$docketdir = "default";
		}
		
		//$this->mysmarty->template_dir  = GETENV("DOCUMENT_ROOT") . "/" . PROJECTNAME . "/templates/smarty/{$docketdir}/";
		
		$myrow[0]['CO_Body'] = $this->process_widgets($myrow['CO_Body']);
				
		
		$this->mysmarty->assign('CO_Body', $myrow);
		$this->mysmarty->assign('CO_seoDesc',"");
		$this->mysmarty->assign('page_id',"");
		
		$this->mysmarty->assign('CO_seoTitle',"PAGE MISSING");
		$this->mysmarty->assign('site_title',"");
		
					
		$this->mysmarty->assign('site_keywords','');		
		$this->mysmarty->assign('site_title','404 - MISSING PAGE');
		$this->mysmarty->assign('site_description','');
		

		
		//$this->mysmarty->assign('page_id',"");
		
		
		/// the last thing to generate is the header
		// need a function like WP_Head() so we can assign variables to it
		
		
		$this->mysmarty->display($template); //, $my_cache_id);
		
		
		
	}
	
	
		/**
	* This function can be called by template files or module code to execute template like function calls
	* Sample string: 
	* $text = "He is a simple demo of  [widget type='bg_pos_slider/bg_widget' othername='seomething else' relative=wawaewa] OR [widget='bg_pos_slider/bg_widget' ] 
	* return processed html
	*/	
	function process_widgets($string){
		
		if($string == "") return "";
		
		// replace BBCode style widget call for actual widget plugin call
		$string = preg_replace_callback(
		'/\[WIDGET=([^\]]+)?\]/i',
		create_function(
		'$matches',
		'
				return \'[Widget::run(\'.$matches[1].\')]\';
				
				'
		),
		$string);
		
		//echo $string;

		// replace wordpress style widget call for actual widget plugin call
		$string = preg_replace_callback(
		'/\[WIDGET ([^\]]+)?\]/i',
		create_function(
		'$matches',
		'
				$widget_attributes = Widget::extract_tag_attributes($matches[1]);
				
				$addon_args = array();
					
				foreach($widget_attributes as $key => $val){
				
					if(isset($widget_attributes[$key])){
							
						$widget_attributes[$key] = str_replace("\'","",trim($widget_attributes[$key]));
										
						if($key != "type"){
							$addon_args[]  = "\'$key\'=>\'$widget_attributes[$key]\'";
						}
					}
				}
						
				$addon_args_string = "array(";
				$addon_args_string .= implode(",",$addon_args);
				$addon_args_string .= ")";
				
				$returnstring = "[Widget::run(\'" . $widget_attributes[\'type\'] . "\'," . $addon_args_string . ")]";
					
				return $returnstring;		
				'
		),
		$string);
		
		
		
		$outbuf = $string;
		$pattern = '/\[(.*?)\]/is';
		$outbuf = preg_replace_callback($pattern, array(&$this, 'func_eval'), $string) . "\n";
		return $outbuf; //$outbuf;
		
	}////////////////////
	
	
}