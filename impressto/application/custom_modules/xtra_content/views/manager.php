<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Xtra Content Manager
@Type: PHP
@Filename: xtra_content_manager.php
@Description: Manage Xtra content fields
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: development
@Date: 2013-03-01
*/
?>

<?php

$modasseturl = ASSETURL . PROJECTNAME . "/default/custom_modules/xtra_content/";

?>

<div class="admin-box">

<h3>XTra Content Fields</h3>

<?php echo $infobar; ?>
			
<?php

$request_uri = getenv("REQUEST_URI");

?>










<div style="clear:both"></div>




<div style="float:left"><h4>Standard Fields</h4></div>
<div style="float:right">
	<button style="margin-top:5px;"  id="new_form_btn" class="btn btn-success" onclick="xtracontent.new_field_prompt('standard')"><i class="icon-white icon-plus"></i> New Field</button>
</div>
<div style="clear:both"></div>
<div id="standard_field_list_div">

<?=$standard_fieldlist?>

</div>

<div style="clear:both"></div>

<br />
<br />


<div style="float:left"><h4>Mobile Fields</h4></div>
<div style="float:right">
	<button style="margin-top:5px;"  id="new_form_btn" class="btn btn-success" onclick="xtracontent.new_field_prompt('mobile')"><i class="icon-white icon-plus"></i> New Field</button>
</div>
<div style="clear:both"></div>
<div id="mobile_field_list_div">

<?=$mobile_fieldlist?>

</div>

	
<br />
					
</div>



<div id="new_field_prompt_div" style="display:none">

<form id="new_field_form">

<input type="hidden" id="new_field_media" name="new_field_media" value="" />
<input type="text" id="new_field_name" name="new_field_name" placeholder="Field Name" />

<label for="field_type">Field Type</label>
<select name="field_type" id="field_type">
<option value="text">Text</option>
<option value="varchar_250">VarChar 250</option>
<option value="int">Integer</option>
</select>


<button type="button" class="btn simplemodal-close" onclick="xtracontent.cancel_add_field()">Cancel</button>
<button type="button" class="btn btn-success simplemodal-close" onclick="xtracontent.add_field()"><i class="icon-white icon-ok"></i> Save</button>
</form>
</div>


<div id="rename_field_prompt_div" style="display:none">

<form id="rename_field_form">

<input type="hidden" id="rename_field_media" name="rename_field_media" value="" />


<label for="old_rename_field_name">Old Field Name</label>
<input readonly type="text" name="old_rename_field_name" id="old_rename_field_name" value="" />

<br />
<label for="new_rename_field_name">New Field Name</label>
<input type="text" name="new_rename_field_name" id="new_rename_field_name" value="" />

<button type="button" class="btn simplemodal-close" onclick="xtracontent.cancel_rename_field()">Cancel</button>
<button type="button" class="btn btn-success simplemodal-close" onclick="xtracontent.rename_field()"><i class="icon-white icon-ok"></i> Save</button>
</form>
</div>

