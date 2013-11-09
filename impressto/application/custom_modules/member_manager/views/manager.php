<?php
/*
@Name: Manager
@Type: PHP
@Filename: manager.php
@Description: 
@Author: 
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2013/01/20
*/
?>


<?php echo $infobar; ?>

<h2>member_manager</h2>


<div style="clear:both"></div>


<form id="member_manager_management_form">


<div style="float:left;"><?=$template_selector?></div>

<div style="float:left; margin-left:10px; margin-top:20px;">
	<button id="member_manager_save_button" class="btn btn-success" type="button" onClick="ps_member_manager_manager.save_settings()"><i class="icon-white icon-ok"></i> Save Settings</button>
</div>



<div style="clear:both"></div>


</form>