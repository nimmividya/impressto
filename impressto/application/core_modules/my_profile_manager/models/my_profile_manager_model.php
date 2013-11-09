<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class my_profile_manager_model extends My_Model{

	
	public function __construct() 
	{

		parent::__construct();
		
	}
	
	/**
	* save standard profile information plus and additional hooked data
	*
	*/
	public function save_profile_settings(){
		
		// this is goinf to be a bitch...
		
	}
	
	/**
	* retrieve standard profile information plus and additional hooked data 
	*
	*/
	public function get_profile_settings($profile_id){
		
		$sql = "SELECT users.*, roles.role_theme FROM {$this->db->dbprefix}users AS users ";
		$sql .= " LEFT JOIN {$this->db->dbprefix}user_roles AS roles ON users.role = roles.id ";
		$sql .= " WHERE users.id = '{$profile_id}'";
		
		$row = $this->db->query($sql)->row(); 
		
		if($row) return $row;
		
		return FALSE;
		
		
		
	}
	
	
	
	public function get_template($role_id){
		
		$row = $this->db->get_where('user_roles', array('id' => $role_id))->row(); 

		if($row) return $row->profile_template;
		
		return FALSE;
		
	}	
	

	
	
	
	
} //end class