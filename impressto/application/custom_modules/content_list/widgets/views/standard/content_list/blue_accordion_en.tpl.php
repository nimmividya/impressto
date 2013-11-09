<?php
/*
@Name: Blue Accordion
@Type: PHP
@Author: peterdrinnan
@Projectnum: 4660
@Version: 1.2
@Status: complete
@Date: 2012-02
*/
?>
<?php

$CI = & get_instance();

$CI->load->library('asset_loader');

$CI->asset_loader->add_header_css("default/custom_modules/content_list/css/blue.css");
$CI->asset_loader->add_header_js("default/custom_modules/content_list/js/blue.js");

?>

<ul>

<?php
		
foreach($contentlist_items AS $item){

?>
	<!-- <li><?=$item['title_en']?></li> -->

		
<?php } ?>	

</ul>


<div class="blueaccordion">
<?php 
		
foreach($contentlist_items AS $item){

?>
	<div class="accordionButton"><?=$item['title_en']?><span class="bluearrow_off"></span></div>
	<div class="accordionContent"><?=$item['content_en']?></div>
		
<?php } ?>	
</div>
