<?php

class xtra_content_model extends My_Model{
	


	public function __construct() 
	{

		parent::__construct();
		
		
	}
	




	/**
* save this record to the database
*
*/
	function save_content( $data ){
		
		
		$standard_tablename = "xtra_content_{$data['lang']}";			
		$mobile_tablename = "xtra_mobile_content_{$data['lang']}";
		
		
		$standard_data = $mobile_data = array();
		
		$fields = $this->get_table_fields("standard");
		
		if(count($fields) > 0){

			
			foreach($fields AS $fielddata){
				
			
				$standard_data[$fielddata["name"]] = stripslashes(trim($this->input->post("xtra_" . $fielddata["name"])));
				
				
			}
			
			
			$query = $this->db->get_where($standard_tablename, array("page_node" => $data['CO_Node']));
			
			if ($query->num_rows() > 0){	
				
				$this->db->where("page_node",$data['CO_Node'])->update($standard_tablename,$standard_data);
				
				
			}else{
				
				$standard_data['page_node'] = $data['CO_Node'];
				$this->db->insert($standard_tablename,$standard_data);
				
			}
			
		}
		

		$fields = $this->get_table_fields("mobile");
		
		if(count($fields) > 0){
			
			
			foreach($fields AS $fielddata){
				
				$mobile_data[$fielddata["name"]] = stripslashes(trim($this->input->post("xtra_mobile_" . $fielddata["name"])));
					
			}
			
			$query = $this->db->get_where($mobile_tablename, array("page_node" => $data['CO_Node']));
			
			if ($query->num_rows() > 0){	
				
				$this->db->where("page_node",$data['CO_Node'])->update($mobile_tablename,$mobile_data);
							
			}else{
				
				$mobile_data['page_node'] = $data['CO_Node'];
				$this->db->insert($mobile_tablename,$mobile_data);
				
			}
			
		}
		
		

	}
	
	

	/**
* delete record
*
*/
	function delete_content( $page_node ){

		// if we are deleting a page, loop through all the languages to 
		// remove all traces
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
			
			$standard_tablename = "xtra_content_{$langcode}";			
			$mobile_tablename = "xtra_mobile_content_{$langcode}";
			
			$this->db->delete($standard_tablename, array('page_node' => $page_node)); 
			$this->db->delete($mobile_tablename, array('page_node' => $page_node)); 
			
		}		
		
	}

	
	

	/**
	*
	*
	*/
	public function get_content( $data, $media = "all"){

		$CI =& get_instance();
		
		$CI->load->library('widget_utils');
		
		if($media == "desktop") $media = "standard";
		
		$return_data = array();
		

		
		if(isset($data['page_id'])) $page_id = $data['page_id'];
		else if(isset($data['CO_Node'])) $page_id = $data['CO_Node'];
		if(isset($data['contentdata']['CO_Node'])) $page_id = $data['contentdata']['CO_Node'];
		

		
		if($media == "all" || $media == "standard"){
			
			
			$fields = $this->get_table_fields("standard");
			
			foreach ($fields as $field_data){

				$return_data['xtra_mobile_' . $field_data['name']] = array("content"=>"","type"=>$field_data['type']);
								
			}
			
			$tablename = "xtra_content_{$data['content_lang']}";			
			
			$query = $this->db->get_where($tablename, array('page_node' => $page_id));
			
			
			if ($query->num_rows() > 0){
				
				$row = $query->row_array(); 
				
				foreach($fields as $field_data){
				
			
					$content = trim($CI->widget_utils->process_widgets($row[$field_data['name']]));
									
					$return_data['xtra_' . $field_data['name']] = array("content"=>$content,"type"=>$field_data['type']);
				}
				
			}
			
		}
		
		
		
		if($media == "all" || $media == "mobile"){
			
			$fields = $this->get_table_fields("mobile");
			
			foreach ($fields as $field_data){
				$return_data['xtra_mobile_' . $field_data['name']] = array("content"=>"","type"=>$field_data['type']);
			}
			
			$tablename = "xtra_mobile_content_{$data['content_lang']}";

			$query = $this->db->get_where($tablename, array('page_node' => $page_id));

			if ($query->num_rows() > 0){
				
				$row = $query->row_array(); 
				
				foreach($fields as $field_data){
				
							
					$content = trim($CI->widget_utils->process_widgets($row[$field_data['name']]));
						
					$return_data['xtra_mobile_' . $field_data['name']] = array("content"=>$content,"type"=>$field_data['type']);
				}
				
			}
			
			
		}
		
		return $return_data;
		
	}

	
	/**
	*
	*
	*/
	public function get_table_fields($media){
		
		
		$CI =& get_instance();
		
		
		$fieldnames = array();
		
		if($media == "desktop") $media == "standard";
		
		if($media == "standard") $tablename = "xtra_content_" . $this->config->item('lang_default');
		else if($media == "mobile") $tablename = "xtra_mobile_content_" . $this->config->item('lang_default');
		
		$fields = $this->db->field_data($tablename);
		
		foreach ($fields as $field){
			
			if($field->name != "id" && $field->name != "page_node"){
				$fieldnames[] = array("name"=>$field->name,"type"=>$field->type,"length"=>$field->max_length);
				
			}
			
		}
		
		
		return $fieldnames;
		
		
	}

	/**
	*
	*
	*/
	public function rename_field($old_field_name,$new_field_name,$media){
		
		$this->load->dbforge();
		
		$new_field_name = str_replace(" ","_",$new_field_name);
		$new_field_name = preg_replace("/[^A-Za-z0-9]_/", '', $new_field_name);
		
		if($media == "desktop") $media == "standard";
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
			
			if($media == "standard") $tablename = "xtra_content_{$langcode}";
			else if($media == "mobile") $tablename = "xtra_mobile_content_{$langcode}";
			
			$fields = $this->db->field_data($tablename);
		
			foreach ($fields as $field){
			
				if($field->name == $old_field_name){
					$type = $field->type;
					$length = $field->max_length;
					
					$fields = array(
						$old_field_name => array(
							'name' => $new_field_name,
							'type' => $type,
							'length' => $length,
						)
					);
			
					$this->dbforge->modify_column($tablename, $fields);
				
					break;
				
				}
			
			}
		
			
			
			
			
		}
		
			
	}
	

	/**
	*
	*
	*/
	public function add_field($field_name,$type,$length,$media){
		
		$this->load->dbforge();
		
		$field_name = str_replace(" ","_",$field_name);
		$field_name = preg_replace("/[^A-Za-z0-9]_/", '', $field_name);
		
		switch($type){

		case "text":
			
			$params = array(
			'type' => "TEXT",
			'null'  => FALSE
			);
			break;
			
			
		case "varchar_250":
			
			$params = array(
			'type'			=> 'varchar',
			'constraint'	=> 250,
			'default'		=> '',
			);
			break;
			
		case "int":
			
			$params = array(
			'type'			=> 'int',
			'constraint'	=> 12,
			'null'			=> FALSE,
			'default'		=> 0,
			);
			
			break;
			
			
		default:
			$params = array(
			'type' => "TEXT",
			'null'  => FALSE
			);
			
			
		}
		
		
		if($media == "desktop") $media == "standard";
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
			
			if($media == "standard") $tablename = "xtra_content_{$langcode}";
			else if($media == "mobile") $tablename = "xtra_mobile_content_{$langcode}";
			
			if (!$this->db->field_exists($field_name, $tablename)){
				
				$this->dbforge->add_column($tablename, array( $field_name => $params) );
				
			} 
			
			
			
		}
		
		
	}
	
	/**
	*
	*
	*/
	public function delete_field($field_name,$media){
		
		$this->load->dbforge();
		
		
		if($media == "desktop") $media == "standard";
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
			
			if($media == "standard") $tablename = "xtra_content_{$langcode}";
			else if($media == "mobile") $tablename = "xtra_mobile_content_{$langcode}";
			
			//$this->db->where()->delete($tablename);
			//$this->db->delete('mytable', array('id' => $id)); 
			
			$this->dbforge->drop_column($tablename, $field_name);
			
			
		}
		
		
	}




} //end class