<!--
@Name: Default Tag List
@Type: PHP
@Filename: tag_list
@Projectnum: 4660
@Author: peterdrinnan
@Status: complete
@Date: 2012-02
-->

<?php


foreach($tags AS $tag){

	echo " <a class=\"tag_label\" href=\"" . $target_page . "/?{$tag_key}=" . $tag . "\">{$tag}</a> ";
	

}


?>


