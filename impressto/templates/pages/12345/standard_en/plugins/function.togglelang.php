<?php
/**
 * Smarty plugin
 * 
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty language toggle function plugin
 * 
 * Type:     function<br>
 * Name:     togglelang<br>
 * Date:     August 20, 2012<br>
 * Purpose:  returns a simple toggle url
 * <pre>
 */
 
function smarty_function_togglelang($params, &$smarty)
{
		
	$CI = & get_instance();
	
	$CI->load->model('/public/ps_content');

	$lang = $CI->config->item('site_lang');
	
	if($lang == "en") $lang = "fr";
	else $lang  = "en";
	
	
	$slug  = $CI->ps_content->getfriendlyurl($CI->config->item('page_id'),$lang);
	if(	$slug == "") $slug = $CI->config->item('page_slug');
		

	
	echo "/" . $lang  . "/" . $slug;
	
	
	
	
	
  
} 

?>