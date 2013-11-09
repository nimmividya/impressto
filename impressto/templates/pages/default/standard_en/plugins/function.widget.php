<?php
/**
 * Smarty plugin
 * 
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty widget function plugin
 * 
 * Type:     function<br>
 * Name:     html_image<br>
 * Date:     Jan 08, 2012<br>
 * Purpose:  run widgets from the template
 * Examples: {widgets type='google_image_map' name='widget1'}
 * <pre>
 */
function smarty_function_widget($params, &$smarty)
{

			
	$addon_args = array();
					
	foreach($params as $key => $val){
				
		if(isset($params[$key])){
							
			$params[$key] = str_replace("\'","",trim($params[$key]));
										
			if($key != "type"){
				$addon_args[$key]  = $params[$key];
			}
		}
	}
	
	
	Widget::run($params['type'],$addon_args);
	
  
  
} 

?>