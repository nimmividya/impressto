<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Im Auth Model
*
* Author:  Galbraith Desmond
* 		   peter@impressto.net
*/

class im_auth_model extends CI_Model {

	function validate()
	{
	
		// standard codeigniter encryption class
		$this->load->library('encrypt');
		
				
		// need to move this to the core ps_auth lib
		// because we will be offering alternative login methods
		// such as oauth, facebook and FluxBB.
		
		$username = trim($this->input->post('username'));
		
		if($username == "") return FALSE;
		
		$this->db->select(
			$this->config->item('profile_table') . '.*, 
			users.id AS im_auth_id, 
			users.username AS im_auth_username, 
			users.password AS im_auth_password, 
			users.email_address AS im_auth_email_address, 
			users.activated AS im_auth_activated, 
			users.role AS im_auth_role, 
			users.user_group AS im_auth_user_group, 
			users.created AS im_auth_created, 
			users.last_login AS im_auth_last_login'
		);
		
	
		//$this->db->where('username', $username);
		//$query = $this->db->get("{$this->db->dbprefix}users");
				
		$this->db->from('users');
		$this->db->join($this->config->item('profile_table'), "{$this->config->item('profile_table')}.{$this->config->item('profile_join_key')} = users.id","left");
		$this->db->where('users.username', $username);
		$query = $this->db->get();
		
				
		if($query->num_rows > 0){

		
		
			$row = $query->row(); 
			 
			$password = $this->encrypt->decode($row->im_auth_password);
						
			if($password == $this->input->post('password')){
				return $query;
			}else if($row->im_auth_password == md5($this->input->post('password'))){ // Wordpress style recovery method
				return $query;
			}
					
		}
		
		return FALSE;
						
		
	}
	
	function create_member()
	{
		
		$new_member_insert_data = array(
			//'first_name' => $this->input->post('first_name'), // these fields are no longer stored in the base table
			//'last_name' => $this->input->post('last_name'), // these fields are no longer stored in the base table
			'email_address' => $this->input->post('email_address'),			
			'username' => $this->input->post('username'),
			'password' =>  $this->encrypt->encode($this->input->post('password'))						
		);
		
		$insert = $this->db->insert('users', $new_member_insert_data);
		return $insert;
	}
	
	
	/**
	* returns the full profile record of the selected user by joining the
	* root user table with the appropriate user profile table
	*
	*/
	public function full_user_profile($id)
	{
		
		// Alter the names of the primary table fields to prevent conflicts with the joined tables.
		$this->db->select(
			$this->config->item('profile_table') . '.*, 
			users.id AS im_auth_id, 
			users.username AS im_auth_username, 
			users.email_address AS im_auth_email_address, 
			users.activated AS im_auth_activated, 
			users.role AS im_auth_role, 
			users.user_group AS im_auth_user_group, 
			users.created AS im_auth_created, 
			users.last_login AS im_auth_last_login'
		);
						   
		$this->db->from('users');
		$this->db->join($this->config->item('profile_table'), "{$this->config->item('profile_table')}.{$this->config->item('profile_join_key')} = users.id");
		$this->db->where('users.id', $id);

		$query = $this->db->get();

		if($query->num_rows > 0){
		
			$row = $query->row(); 

			return $row;
			
		
		}
		
		return FALSE;
	}
	
}