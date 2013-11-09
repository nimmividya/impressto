<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

?>

<table class="table table-striped table-bordered table-condensed">

<thead>
<tr>
<th>Name</th>
<th>Type</th>
<th>Length</th>
<th style="width:160px"></th>
</tr>
</thead>

<tbody>


<?php 

if(isset($fields) && is_array($fields)){

	foreach($fields AS $fieldata){
	
		

?>
<tr>
<td><?=$field_media_prefix?><?=$fieldata['name']?></td>
<td><?=$fieldata['type']?></td>
<td><?=$fieldata['length']?></td>

<td nowrap>
<button class="btn btn-small" onclick="xtracontent.rename_field_prompt('<?=$fieldata['name']?>','<?=$field_media?>')"><i class="icon-pencil"></i> Rename</button>
<button class="btn btn-small btn-danger" onclick="xtracontent.delete_field('<?=$fieldata['name']?>','<?=$field_media?>')"><i class="icon-remove"></i> Delete</button>
</td>

</tr>

<?php

}

}

?>

</tbody>
</table>