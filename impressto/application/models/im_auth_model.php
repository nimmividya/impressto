<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Im Auth Model
*
* Author:  Galbraith Desmond
* 		   peter@impressto.net
*/

class im_auth_model extends CI_Model {

	private $rootfieldnames = array();
	private $aliasedrootfieldnames = array();
		
	
	function __construct($config = array())
	{
			
		parent::__construct();
		
		
		$this->rootfieldnames = array(
			"id"=>"im_auth_id",
			"username"=>"im_auth_username",
			"email"=>"im_auth_email",
			"password"=>"im_auth_password",
			"activated"=>"im_auth_activated",
			"role"=>"im_auth_role",
			"user_group"=>"im_auth_user_group",
			"created"=>"im_auth_created",
			"last_login"=>"im_auth_last_login"		
		);
		
		$this->aliasedrootfieldnames = array();
		
		foreach($this->rootfieldnames AS $fieldname => $alias){
			$this->aliasedrootfieldnames[] = "users.{$fieldname} AS {$alias}";
		}
		
		
		
	}
	
	

	function validate()
	{
	
		// standard codeigniter encryption class
		$this->load->library('encrypt');
	
		$username = trim($this->input->post('username'));
		
		if($username == "") return FALSE;
		
		$this->db->select($this->config->item('profile_table') . '.*,' . implode(",",$this->aliasedrootfieldnames));
		
	
		
		$this->db->from('users');
		$this->db->join($this->config->item('profile_table'), "{$this->config->item('profile_table')}.{$this->config->item('profile_join_key')} = users.id","left");
		$this->db->where('users.username', $username);
		$query = $this->db->get();
	
		//echo $this->db->last_query();
				
		if($query->num_rows > 0){

			$row = $this->_resetAliasedUserFields($query->row_array());
			 
			$password = $this->encrypt->decode($row['password']);
						
			if($password == $this->input->post('password')){
				return $row;
			}else if($row['password'] == md5($this->input->post('password'))){ // Wordpress style recovery method
				return $row;
			}
					
		}
		
		return FALSE;
						
		
	}
	
	function create_member()
	{
		
		$new_member_insert_data = array(
			'email' => $this->input->post('email_address'),			
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

		$this->db->select($this->config->item('profile_table') . '.*,' . implode(",",$this->aliasedrootfieldnames));
						   
		$this->db->from('users');
		$this->db->join($this->config->item('profile_table'), "{$this->config->item('profile_table')}.{$this->config->item('profile_join_key')} = users.id");
		$this->db->where('users.id', $id);
		
		$query = $this->db->get();
		
		if($query->num_rows > 0){
		
			$row = $this->_resetAliasedUserFields($query->row_array());
			
			// we do not want to return the password ever
			unset($row['password']);
			
			return $row;
			
		}
		
		return FALSE;
	}
	
	/**
	*
	*
	*/
	private function _resetAliasedUserFields($row){

		// rename the aliasas to their true names
		foreach($this->rootfieldnames AS $fieldname => $alias){
		
			$row[$fieldname] = $row[$alias];
			unset($row[$alias]);
							
		}
		
		return $row;
			
	
	}
	
}