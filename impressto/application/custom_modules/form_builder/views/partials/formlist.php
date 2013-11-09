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

<table class="table table-striped table-bordered table-condensed">
	<tbody><tr style="font-weight: bold; text-align: center;">
		<td>id</td>
		<td>Form Name</td>
		<td>Shortcode</td>
		<td>Updated</td>
		<td colspan="3">&nbsp;</td>
	</tr>

	<?php
	
	foreach($form_list_data AS $row){ 
	
	
	?>
	
	
		
		<tr style="height: 29px; text-align: center;">
			<td><?=$row['id']?></td>
			<td style="text-align:left"><?=$row['form_name']?></td>
			<td>[widget type='form_builder' name='<?=$row['form_name']?>']</td>
			<td><?=$row['updated']?></td>
			
							<div style="float:right; margin-right:10px;">
						
					</div>
			<td style="width:90px">
			<button type="button" onclick="ps_formbuilder_manager.showrecords('<?=$row['id']?>')" id="btn_new" class="btn btn-default-small"><i class="splashy-documents"></i> Records</button>			
			</td>
			
					
			<td style="width:60px">				
			<a href="/form_builder/build/<?=$row['id']?>" class="btn btn-success-small"><i class="icon-white icon-edit"></i> Edit</a>
			</td>
			<td style="width:80px">				
			<a href="javascript:ps_formbuilder_manager.delete_form('<?=$row['id']?>')" class="btn btn-danger-small"><i class=" icon-white icon-trash"></i> Delete</a>
			</td>
		</tr>
		
	<?php } ?>
	
	
		

	</tbody></table>
