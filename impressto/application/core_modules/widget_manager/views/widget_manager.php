<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Widget Manager
@Type: PHP
@Filename: widget_manager.php
@Description: manage widgets and assign them to collections and zones
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-08-15
*/
?>

<div class="admin-box">
<h3><i class="icon-th"></i> Widget Collections</h3>

<?php echo $infobar; ?>



<div class="widgetSelection clearfix">
<!-- Select a Widget Combobox -->
<div style="float:left">
<select style="width:250px"; id="wm_collection_selector" onchange="ps_widget_manager.selectcollection(this);">
<option value="">Select a Widget Collection</option>
<?php 
foreach($widget_collection_options as $key=>$val){
	echo "<option value=\"{$val}\">{$key}</option>\n";
}
?>
</select>
</div>

<!-- New Widget Collection Button & Fields -->
<div style="float:right; margin-right:10px;">
<button class="btn btn-default" type="button" id="shownewwidgetcollectionfield_btn" onclick="ps_widget_manager.show_newcollectiondiv()">
<i class="icon-star icon-white"></i> New Widget Collection
</button>

<div id="newcollectiondiv" style="width:400px; display:none">
<input type="text" id="new_widget_collection_field" />

<button class="btn btn-default" type="button" onclick="ps_widget_manager.savecollection()">Save</button>
<button onclick="ps_widget_manager.cancelcollection()" class="btn">Cancel</button>
</div>
</div>
</div>

<hr />

<div style="display:visible" id="new_widget_selector_div">
<button style="display:none" class="btn btn-default" type="button" id="widget_add_button" onclick="ps_widget_manager.assign_new_widget()">Add Widget</button>
</div>

<div class="clearfix"></div>

<div id="widgetcollections_div" style="display:none;">

<div style="width:740px">

<div style="float:right; margin-right:25px;">

<button class="btn btn-default" type="button" id="shownewzonefield_btn" onclick="ps_widget_manager.shownewzonefield()">
<i class="icon-star icon-white"></i> New Zone
</button>

<button id="deletecurrentcollection_btn" class="btn btn-danger" type="button" onclick="ps_widget_manager.deletecurrentcollection()">
Delete this collection <i class="icon-trash icon-white"></i>
</button>

</div>

<div id="new_widget_zone_div" style="margin-left:20px; display:none">
<input style="width:80px;" type="text" id="new_widget_zone_field" />
<input type="text" style="width:45px;" id="colorpicker" />

<button class="btn btn-default" type="button" onclick="ps_widget_manager.savezone()">Save</button>
<button onclick="ps_widget_manager.cancelzone()" class="btn">Cancel</button>
</div>


<div class="clearfix"></div>


<h2 style="float:left" id="collection_title"></h2>



<div style="float:right; margin-right:8px; margin-top:0px;">




</div>


</div>

<div class="clearfix"></div>

<div id="widgetCollections" style="float:left; width:740px;">
<!-- Available Widgets -->
<div id="available-widgets" class="available_widgets">
<h3>Current Widgets</h3>
<?php

foreach($active_widgets as $widgetitem){
	
	$label = "";
	$widget_shortcode = "[widget type='";
	
	$configdata = $this->widget_utils->load_widget_config($widgetitem['widget'],$widgetitem['module']);
	
	
	if($widgetitem['module'] == $widgetitem['widget']){
		$label = $widgetitem['module'];
	}else{
		$label = $widgetitem['module'] . " >> " . $widgetitem['widget'];
	}
	
	if($widgetitem['module'] == ""){ // this is an adhoc widget
		$widget_shortcode .= $widgetitem['widget'];
		
	}else{
		$widget_shortcode .= $widgetitem['module'] . "/" . $widgetitem['widget'];
	}
	
	if($widgetitem['instance'] != ""){
		$label .= " >> " . $widgetitem['instance'];
		$widget_shortcode .= "' name='" . $widgetitem['instance'] . "";
	}
	
	
	
	$widget_shortcode .= "']";
	
	
	$widget_slug  = "[";
	
	$widget_slug .= $widgetitem['slug'];
	
	$widget_slug .= "]";
	
	
	
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

	
	if($mod_icon != "") $mod_icon = "<img class=\"mod_icon\" src=\"{$mod_icon}\" />";
	//else $mod_icon = $mod_icon_path;
	
	
	
	echo "<div class=\"droppablewidgets\" id=\"droppablewidget_" . $widgetitem['id'] . "\" >";
	
	echo "<div class=\"clearfix\" style=\"padding: 4px; color:#333333; font-weight:bold\">".$mod_icon . $label;
	
	
	if(isset($configdata['description'])){ ?>
		
		<span style="float:right"><a class="widget_description" rel="tooltip" title="<?=$configdata['description']?>"><i class="icon-exclamation-sign"></i></a></span>
		
		<?php } ?>
	
	
	
	</div>
	
	<div style="display:none" id="slug_alert_<?=$widgetitem['id']?>" class="alert">Slug in use by another widget</div>
	
	
	<button style="float:left" id="shortcode_<?=$widgetitem['id']?>_btn" onclick="ps_widget_manager.show_widgetshortcode(this,'<?=$widgetitem['id']?>')" type="button" class="btn btn-small">Shortcode <i class="icon-cog"></i></button>
	<input READONLY style="width:290px; display:none" id="shortcode_<?=$widgetitem['id']?>" value="<?=$widget_shortcode?>" />
	
	<button style="float:left; margin-left:10px" id="slug_<?=$widgetitem['id']?>_btn" onclick="ps_widget_manager.show_widget_slug(this,'<?=$widgetitem['id']?>')" type="button" class="btn btn-small">Slug <i class="icon-cog"></i></button>
	<div class="clearfix"></div>
	<div id="widget_slug_code_<?=$widgetitem['id']?>" style="display:none">
	<input style="width:150px;" id="slug_<?=$widgetitem['id']?>" value="<?=$widget_slug?>" />
	<button id="save_slug_<?=$widgetitem['id']?>_btn" onclick="ps_widget_manager.save_slug('<?=$widgetitem['id']?>')" type="button" class="btn btn-small">Save <i class="icon-ok-circle"></i></button>
	<button id="save_slug_<?=$widgetitem['id']?>_btn" onclick="ps_widget_manager.cancel_slug('<?=$widgetitem['id']?>')" type="button" class="btn btn-small">Cancel <i class="icon-remove-circle"></i></button>
	</div>
	
	<div class="clearfix"></div>
	
	
	</div>
	
	<?php
	
	
}
?>
</div><!-- [END] . -->

<!-- Widget Areas -->
<div id="widget-areas" class="widget_zones">
<h3>Widget Zones</h3>
<div id="widget_list_div"></div>
</div><!-- [END] . -->
</div><!-- [END] .widgetCollections -->
</div><!-- [END] #widgetcollections_div -->



<div style="display:none; text-align:left" id="placement_options_dialog" title="Widget Options"></div>

</div>

