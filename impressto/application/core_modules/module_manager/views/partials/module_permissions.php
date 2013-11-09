
<form id="module_role_permissions_form">

<input type="hidden" name="module_id" value="<?=$module_id?>" />

<?php //print_r($module_permissions); ?>


<table class="table table-striped table-bordered table-condensed">


<?php 

$bgcolor = "#BEE1EA";
	
foreach($module_permissions as $role_action => $roledata){ 

	if(!isset($roledata['description'])) $roledata['description'] = "";
	

	

?>


	<tr>
	<th colspan="<?=count($defined_roles)?>"><a class="role_action_label" style="color:#222222; font-weight:bold" rel="tooltip" title="<?=addslashes($roledata['description'])?>"><?=$role_action?></a></th>
	</tr>
	
	<tr>
	
	<?php foreach($defined_roles AS $role_id => $role_name){ ?>
	
		<td nowrap><input type="checkbox" id="<?=$role_action?>__<?=$role_id?>_checkmark" name="role_permissions[]" value="<?=$role_action?>__<?=$role_id?>" <?php if( in_array($role_id, $module_permissions[$role_action] )) echo " checked "; ?> />&nbsp;<label style="display: inline;" for="<?=$role_action?>__<?=$role_id?>_checkmark"><?=$defined_roles[$role_id]?></label></td>
		
	<?php } ?>
	

	</tr>
	


<?php } ?>


</table>

</form>


<div style="float:right; margin-top:20px;">
<a href="javascript:ps_module_manager.saverolepermissions();" class="btn btn-success"><i class="icon-ok icon-white"></i> Save</a>
</div>

	
	

