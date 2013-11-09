<?php

class dev_shed_model extends My_Model{

	private $options_table;
		
	
	
	public function __construct() 
	{
		parent::__construct();
		



	}
	
	
	/**
	* get the base item
	*
	*/	
	public function get_settings(){
	
		$return_array = array();
	
		
		$sql = "SELECT * FROM {$this->options_table} WHERE module = 'core' ";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
				
				$return_array[$row->name] = $row->value;
			}
				
		}
		
	
		return $return_array;

		
	}
	
	
	
	public function save_search_settings($data){
	
	
		ps_savemoduleoptions("search",$data);


			
	}
	
	
	public function save_settings($incoming_data){
	
		$sql = "DELETE FROM {$this->options_table} WHERE "; //option_name = ''";

		$incoming = array();
		
		foreach($incoming_data as $key =>$val){
			$incoming[] = "name = '{$key}'";
		}
		
		$sql .= implode(" OR ", $incoming);
		
		$this->db->query($sql);	
		
		
		$data = array();
		
		foreach($incoming_data as $key =>$val){
		
			$data['module'] = 'core';
			$data['name'] = $key;
			$data['value'] = $val;
		
			$this->db->insert('options',$data);
		
		}
		
		//echo $this->db->last_query();
		
		
			
	}
	
	/**
	*
	*
	*/
	public function potential_admin_list(){
		
		$return_array = array();
		
		$sql = "SELECT email_address FROM {$this->db->dbprefix}users WHERE role = '1'";
		
		$query = $this->db->query($sql);	

		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
				
				$return_array[$row->email_address] = $row->email_address;
			}
				
		}
		
	
		return $return_array;

	
	}
	
	
	
} //end class