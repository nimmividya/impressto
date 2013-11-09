<?php
/*
@Name: Manager
@Type: PHP
@Filename: manager.php
@Description: 
@Author: Galbraith Desmond
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/08/29
*/
?>


<?php echo $infobar; ?>

<h2>bread_crumbs</h2>


<div style="clear:both"></div>


<form id="bread_crumbs_management_form">


<div style="float:left;"><?=$template_selector?></div>

<div style="float:left; margin-left:10px; margin-top:20px;">
	<button id="bread_crumbs_save_button" class="btn btn-success" type="button" onClick="ps_bread_crumbs_manager.save_settings()"><i class="icon-white icon-ok"></i> Save Settings</button>
</div>



<div style="clear:both"></div>


</form>