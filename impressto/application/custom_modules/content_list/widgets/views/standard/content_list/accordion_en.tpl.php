<?php
/*
@Name: Basic Accordion
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

//$this->asset_loader->add_header_css("");
//$this->asset_loader->add_header_js("");


?>

<div class="accordion" id="accordion2">
		
<?php 

//print_r($contentlist_items);

foreach($contentlist_items AS $item){

?>

	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2">
			<?=$item['title_en']?>
			</a>
		</div>
		<div id="collapseOne2" class="accordion-body collapse">
			<div class="accordion-inner">
				<?=$item['content_en']?>
			</div>
		</div>
	</div>
	
<?php } ?>
		
</div>

