<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Admin Widget Plugin 
* Uses solely for backend admin widgets that can be used as Dashboard widgets to module add-on widgets 
* This is basically identical to the primary widget but it is identified differently for the sake of sanity
*/

class Admin_Widget extends Widget 
{
	public $module_path;
	public $module;
	
	function run($file) {    
		
		$args = func_get_args();
		
		
		$module = '';
		
		/* is module in filename? */
		if (($pos = strrpos($file, '/')) !== FALSE) {
			$module = substr($file, 0, $pos);
			$file = substr($file, $pos + 1);
		}else{
			$module = $file; // this allows us to just use [widget type='TYPE'] rather that [widget type='TYPE/TYPE']
		}
				

		list($path, $file) = Modules::find($file, $module, 'widgets/');
		
		if ($path === FALSE) {
		
			// check to see it a docket version exists
			$CI =& get_instance();
			
			$projectnum = $CI->config->item('projectnum');
			
			if($projectnum){

				$path = APPPATH. $projectnum . '/widgets/';
				if(!file_exists($path . $file . ".php")) $path = APPPATH.'widgets/';
		
			
			}else{
			
				$path = APPPATH.'widgets/';
				
			}
			
		}
		
		Modules::load_file($file, $path);
		
		$file = ucfirst($file);
		
		if (class_exists($file)){
			$widget = new $file();
		}else{
			echo "<!-- MISSING WIDGET CLASS {$file} -->";
		}
		
		//$widget = new $file();
		
		$widget->module_path = $path;
				
		return call_user_func_array(array($widget, 'run'), array_slice($args, 1));  // take off the first element . this is the wierdness
	}
	
	/**
	* Legacy for front end use and trying to phase out with render_template in /libraries/template_loader.php
	*
	* NOTE: As of May 2012, still used by backend widgets as navigation widgets such as in the case of the 
	* ActiveCollab widgets
	*
	* Seek the views in local templates folder first, giving precedence to mobile
	* if applicable. Last place to look is the module view folders
	*
	* IMPORTANT: THIS WILL ONLY PARSE PHP TEMPATES. SMARTY OR OTHERS WILL THROW AN ERROR
	*
	* @author Nimmitha Vidyathilaka
	*/
	function render($view, $data = array(), $return_html =  FALSE) {
		
		extract($data);
		
		// globalize variables as workaround to weird extract bug
		foreach($data AS $key => $val){
			global ${$key};
			${$key} = $val;
		}

		
		$view =  str_replace(EXT,"",$view); // just a little clean up here
				
		$projectnum = $this->config->item('projectnum');
				
		$module = str_replace(APPPATH,"",$this->module_path);
		$module = str_replace("custom_modules/","",$module);
		$module = str_replace("core_modules/","",$module);	
		$module = str_replace($projectnum . "_modules/","",$module);	
		$module = str_replace("/widgets/","",$module);	
		


		$viewfiles = array();
		
		$pathfix = str_replace(APPPATH,"",$this->module_path);
		$pathfix = str_replace("core_modules","modules",$pathfix);
		$pathfix = str_replace("custom_modules","modules",$pathfix);
		
		
		$viewfiles[] = TEMPLATEPATH . "/modules/{$projectnum}/{$module}/standard/widgets/" . $view.EXT;
		$viewfiles[] = TEMPLATEPATH . "/modules/default/{$module}/standard/widgets/" . $view.EXT;
		
		$viewfiles[] = APPPATH . $projectnum . "/" . $pathfix . "views/standard/" . $view.EXT;
		
		$viewfiles[] = APPPATH . $projectnum . "/" . $pathfix . "views/" . $view.EXT;
		
		$viewfiles[] = $this->module_path.'views/'.$projectnum  . "/" . $view.EXT;
		
		$viewfiles[] = $this->module_path.'views/'.$view.EXT;
		
			
		foreach($viewfiles as $file){
				
			//echo " SEEKING $file <br />";
	
			if(file_exists($file)){
			
				if($return_html){
					ob_start();
				}	
				include($file);
				
				if($return_html){
				
					$return_html = ob_get_contents();
					ob_end_clean();
					
					return $return_html;
					
				}else{
					return;
				}
			}	
			
		}
			
				
	}
	


	function load($object) {
		$this->$object = load_class(ucfirst($object));
	}

	function __get($var) {
		global $CI;
		return $CI->$var;
	}
	
	
	function extract_tag_attributes($response){

		//      First we assume that all valid keys are:  [a-z_]+=
		$split_response = preg_replace("#([a-z_]+=)#", "\n\\1", $response) . "\n";

		//      Now its just a matter of a simple regex:  {$key}={$value}\n
		if(preg_match_all("#([a-z_]+)=([^\n]+)\n#i", $split_response, $matches, PREG_SET_ORDER) == 0){
			return false;
		}
		//      Now turn the $matches array into a dictionary.  $match[0] contains
		//      the entire expressions, $match[1] the key, and $match[2] the value

		$dict = array();

	
		foreach($matches as $match){
			$dict[$match[1]] = $match[2];
		}
		return $dict;
	}

	
	
	
	
	
}  

?>