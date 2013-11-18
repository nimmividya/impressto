<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* generic backend functions. This is also used as a sandbox for functions before they
* are moved into the libraries folder
*
* @author		Galbraith Desmond <galbraithdesmond@gmail.com>
* @description generic backend functions
* @version		1.0.5 (2012-01-02)
*/





/**
* load the role list
* @author: Nimmitha Vidyathilaka
* @return array
*/
function load_defined_roles(){

	$CI =& get_instance();
	
	$return_array = array();
	
	$query = $CI->db->get('user_roles');
	
	if ($query->num_rows() > 0){
		
		foreach ($query->result_array() as $row){
			
			$return_array[$row['name']] = $row['id'];
			
			
		}
	}
	
	return $return_array;
	

}




/**
* load the role based permissions for the specified module
* @author: Nimmitha Vidyathilaka
*/
function load_module_permissions($module_id){

	$CI =& get_instance();
	
	$permissions_array = array();
	
	if(is_numeric($module_id)){
		
		$query = $CI->db->get_where('module_permissions', array('module_id' => $module_id));
		
	}else{
		
		$query = $CI->db->select('*')
			->from('module_permissions')
			->join('modules', 'module_permissions.module_id = modules.id')
			->where('modules.name = \''.$module_id.'\'')
			->get();
		
	}
	

	
	if ($query->num_rows() > 0){
		
		foreach ($query->result_array() as $row){
			
			$module_id = $row['module_id'];
			
			
			if(!isset($permissions_array[$row['action']])){
				
				$permissions_array[$row['action']] = array();
				
			}
			
			$permissions_array[$row['action']][] = $row['role'];
			
			
		}
		
	}

	
	
	$module_config = load_module_config($module_id);
	
	
	if(isset($module_config['module_roleactions']) && is_array($module_config['module_roleactions'])){
		
		foreach($module_config['module_roleactions'] AS $role_action => $role_action_description){

			
			// just add anything that may be missing
			if(! isset($permissions_array[$role_action])){
				
				$permissions_array[$role_action] = array("description"=>$role_action_description);
				
			}else{
				
				$permissions_array[$role_action]['description'] = $role_action_description;
			}
			
			
		}
		
	}
	
	
	return $permissions_array;


}



/**
* loads the correct config file for any called module
*
*/
function load_module_config($module_id){

	$CI =& get_instance();
	
	$return_array = array();
	
	
	$query = $CI->db->get_where('modules', array('id' => $module_id));
	
	
	if ($query->num_rows() > 0){
		
		$row = $query->row();
		
		$module_name = $row->name;
		
		$projectnum = $CI->config->item('projectnum');
		
		$modules_dirs = array(APPPATH.$projectnum."/modules",APPPATH."custom_modules",APPPATH."core_modules");
		
		foreach($modules_dirs as $module_dir){
			
			if(!file_exists($module_dir)) continue;
			
			$config_file = $module_dir . "/" . $module_name . "/config/config.php";
			
			
			$config = null;
			
			if (file_exists($config_file)){ 
				
				include($config_file);
				
				if (isset($config) && is_array($config)){	
					
					return $config;
					
				}						
				
				
			}
			
		}
	} 
	
	return FALSE;

	

}



/**
* get a list of all available widgets with priority
* of docket, custom and core
*
*/	
function get_widget_types(){
	
	$CI =& get_instance();
	
	$return_array = array();
	
	$return_array['Adhoc'] = "widgets";
	
	$projectnum = $CI->config->item('projectnum');
	
	$modules_dirs = array(APPPATH.$projectnum."/modules",APPPATH."custom_modules",APPPATH."core_modules");
	
	foreach($modules_dirs as $module_dir){
		
		if(!file_exists($module_dir)) continue;
		
		
		if ($handle = opendir($module_dir)) {
			
			while (false !== ($entry = readdir($handle))) {
				
				if($entry != "." && $entry != ".." && $entry != "index.html" && $entry != ".htaccess"){
					
					// now search inside the folder for widgets
					if(file_exists($module_dir . "/" . $entry . "/widgets")){
						
						$config_file = $module_dir . "/" . $entry . "/config/config.php";
						
						if (file_exists($config_file)){ 
							
							include($config_file);
							
							/* Check for the optional module_config and serialize if exists*/
							if (isset($config['module_config'])) 
							{	
								$config_params = $config['module_config'];
								
								if(isset($config_params['name'])){
									
									if (!array_key_exists($config_params['name'], $return_array)) {
										
										$return_array[$config_params['name']] = str_replace(APPPATH,"",$module_dir . "/" . $entry);
										
									}
									
									
								}
								
							}
						}
						
					}		
					
				}		
			}
			
			closedir($handle);
			
		}
		
	}
	
	return $return_array;

	
}


/**
*
*
*/
function ps_getmoduleoptions($module){


	$CI =& get_instance();
	
	$return_array = array();
	
	
	$sql = "SELECT * FROM {$CI->db->dbprefix}options WHERE module = '{$module}'";
	
	$query = $CI->db->query($sql);
	
	foreach ($query->result() as $row)
	{
		$return_array[$row->name] = $row->value;
		
	}
	
	return $return_array;
	
	
}



/**
* alias to the same function on the module_utils library
*
*/
function get_modules(){

	$CI =& get_instance();
	
	$CI->load->library('module_utils');
	
	return $CI->module_utils->get_modules();
	
	
}



/**
*
*
*/
function ps_savemoduleoptions($module, $options){


	$CI =& get_instance();
	
	$sql = "DELETE FROM {$CI->db->dbprefix}options WHERE module = '{$module}'";
	$CI->db->query($sql);
	
	
	$insertoptions = array();
	
	$data = array();
	
	
	foreach($options as $key => $val){
		
		$data[] = array('module' => $module,'name' => $key,'value' => $val);
		
	}
	
	$CI->db->insert_batch("{$CI->db->dbprefix}options", $data);
	
	//echo $CI->db->last_query();


}


/**
* solely serves the infobar in the manager interface
* @var string
*/
function getinfobarcontent($section, $sourcedoc = 'core_modules'){

	$CI =& get_instance();
	
	$CI->load->library('impressto');
	$CI->load->library('asset_loader');
	
	// load the infobar css file now
	$CI->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/themes/liquid/css/admin_help.css","","all");

	
	
	
	$prevdir = $CI->impressto->getDir();
	
	$helpdir = INSTALL_ROOT . "help/";
	
	$data['asset_url'] = ASSETURL;
	$data['appname'] = PROJECTNAME;
	
	
	$CI->impressto->setDir($helpdir);
	
	
	$sourcefile = $sourcedoc . ".tpl.php";
	
	
	$outbuf = $CI->impressto->showpartial($sourcefile,strtoupper($section),$data);
	
	// restore the directry
	if($prevdir != "") $CI->impressto->setDir($prevdir);
	
	return $outbuf;
	
	

}


/**
*
* loop throught the adjacency array to return an ordered 2d array
* 
* @param items array
* @param language string
* @return array
*/
function pagelinkselectorlist($items, $language, $use_ids = FALSE, $init = FALSE) {

	$CI =& get_instance();
	
	$CI->load->library("image_color");
	
	static $page_color, $text_color, $color_switch_nestlevel, $nestlevel, $bgcolors, $bgtxtcolors;

	
	if(!$nestlevel) $nestlevel = 0;	
	if(!$bgcolors) $bgcolors = array();
	if(!$bgtxtcolors) $bgtxtcolors = array();	
		
			
	static $return_array;
	
	if($init) $return_array = null;
	
	if(!$return_array) $return_array = array();
	
	
	
	if (count($items) && is_array($items)) {
		
		
		foreach ($items as $page_id=>$page_vals) {
		
		
			if($nestlevel <= $color_switch_nestlevel){
			
				if( isset($bgcolors[$page_vals['node_parent']])){ // we are back to where we were before we set a color	
					$page_color = $bgcolors[$page_vals['node_parent']];
					$text_color = $bgtxtcolors[$page_vals['node_parent']];
					
				}else{
				
					$page_color = null;
					$text_color = null;
					
				}
			}
			
			if($page_vals['CO_Color'] != ""){
			
				$page_color = $page_vals['CO_Color']; // this is the color that carries thru
				$bgcolors[$page_id] = $page_color;
				
				$text_color = "#" . $CI->image_color->getTextColor($page_color);
				$bgtxtcolors[$page_id] = $text_color;
				
				$color_switch_nestlevel = $nestlevel;
			}
			
			
			$has_childen = false;
			
			if(isset($page_vals['children']) && count($page_vals['children'])) { 
				$has_childen = true;
			}

			$code_indent = str_repeat("---",($nestlevel));
			
			$label = "";
			
			if($page_vals['CO_MenuTitle'] != "") $label = $page_vals['CO_MenuTitle'];
			else $label = $page_vals['CO_seoTitle'];
			
			
			$return_array[] = array(
			
				"id" => $page_id,
				"label" => $label,
				"code_indent" => $code_indent,				
				"link"  => "/" . $language . "/" . $page_vals['CO_Url'],
				"color" => $page_color,
				"text_color" => $text_color,
				
			);
				
						
			if ($has_childen){
			
				$nestlevel ++;
					
				pagelinkselectorlist($page_vals['children'], $language, $use_ids);
				
				$nestlevel --;
				
			}
			
		}
		

	}

	return $return_array;
	

}///////



function _im_helper_orderlist_truncate_text($text, $nbrChar, $append='...') {

	if(strlen($text) > $nbrChar) {
		$text = substr($text, 0, $nbrChar);
		$text .= $append;
	}
	return $text;
}



/**
* Returns a full pulldown selector for all pages in the system
*
*/
function get_ps_page_slector($data){

	$CI =& get_instance();
	
	$language = (isset($data['language']) ? $data['language']  : "en" );
	
	$use_ids = ( (isset($data['use_ids']) && $data['use_ids']) ? TRUE  : FALSE);
	
	
	if(!isset($data['usewrapper'])) $data['usewrapper']  = FALSE;
				

	$CI->load->library('adjacencytree');
	$CI->load->library('formelement');
	
	$content_table = "{$CI->db->dbprefix}content_" . $language;

		
	$CI->adjacencytree->init();
	$CI->adjacencytree->setdebug(FALSE);
	
	
	$CI->adjacencytree->setidfield('node_id');
	$CI->adjacencytree->setparentidfield('node_parent');
	$CI->adjacencytree->setpositionfield('node_position');
	$CI->adjacencytree->setdbtable("{$CI->db->dbprefix}content_nodes");
	$CI->adjacencytree->setDBConnectionID($CI->db->conn_id);
	
	$CI->adjacencytree->setjointable($content_table,"CO_node", array("CO_Node","CO_MenuTitle","CO_seoTitle","CO_Url","CO_Color"));
	
	$node = $CI->adjacencytree->getFullNodesArray();
	
	$baserootid = 1;
	
	$groups = $CI->adjacencytree->getChildNodes($baserootid);


	$orderlist = pagelinkselectorlist($groups, $language, $use_ids, TRUE);

	
	$nodes = array("Select"=>"");
	$colors = array("Select"=>"");
	$textcolors = array("Select"=>"");
	
	foreach($orderlist AS $node_data){
	
			$key = $node_data['code_indent'] . $node_data['label'];
			
			if($use_ids){
				$nodes[$key . " [{$node_data['id']}]"] = $node_data['id'];
			}else{
			
				// in case nobody set a furl for the page
				if($node_data['link'] == "" || $node_data['link'] == "/{$language}/"){ 
					$node_data['link'] = "/{$language}/{$node_data['id']}";
				}
					
				$nodes[$key . " [{$node_data['id']}]"] = $node_data['link'];
					
								
			}
			

			
			
			$colors[$key . " [{$node_data['id']}]"] = $node_data['color'];
			$textcolors[$key . " [{$node_data['id']}]"] = $node_data['text_color'];
			
		
	}
		
	
	$inputdata = array();
	
	$inputdata['name'] = $data['name'];
	$inputdata['type'] = 'select';
	$inputdata['showlabels'] = $data['showlabels'];
	$inputdata['id'] = $data['id'];
	$inputdata['label'] = $data['label'];
	$inputdata['onchange'] = $data['onchange'];
	$inputdata['colors'] = $colors;
	$inputdata['textcolors'] = $textcolors;		
	$inputdata['usewrapper'] = $data['usewrapper'];		
	
	if(isset($data['width'])) $inputdata['width'] = $data['width'];
		
	$inputdata['options'] = $nodes;
	$inputdata['value'] = $data['value'];
	
	
	return $CI->formelement->generate($inputdata);
	
	
	
}

