<?php
/*
@Name: Default
@Type: PHP
@Filename: default.tpl.php
@Projectnum: 101
@Author: peterdrinnan
@Status: complete
@Date: 2012-02
*/
?>


<?php Widget::run('content_blocks', array('name'=>'topnavbar')); ?>

<?php

if($api_key != "") echo Widget::run('dashboard/updater', array());


if($dashboard_content != ""){

	echo $dashboard_content;
	
}else{ ?>


	<img style="float:left;" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/themes/classic/images/leaf.png" />

	<div style="float:left; margin-left:20px;">
	
	<h3>Here are some resources you may find useful:</h3>



	</div>

<?php } ?>


