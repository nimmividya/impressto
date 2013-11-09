<?php /*
@Name: Admin Bar
@Type: PHP
@Author: Galbraith Desmond
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/09/20
*/
?>

<?php

$CI =& get_instance(); 

$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/custom_modules/admin_bar/js/admin_bar.js"); 
$CI->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/custom_modules/admin_bar/css/style.css"); 
	

?>


	<div  id="adminbar">
	
		 <ul>
		   <li><a href="/<?php echo PROJECTNAME; ?>-admin/" target="_blank"><button>Admin</button></a></li>
		   <li><a href="/page_manager/edit/<?=$site_lang?>/<?=$page_id ?>" target="_blank"><button class="default">Edit Page</button></a></li>
		   		   	 
		 </ul>
		 
		 
		 <div id="adminbar_details" style="float:left; <?php if($pagedata['CO_Color'] != "") echo "backgrond-color: {$pagedata['CO_Color']}"; ?>">
		 		 		 
	   
		   Last Edit:<br />
		   <?php echo date("Y/m/d h:i", strtotime($pagedata['CO_WhenModified'])); ?>
		   <br />
		   <?php echo $pagedata['editor_name'] != "" ? $pagedata['editor_name'] : $pagedata['usr_username']; ?>
		   <br />
	 	   <br />
		   Template:
		   <br />		   <?=$pagedata['CO_Template']?>
		   <br />
		    <br />
			Searchable: <?php echo $pagedata['CO_Searchable'] == 1 ? "Yes" : "No" ; ?>
		   <br />
		   	Hits: <?=$pagedata['hits']?>
			 <br />
			
			</div>
		 
	</div>