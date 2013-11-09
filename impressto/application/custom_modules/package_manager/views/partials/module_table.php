
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr>
<th>Name</th>
<th>Description</th>
<th width="260" colspan="2"></th>
</tr>
</thead>
<tbody>

<?php

foreach($module_list as $module_dirname => $module_data){

	
	
	if($module_data['active']){
	
		if($module_data['module_type'] == "core"){
		
			$actionicon = "<a style=\"width:100px\" href=\"javascript:ps_module_manager.reinstall('{$module_dirname}');\" class=\"btn\"><i class=\"icon-refresh\"></i> Reinstall</a>";

			$permissionsicon = "<a style=\"width:80px\" href=\"javascript:ps_module_manager.setpermissions('{$module_data['id']}');\" class=\"btn\"><i class=\"icon-check\"></i> Rights</a>";

						
		
		}else{
				
		
			$actionicon = "<a style=\"width:100px\" href=\"javascript:ps_module_manager.deactivatemodule('{$module_dirname}');\" class=\"btn btn-danger\"><i class=\"icon-remove icon-white\"></i> Deactivate</a>";
			$permissionsicon = "<a style=\"width:80px\" href=\"javascript:ps_module_manager.setpermissions('{$module_data['id']}');\" class=\"btn\"><i class=\"icon-check\"></i> Rights</a>";
	
		}
		
		
	}else{
	
		if($module_data['module_type'] == "core"){
		
			$actionicon = "<a style=\"width:100px\" href=\"javascript:ps_module_manager.reinstall('{$module_dirname}');\" class=\"btn\"><i class=\icon-refresh\"></i> Reinstall</a>";
		}else{
		
			$actionicon = "<a style=\"width:100px\" href=\"javascript:ps_module_manager.activatemodule('{$module_dirname}');\" class=\"btn btn-success\"><i class=\"icon-ok icon-white\"></i> Activate</a>";
		}
		
		$permissionsicon = "";
			
	}
	



	echo "<tr>";
	
	echo "<td style=\"vertical-align:top;\"><strong>" . $module_data['name'] . "</strong></td>";
	echo "<td style=\"vertical-align:top;\">";

	echo $module_data['description'];
	
	echo "<br />";
	
	
	echo "<span class=\"badge badge-info\">Version {$module_data['version']} - Last Updated {$module_data['last_updated']}</span>";
		
	echo " <div style=\"float:right\" id=\"update_check_{$module_data['id']}\"><a href=\"javascript:ps_module_manager.check_for_module_update('{$module_dirname}','{$module_data['module_type']}','{$module_data['id']}','{$module_data['version']}')\">Check for updates</a></div>";
	
		
	
	
		
	echo "</td>";
	echo "<td>" . $actionicon . "</td>";
	echo "<td>" . $permissionsicon . "</td>";
	echo "</tr>";
					

}

?>
</tbody>
</table>