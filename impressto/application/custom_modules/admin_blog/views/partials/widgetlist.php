<table class="crudRecords">
<tr>
<th style="width:40px">ID</th>
<th>Module</th>
<th>Type</th>
<th>Instance</th>
<th>Template</th>
<th style="width:160px"></th>
</tr>

<?php foreach($widget_list_data as $listdata){ ?>

	<tr>
	<td><?=$listdata['widget_id']?></td>
	<td><?=$listdata['widget_module']?></td>
	<td><?=$listdata['widget_type']?></td>
	<td><?=$listdata['widget_instance']?></td>
	<td><?=$listdata['widget_template']?></td>
	<td align="right">			
			<a class="btn btn-success-small" href="javascript:ps_blogmanager.editwidget('<?=$listdata['widget_id']?>')"><i class="icon-white icon-edit"></i> Edit</a>
					
			<a class="btn btn-danger-small" href="javascript:ps_blogmanager.deletewidget('<?=$listdata['widget_id']?>')"><i class=" icon-white icon-trash"></i> Delete</a>
			</td>
	
	</tr>
	
<?php } ?>

</table>
