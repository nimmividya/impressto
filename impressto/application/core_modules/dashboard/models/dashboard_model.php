<?php

class dashboard_model extends My_Model{

	private $options_table;
		
	
	
	public function __construct() 
	{
		parent::__construct();
	
	}
	
	public function get_template($role_id){
		
		$row = $this->db->get_where('user_roles', array('id' => $role_id))->row(); 
		
		if($row) return $row->dashboard_template;
				
		return FALSE;
		
	}		
			
	public function get_page($role_id){
		
		$row = $this->db->get_where('user_roles', array('id' => $role_id))->row(); 
		
		//print_r($row);
		
		if($row) return $row->dashboard_page;
				
		return FALSE;
		
	}	
	
	
} //end class