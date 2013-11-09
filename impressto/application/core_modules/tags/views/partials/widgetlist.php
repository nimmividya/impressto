<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: admin widget list
@Type: PHP
@Filename: widgetlist.php
@Description: 
@Author: 
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/09/04
*/
?>


<table class="table table-striped table-bordered table-condensed">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Content Module</th>
<th>Template</th>
<th>TAG</th>
<th></th>
</tr>
</thead>
<tbody>

	<?php
	

	foreach($widget_list AS $widget){ 

	
	

	?>
	
	
	<tr>
	<td><?=$widget['widget_id']?></td>
	<td><?=$widget['instance']?></td>
	<td><?=$widget['options']['content_module']?></td>
	<td><?=$widget['options']['template']?></td>
	<td>[widget type='tags/tag_cloud' name='<?=$widget['instance']?>']</td>
	<td><a href="javascript:ps_tags_manager.delete_widget('<?=$widget['widget_id']?>');"><i class="icon-trash"></i> Delete</a></td>
	</tr>
	
	
	<?php 	
	
	
	}
	
		
	?>

</tbody>
</table>
		
	
