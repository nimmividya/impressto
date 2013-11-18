<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Contact Form Manager
@Type: PHP
@Filename: manager.php
@Description: Form field management interface
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

						
<form id="field_editor_form" method="post">
<input type="hidden" id="field_id" name="field_id" value="<?=$field_id?>" />
		

<div class="buttonbar clearfix">

	<div style="float:left">
	<h4><?php
	
	if($field_id == "") echo " Add New Field";
	else echo "Edit Field";
	
	?></h4>
	</div>
	
	<div style="float:right">
	<button type="button" class="btn" onclick="userfield_manager.cancel_field_edit()" id="btn_add_new">Cancel</button>
	<button type="button" class="btn btn-success" onclick="userfield_manager.save_field()" id="btn_add_new"><i class="icon-white icon-ok"></i> Save</button>
	</div>
</div>
	
	<div class="clearfix"></div>
		
		
	
	<div class="error_box errorbox cornered" style="display: none;"></div>
	
	
	<div style="float:left">
	<label for="field_name">Field Name</label>
	<input style="width:196px" type="text" id="field_name" name="field_name" value="<?=$field_name?>" />
	</div>
	
	<div style="float:left; margin-left:20px;">
	<label for="field_label">Field Label</label>
	<input style="width:196px" type="text" id="field_label" name="field_label" value="<?=$field_label?>" />
	</div>
	
	<div class="clearfix"></div>
	
	<div style="float:left;">
	<label for="paragraph">Paragraph</label>
	<textarea style="width:720px; height:100px" id="paragraph" name="paragraph"><?=$paragraph?></textarea>
	</div>
	
	<div class="clearfix"></div>
	

	<div style="float:left">
	<label class="checkbox">
		<input type="checkbox" id="field_active" name="active" value="1" <?=$active_check?> />
		Active
	</label>
	</div>
	
	
	<div style="float:left; margin-left:20px;">
	<label class="checkbox">
		<input type="checkbox" id="field_visible" name="visible" value="1" <?=$visible_check?> />
		Visible
	</label>
	</div>
	
	<div style="float:left; margin-left:20px;">
	<label class="checkbox">
		<input type="checkbox" id="field_showlabel" name="showlabel" value="1" <?=$showlabel_check?> />
		Show Label
	</label>
	</div>

	
	<div style="float:left; margin-left:20px;">
	<label class="checkbox">
		<input type="checkbox" id="field_disabled" name="disabled" value="1" <?=$disabled_check?> />
		Disabled
	</label>
	</div>
	
	<div style="float:left; margin-left:20px;">
	<label class="checkbox">
		<input type="checkbox" id="field_required" name="required" value="1" <?=$required_check?> />
		Required
	</label>
	</div>

	
	
	<div class="clearfix"></div>
	
	
	<div style="float:left;">
	<label for="ftype">Field Type</label>
		<?=$ftype_selector?>
	</div>

	
	<div class="clearfix"></div>

	<div style="float:left;<?=$fedit_orientation_display?>" id="fedit_orientation">
	<label for="field_orientation">Orientation</label>
	<?=$orientation_selector?>
	</div>
	

	<div class="clearfix"></div>
	
	<div style="float:left; margin-right:20px;<?=$fedit_width_display?>" id="fedit_width">
	<label for="field_width"><span id="field_width_label">Width</span>: <span id="field_width_display"><?=$width?></span></label>
	<input style="width:40px;" type="hidden" id="field_width" name="field_width" value="<?=$width?>" />

	<div style="float:left; width:200px" id="width_slider"></div>
	<script>  userfield_manager.init_width_slider('<?=$width?>'); </script>
	
	</div>
	
	<div style="float:left;<?=$fedit_height_display?>" id="fedit_height">
	<label for="field_height"><span id="field_height_label">Height</span>: <span id="field_height_display"><?=$height?></span></label>
	<input style="width:40px;" type="hidden" id="field_height" name="field_height" value="<?=$height?>" />
	
	<div style="float:left; width:200px" id="height_slider"></div>
	<script>  userfield_manager.init_height_slider('<?=$height?>'); </script>
	
	</div>
	


	<div class="clearfix"></div>
	
	
	<div style="float:left;<?=$fedit_onchange_display?>" id="fedit_onchange">
	<label for="field_onchange">OnChange</label>
	<input style="width:426px;" type="text" id="field_onchange" name="field_onchange" value="<?=$onchange?>" />
	</div>
	
	

	<div class="clearfix"></div>


	<div style="float:left; margin-right:20px;<?=$fedit_field_value_display?>" id="fedit_field_value">
		<label for="field_value">Value</label>
		<input type="text" id="field_value" name="field_value" value="<?=$field_value?>" />
	</div>
	
	
	<div style="float:left;<?=$fedit_default_value_display?>" id="fedit_default_value">
		<label for="default_value">Default Value</label>
		<input type="text" id="default_value" name="default_value" value="<?=$default_value?>" />
	</div>
	
	<div class="clearfix"></div>
	
						
	<br>
	<span id="d_field"></span>
	


	
	
	<div id="field_options_div" style="width:440px; <?php if($field_options == "") echo " display:none; ";?>">
	<?=$field_options?>
	</div>
	
	
	<div class="clearfix"></div>
	
			
	</form>
				
				

	
						
						
		