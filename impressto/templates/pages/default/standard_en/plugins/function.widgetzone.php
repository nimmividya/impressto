<?php
/**
* Smarty plugin
* 
* @package Smarty
* @subpackage PluginsFunction
*/

/**
* Smarty widget function plugin
* 
* Type:     function<br>
* Name:     myApp WidgetZone plugin<br>
* Author:   Galbraith Desmond (Acart)<br>
* Date:     Jan 08, 2012<br>
* Purpose:  get widgets and render them in order<br>
* Examples: {widgetzone name='top'}
* <pre>
*/
function smarty_function_widgetzone($params, &$smarty)
{
	
	$CI =& get_instance();
	
	

	//$page_id = PS_PAGEID;

	if (defined('PS_PAGEID')) $page_id = PS_PAGEID;
		
	// for direct module calls we do not have a page ID, just the widget collection
	if (defined('PS_WCID'))  $widget_collection_id = PS_WCID;
	

	
	foreach($params as $key => $val){
		
		if(isset($params[$key])){
			
			$params[$key] = str_replace("\'","",trim($params[$key]));
			
		}
	}
	
	// get the list id from the {$CI->db->dbprefix}widget_lists table
	$sql = "SELECT id FROM {$CI->db->dbprefix}widget_zones WHERE name = '{$params['name']}'";
	$query1 = $CI->db->query($sql);
	
	
	if ($query1->num_rows() > 0){
		
		$row1 = $query1->row();
		$zone_id = $row1->id;

		if(isset($page_id)){
			// get the list id from the {$CI->db->dbprefix}widget_lists table
			$sql = "SELECT widget_collection FROM {$CI->db->dbprefix}widget_collection_assignments WHERE page_node = '{$page_id}'";

		}else if(isset($widget_collection_id)){
			// peterdrinnan - a somewhat pointless query but saves me from rewriting the whole function
			$sql = "SELECT widget_collection FROM {$CI->db->dbprefix}widget_collection_assignments WHERE widget_collection = '{$widget_collection_id}'";

		}
		
		$query2 = $CI->db->query($sql);
				
		if ($query2->num_rows() > 0){
		
			
			$row2 = $query2->row();
			$widget_collection_id = $row2->widget_collection;
			
			$sql = "SELECT {$CI->db->dbprefix}widgets.widget_id, {$CI->db->dbprefix}widgets.module, {$CI->db->dbprefix}widgets.widget, {$CI->db->dbprefix}widgets.instance, {$CI->db->dbprefix}widget_placements.id AS placement_id  FROM {$CI->db->dbprefix}widgets LEFT JOIN {$CI->db->dbprefix}widget_placements ON ";
			$sql .= " {$CI->db->dbprefix}widgets.widget_id = {$CI->db->dbprefix}widget_placements.widget_id WHERE {$CI->db->dbprefix}widget_placements.zone_id='{$zone_id}' ";
			$sql .= " AND {$CI->db->dbprefix}widget_placements.collection_id = '{$widget_collection_id}' ";
			$sql .= " ORDER BY {$CI->db->dbprefix}widget_placements.position";
			
			$query3 = $CI->db->query($sql);
			
			if ($query3->num_rows() > 0){
				
				foreach ($query3->result() as $row3){
				
				
					$addon_args = array();
					
					// little hack to add a first element that is tossed out later .. it is wierd but it has a reason
					$addon_args['nullkey'] = "nullval";
					
					$addon_args['widget_id']  = $row3->widget_id;
					
						
					
					// get anby options assigned to this widget placement and add them to the args		
					$sql = "SELECT * FROM {$CI->db->dbprefix}widget_placement_options ";
					$sql .= " WHERE placement_id='{$row3->placement_id}' ";
					
					$query4 = $CI->db->query($sql);
					
					if ($query4->num_rows() > 0){
						
						foreach ($query4->result() as $row4){

							$addon_args[$row4->name]  = $row4->value;
							
						}  
					}
					
					$addon_args['instance']  = $row3->instance;
					
					$widget = $row3->widget;
					
				
					
					if($row3->module != "") $widget = $row3->module . "/". $widget;
					
					// we just pass the names. no id
					//echo " IT BE $widget <br />";
					
									
					Widget::run($widget,$addon_args);
					
					
				}
				
			}
			
		}

	} 
}

?>