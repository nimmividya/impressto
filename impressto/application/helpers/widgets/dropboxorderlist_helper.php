<?php

/***
used for displaying adjacency lists in the dropbox view
@author - Galbraith Desmond
*/


/**
* loop throught the adjacency array to build a view
*/
function dropboxorderlist($items) {
	
	global $group_indent;
	
	$CI =& get_instance();
	
	
	$managegroupspageitems = '';

	if (count($items) && is_array($items)) {
		
		$group_indent ++;
		
		foreach ($items as $cat_id=>$catvals) {
			
			
			$has_childen = false;
			
			if(isset($catvals['children']) && count($catvals['children'])) { 
				$has_childen = true;
			}
			
			
			
			$code_indent = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",($group_indent-1)); // sanity saver for lowlife coders
			
			if($catvals['filename'] == ""){ // it is a folder
				
				$managegroupspageitems .= "<li>$code_indent<img src=\"" . ASSETURL . "/" . PROJECTNAME . "/default/core/images/actionicons/folder_expand.gif\" />";
				
			}else{
				
				$mimeicon = $CI->file_tools->GetMimeIcon($CI->file_tools->GetMimeCode($catvals['mimetype']));
									
				
				$managegroupspageitems .= "<li>$code_indent<img src=\"" . ASSETURL . "/" . PROJECTNAME . "/default/core/images/mimeicons/{$mimeicon}.gif\" />";
				
			}
			
			
			if($catvals['filename'] == ""){ // it is a folder
				
				$managegroupspageitems .=  "<span onclick=\"ps_dropbox.openfolder('{$cat_id}');\" ";
				
				$managegroupspageitems .= $catvals['filepath'].$catvals['filename'];
				
				$managegroupspageitems .= "\">\n";
				
				$managegroupspageitems .= dropbox_truncate_text($catvals['filepath'].$catvals['filename'], 40); 
				
				$managegroupspageitems .=  "</span>\n";
				
			}else{
				
				$managegroupspageitems .=  "<a target=\"_blank\" href=\"";
				
				//if($catvals['filepath'] != "") 
				
				$managegroupspageitems .= "/dropbox_connect/get_file/?filepath=" . urlencode($catvals['filepath']."/".$catvals['filename']);
				//else $managegroupspageitems .= $catvals['CO_Node'];
				
				$managegroupspageitems .= "\">\n";
				
				
				$managegroupspageitems .=   dropbox_truncate_text($catvals['filename'], 40); 
				
				$managegroupspageitems .=  "</a>\n";
				
			}
			
			
			
			
			
			if ($has_childen) {
				
				
				$subitems = $code_indent . $code_indent . dropboxorderlist($catvals['children']);
				
				if(trim($subitems) != ""){
					
					$managegroupspageitems .= $code_indent . $code_indent . "\n<ul id=\"dropbox_sublist_{$cat_id}\" style=\"display: none;\">\n"; //>\n";
					$managegroupspageitems .= trim($subitems);
					$managegroupspageitems .= $code_indent . $code_indent . "</ul>\n";
					
					
				}
				
				

				
				
				
				
			}
			
			$managegroupspageitems .= "</li>\n";
			
			//	}
			
			
			
			
		}
		
		$group_indent --;
		
		
	}


	
	return $managegroupspageitems;

}///////




/**
* need a unique function name here because of potential conflicts with other helpers
* 
*/
function dropbox_truncate_text($text, $nbrChar, $append='...') {
	if(strlen($text) > $nbrChar) {
		$text = substr($text, 0, $nbrChar);
		$text .= $append;
	}
	return $text;
}



?>