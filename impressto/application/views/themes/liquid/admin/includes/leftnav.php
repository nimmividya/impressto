<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$languages = $this->config->item('languages');


$user_role = $this->session->userdata('role');  // this HAS TO come from the user session

//$current_module = "";

$this->load->helper('im_helper');
$module_list = get_modules();


$menusectionclosetags  = array('in' => '', 'active' => '');
$menusectionopentags  = array('in' => 'in', 'active' => 'sdb_h_active');


$menusection['content'] = $menusectionclosetags;
$menusection['assets'] = $menusectionclosetags;
$menusection['custom'] = $menusectionclosetags;
$menusection['module'] = $menusectionclosetags;
$menusection['widget'] = $menusectionclosetags;
$menusection['config'] = $menusectionclosetags;

$autosections = array(

'content' => array('icon' =>'icon-folder-close', 'menutrigger' => 'collapseOne'),
'assets' => array('icon' =>'icon-hdd', 'menutrigger' => 'collapseTwo'),
'module' => array('icon' =>'icon-th-large', 'menutrigger' => 'collapseThree'),
'widget' => array('icon' =>'icon-th', 'menutrigger' => 'collapseFour'),
'config' => array('icon' =>'icon-wrench', 'menutrigger' => 'collapseFive'),
);



$current_menu_section = $this->config->item('current_menu_section');

$menusection[$current_menu_section] = $menusectionopentags;

$navsections = array();

// osrt hte left menu items alpahbeticvally

foreach($module_list as $module_dirname => $module_data){

	$navsections[$module_data['admin_menu_section']][] = array("dirname"=>$module_dirname,"url"=>$module_data['url'],"name"=>$module_data['name'],"active"=>$module_data['active']);
	
}


?> 

<div id="side_accordion" class="accordion">


<?php


foreach($autosections AS $section => $sectionval){
	
	$listitems = "";
	
	if($section == "content"){
		
		$permissions = load_module_permissions("page_manager");
		
		if(isset($permissions['MANAGE']) && in_array($user_role,$permissions['MANAGE'])){ 
			
			$lang_avail = $this->config->item('lang_avail');
			
			foreach($lang_avail AS $langcode=>$language){ 
				
				$listitems .= "<li><a href=\"/page_manager/index/{$langcode}/\">Content (" . ucwords($language) . ")</a></li>\n";
				
			} 
			
		}
		
	}else{
		
		if(isset($navsections[$section])){
			
			// sort the nav items by name alphabetically 
			usort($navsections[$section], "subarraycomp");
			
			foreach($navsections[$section] as $navsectionmoduledata ){
				
				// get the module permissions to determine if we can show it here
				$permissions = load_module_permissions($navsectionmoduledata['dirname']);
				
				// INITIALIZE
				$permarray = array();
				
				// WE ARE USING A MULTITUDE OF OPTIONS HERE BECAUSE OF INCONSISTANCIES IN THE CONFIG FILES
				if(isset($permissions['ACCESSIBLE']) && is_array($permissions['ACCESSIBLE'])) $permarray =  $permissions['ACCESSIBLE'];
				if(isset($permissions['MANAGE']) && is_array($permissions['MANAGE'])) $permarray =  $permissions['MANAGE'];
				if(isset($permissions['CAN_ADMIN']) && is_array($permissions['CAN_ADMIN'])) $permarray =  $permissions['CAN_ADMIN'];
				
				
				if(($section == "config" && $user_role == 1) || in_array($user_role,$permarray)){ 
					
					if($navsectionmoduledata['active']){
						
						$listitems .= "<li ";
						
						if(	
							$this->router->class == $navsectionmoduledata['dirname']
							||
							$this->config->item('router_class') == $navsectionmoduledata['dirname']
						){


							$listitems .= " class=\"active_lmenu\" "; 
						}
						
						$listitems .= "><a href=\"/{$navsectionmoduledata['url']}/\">{$navsectionmoduledata['name']}</a></li>";
						
					}				
				}
			}
			
		}
		
	}
	
	if($listitems != ""){ ?>
		
		<div class="accordion-group">
		<div class="accordion-heading <?=$menusection[$section]['active']?>">
		<a href="#<?=$sectionval['menutrigger']?>" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
		<i class="<?=$sectionval['icon']?>"></i> <?php echo lang('leftnav_' . $section); ?>
		</a>
		</div>
		<div class="accordion-body <?=$menusection[$section]['in']?> collapse" id="<?=$sectionval['menutrigger']?>">
		<div class="accordion-inner">
		<ul class="nav nav-list">
		<?=$listitems?>
		</ul>
		</div>
		</div>
		</div>
		
		<?php
		
	}

	

}

?>


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


