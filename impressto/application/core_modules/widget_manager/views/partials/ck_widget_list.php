<?php
/*
@Name: Widget List Partial
@Type: PHP
@Filename: widget_list.php
@Lang: 
@Description: Simple shows a list of all the site widgets
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Status: complete
@Date: 2012-06-18
*/
?>

<div id="<?=$ckeditor_name?>_widget_list_div" style="background:#EAEAEA; width:400px; height:350px; overflow:auto">

<input type="hidden" id="<?=$ckeditor_name?>_selected_widget" value="" />

<table id="<?=$ckeditor_name?>_widget_list_table" class="table table-striped">
<?php


	
foreach($active_widgets as $widgetitem){

	
	$label = "";
	$widget_shortcode = "[widget type='";
	
	$configdata = $this->widget_utils->load_widget_config($widgetitem['widget'],$widgetitem['module']);

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
	<td class="widget_list_item_td" id="<?=$ckeditor_name?>_widget_selector_item_<?=$widgetitem['id']?>" onclick="assign_widget('<?=$ckeditor_name?>','<?=$widgetitem['id']?>','<?=$slug?>')">
	
	
			<span><strong><?=$label?></strong></span>
	
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

