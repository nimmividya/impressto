<table class="table table-striped table-bordered table-condensed">
<tr>
<th>Name</th>
<th>Insert Codes (Inline and PHP)</th>
<th colspan="2">Actions</th>
</tr>


<?php foreach($blocklistdata as $data){ ?>


	<tr>
		<td style="width: 160px;">
			<?php echo $data['name']; ?>
		</td>
		<td nowrap style="width: 380px;">[<?php echo $data['slug']; ?>]<br /><br /><?php echo $data['phpslug']; ?></td>
		
		<td style="width:60px" align="center">
			<a href="javascript:ps_cblockmanager.editblock('<?php echo $data['id']; ?>')" class="btn btn-success-small"><i class="icon-white icon-edit"></i> Edit</a>
		</td>
		<td style="width:70px" align="center">
			<a href="javascript:ps_cblockmanager.deleteblock('<?php echo $data['id']; ?>')" class="btn btn-danger-small"><i class=" icon-white icon-trash"></i> Delete</a>
		</td>
	</tr>
	
<?php } ?>

</table>


