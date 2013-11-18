<?php

class mUsers extends CI_Model{

	public function getAll(){
	
			
		$sql = "SELECT id AS id, username AS username, password AS password,";
		$sql .= " email AS email, role AS role ";
		$sql .= " FROM {$this->db->dbprefix}users ORDER BY id ASC ";		
		
		$query = $this->db->query($sql);

		
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return array();
		}
	
	} //end getAll
	
	public function delete($id){
		 /*
		  * Any non-digit character will be excluded after passing $id
		  * from intval function. This is done for security reason.
		  */
		$id = intval($id);
		
		$this->db->delete("{$this->db->dbprefix}users", array( 'id' => $id ) );
	}
	
	public function getById($id){
	
		$id = intval ($id);
		
		$query = $this->db->where('id', $id)->limit(1)->get("{$this->db->dbprefix}users");
		
		if($query->num_rows() > 0){
			return $query->row();
		} else {
			return array();
		}
	}
	
	public function update(){
	
		$data = array(
			'username' => $this->input->post('username', true),
			'email_address' => $this->input->post('email_address', true),
			'role' => $this->input->post('urole', true)
		);
		
		$this->load->library('encrypt');
		
	
		if(trim($this->input->post('password')) != ""){
		
			$data['password'] = $this->encrypt->encode($this->input->post('password'));
						
		}
						
		$this->db->update( 'users', $data, array( 'id' => $this->input->post('id', true)));

		// TODO!!!
		// now save all the profile data
		// get all the fileds that are active for this user role
		
		// loop though them all and save any posted data...
		
				
	}
	
	public function create(){

		$this->load->library('encrypt');
		
		
		$data = array(
			//'first_name' => $this->input->post('cfirst_name', true),
			//'last_name' => $this->input->post('clast_name', true),
			'username' => $this->input->post('cusername', true),
			'email_address' => $this->input->post('cemail_address', true),
			'role' => $this->input->post('cuser_role', true)
						
		);
		

				
		if(trim($this->input->post('cpassword')) != ""){

			$data['password'] = $this->encrypt->encode($this->input->post('cpassword'));
						
		}
		
		
		$this->db->insert('users', $data);
	}
	
	
	/**
	* Simply read the field names from the standard and extended user field tables and return them as an array
	*
	*/
	public function get_all_fieldnames(){
	
		$return_array = array();
	
		$return_array["basic"] = array();
		$return_array["extended"] = array();
		
		
		$fields = $this->db->list_fields('users');
		
		foreach ($fields as $field)
		{
			$return_array["basic"][] = $field;
		} 
		
		$fields = $this->db->list_fields($this->config->item('profile_table'));
		
		foreach ($fields as $field)
		{
			$return_array["extended"][] = $field;
		} 
		

		return $return_array;
	
		
	
	}
	
	
	/**
	* Simply returns an array of all extended user fields
	*
	*/
	public function get_extended_user_fields(){


		$return_array = array("error"=>"");
		
		$query = $this->db->select('user_fields.id, user_fields.field_name, user_fields.input_type')
				->from('user_fields')
				->group_by("user_fields.id")
				->order_by("user_fields.position", "asc")
				->get();
				
		foreach ($query->result_array() as $row)
		{
			
			$return_array[$row['field_name']] = array("field_id"=>$row['id'],"selected"=>0);
		}

		return $return_array;
		
						
	
	}
	
	/**
	* Simply returns an array of all the priority fields 
	* These are fields that are shown in the main user list
	*
	*/
	public function get_priority_fields(){
			
		return array("Username","Email Address","Role","Group");
				
	}
		

	
	
	
	public function save_role($data){
	
	
		if ($data['id'] !== "") {
				
			$record = array( 
				'name'=>$data['name'],
				'description'=>$data['description'],
				'role_theme'=>$data['role_theme'],
				'profile_template'=>$data['profile_template'],
				'dashboard_template'=>$data['dashboard_template'],
				'dashboard_page'=>$data['dashboard_page'],
					
			);
			
			$query = $this->db->update('user_roles', $record, array('id'=>$data['id']));
			
		}else{
		
			$record = array( 
				'name'=>$data['name'],
				'description'=>$data['description'],
				'role_theme'=>$data['role_theme'],
				'profile_template'=>$data['profile_template'],
				'dashboard_template'=>$data['dashboard_template'],
				'dashboard_page'=>$data['dashboard_page'],
			);
			
			$query = $this->db->insert('user_roles', $record);
			
		}
		
		//	echo $this->db->last_query();
				
	
	
	}


		
	
	public function delete_role($id){
	
	
		$this->db->delete('user_roles', array('id' => $id)); 
		
	}
	
	
	

	/**
	* simly returns an array of all the roles
	*
	*/
	public function get_roles(){
	
		$return_array = array();
		
		$query = $this->db->get("user_roles");
		
		foreach ($query->result_array() as $row)
		{
			
			$return_array[$row['name']] = $row['id'];
		}

		return $return_array;
	
	}
	
	/**
	* returns a json striong with the role data
	*
	*/

	public function getroledata($id){
		
		$role_data = array("error"=>"");
		
		$query = $this->db->get_where('user_roles', array('id'=>$id), 1, 0);
		
		
	
		if($query->num_rows() > 0){
		
						
			$row = $query->row();
		
			$role_data['id'] = $row->id;
			$role_data['name']=$row->name;
			$role_data['description']=$row->description;
			$role_data['role_theme']=$row->role_theme;
			$role_data['profile_template']=$row->profile_template;			
			$role_data['dashboard_template']=$row->dashboard_template;
			$role_data['dashboard_page']=$row->dashboard_page;
			
			
		} else {
		
			$role_data['error']="no data";
			
			
		}
		
		return $role_data;
				
	
	} // end getroledata
	
	
	
	/**
	* retrieve standard profile information plus and additional hooked data 
	*
	*/
	public function get_profile_data($user_id){

		$return_array = array();
		
		
		$sql = "SELECT users.*, roles.name, roles.description FROM {$this->db->dbprefix}users AS users ";
		$sql .= " JOIN {$this->db->dbprefix}user_roles AS roles ON users.role = roles.id ";
		$sql .= " WHERE users.id = '{$user_id}'";

		
		$query = $this->db->query($sql);

		$role = null;
		
		if ($query->num_rows() > 0)
		{
			
			$row = $query->row_array();
			
			//Console::log($row);
			
			foreach ($row as $fieldname => $val){
				
				if($fieldname == "role") $role = $val;
				
				if($fieldname != "id" && $fieldname != "role"  && $fieldname != "password"){ // nobody can change their own id or role
					$return_array[$fieldname] = array("value"=>$val);
				}
			}
			
		
			$field_attribs = $this->get_profile_field_attribs($role);
			
			
			$sql = "SELECT * FROM {$this->db->dbprefix}{$this->config->item('profile_table')} WHERE user_id = '{$user_id}'";
			
			
			$query = $this->db->query($sql);

			if ($query->num_rows() > 0)
			{
				
				$row = $query->row_array(); 
				

				foreach ($row as $fieldname => $val)
				{
					
					if($fieldname != "id" && $fieldname != "id"){

						// we need to know the field type here.
						$field_options = null;
						
						if(isset($field_attribs[$fieldname]['field_options']) && is_array($field_attribs[$fieldname]['field_options']) ){
							
							$field_options = $field_attribs[$fieldname]['field_options'];
						
						}

						if(
								$field_attribs[$fieldname]['field_type'] == "multiselect"
								||
								$field_attribs[$fieldname]['field_type'] == "multicheck"
								||
								$field_attribs[$fieldname]['field_type'] == "multicheckbox"
								
								){
							
							// we also know the value is serialized so we will deserialize it
							$val = unserialize($val);
							
						}
						
						
						$return_array[$fieldname] = array("value"=>$val,"field_type"=>$field_attribs[$fieldname]['field_type'], "options"=>$field_options);
						
					}
					
				}
			}
			
			//Console::log($return_array);

		}
		
		return $return_array;
		
		
	}
	
	
	/**
	* retrieve a list of all user fields associated with a specific user role
	*
	*/
	public function get_profile_field_attribs($role_id){
	
		$return_array = array();
		
		$custom_user_field_names = $custom_user_fields_attribs = array();
		
		$standard_user_fields = $this->db->list_fields('users');
		
		
		foreach($standard_user_fields AS $val){

			$field_options = null;
			
			if($val != "role" && $val != "id" && $val != "password"){ // nobody can change their own role or id
				$return_array[$val] = array("extended"=>FALSE, "field_type"=>"text","field_options"=>$field_options);
			}
			
		}		
		
		
		//user data table name comes from the config 
		// we have a key and table
		$sql = "SELECT user_fields.* FROM {$this->db->dbprefix}user_fields AS user_fields ";
		$sql .= " JOIN {$this->db->dbprefix}user_role_fields AS user_role_fields ON user_fields.id = user_role_fields.field_id ";
		$sql .= " WHERE user_role_fields.role_id = '{$role_id}' ORDER BY user_fields.position";

		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			
			foreach ($query->result_array() as $row){
				
				$field_options = null;
				
				if(	
					$row['field_type'] == "radio" 
					|| $row['field_type'] == "dropdown"
					|| $row['field_type'] == "select"
				){
					
					$field_options = $this->_get_field_options($row['id']);
					
				}
				
				$return_array[$row['name']] = array("extended"=>TRUE,"field_type"=>$row['field_type'],"field_options"=>$field_options);
				
			}
			
		} 
		
		
		return $return_array;
		
		
	}
	
	
	
	
	/**
	* returns user field options for selected field ids
	*
	*/
	private function _get_field_options($field_id){
		
		$return_array = array();
		
		$query = $this->db->select('option_value, option_label')
			->from('user_field_options')
			->where('field_id', $field_id) 
			->order_by("position", "asc") 
			->get();
		
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){

				$return_array[$row->option_label] = $row->option_value;
				
			}
		} 
		
		return $return_array;
		
	}
	
	
} //end class