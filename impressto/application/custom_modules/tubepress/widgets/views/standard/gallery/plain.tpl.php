<?php
/*
@Name: Plain and Simple Wrapper
@Type: PHP
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-02
*/
?>


<?php

// no need to register these because they are loaded by the third party tubepress plugin
//$CI =& get_instance(); 
//$CI->load->library('asset_loader');
//$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/vendor/tubepress_pro/static/js/tubepress.js");	
//$CI->asset_loader->add_header_css(ASSETURL . PROJECTNAME  . "/default/vendor/tubepress_pro/themes/default/style.css");	

?>

<?php if($debug_data){ ?>

<div style="text-align:left">
	<ul>
	
	<?php foreach($debug_data AS $key => $val){ ?>
	
		<li><?=$key?> = <?=$val?></li>
		
	<?php } ?>
	
	</ul>
</div>

<?php } ?>

<?=$widgetbody?>