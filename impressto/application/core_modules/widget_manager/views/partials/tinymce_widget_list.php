<?php
/*
@Name: Widget List Partial
@Type: PHP
@Filename: widget_list.php
@Lang: 
@Description: Simple shows a list of all the site widgets
@Author: peterdrinnan
@Projectnum: 1001
@Status: complete
@Date: 2012-06-18
*/

$this->load->library('asset_loader');

$this->asset_loader->add_header_css("core/css/reset.css","","all");
			
$this->asset_loader->add_header_css("third_party/bootstrap/css/bootstrap.css","","all");
$this->asset_loader->add_header_css("third_party/bootstrap/css/bootstrap-responsive.min.css","","all");

$this->asset_loader->add_header_js_top("third_party/jquery/jquery-" . $this->config->item('jquery_version') . ".js");	
		


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Widget Selector</title>

	
	<?php
	
	echo $this->asset_loader->output_header_css();
	
	echo $this->asset_loader->output_header_js();
		
	?>
	
	<style>
	
	.widget_item_selector_active{
		background-color:#F9F579 !important;
	}
	
	.mod_icon{
		width:32px;
		height: 32px;
		float:left;
		margin-right:10px;
	}

	
	</style>

	<script type="text/javascript" src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/tiny_mce/tiny_mce_popup.js"></script>
	<script type="text/javascript" src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/tiny_mce/plugins/widgets/js/dialog.js"></script>
	
</head>
<body>

<form onsubmit="WidgetsDialog.insert();return false;" action="#">



<div id="widget_list_div" style="background:#EAEAEA; width:400px; height:350px; overflow:auto">

<input type="hidden" id="selected_widget" name="selected_widget" value="" />

<table id="widget_list_table" class="table table-striped">
<?php


	
foreach($active_widgets as $widgetitem){

	
	$label = "";
	
	$widget_shortcode = "[widget type='";
	
	$configdata = $this->widget_utils->load_widget_config($widgetitem['widget'],$widgetitem['module']);

	
	$mod_icon = "";
	
	if($configdata['module_type'] == "widget"){
	
		$mod_icon_path = ASSET_ROOT . PROJECTNAME . "/default/widgets/{$widgetitem['widget']}/img/widget_icon.png";
		
		if(file_exists($mod_icon_path)){
		
			$mod_icon = ASSETURL . PROJECTNAME . "/default/widgets/{$widgetitem['widget']}/img/widget_icon.png";
		}
	
	}else{
	
		$mod_icon_path = ASSET_ROOT . PROJECTNAME . "/default/{$configdata['module_type']}_modules/{$widgetitem['module']}/img/mod_icon.png";
		
		if(file_exists($mod_icon_path)){
		
			$mod_icon = ASSETURL . PROJECTNAME . "/default/{$configdata['module_type']}_modules/{$widgetitem['module']}/img/mod_icon.png";
		
		}else{
	
			// legacy path
			$mod_icon_path = ASSET_ROOT . PROJECTNAME . "/default/{$configdata['module_type']}_modules/{$widgetitem['module']}/images/mod_icon.png";
		
			if(file_exists($mod_icon_path)){
		
				$mod_icon = ASSETURL . PROJECTNAME . "/default/{$configdata['module_type']}_modules/{$widgetitem['module']}/images/mod_icon.png";
			
			}
		}	
	}

	
	//echo $mod_icon_path;
	
	
	if($mod_icon != "") $mod_icon = "<img class=\"mod_icon\" src=\"{$mod_icon}\" />";
	
	
	if(isset($widgetitem['instance']) && $widgetitem['instance'] != ""){ 
		$label = $widgetitem['instance'];
	}
	
	if($widgetitem['module'] == $widgetitem['widget']){
	
		if($label != "") $label .= "<br />";
		$label .= $widgetitem['module'];
		
	}else if($widgetitem['module'] != ""){
	
		if($label != "") $label .= "<br />";
		$label .= $widgetitem['module'] . " >> " . $widgetitem['widget'];
		
	}else{
		if($label != "") $label .= "<br />";
		$label .= $widgetitem['widget'];
	}


	

	$slug = "[";
	
	if($widgetitem['slug'] == ""){
	
		$slug = "[widget type=\'";
	
		if($widgetitem['module'] == ""){ // this is an adhoc widget
			$slug .= $widgetitem['widget'];
		}else if($widgetitem['module'] == $widgetitem['widget']){
			$slug .= $widgetitem['module'];
		}else{
			$slug .= $widgetitem['module'] . "/" . $widgetitem['widget'];
		}
				
		$slug  .= "\'";
		
		if($widgetitem['instance'] != ""){
			$slug .= " name=\'" . $widgetitem['instance'] . "\'";
		}
	
	}else{
		$slug  .= $widgetitem['slug'];
	}
	
	$slug  .= "]";

	?>
	
	<tr>
	<td class="widget_list_item_td" id="widget_selector_item_<?=$widgetitem['id']?>" onclick="assign_widget('','<?=$widgetitem['id']?>','<?=$slug?>')">
	
	
			<span><strong><?=$mod_icon?><?=$label?></strong></span>
	
			<?php
		
			if(isset($configdata['description'])){ ?>
		
				<br /><span><?=$configdata['description']?></span>
		
			<?php } ?>
		
	</td>
	</tr>
		
	<?php
		
}
?>

</table>

</div>

	<div class="mceActionPanel">
		<input type="button" id="insert" name="insert" value="{#insert}" onclick="WidgetsDialog.insert();" />
		<input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
	</div>
	

</form>

</body>
</html>


