<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class form_builder_model extends My_Model{

	
	public function __construct() 
	{

		parent::__construct();
		
	}
	
	/**
	*
	* simply read the sparks visual captcha image folder and return the names of the folders
	*
	*/
	public function get_visualcaptcha_themes(){
	
		$this->load->helper('directory_helper');
		
		$scourdir = ASSET_ROOT . "sparks/visualcaptcha/images";
		
		$diretory_map = directory_map($scourdir);
		
		$return_array = array();
		
		if(is_array($diretory_map)){
		
			foreach($diretory_map AS $key => $val){
				
				if(!is_numeric($key)) $return_array[] = $key;
				
			}
			
			return $return_array;
			
		}
		
		return FALSE;
		
		
	
	}

	/**
	*
	*
	*/
	public function save_new_form($form_name){
	
		$this->load->library('widget_utils');
			
				
		$data = array(
			'form_name' => $form_name,
			'updated' => date("Y-m-d h:i:s")

		);
		
		$this->db->insert('form_builder_forms', $data);
	
		$this->widget_utils->register_widget("form_builder","form_builder", $form_name);
			
				
	
	}
	

	/**
	*
	*
	*/
	public function check_form_name_duplicate($form_name){
	
				
		$query = $this->db->get_where('form_builder_forms', array('form_name' => $form_name));
		
		if ($query->num_rows() > 0){

			return TRUE;

		}
					
					
		
	
	}
	
	
	
	
	public function get_form_id_by_name($form_name){
	
	
		$sql = "SELECT id FROM {$this->db->dbprefix}form_builder_forms WHERE form_name = '{$form_name}'";
	
		$query = $this->db->query($sql);
		
		
		if($query && $query->num_rows() > 0){
				
			return $query->row()->id;
				
		}
		
		
	}
	
	
	/**
	*
	*
	*/	
	public function get_form_settings($form_id){
	
		$return_array = array();
		
		$query = $this->db->get_where('form_builder_forms', array('id' => $form_id));
		
		//echo $this->db->last_query();
		
		if($query && $query->num_rows() > 0){
				
			$return_array = $query->row_array(); 
				
		}
		
		$capt = print_r($return_array, TRUE);
		
		$data = array('form_settings' => $capt);
				
		Console::log($data);
		
		
		
		//print_r($return_array);
		
		
		return $return_array;

	}
	
	
	/**
	*
	*
	*/	
	public function save_form_settings($data){
		
		// purge the old setting before saving the new ones		
		//$this->db->delete('form_builder_settings', array('form_id' => $data['form_id'])); 

		
		$updatedata = array(
		
			'template' => $data['template'],
			'email_account' => $data['email_account'],
			'button_value' => $data['button_value'],
			'content' => $data['content'],
			'captcha' => $data['captcha'],
			'captcha_theme' => $data['captcha_theme'],
			'from_a' => $data['from_a'],
			'success_message' => $data['success_message'],
			'javascript' => $data['javascript'],
			'updated' => date('Y-m-d H:i:s')
						
			
		
		);

		//'form_id' => $data['form_id'],
		$this->db->where('id', $data['form_id']);
		
		$this->db->update('form_builder_forms', $updatedata); 
			
	
	}
	
	
	/**
	* 
	*
	*/
	public function delete_form($form_id){
	
		$this->db->delete('form_builder_forms', array('id' => $form_id)); 

		$query = $this->db->get_where('form_builder_form_fields', array('form_id' => $form_id));
		
		if($query && $query->num_rows() > 0){
			
			foreach ($query->result() as $row){
			
				$this->db->delete('form_builder_form_fields', array('form_id' => $row->field_id)); 
				$this->db->delete('form_builder_fields', array('form_id' => $row->field_id));
				
			}
			
			$this->widget_utils->un_register_widget("form_builder","form_builder", $form_name);
					
			
			
		}
		
				
	}
	
	
	/**
	*
	*
	*/
	public function get_form_list_data(){
	
		$return_array = array();
		
		
		$query = $this->db->get('form_builder_forms');
				
		if($query && $query->num_rows() > 0){
			
			foreach ($query->result_array() as $row){
			
				$return_array[] = $row;
				
			}
		
		
		}
		
		return $return_array;
		
	
	}
	
	
	public function get_active_fields($form_id){
		
		$return_array = array();
		
		$sql = "SELECT * FROM {$this->db->dbprefix}form_builder_form_fields AS FINDEX "
		. " LEFT JOIN {$this->db->dbprefix}form_builder_fields AS FIELDS "
		. " ON FINDEX.field_id = FIELDS.field_id "
		. " WHERE FINDEX.form_id = '{$form_id}' "
		. " ORDER BY FIELDS.position ASC";
				
		$query = $this->db->query($sql);
				
		if ($query->num_rows() > 0){
				
			foreach ($query->result_array() as $row){
						
						
				$return_array[] = $row;
			}
			
		}
				
		return $return_array;
		
	}
	
	
} //end class