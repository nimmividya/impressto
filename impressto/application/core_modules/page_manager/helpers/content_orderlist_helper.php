<?php

/***
used for displaying adjacency lists in the content manager
@author - Galbraith Desmond
*/


/**
* loop throught the adjacency array to build a view
*/
function tabledorderlist($items, $lang, $pagemanager_listicons = null, $keyword = "", $keyword_match_nodes = null) {
	
	$CI =& get_instance();
	$CI->load->library("image_color");
	
	static $page_color, $text_color, $color_switch_nestlevel, $nestlevel, $bgcolors, $bgtxtcolors, $keyword_nodes;
	
	static $usernames;
	if(!$usernames) $usernames = array();
	
		
	
	
	if(!$nestlevel) $nestlevel = 0;	
	if(!$bgcolors) $bgcolors = array();
	if(!$bgtxtcolors) $bgtxtcolors = array();	
	
	if(!$keyword_match_nodes) $keyword_match_nodes = array();	
	if(!$keyword_nodes) $keyword_nodes = array();		
	
	$pageitems = '';
	

	if (count($items) && is_array($items)) {
		
		
		foreach ($items as $node_id=>$catvals) {

		
			$has_childen = false;
			
			if(isset($catvals['children']) && count($catvals['children'])) { 
				$has_childen = true;
			}
			
			
			if($nestlevel <= $color_switch_nestlevel){
				
				if( isset($bgcolors[$catvals['node_parent']])){ // we are back to where we were before we set a color	
					
					$page_color = $bgcolors[$catvals['node_parent']];
					$text_color = $bgtxtcolors[$catvals['node_parent']];
					
				}else{
					
					$page_color = null;
					$text_color = "000000";
					
				}
			}
			
			
			
			if($catvals['CO_Color'] != ""){
				
				$page_color = $catvals['CO_Color']; // this is the color that carries thru
				$bgcolors[$node_id] = $page_color;
				
				$text_color = $CI->image_color->getTextColor($page_color);
				$bgtxtcolors[$node_id] = $text_color;
				
				
				$color_switch_nestlevel = $nestlevel;
			}
			
			
			
			$published_css_tag = ($catvals['CO_Active'] == 1) ? "" : "_unpublished";
			
			if($published_css_tag == ""){
				$public_css_tag = ($catvals['CO_Public'] == 1) ? "" : "_notpublic";
			}else{
				$public_css_tag = "";
			}
			

			
			$code_indent = str_repeat(" ",($nestlevel)); // sanity saver for lowlife coders
			
			$pageitems .= "$code_indent<li ";
		
			$pageitems .= " id=\"item__{$node_id}\" ";
			
			$pageitems .= ">";
			
			$pageitems .= $code_indent;
			
			$pageitems .= $code_indent . "<div class=\"li\"";
			
			if($page_color != "") $pageitems .= " style=\"background:{$page_color};\" ";
			
			
			$pageitems .= ">\n";
			
			$pageitems .= $code_indent . "<div class=\"edit\" style=\"padding-top: 1px;\"";
			
			$pageitems .= " >\n";
			
						
			$pageitems .= "&nbsp;</div>\n";
			
			// get the name of whoever edited this page
			if(!isset( $usernames['user_' . $catvals['CO_ModifiedBy']] )){
			
				$user = $CI->mUsers->getById($catvals['CO_ModifiedBy']);
				
				if($user){
								
					//if( $user->first_name == "" || $user->last_name == "" ) 
					$usrname = $user->username;
					//else $usrname = $user->first_name . " " . $user->last_name;
									
					$usernames['user_' . $catvals['CO_ModifiedBy']] = $usrname;
				
				}else{
				
					$usernames['user_' . $catvals['CO_ModifiedBy']] = "unknown";
				
				}
						
			}

		
				
			$pageitems .= $code_indent . "<div class=\"author\" style=\"color: #{$text_color}\">";
			
			if($catvals['hits'] > 0) $pageitems .= "<span class=\"badge badge-success\">Hits: {$catvals['hits']}</span>";
			
			if($catvals['draft_id'] != "") 	$pageitems .= " <span class=\"badge badge-warning\">Draft</span>";
			
			if($catvals['CO_Active'] == 0) $pageitems .= "  <span class=\"label\">Inactive</span>";
			
			
			$pageitems .= "  <span class=\"badge badge-info\">Modified by {$usernames['user_' . $catvals['CO_ModifiedBy']]} - {$catvals['CO_WhenModified']}</span></div>\n";
			
			
			if ($has_childen) {
				$pageitems .= $code_indent . "	&nbsp;<img onclick=\"psctntmgr.psfoldertoggle('{$node_id}');\" alt=\"Page\" src=\"" . ASSETURL . PROJECTNAME . "/default/core/images/pageList_Closed.gif\" id=\"img_{$node_id}\"> \n";
			}else{
				$pageitems .= $code_indent . "&nbsp;<img alt=\"Page\" src=\"" . ASSETURL . PROJECTNAME . "/default/core/images/pageList_Page.gif\"> \n";
			}

			$pageitems .= $code_indent . "<a ";
			
		
			// allows us to attach the correct context menu to this item
			if ($has_childen)  	$pageitems .= " class=\"page_listitem\" ";
			else $pageitems .= " class=\"childless_page_listitem\" ";
				
			
			$pageitems .=  "slug=\"{$catvals['CO_Url']}\" id=\"page_anchor_{$node_id}\" title=\"Edit this page\" style=\"color: #{$text_color}\" class=\"editLink{$published_css_tag}{$public_css_tag}\" ";
			//$pageitems .=  "href=\"/page_manager/edit/{$lang}/{$node_id}\" ";
			$pageitems .=  "href=\"#\" ";			
			$pageitems .=  " >&nbsp;";

			if($catvals['CO_MenuTitle'] != "") $label = $catvals['CO_MenuTitle'];
			else $label = $catvals['CO_seoTitle'];
			
	
			
		

			$from_time= strtotime($catvals['CO_WhenModified']);
			$to_time = time();

			$minutesold = round(abs($to_time - $from_time) / 60,0). " minutes";
			
			if($minutesold < 30) $label .= " - modified " . $minutesold . " ago ";
			
			if(in_array($node_id,$keyword_match_nodes)){
			
				$label = "<strong style=\"padding:3px; color:#000000; background: yellow\">{$label}</strong>";
			
			}
			
			if(isset($pagemanager_listicons['page_' . $node_id])) $pageitems .= $pagemanager_listicons['page_' . $node_id];
			
			
			$pageitems .= $label;
			
			$pageitems .=  "</a></div>\n";
			
			
			if ($has_childen) {
				
				$nestlevel ++;
				
				$pageitems .= "\n<script type=\"text/javascript\">\n";
				
				$pageitems .= "$(function() {\n";
				$pageitems .= "   psctntmgr.setupsortable('{$node_id}');\n";
				$pageitems .= "});\n";
				
				$pageitems .= "</script>\n";
				
				
				$pageitems .= $code_indent . "\n<ul style=\"display: none;\" id=\"u_{$node_id}\" class=\"page_browser\">\n";
				
				$orderlist = tabledorderlist($catvals['children'], $lang, $pagemanager_listicons, $keyword, $keyword_match_nodes);
				
				$pageitems .= $code_indent . $orderlist['pageitems'];
				
				$pageitems .= "$code_indent</ul>\n";
				
				$nestlevel --;
				
				
				
			}
			
			$pageitems .= "  </li>\n";
			
		}
		
		
	}

	
	return array("pageitems" =>$pageitems,"keyword_nodes" => $keyword_nodes);
	

}///////


/**
* loop throught the adjacency array to build an ordered array
*/
function ordered_array($items, $omit_ids) {

	$CI =& get_instance();
	$CI->load->library("image_color");
	
	
	static $page_color, $text_color, $color_switch_nestlevel, $nestlevel, $bgtxtcolors, $bgcolors;
	
	if(!$nestlevel) $nestlevel = 0;	
	if(!$bgcolors) $bgcolors = array();
	if(!$bgtxtcolors) $bgtxtcolors = array();	
	
	$returnoptions = array();

	if (count($items) && is_array($items)) {
		

		foreach ($items as $node_id=>$catvals) {
			

			if($nestlevel <= $color_switch_nestlevel){
				if( isset($bgcolors[$catvals['node_parent']])){ // we are back to where we were before we set a color	
					
					$page_color = $bgcolors[$catvals['node_parent']];
					$text_color = $bgtxtcolors[$catvals['node_parent']];
					
				}else{
					
					$page_color = null;
					$text_color = null;
				}
			}
			
			if($catvals['CO_Color'] != ""){
				
				$page_color = $catvals['CO_Color']; // this is the color that carries thru
				$text_color = "#" . $CI->image_color->getTextColor($page_color);
				
				$bgcolors[$node_id] = $catvals['CO_Color'];
				$bgtxtcolors[$node_id] = $text_color;
				
				$color_switch_nestlevel = $nestlevel;
			}
			
			
			
			$skipthis = false;
			
			if(is_array($omit_ids) && in_array($node_id,$omit_ids))$skipthis = true;
			
			if(!$skipthis){
				
				
				if($nestlevel > 0) $code_indent = str_repeat("---",($nestlevel)); // sanity saver for lowlife coders
				else $code_indent = "";
				
				$has_childen = false;
				
				if(isset($catvals['children']) && count($catvals['children'])) { 
					$has_childen = true;
				}
				
				

				$label = $code_indent .  orderlist_truncate_text($catvals['CO_MenuTitle'], 80);
				
				$returnoptions[] = array(
				
				"id" => $node_id,
				"label"=> $label,
				"code_indent" => $code_indent,					
				"color" => $page_color,
				"text_color" => $text_color,
				"slug" => $catvals['CO_Url'],
				"last_modified" => $catvals['CO_WhenModified'],
					
			
				
				);
				
				

				
				$sub_array = array();
				
				if ($has_childen) {
					
					
					$nestlevel ++;
					
					$sub_array = ordered_array($catvals['children'],$omit_ids);
					$returnoptions = array_merge($returnoptions, $sub_array);
					
					$nestlevel --;
					
					
				}	
				
			}
			
		}
		

	}
	
	return $returnoptions;

}







/**
* loop throught the adjacency array to build a selection list
*/
function selectororderlist($items,$omit_ids) {

	$CI =& get_instance();
	$CI->load->library("image_color");
	
	
	static $page_color, $text_color, $color_switch_nestlevel, $nestlevel, $bgtxtcolors, $bgcolors;
	
	if(!$nestlevel) $nestlevel = 0;	
	if(!$bgcolors) $bgcolors = array();
	if(!$bgtxtcolors) $bgtxtcolors = array();	
	
	$returnoptions = array();

	if (count($items) && is_array($items)) {
		

		foreach ($items as $node_id=>$catvals) {
			

			if($nestlevel <= $color_switch_nestlevel){
				if( isset($bgcolors[$catvals['node_parent']])){ // we are back to where we were before we set a color	
					
					$page_color = $bgcolors[$catvals['node_parent']];
					$text_color = $bgtxtcolors[$catvals['node_parent']];
					
				}else{
					
					$page_color = null;
					$text_color = null;
				}
			}
			
			if($catvals['CO_Color'] != ""){
				
				$page_color = $catvals['CO_Color']; // this is the color that carries thru
				$text_color = "#" . $CI->image_color->getTextColor($page_color);
				
				$bgcolors[$node_id] = $catvals['CO_Color'];
				$bgtxtcolors[$node_id] = $text_color;
				
				$color_switch_nestlevel = $nestlevel;
			}
			
			
			
			$skipthis = false;
			
			if(is_array($omit_ids) && in_array($node_id,$omit_ids))$skipthis = true;
			
			if(!$skipthis){
				
				
				if($nestlevel > 0) $code_indent = str_repeat("---",($nestlevel)); // sanity saver for lowlife coders
				else $code_indent = "";
				
				$has_childen = false;
				
				if(isset($catvals['children']) && count($catvals['children'])) { 
					$has_childen = true;
				}
				
				

				$label = $code_indent .  orderlist_truncate_text($catvals['CO_MenuTitle'], 80);
				
				$returnoptions[] = array(
				
				"id" => $node_id,
				"label"=> $label,
				"code_indent" => $code_indent,					
				"color" => $page_color,
				"text_color" => $text_color,
				
				);
				
				

				
				$sub_array = array();
				
				if ($has_childen) {
					
					
					$nestlevel ++;
					
					$sub_array = selectororderlist($catvals['children'],$omit_ids);
					$returnoptions = array_merge($returnoptions, $sub_array);
					
					$nestlevel --;
					
					
				}	
				
			}
			
		}
		

	}
	
	return $returnoptions;

}



function orderlist_truncate_text($text, $nbrChar, $append='...') {

	if(strlen($text) > $nbrChar) {
		$text = substr($text, 0, $nbrChar);
		$text .= $append;
	}
	
	return $text;
	
}






