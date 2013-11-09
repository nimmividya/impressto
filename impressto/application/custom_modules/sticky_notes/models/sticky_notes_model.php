<?php

class sticky_notes_model extends My_Model{



	/**
	*
	*
	*/
	function generate_report_data(){
		
		$report_data = array();
		
		
		$sql = "SELECT * FROM {$this->db->dbprefix}stickynotes ORDER BY priority ASC, updated ASC";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{

			foreach ($query->result_array() as $row)
			{
				
				$row['page_title'] = "";
				
				// now get the page name
				$sql = "SELECT * FROM {$this->db->dbprefix}content_{$row['content_lang']} WHERE CO_Node = {$row['content_id']}";
				
				$query2 = $this->db->query($sql);
				
				if ($query2->num_rows() > 0){
					
					$row['page_title'] = $query2->row()->CO_seoTitle . " [{$row['content_lang']}]";
					$row['page_link'] = "/" . $row['content_lang'] . "/" . $query2->row()->CO_Url;
				}
				
				$row['update_stamp'] = date("Y/m/d h:i",strtotime($row['updated']));
				
				$report_data[] = $row;
				
			}
		}
		
		return $report_data;
		
		
	}
	
	
} //end class