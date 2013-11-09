<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bread_crumbs_model extends My_Model{

	
	public function __construct() 
	{

		parent::__construct();
		
	}
	
	public function get_trail($node_id,$lang='en'){
	
	
			$this->load->library('adjacencytree');
			
			$content_table = "{$this->db->dbprefix}content_" . $lang;
		
			$this->adjacencytree->setdebug(false);
		
		
			$this->adjacencytree->setidfield('node_id');
			$this->adjacencytree->setparentidfield('node_parent');
			$this->adjacencytree->setpositionfield('node_position');
			$this->adjacencytree->setdbtable("{$this->db->dbprefix}content_nodes");
			$this->adjacencytree->setDBConnectionID($this->db->conn_id);
		
			$this->adjacencytree->setjointable($content_table,"CO_node", array("CO_Node","CO_Url","CO_seoTitle","CO_MenuTitle")); //CO_MenuTitle ??
											
			$node_data = $this->adjacencytree->getNode($node_id);
			
			$parent_nodes = $this->adjacencytree->getParentsData($node_id);
			
			//echo "node_id = $node_id ";
			
			//print_r($parent_nodes);
			
			
			$return_array = array();
						
			if($node_data['CO_seoTitle'] != 0 && $node_data['CO_seoTitle'] != "") 
				$return_array[$node_data['CO_seoTitle']] = $node_data['CO_Url'];
			else
				$return_array[$node_data['CO_seoTitle']] = $node_data['CO_Url'];
		
				
				
			foreach($parent_nodes AS $nodevals){
				
				if($nodevals['CO_seoTitle'] != 0 && $nodevals['CO_seoTitle'] != "") $nodekey = $nodevals['CO_seoTitle'];
				else $nodekey = $nodevals['CO_seoTitle'];
				
				$return_array[$nodekey] = $nodevals['CO_Url'];
						
			}
			
			$return_array = array_reverse($return_array);
						
			return $return_array;
			
	
	}
	
	
} //end class