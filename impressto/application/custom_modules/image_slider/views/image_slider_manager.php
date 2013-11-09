<style>

.odd {
   background: #FFFFFF;
}

.even {
   background: #dff0f5;
}

#bgs_datatable th{
	background-color:#30545E;
	color: #FFFFFF;
	font-weight: bold;
	height:20px;
	padding:5px;
}
#backgroundPopup{
	display:none;
	position:fixed;
	_position:absolute; /* hack for internet explorer 6*/
	height:100%;
	width:100%;
	top:0;
	left:0;
	background:#000000;
	border:1px solid #cecece;
	z-index:1;
}
#image_cropping_div{
	display:none;
	position:fixed;
	_position:absolute; /* hack for internet explorer 6*/
	background:#FFFFFF;
	border:2px solid #cecece;
	z-index:2;
	padding:12px;
	font-size:13px;
}
#image_cropping_div h1{
	text-align:left;
	color:#6FA5FD;
	font-size:22px;
	font-weight:700;
	border-bottom:1px dotted #D3D3D3;
	padding-bottom:2px;
	margin-bottom:20px;
}
#popupContactClose{
	font-size:14px;
	line-height:14px;
	right:6px;
	top:4px;
	position:absolute;
	color:#6fa5fd;
	font-weight:700;
	display:block;
}
#button{
	text-align:center;
	margin:100px;
}
</style>



<?php echo $infobar; ?>

<h2>Image Slider</h2>

<div style="float:left"><?php echo $widget_selector; ?></div>
<input id="new_widget_button" class="btn btn-default" style="float:right" type="button" Value="New Slider" onClick="imageslider_manager.shownewidgetnameinput()">
<div style="clear:both"></div>
<div id="newidgetnameinput_div" style="display:none">
	<form id="" action="/admin/image_slider/createnewwidget" method="post">
		<label for="new_widget_name">New Widget Name:</label>
		<input type="text" id="new_widget_name" name="new_widget_name" value="" style="width:200px" maxlength="50">

		<input class="btn btn-default" type="button" Value="Cancel" onClick="imageslider_manager.cancelnewidgetname()">
		<input class="btn btn-default" type="submit" Value="Continue &raquo;&raquo;">
	</form>
</div>

<div id="image_slide_form_div" style="display:none">

	<form id="image_slide_form" style="margin: 15px 0;" method="post" enctype="multipart/form-data">

	  <input type="hidden" name="s_edit_id" id="s_edit_id" value="" />
	  <input type="hidden" name="temp_image" id="temp_image" value="" />
	  <input type="hidden" name="form_widget_name" id="form_widget_name" value="" />
	  
	   <table cellspacing="0" cellpadding="0">
		    <tr>
				<td valign="top">
					<div style="float: left;">
					
					<form name="form" action="" method="POST" enctype="multipart/form-data">	
					<fieldset style="margin: 0 0 10px;">
							
					
					
						<div>
							<div style="float:left">
								<label for="slide_title_en" style="margin: 0 0 5px 0;display: block;font-size: 14px;">EN Title</label>
								<input type="text" style="border: 1px solid #2BA8CD;padding: 3px 2px;width: 200px;" id="slide_title_en" name="slide_title_en" value="" />
							</div>
							
							<div style="float:left; margin-left:20px;">
								<label for="slide_caption_en" style="margin: 0 0 5px 0;display: block;font-size: 14px;">EN Caption</label>
								<textarea style="border: 1px solid #2BA8CD; width: 400px; height:60px;" id="slide_caption_en" name="slide_caption_en"></textarea>
							</div>	
						</div>
						
						<div style="clear:both"></div>
						
						
						<div style="float:left;">
															
							<label for="slide_url_en" style="margin: 0 0 5px 0;display: block;font-size: 14px;">EN URL</label>
							<input type="text" style="border: 1px solid #2BA8CD;padding: 3px 2px;width: 600px;" id="slide_url_en" name="slide_url_en" value="" />
													
						</div>
						
						
						<div style="clear:both"></div>
							
						<div>
						
							<div style="float:left">
								<label for="slide_title_fr" style="margin: 0 0 5px 0;display: block;font-size: 14px;">FR Title</label>
								<input type="text" style="border: 1px solid #2BA8CD;padding: 3px 2px;width: 200px;" id="slide_title_fr" name="slide_title_fr" value="" />
							</div>

							<div style="float:left; margin-left:20px;">
								<label for="slide_caption_fr" style="margin: 0 0 5px 0;display: block;font-size: 14px;">FR Caption</label>
								<textarea style="border: 1px solid #2BA8CD; width: 400px; height:60px;" id="slide_caption_fr" name="slide_caption_fr"></textarea>
							</div>
						</div>
						
						<div style="clear:both"></div>
						
						
						<div style="float:left;">
															
							<label for="slide_url_fr" style="margin: 0 0 5px 0;display: block;font-size: 14px;">FR URL</label>
							<input type="text" style="border: 1px solid #2BA8CD;padding: 3px 2px;width: 600px;" id="slide_url_fr" name="slide_url_fr" value="" />
													
						</div>
							
						<div style="clear:both"></div>
						
						
						<div style="float:left; margin-top:10px;">
									
							
							<label for="fileToUpload" style="margin: 0 0 5px 0;display: block;font-size: 14px;">Please select a file and click Upload button</label>

							<input name="fileToUpload" id="fileToUpload" type="file" style="display:none">
							<div class="input-append">
								<input id="new_slide_imgname" class="input-large" type="text">
								<a class="btn" onclick="$('input[id=fileToUpload]').click();">Browse</a>
								<a class="btn" onclick="imageslider_manager.ajaxFileUpload();">Upload</a>
								
							</div>

							<img id="loading" style="width:24px; height:24px;" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/ajax-loader.gif" style="display:none;">

													
							<div id="thumbnail_holder_div"></div>
									
							</div>
								
							<div style="clear:both; height:20px;"></div>
								
					
						<div style="bordr:1px solid #02FEAA">
						<img id="slide_img" name="slide_img" style="max-width:690px; max-height:600px;" src="" />
						</div>
				
						<div id="savebutton_div" style="display:none">
							<a style="float:right" class="btn btn-danger" href="javascript:imageslider_manager.cancel_item()"><i class="icon-white icon-remove"></i> Cancel</a>
							<a style="float:right; margin-right:6px;" class="btn btn-success" href="javascript:imageslider_manager.save_item()"><i class="icon-white icon-ok"></i> Save</a>

						</div>
						
						</fieldset>
					</form>
						
						
					</div>
			   </td>
		   </tr>
	   </table>
	</form>
	   

	
</div><!-- [END] #bgp_edit_form_div -->

	<div id="backgroundPopup"></div>
	
	<hr/>
	
	<div id="widget_content_list_div" style="display:<?=$widget_content_list_div_visible?>">

	<div style="float:left"><?=$template_selector?></div>
	
	<input class="btn btn-default" style="float:right; margin-top:14px;" type="button" Value="New Slide" onClick="imageslider_manager.new_item()">

	<div style="clear:both"></div>
	
	
	

	<h3>List of Content</h3><br/>
 
 	<form id="slideshow" name="slideshow" method="post" action="index.php?a=upd">
		<div id="content_list_div">
			<?php echo $datarows; ?>
		</div> <!-- end content list div -->
	</form>
	
	</div>