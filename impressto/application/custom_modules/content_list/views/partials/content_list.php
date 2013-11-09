<?php
/*
@Name: content list items
@Type: PHP
@Filename: content_list.php
@Description: shows a list of items for a specific content list
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>



<table id="content_list_table" class="table table-striped table-bordered table-condensed">
<thead>
<tr>
<th>id</th>
<th>Title(EN)</th>
<th>Content(EN)</th>
<th style="width:120px">Action</th>
</tr>
</thead>
<tbody>

<?php 

foreach($widget_list_data AS  $widget_data){ 

	$widget_data['content_en'] = strip_tags($widget_data['content_en']);
	
	if(strlen($widget_data['content_en']) > 200) 
		$widget_data['content_en'] = substr($widget_data['content_en'], 0,200) . "...";
	

?>



<tr id="item_row_<?=$widget_data['id']?>">

<td><?=$widget_data['id']?></td>
<td><?=$widget_data['title_en']?></td>
<td><?=$widget_data['content_en']?></td>
<td>

<a href="javascript:pscontentlistmanager.edit_list_item('<?=$widget_data['id']?>')"><i class="icon-pencil"></i> Edit</a>
<a href="javascript:pscontentlistmanager.delete_list_item('<?=$widget_data['id']?>')"><i class="icon-trash"></i> Delete</a>
 

</td>
</tr>

<?php } ?>

</tbody>

</table>






