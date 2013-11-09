<table class="table table-striped">
<thead>
	<tr>
		<th style="width:40px">ID</th>
		<th>Name</th>
		<th>Template</th>
		<th width="200">Action</th>
	</tr>
</thead>
	<tbody>
	<?php foreach($widget_list_data as $listdata){


		//print_r($listdata);
	 ?>

		<tr>
		<td><?=$listdata['widget_id']?></td>
		<td><?=$listdata['instance']?></td>
		<td><?=$listdata['options']['template']?></td>
		<td align="right">			
			<a class="btn btn-default-small" href="javascript:pscontentlistmanager.copywidget('<?=$listdata['widget_id']?>')"><i class="icon-white icon-share"></i> Copy</a>
			<a class="btn btn-default-small" href="javascript:pscontentlistmanager.editwidget('<?=$listdata['widget_id']?>')"><i class="icon-white icon-edit"></i> Edit</a>
			<a class="btn btn-danger-small" href="javascript:pscontentlistmanager.deletewidget('<?=$listdata['widget_id']?>')"><i class=" icon-white icon-trash"></i> Delete</a>
		</td>
		
		</tr>
		
	<?php } ?>
	</tbody>
</table>
