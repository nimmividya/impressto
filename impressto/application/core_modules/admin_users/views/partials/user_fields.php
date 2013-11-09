


<table class="table table-bordered" id="extended_fields">
<thead>
<tr style="color: black; font-weight: bold;background-color:#c0c0c0" class="nodrop nodrag">
<th>Order</th>
<th>Field Name</th>
<th>Data Type</th>
<th>Input Type</th>
<th>Max Length</th>
<th colspan="2"></th>

</tr>
</thead>
<tbody>

<?php 


foreach($userfielddata AS $name => $field){ ?>

<tr id="<?=$field['field_id']?>">
<td class="dragHandle">&nbsp;</td>	
<td><?=$field['field_name']?></td>
<td><?=$field['data_type']?></td>
<td><?=$field['input_type']?></td>
<td><?=$field['max_length']?></td>
<td colspan="2" align="right">
<button onclick="userfield_manager.edit_user_field('<?=$field['field_id']?>')" class="btn">Edit</button>
<button onclick="userfield_manager.delete_user_field('<?=$field['field_id']?>')" class="btn">Delete</button>
</td>
</tr>



<?php } ?>
</tbody>
</table>
