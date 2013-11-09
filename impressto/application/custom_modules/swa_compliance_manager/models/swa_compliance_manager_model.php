<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class swa_compliance_manager_model extends My_Model{

	
	public function __construct() 
	{

		parent::__construct();
		
	}
	

	
	public function get_status($node_id, $lang){
	
	
		$row = null;
			
		$query = $this->db->get_where('clf_compliance',array('page_node' => $node_id, 'lang' => $lang));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array(); 
			
		}

		return $row;
	
	}
	
	
	public function get_compliance_ratings($lang){
	
	
		$rows = null;
			
		$query = $this->db->get_where('clf_compliance', array('lang'=>$lang));
						
		if ($query->num_rows() > 0){
		
			foreach ($query->result_array() as $row){
  
				$rows['page_' . $row['page_node']]= $row;
			
			} 

		}
		
		return $rows;
	
	}
	
	
	
	public function save_status($page_node, $data){
	
						
		$query = $this->db->get_where('clf_compliance',array('page_node'=> $page_node, 'lang' => $data['lang']));
				
		if ($query->num_rows() > 0)
		{
		
			$this->db->where('lang', $data['lang']);
			$this->db->where('page_node', $page_node);
			$this->db->update('clf_compliance', $data); 
		
		}else{
		
			$data['page_node'] = $page_node;
		
			$this->db->insert('clf_compliance', $data); 
		
		
		}
		
		//echo $this->db->last_query();
		
			
	
	}
	
	
	
	public function getfilepath($page_id,$lang='en'){
	
			$CI =& get_instance();
			
	
			$CI->load->library('adjacencytree');
			$CI->load->library('file_tools');
			$CI->load->helper('file_helper');
			
			$content_table = "{$CI->db->dbprefix}content_" . $lang;
		
			$CI->adjacencytree->setdebug(false);
		
		
			$CI->adjacencytree->setidfield('node_id');
			$CI->adjacencytree->setparentidfield('node_parent');
			$CI->adjacencytree->setpositionfield('node_position');
			$CI->adjacencytree->setdbtable("{$CI->db->dbprefix}content_nodes");
			$CI->adjacencytree->setDBConnectionID($CI->db->conn_id);
		
			$CI->adjacencytree->setjointable($content_table,"CO_node", array("CO_Node","CO_seoTitle"));
								
		
			$parent_nodes = $CI->adjacencytree->getParentsData($page_id);
			
		
			$dir_path = ASSET_ROOT . "upload/clf_compliance_manager/" . $lang;
			
			
			foreach($parent_nodes AS $nodevals){
			
				$dir_path .= "/" . strtolower($nodevals['CO_seoTitle']);
			
			}
			
			return $dir_path;
			
	
	}
	
	
	public function get_static_html( $data ) // we will update the data array
    {
	
		$CI =& get_instance();
				
		//add the path for the widgets module so we can locate the models	
		$CI->load->_add_module_paths('swa_compliance_manager');
		$CI->load->model('swa_compliance_manager_model');
			
		if(isset($data['contentdata'])){
		
			foreach($data['contentdata'] AS $key=>$val){
				$data[$key] = $val;
			}
		}
						
						
		
		if(isset($data['CO_Node']) && $data['CO_Node']){
			
			$target_file = $this->getfilepath($data['CO_Node'],$data['content_lang']) . "/" . $data['CO_seoTitle'] . ".html";
			
			//echo "target_file = $target_file ";
					
				
			if(file_exists($target_file)){
			
				$data['CO_Body'] = read_file($target_file);
				if(isset($data['contentdata'])) $data['contentdata']['CO_Body'] = $data['CO_Body'];
			
			}
			
		}

		return $data;
			
		
    }
	
	
	
} //end class