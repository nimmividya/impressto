<!--
@Name: Language toggle
@Type: PHP
@Author: 
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/09/04
-->

<?php

$CI = & get_instance();


$lang_avail = $CI->config->item('lang_avail');


	foreach($lang_avail AS $langcode=>$language){ 
		

		if($langcode != $lang_selected){
		
			echo " <a class=\"util\" href=\"/{$langcode}/" . ${'url_' . $langcode} . "\">" . ucwords($language) . "</a>";
			
		
		}
		
	}
	
	
?>
	