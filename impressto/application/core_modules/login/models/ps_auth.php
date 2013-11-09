<?php

class ps_auth extends CI_Model {

	function validate()
	{
	
		// need to move this to the core ps_auth lib
		// because we will be offering alternative login methods
		// such as oauth, facebook and FluxBB.
		
		$username = trim($this->input->post('username'));
		
		if($username == "") return FALSE;
	
		$this->db->where('usr_username', $username);
		$query = $this->db->get("{$this->db->dbprefix}users");
		
		if($query->num_rows > 0){
		
			$row = $query->row(); 
		 
			$password = $this->encrypt->decode($row->usr_password);
						
			if($password == $this->input->post('password')){
				return $query;
			}else if($row->usr_password == md5($this->input->post('password'))){ // Wordpress style recovery method
				return $query;
			}
					
		}
		
		return FALSE;
						
		
	}
	
	function create_member()
	{
		
		$new_member_insert_data = array(
			'usr_first_name' => $this->input->post('first_name'),
			'usr_last_name' => $this->input->post('last_name'),
			'usr_email_address' => $this->input->post('email_address'),			
			'usr_username' => $this->input->post('username'),
			'usr_password' =>  $this->encrypt->encode($this->input->post('password'))						
		);
		
		$insert = $this->db->insert('users', $new_member_insert_data);
		return $insert;
	}
}