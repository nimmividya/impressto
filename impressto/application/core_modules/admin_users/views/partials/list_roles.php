


<span>All () | Admin(2) | Developer (2)</span>

<table id="roles_table" class="crudRecords" class="table table-striped table-bordered table-condensed">
<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>#Users</th>
<th></th>
</tr>


<?php

foreach($roledata as $data){

?>


	<tr>
	<td>id</td>
	<td><?=$data['name']?></td>
	<td><?=$data['description']?></td>
	<td><?=$data['num_users']?></td>
	
	<td><button class="btn" onclick="ps_usermanager.role_fields('<?=$data['id']?>')"><i class="icon-cogs"></i> User Fields</button>
	
	
  <button class="btn" onclick="ps_usermanager.edit_role('<?=$data['id']?>')"><i class="icon-pencil"></i> Edit</button>
  <?php if($data['id'] == "") { ?><button class="btn" onclick="ps_usermanager.delete_role('<?=$data['id']?>')"><i class="icon-trash"></i> Delete</button><?php } ?>
  

		
	</td>
	</tr>
	

	
<?php


}


?>

</table>


