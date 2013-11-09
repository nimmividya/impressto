<?php

class site_settings_model extends CI_Model{

	private $options_table;
		
	
	
	public function __construct() 
	{
		parent::__construct();
		

		$this->options_table = $this->db->dbprefix . "options";

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
	
	
		//ps_savemoduleoptions("search",$data);


			
	}
	
	
	public function get_themes(){

		$return_array = array();
		
		//ps_savemoduleoptions("search",$data);
		// PROJECT FOLDER
		$project_theme_dir = APPPATH . PROJECTNUM . "/views/themes";
		$default_theme_dir = APPPATH . "/views/themes";

		if ($handle = opendir($project_theme_dir)) {
			

			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					if(is_dir($project_theme_dir . "/" . $entry)){
						$return_array[ucwords($entry)]= $entry;
					}
				}
			}

			closedir($handle);

			
		}
		
		
 		if ($handle = opendir($default_theme_dir)) {

			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					if(is_dir($default_theme_dir . "/" . $entry)){
						$return_array[ucwords($entry)]= $entry;
					}
				}
			}

			closedir($handle);

			
		}
		
		return $return_array;
		
			
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