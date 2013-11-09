<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Contact Form Manager
@Type: PHP
@Filename: fieldlist.php
@Description: Form field management interface
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

<?php

$modasseturl = ASSETURL . PROJECTNAME . "/default/custom_modules/form_builder/";


?>


		<table class="table table-striped table-bordered table-condensed" id="form_fields">
		<tr style="color: black; font-weight: bold;background-color:#c0c0c0" class="nodrop nodrag">
		<th>Order</th>
		<th>Active</th>
		<th>Required</th>
		<th>Field Name</th>
		<th>Field Label</th>
		<th>Field Type</th>
		<th colspan="2">Actions</th>						
		</tr>
	
		<?php
			

			
			
		$sql = "SELECT * FROM {$this->db->dbprefix}form_builder_form_fields AS FINDEX "
		. " LEFT JOIN {$this->db->dbprefix}form_builder_fields AS FIELDS "
		. " ON FINDEX.field_id = FIELDS.field_id "
		. " WHERE FINDEX.form_id = '{$form_id}' "
		. " ORDER BY FIELDS.position ASC";
				
		$query = $this->db->query($sql);
				
		if ($query->num_rows() > 0){
				
			foreach ($query->result_array() as $row){
						
				$updatedflag = "";
										
				$minutesold = round(abs(time() - strtotime($row['updated'])) / 60,0);
						
				if($minutesold < 10) $updatedflag = "<img src=\"{$modasseturl}images/updated.png\" />";
							
			
							
				?>
							
							
				<tr id="<?php echo $row['field_id'];?>">
				<td class="dragHandle">&nbsp;</td>	
				<td><input onchange="ps_formbuilder_manager.update_active(this,'<?=$row['field_id']?>');" type="checkbox" id="active[]" name="active[<?php echo $row['field_id'];?>]" <?php if ($row['active'] == 1){echo 'checked';} ?>></td>
				<td><input onchange="ps_formbuilder_manager.update_required(this,'<?=$row['field_id']?>');" type="checkbox" id="required[]" name="required[<?=$row['field_id']?>]" <?php if ($row['required'] == 1){echo 'checked';} ?>>
				<input type="hidden" value="<?php echo $row['field_id'];?>" name="field_id[]"></td>
				<td><?=$updatedflag?><?=$row['field_name']?></td>
				<td><?=$row['field_label']?></td>
				<td><img src="<?=$modasseturl?>images/<?=$row['ftype']?>.png" style="margin-right:10px;" /><?=$row['ftype']?></td>
			

							<td><center><a href="javascript:ps_formbuilder_manager.edit_field('<?=$row['field_id']?>');" class="update_special" rel="<?php echo $row['field_id']; ?>"><i class="icon-pencil"></i> Edit</a></center></td>
							
							<td><a href="javascript:ps_formbuilder_manager.delete_field('<?=$row['field_id']?>');" class="ajax-links" rel="<?php echo $row['field_id'];?>" style="text-decoration:none;"><i class="icon-trash"></i> Delete</a></td>
							</tr>
							
							<?php
							}
							
						}
						
						?>
							
							
							
						</table>
						
				