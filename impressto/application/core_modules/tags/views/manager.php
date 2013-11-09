<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

<h2>Tags</h2>

<?php

// this is for the jquery UI 1.9 tabs bug
$request_uri = getenv("REQUEST_URI");

?>

<div id="crudTabs" style="display: none;">

	<ul>
		<li><a href="<?=$request_uri?>#widget_list">Widgets</a></li>
		<li><a href="<?=$request_uri?>#tag_settings">Setting</a></li>
	</ul>
	

	<div id="widget_list">
	
		<div style="clear:both"></div>

		<div id="new_tagcloud_widget_button_div" style="float:right; margin:24px 0 30px;">
			<button id="new_tagcloud_widget_button" class="btn btn-info" type="button" onClick="ps_tags_manager.show_tag_cloud_form()"><i class="icon-white icon-star"></i> New Tag Cloud Widget</button>
		</div>

		<div id="tag_cloud_builder_div" style="float:left; display:none">

			<form id="tag_cloud_widget_form">
			<input type="hidden" id="tag_cloud_widget_id" name="tag_cloud_widget_id" value="" />
					
			<div class="control-group" style="float:left; width:170px;">
				<label class="control-label" for="tag_cloud_name">Name</label>
				<input type="text" id="tag_cloud_name" name="tag_cloud_name" style="width:170px" />
			</div>
			
			<div class="control-group" style="float:left; margin-left: 10px; width:180px;">
				<label class="control-label" for="tag_content_module">Content Type</label>
				<?=$tag_cloud_content_module_selector?>
			</div>
			
			<div class="control-group" style="float:left; margin-left: 10px; width:220px;">
				<label class="control-label" for="tag_cloud_template">Template</label>
				<?=$tag_cloud_template_selector?>
			</div>

			<div style="float:left; margin: 24px 5px 30px 30px;"><button id="tagcloud_save_button" class="btn btn-success" type="button" onClick="ps_tags_manager.save_widget()"><i class="icon-white icon-ok"></i> Save</button></div>
			<div style="float:left; margin: 24px 0 30px"><button id="tagcloud_save_button" class="btn" type="button" onClick="ps_tags_manager.cancel_widget()"><i class="icon icon-remove"></i> Cancel</button></div>

			</form>

			<div class="clearfix"></div>
		</div>

		<div class="clearfix"></div>

		<div style="margin-top:10px;"id="cloud_widget_list_div"><?=$cloud_widget_list?></div>


	</div>
	
	
	
	<div id="tag_settings">
	
		<br />

		<form id="tags_management_form" style="float:left">

			
		<div class="formSep">
		<h4>General Settings</h4>

		<div style="float:left;"><?=$tag_list_template_selector?></div>

	
		
		<div class="clearfix"></div>
		
		</div>
			
	
		<div class="formSep">
		<h4>Tag Cloud Target Pages</h4>

	
		
		<?php
		
		foreach($content_module_page_selectors AS $content_module => $selector){

			$cm_label = ucwords(str_replace("_"," ",str_replace("admin_","",$content_module)));
	
			?>
		
			<label for="<?=$content_module?>_target"><?=$cm_label?></label><?=$selector?>
			<div class="clearfix"></div>
					
			
		<?php } ?>
		</div>

		<div style="float:left; margin:22px 10px 0 10px">
			<button id="tags_save_button" class="btn btn-success" type="button" onClick="ps_tags_manager.save_settings()"><i class="icon-white icon-ok"></i> Save Settings</button>
		</div>
		

		</form>

		<div style="clear:both"></div>

	
	</div>
	
</div>


