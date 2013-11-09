<!--
@Name: Dark Comments
@Type: PHP
@Filename: standard.php
@Projectnum: 1001
@Author: peterdrinnan
@Status: development
@Date: 2012-12-06
-->
<?php

$CI = &get_instance();

	$CI->load->library('asset_loader');
	
	// skin1 = rounded borders, skin2 = simple white, skin3 = dark
	$CI->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/custom_modules/commento/css/skin3.css");
	$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/commento/js/commento.js");	
				

?>


<?php 

if($initial_hidden == 1){ ?>




<div id="commento_container">

	<div id="comments_header">

	<a class="show_commentos_link" href="javascript:commento.show_comments()"><?=lang('SHOW_COMMENTS')?></a>
	<a style="display:none" class="hide_commentos_link" href="javascript:commento.hide_comments()"><?=lang('HIDE_COMMENTS')?></a>
	</div>

	<div id="commento_wrapper" style="display:none">

	<?=$comments?>
	
	</div>
</div>

<?php }else{ ?>



	
<div id="commento_container" >

	<div id="comments_header"><a class="show_commentos_link" ><?=lang('comments_label')?></a></div>

	<?=$comments?>
</div>


<?php } ?>

		