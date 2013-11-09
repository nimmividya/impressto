<?php

/***
used for displaying adjacency lists in the content manager
@author - Galbraith Desmond
*/


/**
* loop throught the adjacency array to build a view
*/
function navbarorderlist($items) {
	
	global $group_indent, $Image_Color;
	
	$CI =& get_instance();
	

	
	$managegroupspageitems = '';

	if (count($items) && is_array($items)) {
		
		$group_indent ++;
		
		foreach ($items as $cat_id=>$catvals) {
		
	
			$has_childen = false;
			
			if(isset($catvals['children']) && count($catvals['children'])) { 
				$has_childen = true;
			}
			
			
			$code_indent = str_repeat("---",($group_indent-1)); // sanity saver for lowlife coders
			
			$managegroupspageitems .= "<option>$code_indent";
			
			$managegroupspageitems .=  "<a href=\"/" . $CI->language . "/";
			
			if($catvals['CO_Url'] != "") $managegroupspageitems .= $catvals['CO_Url'];
			else $managegroupspageitems .= $catvals['CO_Node'];
			
			$managegroupspageitems .= "\">\n";
	
			if($catvals['CO_MenuTitle'] != "") $managegroupspageitems .= $catvals['CO_MenuTitle'];
			else $managegroupspageitems .= $catvals['CO_seoTitle'];
			
			$managegroupspageitems .=  "</a>\n";
			
			
			
			if ($has_childen) {
			
				
							
				$managegroupspageitems .= "\n<option value=\"\">{$code_indent}{$code_indent}\n";
				
				$managegroupspageitems .= $code_indent . $code_indent . navbarorderlist($catvals['children']);
				
				$managegroupspageitems .= $code_indent . $code_indent . "</option>\n";
				
				
			}
			
			$managegroupspageitems .= "</option>\n";
			
			
			
		}
		
		$group_indent --;
		
		
	}


	
	return $managegroupspageitems;

}///////





/**
* loop throught the adjacency array to build a view
*/
function selectororderlist($items,$omit_ids) {
	
	global $group_indent;
	
	$returnoptions = array();

	if (count($items) && is_array($items)) {
		
		$group_indent ++;
		
		foreach ($items as $cat_id=>$catvals) {
		
			$skipthis = false;
		
			if(is_array($omit_ids) && in_array($cat_id,$omit_ids))$skipthis = true;
		
			if(!$skipthis){
			
				$indentint = $group_indent-2;
								
				if($indentint > 0) $code_indent = str_repeat("---",($group_indent-2)); // sanity saver for lowlife coders
				else $code_indent = "";
				
				$has_childen = false;
			
				if(isset($catvals['children']) && count($catvals['children'])) { 
					$has_childen = true;
				}
			
				$returnoptions["node_" . $cat_id] = "{$code_indent}" . $catvals['CO_MenuTitle'];   
			
				$returnoptions["node_" . $cat_id] = orderlist_truncate_text($returnoptions["node_" . $cat_id], 80);  
			
				$sub_array = array();
			
				if ($has_childen) {
					$sub_array = selectororderlist($catvals['children'],$omit_ids);
					$returnoptions = array_merge($returnoptions, $sub_array);
				
				}	
			
			}
			
		}
		
		$group_indent --;		
		
	}
	
	return $returnoptions;

}///////


function orderlist_truncate_text($text, $nbrChar, $append='...') {
     if(strlen($text) > $nbrChar) {
          $text = substr($text, 0, $nbrChar);
          $text .= $append;
     }
     return $text;
}



?>