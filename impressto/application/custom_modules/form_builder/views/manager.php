<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Contact Form Manager
@Type: PHP
@Filename: manager.php
@Description: Form field management interface
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

<?php

$modasseturl = ASSETURL . PROJECTNAME . "/default/custom_modules/form_builder/";


?>

<div class="admin-box">

<h3>Form Builder</h3>

<?php echo $infobar; ?>
			
<?php

$request_uri = getenv("REQUEST_URI");

?>


<div style="height:50px;">
<button style="margin-top:5px;"  id="new_form_btn" class="btn btn-success" onclick="ps_formbuilder_manager.new_form_prompt()"><i class="icon-white icon-star"></i> New Form</button>



<div id="new_form_prompt_div" style="display:none">
<input type="text" id="new_form_name" name="new_form_name" placeholder="Form Name" />
<button class="btn" onclick="ps_formbuilder_manager.cancel_new_form_prompt()">Cancel</button>
<button class="btn btn-success" onclick="ps_formbuilder_manager.save_new_form()"><i class="icon-white icon-ok"></i> Save</button>
</div>

</div>


<div style="clear:both"></div>


<div id="form_list_div">

<?=$formlist?>

</div>

	
<br />
					
</div>
