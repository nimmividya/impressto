<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**
	*
	*
	*/
function showpostits($content_id, $lang) {

	$CI = & get_instance();

	$CI->load->helper('directory');
		
	//Console::log($datapath);
	
	$html = "";
		
	$admin = TRUE;
	
	$sql = "SELECT * FROM {$CI->db->dbprefix}stickynotes WHERE content_lang = '{$lang}' AND content_id = '{$content_id}'";
	
	$query = $CI->db->query($sql);
	
	$html .= "<div id=\"postit_container\">";
	
	if ($query->num_rows() > 0){
	
		foreach ($query->result() as $row){
		
			$data = array(
			"sticky_id" => $row->id,
			"content_id" => $row->content_id,
			"content_lang" => $row->content_lang,
			"message" => $row->message,
			"priority" => $row->priority,
			"user_id" =>  $row->user_id,
			"top_pos" => $row->top_pos,
			"left_pos" => $row->left_pos,	
	
			);
			
			$data['newsticky'] = FALSE;
			
			
			// now search the attachment folder to find and files that may bre associated with this sticky
			
				
			$sticky_folder_path = ASSET_ROOT . "upload/" . PROJECTNAME . "/sticky_notes/" . $row->id;
			$data['sticky_folder_url'] = ASSETURL . "upload/" . PROJECTNAME . "/sticky_notes/" . $row->id;
			
						
			$data['sticky_attachments'] = directory_map($sticky_folder_path, 1);
			
			if(!is_array($data['sticky_attachments'])) $data['sticky_attachments'] = array();
	
			
			$html .= $CI->load->view("sticky_notes/sticky_note", $data, TRUE);
			
		}
	}

	$html .= "<div id=\"sticky_report_container\">";
		
	$html .= "<img onclick=\"ps_stickies.hidestickyreport()\" style=\"float:right\" src=\"" . ASSETURL . PROJECTNAME . "/default/custom_modules/sticky_notes/img/close_page.gif\" />";
	
	$html .= "<div id=\"sticky_report_datawrap\"></div></div>";
	
	$html .= "</div>";
		
	return $html;
	
	
}


