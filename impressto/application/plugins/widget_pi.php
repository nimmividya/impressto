<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Widget Plugin 
* 
* Install this file as application/plugins/widget_pi.php
* 
* @version:     0.21
* $copyright     Copyright (c) Wiredesignz 2009-09-07
* 
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
* 
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
* 
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*/

// example of usage
// In page content
//  [widget type='bg_pos_slider/bg_widget' name="widget1" othername='seomething else' relative=wawaewa]
// OR in content pages
// [widget='bg_pos_slider/bg_widget']

// PHP directly
// Widget::run('type',$addon_args);
// 
// in smarty
// {widgets type='widgettype' name='widget_instance_name'}

class Widget
{
	public $module_path;
	public $module;

	/**
	* run slus for shortcodes here
	*
	*/
	public function run_slug($slug) {  
	
		
		$CI =& get_instance();
		
		$query = $CI->db->get_where("widgets", array("slug"=>$slug));
		
		if ($query->num_rows() > 0){
					
			$row = $query->row();
			
			$module = $row->module;
			$widget = $row->widget;
			$instance = $row->instance;
			
			if($module == "")$file = $widget;
			else $file = $module . "/" . $widget;
			
			$args = null;
			
			if($instance != "") $args = array("name"=>$instance);
			
			Widget::run($file,$args);
					
		
		}
	
	}
	
	
	
	public function run($file) {    
		
		$CI =& get_instance();
				
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
		
			//echo " FLAG2 $file ";
			
		
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
		
			// if we are in development or testing mode add debug into for template work
			if( $CI->config->item('debugmode') ){
			
				// DO NOT DELETE : Turned off untilthe damn minified css gets fixed
				//echo "<!-- PS WIDGET: " . str_replace(getenv("DOCUMENT_ROOT"),"",$path . $file ) . ".php -->";
			}
			
			$widget = new $file();
		}
				
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
	public function render($view, $data = array(), $return_html =  FALSE) {
		
		extract($data);
				
		$view =  str_replace(EXT,"",$view); // just a little clean up here
				
		$projectnum = $this->config->item('projectnum');
		$domobile = $this->config->item('domobile');
				
		$module = str_replace(APPPATH,"",$this->module_path);
		$module = str_replace("custom_modules/","",$module);
		$module = str_replace("core_modules/","",$module);	
		$module = str_replace($projectnum . "_modules/","",$module);	
		$module = str_replace("/widgets/","",$module);	
		
		
		$this->load->helper('mobile');
		$device = ps_domobile() ? "mobile" : "standard";
		

		$viewfiles = array();
		
		$pathfix = str_replace(APPPATH,"",$this->module_path);
		$pathfix = str_replace("core_modules","modules",$pathfix);
		$pathfix = str_replace("custom_modules","modules",$pathfix);
		
		
		if($domobile){
		
			$viewfiles[] = TEMPLATEPATH . "/modules/" . $projectnum . "/" . $module . "/mobile/widgets/" . $view.EXT;
			$viewfiles[] = TEMPLATEPATH . "/modules/default/". $module . "/mobile/widgets/" . $view.EXT;
					
		}		
		
		
		if($device != "standard") $viewfiles[] = TEMPLATEPATH . "/modules/{$projectnum}/{$module}/{$device}/widgets/" . $view.EXT;
		if($device != "standard") $viewfiles[] = TEMPLATEPATH . "/modules/default/{$module}/{$device}/widgets/" . $view.EXT;
		
		$viewfiles[] = TEMPLATEPATH . "/modules/{$projectnum}/{$module}/standard/widgets/" . $view.EXT;
		$viewfiles[] = TEMPLATEPATH . "/modules/default/{$module}/standard/widgets/" . $view.EXT;
		
		
		if($device != "standard") $viewfiles[] = APPPATH . $projectnum . "/" . $pathfix . "views/{$device}/" . $view.EXT;
		
		$viewfiles[] = APPPATH . $projectnum . "/" . $pathfix . "views/standard/" . $view.EXT;
		
		$viewfiles[] = APPPATH . $projectnum . "/" . $pathfix . "views/" . $view.EXT;
					
		$viewfiles[] = $this->module_path.'views/'.$projectnum . '/' . $view.'/'.$view.EXT;
		
		$viewfiles[] = $this->module_path.'views/'.$projectnum  . "/" . $view.EXT;
			
		$viewfiles[] = $this->module_path.'views/'.$view.'/'.$view.EXT;
		
		$viewfiles[] = $this->module_path.'views/'.$view.EXT;
		
		foreach($viewfiles as $file){
		
			//echo "{$file} <br />";
				
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
	


	protected function load($object) {
		$this->$object = load_class(ucfirst($object));
	}

	public function __get($var) {
		global $CI;
		return $CI->$var;
	}
	
	
	public function extract_tag_attributes($response){

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

	
	/**
	* Allows us to have PHP code in content blocks and such things
	*
	*/
	protected function phpparse_string($phpstring){
	
		$CI = & get_instance();
		

		// skip and hop over the extrat function
		$this_phpstring = $phpstring;
	
		extract( $GLOBALS ); // this is friggin GOLD
				
		$phpstring = $this_phpstring;
		

		global $ps_vars;
		$ps_vars = get_object_vars($CI);

		ob_start();
		eval(" ?>" . $phpstring . "<?php ");
		$outbuf = ob_get_contents();
		ob_end_clean();

		return $outbuf;

	}
	
	
	
	/**
	* This should be replaced by the function in widget_utils
	*/	
	protected function process_sub_widgets($string){
	
		$CI = & get_instance();
			
		$CI->load->library('widget_utils');
		
		return $CI->widget_utils->process_widgets($string);
		
		
	}////////////////////
	
	
	/**
	* Simply gets the module version number if it exists
	* @return bool FALSE on fail, string version on success
	* @author Nimmitha Vidyathilaka
	* @since November 06, 2012 
	*/	
	public function _get_module_version($module){
	
		$CI = & get_instance();
			
		$CI->load->config($module . '/config');
		
		$module_config = $CI->config->item('module_config');
		
		if(isset($module_config['version'])) return $module_config['version'];
		else return FALSE;
			
		
	}
	
	
	
	
}  