<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


	
<?php

$request_uri = getenv("REQUEST_URI");

?>

				

	<div class="block well">

	
	
		<div class="navbar">
			<div class="navbar-inner">
		        <h2>Image Galleries</h2>
			</div>
		</div>
	 <div class="body">
	

					
		<div id="galleries" class="panel-body">
		
	
				<?php echo $infobar; ?>
		
				<div id="galleries_list_div">
				
				<button class="btn pull-right" onclick="ps_imagegallerymanager.newgallerydialog()"><i class="icon-star"></i> New gallery</button>
			
				
				<div class="clearfix" style="margin-bottom:20px"></div>
				
			
				

				<table id="gallery-list-table" style="width:100%" class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<tr>
					<th>id</th>
					<th>name</th>
					<th>description</th>
					<th>template</th>
					<th></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				</table>
				



				<script id="gallerylist-template" type="text/x-handlebars-template">

					{{#each .}}
						<tr>
							<td>{{id}}</td>
							<td>{{name}}</td>
							<td>{{description}}</td>
							<td>{{template}}</td>
							<td style="text-align:right" nowrap>
							<button class="btn" onclick="ps_imagegallerymanager.editgallery('{{id}}')"><i class="icon-edit"></i> Edit</button>
							<button class="btn" onclick="ps_imagegallerymanager.deletegallery('{{id}}')"><i class="icon-trash"></i> Delete</button>
							</td>	
							</tr>
					{{/each}}
				
				</script>
				

			
			</div>
			

			
				
			<div id="image_editor_div" style="display:none">
			
				<br />
				

						
					<div class="w-box-header">IMAGE EDIT</div>
					<div class="w-box-content cnt_a">
						
						<div style="float:left">
						
										
							<div style="display:none" id="initcrop_div">
								<a onclick="ps_imagegallerymanager.opencropbox()"><img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/custom_modules/image_gallery/images/img_crop.png" alt="cropper" border="0" /> Crop Thumbnail</a>
							</div>
							
								
							<div id="thumbnail_holder_div" style="margin-top:5px; display:none">
								<img id="item_thumbnail_preview" src=""/>
							</div>
							
									
							
					
						</div>
									
									
						<div style="float:left; margin-left:20px;">
												
						
							<form id="image_details_form">
							<input type="hidden" id="image_id" name="image_id" value="" />
							<input type="hidden" id="uploaded_image_name" name="uploaded_image_name" value="" />
								
					
					
					
					
							<div style="float:left">
								<label for="image_label">Label</label>
								<input type="text" id="image_label" name="image_label" style="width:150px;" />
							</div>
								
							<div style="float:left; margin-left:10px;">
								<label for="image_alt">Alt Tag</label>
								<input type="text" id="image_alt" name="image_alt" style="width:150px;" />	
							</div>
								
							<div class="clearfix"></div>
					
							<label for="image_caption">Caption</label>
							<textarea id="image_caption" name="image_caption" style="width:400px; height:50px"></textarea>	

							<div class="clearfix"></div>
							
							<div style="float:left">
								<?php echo $editor_category_selector; ?>
							</div>
								
							<div style="float:left; margin-left:10px; margin-top:24px;">
								<input type="file" name="fileToUpload" id="fileToUpload"  class="uni_style" />
				
							
							</div>
				
							<div class="clearfix"></div>
								<input id="resize_img_check" type="checkbox" name="resize_img_check" value="1" class="input" /> Resize image
								<input id="default_category_image" type="checkbox" name="default_category_image" value="1" class="input" />&nbsp;<label style="display:inline" for="category_image">Set as Category Image</label>
							
							
							<div class="clearfix"></div>
							
							<div style="float:right; margin-right:10px; margin-top:22px;">
								<button type="button" id="closeeditandrefresh_button" style="display:none; margin-left:5px;" class="btn btn-default" onclick="ps_imagegallerymanager.closeeditandrefresh()">Close</button>
								<button type="button" id="cancelimageedit_button"class="btn" style="margin-left:5px;" onclick="ps_imagegallerymanager.cancelimageedit()">Cancel</button>
								<button type="button" class="btn btn-default" onclick="ps_imagegallerymanager.saveimage()"><i class="icon-ok"></i> Save</button>
							</div>
								
							<div class="clearfix"></div>
																
							</form>
			
							
						</div>				
														
				
						<div class="clearfix"></div>
				
					</div>
					
					<div class="clearfix"></div>
					
					
				</div>
				
			
			
				
			<br />
			
			
			
			<div id="image_gallery_list"></div>


		</div>

		
	</div>
</div>
	
		



<div id="newGalleryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">New Gallery</h3>
</div>
<div class="modal-body">


<div class="alert alert-error" id="newGalleryModal-alertbox" style="display:none">
       <a class="close" data-dismiss="alert">×</a>
        <div ></div>
		
</div>

<form id="new-gallery-form">

	 <label>Gallery Name</label>
		<input type="text" name="name">
   
		<label>Description</label>
		<textarea rows="3" name="description"></textarea>
		
		<label>Template</label>
		<select name="template">
		<?php
		
		foreach($template_options As $key => $val){
		
			echo "<option value=\"{$val}\">{$key}</option>\n";
		
		}
		
		?>
		</select>
		
                           
</form>


</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="ps_imagegallerymanager.savenewgallery()">Save</button>
</div>
</div>









<div id="settingsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Gallery Settings</h3>
</div>
<div class="modal-body">

    <div class="alert alert-error" id="settings-form-alertbox" style="display:none">
	
		Please select a template
    
    </div>



<form id="gallery_settings_form">

		<div id="thumb_maxwidth_input_div" class="formelement">
<label for="thumb_maxwidth_input">Thumbnail max width</label>
<input type="text" value="" title="Thumbnail max width" id="thumb_maxwidth_input" name="thumb_maxwidth_input"></div>
		<br>
		<div id="thumb_maxheight_input_div" class="formelement">
<label for="thumb_maxheight_input">Thumbnail max height</label>
<input type="text" value="" title="Thumbnail max height" id="thumb_maxheight_input" name="thumb_maxheight_input"></div>
		<br>
		<div id="resized_maxwidth_input_div" class="formelement">
<label for="resized_maxwidth_input">Resized max width</label>
<input type="text" value="" title="Resized max width" id="resized_maxwidth_input" name="resized_maxwidth_input"></div>
		<br>
		<div id="resized_maxheight_input_div" class="formelement">
<label for="resized_maxheight_input">Resized max height</label>
<input type="text"  value="" title="Resized max height" id="resized_maxheight_input" name="resized_maxheight_input"></div>


	<?=$template_selector?>

		<br>
		
	</form>
						
								
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="ps_imagegallerymanager.savegallerysettings()">Save</button>
</div>
</div>






<div id="categoryManageModal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Manage Categories</h3>
</div>
<div class="modal-body">

			<div style="float:right;">
								
			
				<button class="btn btn-default"  id="add_category_button" onclick="ps_imagegallerymanager.addcategory()"><i class="icon-plus icon-white"></i> Add Category</button>

				<form id="new_category_form">
				
				<div style="display:none" id="new_category_div">
				
		
					<label  style="display:inline" for="new_category">Category (EN)</label>
					<input type="text" id="new_category" name="new_category" style="width:150px" />
	
					<input type="button" class="btn btn-default" id="save_new_category_button" onclick="ps_imagegallerymanager.savenewcategory()" value="Save Category" />			
					<input style="" class="btn btn-default" type="button" id="save_new_category_button" onclick="ps_imagegallerymanager.cancelnewcategory()" value="Cancel" />	
					
					
						
				
				</div>

				</form>
			
			</div>
			
			<div class="clearfix"></div>
			
			<div id="category_editor_div" style="display:none">
			

			
				
				<div style="float:left" id="category_thumbnail_holder_div"></div>
				
				<div style="float:left; margin-left:10px;">
					
					<div style="float:left; margin-left:10px;">
					
					<form id="category_edit_form">
					<input type="hidden" name="edit_category_id" id="edit_category_id" value="" />
				
					<label style="display:inline" for="edit_category_name_en">Name(EN)</label>
					<input type="text" name="edit_category_name_en" id="edit_category_name_en" value="" />
							
					</form>
					</div>
						
					<div style="float:left; margin-left:10px;">
				
						<button class="btn" onclick="ps_imagegallerymanager.savecategory();">Save</button>
						<button class="btn" onclick="ps_imagegallerymanager.canceleditcategory();">Cancel</button>
						
					</div>
					
					<div class="clearfix"></div>
				
					</div>
				
				
			
			
			
			</div>
			
			<div class="clearfix"></div>
			
			<br />
			
			
			
			<div id="gallery_categories_list_div"></div>
						
					
			
			
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" onclick="ps_imagegallerymanager.savenewgallery()">Save</button>
</div>
</div>



<div id="image_cropping_div" class="modal hide fade in" style="display: none; ">
            <div class="modal-header">
              <a class="close" data-dismiss="modal">×</a>
              <h3>Thumbnail Cropper</h3>
            </div>
            <div class="modal-body">
			
			<form id="crop_thumb_form">
					
				<input type="hidden" id="thumb_image_name" name="thumb_image_name" />
				<input type="hidden" id="thumb_image_category" name="thumb_image_category" />
				
				<input type="hidden" id="x" name="x" />
				<input type="hidden" id="y" name="y" />
				<input type="hidden" id="w" name="w" />
				<input type="hidden" id="h" name="h" />
			</form>
			
				<!--  .jcrop img {max-width: none} NEEDED IN CSS TO FIX BOOTSTRAP CONFLICT -->
				<div class="jcrop">
			
					<img src="" style="float: left; margin-right: 10px;" id="original_image_preview" alt="Create Thumbnail" />
				
				</div>
						
				
			
			
            </div>
			
			
							
            <div class="modal-footer">
              <a onclick="ps_imagegallerymanager.savecrop_dimensions()" class="btn btn-success"><img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/custom_modules/image_gallery/images/saving_crop.png" alt="Save Crop" width="16" height="16" style="vertical-align: middle;margin: 0 5px 0 0;"/> Save Cropping</a>
              <a href="#" class="btn" data-dismiss="modal">Close</a>
            </div>
</div>
 
			
