

<table id="categories_list_table" class="table table-striped table-bordered table-condensed">
<thead>
<tr>
<th></th>
<th valign="left" style="width:20px;">ID</th>
<th valign="left" style="">Category</th>
<th valign="left" style="">#Images</th>
<th valign="center" style="width:40px;">Actions</th>
</tr>
</thead>
<tbody>

<?php 

foreach($gallery_categories as $id => $catvals){

	$id = str_replace("cat_","",$id);
	
	
?>


<tr id="cat_row_<?=$id?>">
<td style="text-align:center; cursor:move;"><i class="icon-sort"></i></td>
<td style="vertical-align: top"><?=$catvals['id']?></td>
<td style="vertical-align: top; width: 200px;"><?=$catvals['name_en']?>&nbsp;</td>
<td style="vertical-align: top; width: 100px;" ><?=$catvals['num_images']?></td>
<td style="vertical-align: top" align="center" nowrap>

<div style="float:left; width:20px">&nbsp;
	<img class="action_icon" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/actionicons/edit.gif" onclick="ps_imagegallerymanager.editcat('<?=$id?>')">
</div>
	
<div style="float:left; width:20px">&nbsp;
	<?php if($catvals['num_images'] == 0){ ?><img class="action_icon" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/actionicons/delete.gif" onclick="ps_imagegallerymanager.deletecat('<?=$id?>')"><?php } ?>
</div>

<div class="clearfix"></div>
	
	



</td>

</tr>


<?php 

} 

?>


</tbody>
</table>

