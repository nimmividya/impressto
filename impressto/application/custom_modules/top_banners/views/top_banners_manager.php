
<link rel="stylesheet" type="text/css" href="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/core/css/jquery/jquery_ui/ui-lightness/jquery-ui-1.8.16.custom.css" />	
<link rel="Stylesheet" type="text/css" href="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/core/css/jquery/jcrop/jquery.Jcrop.css" />
<link rel="Stylesheet" type="text/css" href="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/core/css/jquery/jHtmlArea/jHtmlArea.css" />
<link rel="Stylesheet" type="text/css" href="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/core/css/jquery/jHtmlArea/jHtmlArea.ColorPickerMenu.css" />

<link rel="Stylesheet" type="text/css" href="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/custom_modules/bg_pos_slider/css/style.css" />


	
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



<?php echo $headerjs; ?>

	

<div id="overview" style="background-color:#F0F0F0;">
    <h1><a href="javascript:void(0);" onclick="psToggle('overview');" class="btn" id="closeHelp">X</a>Help</h1>
   <p>Please see the PageShaper <a href="http://30905.vws.magma.ca/manual/Brewers2010_PageShaper_manual.pdf" target="_blank" >manual</a> </p>

</div>

<?php echo $infobar; ?>



<h2>Image Slider</h2>

<div style="float:left"><?php echo $widget_selector; ?></div>
<input class="btn btn-default" style="float:right" type="button" Value="New Slider" onclick="imageslider_manager.shownewidgetnameinput()">
<div style="clear:both"></div>
<div id="newidgetnameinput_div" style="display:none">
<form id="" action="/admin/top_banners/createnewwidget" method="post">
<label for="new_widget_name">New Widget Name:</label>
<input type="text" id="new_widget_name" name="new_widget_name" value="" style="width:200px" maxlength="50">

<input class="btn btn-default" type="button" Value="Cancel" onclick="imageslider_manager.cancelnewidgetname()">
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
					<div style="float: left;margin: 0 10px;width: 380px;margin: 0 10px;">
					
					
						<label for="s_title" style="margin: 0 0 5px 0;display: block;font-size: 14px;">Title</label>
						<input type="text" style="border: 1px solid #2BA8CD;padding: 3px 2px;width: 100px;" id="s_title" name="s_title" value="" />
											
						
						<form name="form" action="" method="POST" enctype="multipart/form-data">	
							<fieldset>
								<legend>Image Upload</legend>
							
								<img id="loading" style="width:24px; height:24px;" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/ajax-loader.gif" style="display:none;">

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
											<td><button class="button" id="buttonUpload" onclick="return imageslider_manager.ajaxFileUpload();">Upload</button></td>
										</tr>
									</tfoot>
								</table>
									<div id="thumbnail_holder_div"></div>
							</fieldset>
						</form>
						<div style="bordr:1px solid #02FEAA">
						<img id="slide_img" name="slide_img" style="width:690px" src="" />
						</div>
						
						<div class="subNav" id="savebutton_div" style="display:none; margin: 10px 0;">
							<a class="btn btn-default" href="javascript:imageslider_manager.save_item()">Save</a>
						</div>
						
					</div>
			   </td>
		   </tr>
	   </table>
	</form>
	   

	
</div><!-- [END] #bgp_edit_form_div -->
   


		

	<div id="backgroundPopup"></div>
	
 <hr/>
 
  <input class="btn btn-default" style="float:right" type="button" Value="New Slide" onclick="imageslider_manager.new_item()">

  <div style="clear:both"></div>
 
 <h3>List of Content</h3><br/>
 

 
 	<form id="slideshow" name="slideshow" method="post" action="index.php?a=upd">
	<div id="content_list_div">
		<?php echo $datarows; ?>
	</div> <!-- end content list div -->
</form>


