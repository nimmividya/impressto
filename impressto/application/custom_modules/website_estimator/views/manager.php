<?php
/*
@Name: Manager
@Type: PHP
@Filename: manager.php
@Description: 
@Author: Acart
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/12/05
*/
?>


<?php echo $infobar; ?>

<h2>website_estimator</h2>


<div style="clear:both"></div>


<form id="website_estimator_management_form">


<div style="float:left;"><?=$template_selector?></div>

<div style="float:left; margin-left:10px; margin-top:20px;">
	<button id="website_estimator_save_button" class="btn btn-success" type="button" onClick="ps_website_estimator_manager.save_settings()"><i class="icon-white icon-ok"></i> Save Settings</button>
</div>



<div style="clear:both"></div>


</form>