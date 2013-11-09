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
@Date: 2012/09/04
*/
?>


<?php echo $infobar; ?>

<h2>language_toggle</h2>


<div style="clear:both"></div>


<form id="language_toggle_management_form">


<div style="float:left;"><?=$template_selector?></div>

<div style="float:left; margin-left:10px; margin-top:20px;">
	<button id="language_toggle_save_button" class="btn btn-success" type="button" onClick="ps_language_toggle_manager.save_settings()"><i class="icon-white icon-ok"></i> Save Settings</button>
</div>

<div style="clear:both"></div>

<h4>Here are your short codes</h4>

<div style="width:100px">PHP: </div><input type="text" style="width:400px" value="Widget::run('language_toggle/language_toggle');" /><br />
<div style="width:100px">Smarty: </div><input type="text" style="width:400px" value="{widget type='language_toggle/language_toggle'}" /><br />
<div style="width:100px">Inline: </div><input type="text" style="width:400px" value="[widget type='language_toggle/language_toggle']" /><br />




<div style="clear:both"></div>


</form>