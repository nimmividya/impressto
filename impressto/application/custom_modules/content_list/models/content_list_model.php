<?php

class content_list_model extends CI_Model{



	public function getcontentlist_items($widget_id = null){
	
		$return_array = array();
		

		$sql = "SELECT * FROM {$this->db->dbprefix}content_list_items WHERE widget_id = '{$widget_id}' ORDER BY position ASC";
				
		$query = $this->db->query($sql);
			
		foreach ($query->result_array() as $row){
		
			 $return_array[] = $row;
			 			 
		}
		
		
		return $return_array;

	}
	
	
	public function get_list_item($item_id){
	
		return $this->db->get_where('content_list_items', array('id'=>$item_id))->row_array();
	
	
	}


	
	
} //end class