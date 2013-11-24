<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Style Sheet Manager
@Type: PHP
@Filename: manager.php
@Description: manage style sheets without having to go to your freaking hard drive eh! 
@Author: Some Impressto Dude (who takes no blame here)
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-08-15
*/
?>

<div class="admin-box">

<h3>Stylesheet Manager</h3>
<?=$infobar?>

<div class="alert" style="min-height:100px;">

<img style="float:left; margin-right:10px;" src="<?php echo ASSETURL; ?>/<?php echo PROJECTNAME; ?>/default/core/images/old_coder.png" />


<i style="font-size:20px; color:#666666" class="icon-warning-sign"></i> IMPORTANT NOTE FOR DEVELOPERS

<br />
<br />


If this site is under version control and you are not currently working on your development server copy, any changes made here to 
CSS files that are not copied back to the developement server copy will likely be lost on the next developer commit. 
</div>




<div class="footNav clearfix" style="padding: 5px 0 5px 7px;">
	<div style="float:left"><?php echo $module_selector; ?></div>
	<div style="float:left; margin-left:20px" id="css_selector_div"></div>
	<button class="btn btn-success" type="button" id="savecss_button" style="display:none; float:left; margin: 24px 0 0 20px;" onClick="ps_stylesheetmanager.savecss()"><i class="icon-ok"></i> Save</button>
	<div style="float:right;margin: 24px 20px 0 0;"><input type="text" style="width:100px;" class="color-picker" id="colorpicker" /></div>
</div>

<div class="clearfix"></div>

<code id="css_file_data">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code>


<textarea id="css_edit_area" class="lined" rows="30" style="width: 90%; outline: none !important;"></textarea>

</div>
