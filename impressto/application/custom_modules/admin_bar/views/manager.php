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
@Date: 2012/09/20
*/
?>


<?php echo $infobar; ?>

<h2>admin_bar</h2>


<div style="clear:both"></div>


<form id="admin_bar_management_form">


<div style="float:left;"><?=$template_selector?></div>

<div style="float:left; margin-left:10px; margin-top:20px;">
	<button id="admin_bar_save_button" class="btn btn-success" type="button" onClick="ps_admin_bar_manager.save_settings()"><i class="icon-white icon-ok"></i> Save Settings</button>
</div>



<div style="clear:both"></div>


</form>