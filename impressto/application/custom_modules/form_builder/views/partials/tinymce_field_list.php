<?php
/*
@Name: Field List Partial
@Type: PHP
@Filename: tinymce_field_list.php
@Lang: 
@Description: Simple shows a list of all the form buildr fields
@Author: peterdrinnan
@Projectnum: 1001
@Status: complete
@Date: 2012-06-18
*/

$this->load->library('asset_loader');

$this->asset_loader->add_header_css("core/css/reset.css","","all");
			
$this->asset_loader->add_header_css("vendor/bootstrap/css/bootstrap.css","","all");
$this->asset_loader->add_header_css("vendor/bootstrap/css/bootstrap-responsive.min.css","","all");

$this->asset_loader->add_header_js_top("vendor/jquery/jquery-" . $this->config->item('jquery_version') . ".js");	
		

$modasseturl = ASSETURL . PROJECTNAME . "/default/custom_modules/form_builder/";


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Form Builder Fields</title>

	
	<?php
	
	echo $this->asset_loader->output_header_css();
	
	echo $this->asset_loader->output_header_js();
		
	?>
	
	<style>
	
	.fbldfield_item_selector_active{
		background-color:#F9F579 !important;
	}
	
	.field_icon{
		width:16px;
		height: 16px;
		float:left;
		margin-right:10px;
	}

	
	</style>

	<script type="text/javascript" src="<?php echo ASSETURL; ?>vendor/tiny_mce/tiny_mce_popup.js"></script>
	<script type="text/javascript" src="<?php echo ASSETURL; ?>vendor/tiny_mce/plugins/fbldfield/js/dialog.js"></script>
	
</head>
<body>

<form onsubmit="WidgetsDialog.insert();return false;" action="#">



<div id="fbldfield_list_div" style="background:#EAEAEA; width:400px; height:350px; overflow:auto">

<input type="hidden" id="selected_fbldfield" name="selected_fbldfield" value="" />

<table id="fbldfield_list_table" class="table table-striped">

	<tr>
	<td class="fbls_field_list_item_td" id="fbldfield_selector_item_001" onclick="assign_fbldfield('001','[fbld_full_field_list]')">
	
			<span><strong>All Fields</strong></span>
	
			<br /><span>[fbld_full_field_list]</span>
		
	</td>
	</tr>
	
	
	<tr>
	<td class="fbls_field_list_item_td" id="fbldfield_selector_item_002" onclick="assign_fbldfield('002','[fbld_submit]')">
	
			<span><strong>Submit Button</strong></span>
	
			<br /><span>[fbld_submit]</span>
		
	</td>
	</tr>
	
	
	
<?php


	
foreach($active_fields as $field){

	
	$label = $field['field_label'];
	
	$shortcode = "[fbldfield='";

	$shortcode  .= $field['field_name'];

	$shortcode  .= "']";
	
	$field_icon = "<img class=\"field_icon\" src=\"{$modasseturl}/images/{$field['ftype']}.png\" />";
		
	?>
	
	<tr>
	<td class="fbls_field_list_item_td" id="fbldfield_selector_item_<?=$field['field_id']?>" onclick="assign_fbldfield('<?=$field['field_id']?>','<?php echo addslashes($shortcode); ?>')">
	
			<span><strong><?=$field_icon?>&nbsp;<?=$label?></strong></span>
	
			<br /><span><?=$shortcode?></span>
		

		
	</td>
	</tr>
		
	<?php
		
}
?>

</table>

</div>

	<div class="mceActionPanel">
		<input type="button" id="insert" name="insert" value="{#insert}" onclick="FBLDFieldDialog.insert();" />
		<input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
	</div>
	

</form>

</body>
</html>


