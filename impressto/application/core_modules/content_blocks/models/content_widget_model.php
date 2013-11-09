<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class content_widget_model extends My_Model{

	public $dbtable;
	public $active_content_table;
	public $dbprefix;
	
	
	public function __construct(){
		
		$site_lang = $this->config->item('lang_selected');
		
		$this->active_content_table = $this->db->dbprefix . "contentblocks_" . $site_lang;	
		
		$this->dbtable = $this->db->dbprefix . "contentblocks";
		
		$this->dbprefix = $this->db->dbprefix;
		
		
	}
	
	
	public function getwidgetdata($instance){
		

		$sql = "SELECT {$this->dbtable}.*, {$this->active_content_table}.* ";
		
		$sql .= " FROM {$this->dbtable} LEFT JOIN {$this->active_content_table} ON {$this->dbtable}.id = {$this->active_content_table}.block_id ";
		
		$sql .= " WHERE {$this->dbtable}.name = '{$instance}'";
		
		
		$query = $this->db->query($sql);
		
	

		
		if ($query->num_rows() > 0){
			
			$row = $query->row(); 
			
			$return_array = array(
			
			'name' => $row->name,
			'javascript' => $row->javascript,
			'css' => $row->css,
			'template' => $row->template,
			'blockmobile' => $row->blockmobile,
			'content' => $row->content
			);
			
			return $return_array;
			
			
			
			
		}
		
		
		

		
	}


	
	
	
	
} //end class