


<div class="pull-left" style="margin-bottom:15px"><?php echo $category_selector; ?></div>

<div class="pull-right" style="margin-top:10px">

<a class="pull-right clearfix" href="javascript:ps_imagegallerymanager.showgallerylist()">back to gallery list</a>



	
<br />

    <div class="btn-group pull-right">
    <button class="btn" onclick="ps_imagegallerymanager.managecategories('<?=$gallery?>')"><i class="icon-folder-close"></i> Manage Categories</button>
    <button class="btn" onclick="ps_imagegallerymanager.editgallerysettings('<?=$gallery?>')"><i class="icon-wrench"></i> Settings</button>
    </div>
	

<button class="btn btn-default pull-right" style="margin-right:10px" onclick="ps_imagegallerymanager.addimage()" id="add_image_button"><i class="icon-plus icon-white"></i> Add Image</button>

</div>

									
				
<div style="clear:both"></div>


<table id="gallery_images_list_table" class="table table-striped table-bordered table-condensed">
<thead>
<tr>
<th></th>
<th valign="left" style="">Thumbnail</th>
<th valign="left" style="">Label</th>
<th valign="left" style="">Caption</th>
<th valign="left" style="">Alt Tag</th>
<th valign="center" style="width:86px;">Action</th>
</tr>
</thead>
<tbody>


<?php 

$position = 1;

$uparrowdisplay =  "none";
$downarrowdisplay =  "none";


foreach($galleryrecords as $key => $val){

	$id = str_replace("item_","",$key);

	$cellcolorstyle = "";

	if($id == $default_category_image){
	
		$cellcolorstyle = "background-color:#F9EF81;";
	
	}
		
?>

<tr id="image_row_<?=$id?>">

<td style="text-align:center; cursor:move;"><i class="icon-sort"></i></td>

<td style="vertical-align: top"><?=$val['imagename']?><br /><img id="imagelist_thumb_<?=$id?>" src="<?php echo ASSETURL; ?>uploads/<?php echo PROJECTNAME; ?>/image_gallery/<?=$gallery?>/<?=$val['category']?>/thumbs/<?=$val['imagename']?>"></td>
<td style="vertical-align: top; width: 100px;"><?=$val['label']?>&nbsp;</td>
<td style="vertical-align: top; width: 200px;"><?=$val['caption']?>&nbsp;</td>
<td style="vertical-align: top; width: 100px;" ><?=$val['alttag']?>&nbsp;</td>

<td nowrap>

		<button class="btn" onclick="ps_imagegallerymanager.edititem('<?=$id?>')"><img class="action_icon" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/actionicons/edit.gif"> Edit</button>
		<button class="btn" onclick="ps_imagegallerymanager.deleteitem('<?=$id?>')"><img class="action_icon" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/actionicons/delete.gif"> Delete</button>

</td>
	
</tr>


<?php 

	$position ++;

} 

?>

</tbody>
</table>

