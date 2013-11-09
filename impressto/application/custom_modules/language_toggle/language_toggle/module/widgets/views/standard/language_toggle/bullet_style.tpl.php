<!--
@Name: Bullet Style toggle
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
		
			$lang_display = $CI->lang->line($language);
				
			echo "<li><a href=\"/{$langcode}/" . ${'url_' . $langcode} . "\">" . ucwords($lang_display) . "</a></li>";
			
		
		}
		
	}
	
	
?>
	