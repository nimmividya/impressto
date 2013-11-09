
<script>

	ps_bgposmanager.asset_url = '<?php echo ASSETURL; ?>';

</script>



<h2>Background Slideshow Shifter</h2>

<div style="float:left"><?php echo $widget_selector; ?></div>
<button class="btn btn-default" style="float:right" type="button"  onclick="ps_bgposmanager.shownewidgetnameinput()"><i class="icon-asterisk"></i> New Slider</button>

<div style="clear:both"></div>
<div id="newidgetnameinput_div" style="display:none">
<form id="" action="/bg_pos_slider/createnewwidget" method="post">
<label for="new_widget_name">New Widget Name:</label>
<input type="text" id="new_widget_name" name="new_widget_name" value="" style="width:200px" maxlength="50">
<input class="btn btn-default" type="button" Value="Cancel" onclick="ps_bgposmanager.cancelnewidgetname()">
<input class="btn btn-default" type="submit" Value="Continue &raquo;&raquo;">
</form>
</div>



<div id="bgp_edit_form_div" style="display:none">

	<form id="bgp_edit_form" style="margin: 15px 0;">

		<input type="hidden" name="edit_id" id="edit_id" value="" />
		<input type="hidden" name="widget_name" id="widget_name" value="<?php echo $widget_name; ?>" />
		<input type="hidden" id="background_image_url" name="background_image_url" value="" />
	   
	   
	   <table cellspacing="0" cellpadding="0">
		    <tr>
				<td>
					<textarea style="width:200px; height:300px;" id="s_content" name="s_content" style=""></textarea>
				</td>
				<td valign="top">
					<div style="float: left;margin: 0 10px;width: 380px;margin: 0 10px;">
					
						<img id="loading" src="./images/loading.gif" style="display:none;">
					
						<label for="s_title" style="margin: 0 0 5px 0;display: block;font-size: 14px;">Title</label>
						<input type="text" style="border: 1px solid #2BA8CD;padding: 3px 2px;width: 372px;" id="s_title" name="s_title" value="" />
						
						
						<label for="s_link" style="margin: 0 0 5px 0;display: block;font-size: 14px;">Link</label>
						<input type="text" style="border: 1px solid #2BA8CD;padding: 3px 2px;width: 372px;" id="s_link" name="s_link" value="" />
						
						<input type="hidden" id="s_leftpos" name="s_leftpos" value="" />
						
						
						<div style="clear:both; height:20px;"></div>
						<div style="background: #BCD0D6;">
						<form name="background_image_form" id="background_filetoupload_form" action="" method="POST" enctype="multipart/form-data">	
						<!-- <input type="hidden" name="widget_name" value="<?php echo $widget_name; ?>" /> -->
						
							<fieldset>
								<legend>Background Image Upload</legend>
							
								

								<table cellpadding="0" cellspacing="0" class="tableForm">
									<thead>
										<tr>
											<th>Please select a file and click Upload button</th>
										</tr>
									</thead>
									<tbody>	
										<tr>
											<td><input id="background_fileToUpload" type="file" size="25" name="background_fileToUpload" class="input"></td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td><button class="btn" id="buttonUpload" onclick="return ps_bgposmanager.backgroundAjaxFileUpload();">Upload</button></td>
										</tr>
									</tfoot>
								</table>
								
							</fieldset>
						</form>
						</div>
						
						<br />
						
						
						<div style="background: #BCD0D6;">
						<form name="image_form" action="" method="POST" enctype="multipart/form-data">	
							<fieldset>
								<legend>Image Upload</legend>
							
							

								<table cellpadding="0" cellspacing="0" class="tableForm">
									<thead>
										<tr>
											<th>Please select a file and click Upload button</th>
										</tr>
									</thead>
									<tbody>	
										<tr>
											<td><input id="fileToUpload" type="file" size="25" name="fileToUpload" class="input"></td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td><button class="btn" id="buttonUpload" onclick="return ps_bgposmanager.ajaxFileUpload();">Upload</button></td>
										</tr>
									</tfoot>
								</table>
									<div id="thumbnail_holder_div"></div>
							</fieldset>
						</form>
						</div>
						
						
						<div id="savebutton_div" style="display:none; margin: 10px 0;">
							<div style="float:right"><button type="button" class="btn btn-default" onclick="ps_bgposmanager.save_bgp_item()"><i class="icon-ok"></i> Save</button></div>
						</div>
						
					</div>
			   </td>
		   </tr>
	   </table>
	</form>
	   

	
</div><!-- [END] #bgp_edit_form_div -->
   


	
	<div id="image_cropping_div" style="display:none; margin: 10px 0;">
				<a style="cursor:pointer" id="popupContactClose">x</a>
		<h2>Image Cropper</h2>
		

			<div class="cropping_save_btn">
				<input type="hidden" id="x" name="x" />
				<input type="hidden" id="y" name="y" />
				<input type="hidden" id="w" name="w" />
				<input type="hidden" id="h" name="h" />
				<a href="javascript:savecrop_dimensions()" style="vertical-align: middle;margin: 5px 0;display: block;">
					<img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/custom_modules/bg_pos_slider/images/saving_crop.png" alt="Save Crop" width="16" height="16" style="vertical-align: middle;margin: 0 5px 0 0;"/>
					Save Cropping
				</a>
			</div>
			<img src="" id="crop_box" name="crop_box" alt="crop image" />
	</div>
		
		
		

	<div id="backgroundPopup"></div>
	
	<?php if($widget_id != ""){ ?>
	
	<br />
	<div style="padding:5px; background:#FAFAFA">
	
	<form id="widget_options">
	<input type="hidden" name="widget_id" id="widget_id" value="<?=$widget_id?>" />
	
	
	<label for="widget_prev_page_selector">Previous Page</label>
	<?php 

	$data = array(
	"language" =>"en",
	'name'        => "widget_prev_page_selector",
	'type'          => 'select',
	'showlabels'          => false,
	'id'          => "widget_prev_page_selector",
	'width'          => 300,
	'label'          => "",
	'onchange' => "",
	'value'       => $prev_page
	
	);

	echo get_ps_page_slector($data); 

	?>

	<label for="widget_next_page_selector">Next Page</label>
	<?php 
	
	$data = array(
	"language" =>"en",
	'name'        => "widget_next_page_selector",
	'type'          => 'select',
	'showlabels'          => false,
	'id'          => "widget_next_page_selector",
	'width'          => 300,
	'label'          => "",
	'onchange' => "",
	'value'       => $next_page
	);
	
	echo get_ps_page_slector($data); 
	
	?>
	
	<div style="clear:both"></div>
	<br />
	<button type="button" onclick="ps_bgposmanager.save_widet_settings()" style="float:left" class="btn btn-default"><i class="icon-ok"></i> Save Settings</button>
	

	
	
	</form>
	
	<div style="clear:both"></div>
	
	</div>
	
	<?php } ?>
	
 <hr/>
 
 <h3>List of Content</h3><br/>
 
 	<form id="slideshow" name="slideshow" method="post" action="index.php?a=upd">
	<div id="content_list_div">
		<?php echo $datarows; ?>
	</div> <!-- end content list div -->
</form>


