<?php 	

$languages = $this->config->item('languages');





$user_role = $this->session->userdata('role');  // this HAS TO come from the user session

$current_module = "";

$this->load->helper('ps_helper');
$module_list = get_modules();

$navsections = array();

// osrt hte left menu items alpahbeticvally

foreach($module_list as $module_dirname => $module_data){

	$navsections[$module_data['admin_menu_section']][] = array("dirname"=>$module_dirname,"url"=>$module_data['url'],"name"=>$module_data['name'],"active"=>$module_data['active']);
	
}
	

 ?> 
 
	<!-- peterdrinnan - hacked in. should go in core css -->
	<style>
	
	.active_lmenu{
	
		background: #EFF5F7;
	
	}
	
	</style>
	

	
	
		<div id="leftNav">
        	<ul>
			
				<?php
				
				$permissions = load_module_permissions("page_manager");
							
				if(isset($permissions['MANAGE']) && in_array($user_role,$permissions['MANAGE'])){ 
					
						
					if( in_array("en",$languages)){ ?>
						<li><a href="/page_manager/index/en/">Content (English)</a></li><?php
						
					}
					
					if( in_array("fr",$languages)){ ?>
					<li><a href="/page_manager/index/fr/">Content (French)</a></li>
					
					<?php 
					
					} 
					
									
				}
				
				?>
				
				<li class="spacer">&nbsp;</li>

				<?php
				
				if(isset($navsections['content'])){
				
					// sort the nav items by name alphabetically 
					usort($navsections['content'], "subarraycomp");
					
				
					foreach($navsections['content'] as $navsectionmoduledata ){
					
						// get the module permissions to determine if we can show it here
						$permissions = load_module_permissions($navsectionmoduledata['dirname']);
						
						// INITIALIZE
						$permarray = array();
						
						
						// WE ARE USING A MULTITUDE OF OPTIONS HERE BECAUSE OF INCONSISTANCIES IN THE CONFIG FILES
						if(isset($permissions['ACCESSIBLE']) && is_array($permissions['ACCESSIBLE'])) $permarray =  $permissions['ACCESSIBLE'];
						if(isset($permissions['MANAGE']) && is_array($permissions['MANAGE'])) $permarray =  $permissions['MANAGE'];
						if(isset($permissions['CAN_ADMIN']) && is_array($permissions['CAN_ADMIN'])) $permarray =  $permissions['CAN_ADMIN'];
						
															
						if(in_array($user_role,$permarray)){ 
						
						
							if($navsectionmoduledata['active']){
						
								echo "<li ";
							
								if($this->router->class == $navsectionmoduledata['dirname']) echo " class=\"active_lmenu\" "; 
	
								echo "><a href=\"/{$navsectionmoduledata['url']}/\">{$navsectionmoduledata['name']}</a></li>";
						
							}
						
						}
					}
					
				}
				
				?>
						
		<li class="spacer">&nbsp;</li>
				<?php
				

			

				
				
				if(isset($navsections['custom'])){
				
					// sort the nav items by name alphabetically 
					usort($navsections['custom'], "subarraycomp");
					
				
					foreach($navsections['custom'] as $navsectionmoduledata ){
					
						// get the module permissions to determine if we can show it here
						$permissions = load_module_permissions($navsectionmoduledata['dirname']);
						
						// INITIALIZE
						$permarray = array();
						
						
						// WE ARE USING A MULTITUDE OF OPTIONS HERE BECAUSE OF INCONSISTANCIES IN THE CONFIG FILES
						if(isset($permissions['ACCESSIBLE']) && is_array($permissions['ACCESSIBLE'])) $permarray =  $permissions['ACCESSIBLE'];
						if(isset($permissions['MANAGE']) && is_array($permissions['MANAGE'])) $permarray =  $permissions['MANAGE'];
						if(isset($permissions['CAN_ADMIN']) && is_array($permissions['CAN_ADMIN'])) $permarray =  $permissions['CAN_ADMIN'];
						
					
				
											
						if(in_array($user_role,$permarray)){ 
						
					
							if($navsectionmoduledata['active']){
								echo "<li ";
							
								if($this->router->class == $navsectionmoduledata['dirname']) echo " class=\"active_lmenu\" "; 
							
								echo "><a href=\"/{$navsectionmoduledata['url']}/\">{$navsectionmoduledata['name']}</a></li>";
							}
						}
					
					}
					
				}
				
				?>

						
				
				<li class="spacer">&nbsp;</li>
				
				
		
				

				
				<?php
				
				if(isset($navsections['core'])){
		
					//print_r($navsections['core']);
					
		
					// sort the nav items by name alphabetically 
					usort($navsections['core'], "subarraycomp");
				
					foreach($navsections['core'] as $navsectionmoduledata ){
					
											// get the module permissions to determine if we can show it here
						$permissions = load_module_permissions($navsectionmoduledata['dirname']);
						
						// INITIALIZE
						$permarray = array();
						
						
						// WE ARE USING A MULTITUDE OF OPTIONS HERE BECAUSE OF INCONSISTANCIES IN THE CONFIG FILES
						if(isset($permissions['ACCESSIBLE']) && is_array($permissions['ACCESSIBLE'])) $permarray =  $permissions['ACCESSIBLE'];
						if(isset($permissions['MANAGE']) && is_array($permissions['MANAGE'])) $permarray =  $permissions['MANAGE'];
						if(isset($permissions['CAN_ADMIN']) && is_array($permissions['CAN_ADMIN'])) $permarray =  $permissions['CAN_ADMIN'];
						
					
				
						// user role 1 is assumed to be an administrator					
						if($user_role == 1 || in_array($user_role,$permarray)){ 
											
					
							if(
							($navsectionmoduledata['active'] || $navsectionmoduledata['dirname'] == "module_manager")
							&& $navsectionmoduledata['dirname'] != "page_manager"
							){
							
								echo "<li ";
							
								if($this->router->class == $navsectionmoduledata['dirname']) echo " class=\"active_lmenu\" "; 
														
								echo "><a href=\"/{$navsectionmoduledata['url']}/\">{$navsectionmoduledata['name']}</a></li>";
							}
						
						}
					
					}
					
				}
				
				?>
				
				<li class="spacer">&nbsp;</li>

            </ul>
			
			

			
				
		</div>
		

		
<?php

/**
* used to sort arrays alphabetically by sub items
*
*/
function subarraycomp($a, $b) {
	if ($a['name'] == $b['name']) {
		return 0;
	}
	return ($a['name'] < $b['name']) ? -1 : 1;
}
			
			