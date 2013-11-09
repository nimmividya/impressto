<!--
@Name: Language toggle float right
@Type: PHP
@Author: 
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/09/04
-->
<?php

	$CI = & get_instance();
	
	$css_string = " 
	
	.language_toggle_wrapper{
		float:right; 
		margin-right:40px;
		margin-top:10px; 
	 }
	
	.language_toggle_wrapper a{
		color: #788e1e;
		font-weight: normal;
	 }	
	 
	 ";
	
	
	
	$CI->asset_loader->add_header_css_string($css_string); 
	
 
?>

<div class="language_toggle_wrapper">
<?php


$lang_toggles = array();

$CI->lang->load('language_toggle', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	

$lang_avail = $CI->config->item('lang_avail');


foreach($lang_avail AS $langcode=>$language){ 
		

	if($langcode != $lang_selected){
		
		$lang_toggles [] = "<a class=\"util\" href=\"/{$langcode}/" . ${'url_' . $langcode} . "\">" . $CI->lang->line($language) . "</a>";
			
	}
		
}
	
echo implode(" | ",$lang_toggles);
	
	
?>
</div>
