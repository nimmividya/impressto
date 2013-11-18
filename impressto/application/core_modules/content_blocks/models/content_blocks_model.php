<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class content_blocks_model extends My_Model{

	public $dbtable;

	public $dblangtables;
	
	public function __construct(){
		
		$this->dbtable = $this->db->dbprefix . "contentblocks";
		$this->widgetstable = $this->db->dbprefix . "widgets";

		$this->dblangtables = array();
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
		
			$this->dblangtables[$langcode] = "contentblocks_" . $langcode;
			
		}
	
		
	}
	

	/**
	* get all postings  
	*
	*/
	function getblocklist(){ 

		
		$return_array = array();
		
				
		$sql = "SELECT {$this->dbtable}.*, ";
		
		$dblangdeclares = $dblangjoins = array();
				
		foreach($this->dblangtables as $langcode => $dblangtable){
		
			$dblangdeclares[] = "{$this->db->dbprefix}{$dblangtable}.content AS content_{$langcode}";
			$dblangjoins[] = "LEFT JOIN {$this->db->dbprefix}{$dblangtable} ON {$this->dbtable}.id = {$this->db->dbprefix}{$dblangtable}.block_id ";
		}
		
		$sql .= implode(",",$dblangdeclares);
		$sql .= " FROM {$this->dbtable} ";
		
		$sql .= implode(" ",$dblangjoins);
		
		$sql .= " ORDER BY updated DESC ";
		
		//echo $sql;
		
	
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
			
				$slug = $this->get_slug($row->name);
			
				
				if($slug == ""){
					$slug = "widget type='content_blocks' name='{$row->name}'";
				}
						
				$phpslug = "&lt;" . "?php Widget::run('content_blocks', array('name'=>'{$row->name}')); ?" . "&gt;";
					
						
				
				$return_array[] = array("id"=>$row->id,"name"=>$row->name,'slug'=>$slug,'phpslug'=>$phpslug,"javascript"=>$row->javascript,"css"=>$row->css,"template"=>$row->template,"blockmobile"=>$row->blockmobile);
			}
			
			
		}
		
		return $return_array;
		

		
	}  
	
	
	/**
	*
	*
	*/	
	function getblockdata($block_id){  
		
	
		$return_array = array();
		
		$lang_avail = $this->config->item('lang_avail');
		
		
		$sql = "SELECT {$this->dbtable}.*, ";
		

		$dblangdeclares = $dblangjoins = array();
				
		foreach($this->dblangtables as $langcode => $dblangtable){
		
			$dblangdeclares[] = "{$this->db->dbprefix}{$dblangtable}.content AS content_{$langcode}";
			$dblangjoins[] = "LEFT JOIN {$this->db->dbprefix}{$dblangtable} ON {$this->dbtable}.id = {$this->db->dbprefix}{$dblangtable}.block_id ";
		}
		
		$sql .= implode(",",$dblangdeclares);

		$sql .= " FROM {$this->dbtable} ";
		
		$sql .= implode(" ",$dblangjoins);
		
		$sql .= " WHERE {$this->dbtable}.id = '{$block_id}' ";
		
		
		$query = $this->db->query($sql);
		
		//echo $sql . "\n";
		
		if ($query->num_rows() > 0){
			
			$row = $query->row_array(); 
			
			$return_array = array(
			"id"=>$row['id']
			,"name"=>$row['name']
			,"javascript"=>$row['javascript']
			,"css"=>$row['css']
			,"template"=>$row['template']
			,"blockmobile"=>$row['blockmobile']
			
			);
			

		 
			foreach($lang_avail AS $langcode=>$language){ 
		
				$return_array['content_'.$langcode] =  ($row['content_' . $langcode] == null) ? "" : $row['content_' . $langcode];
							
			}
			
		}
		
		return $return_array;
		

		
	}  
	
	public function saveblock($data){  
	
		
		$coredata = array(
		'name' => $data['name'],
		'javascript' => $data['javascript'],
		'css' => $data['css'],
		'template' => $data['template'],
		'blockmobile' => (isset($data['blockmobile']) && $data['blockmobile'] != "") ? 'Y' : 'N',
		'updated' => date('Y-m-d H:i:s')
		
		);

		
		$lang_avail = $this->config->item('lang_avail');

		 
		foreach($lang_avail AS $langcode=>$language){ 
		

			// here is a little hack to "save" the PHP 
			$data['content_'.$langcode] = str_replace("<?=","[?=",$data['content_'.$langcode]);
			$data['content_'.$langcode] = str_replace("<?php ","[? ",$data['content_'.$langcode]);
			$data['content_'.$langcode] = str_replace("?>","?]",$data['content_'.$langcode]);
		
			// now clean up the rest of it.
			if($this->input->post('purify_content')== "1"){
				$data['content_'.$langcode] = purify($data['content_'.$langcode]);
			}
				
		
			$data['content_'.$langcode] = str_replace("[?=","<?=",$data['content_'.$langcode]);
			$data['content_'.$langcode] = str_replace("[? ","<?php ",$data['content_'.$langcode]);
			$data['content_'.$langcode] = str_replace("?]","?>",$data['content_'.$langcode]);
		
			${'content_'.$langcode.'_data'} = array('content' => $data['content_'.$langcode]);

			
		}
		
			
		// if an instance name already exists, at a number to this one
		
		if($this->checkduplicateinstance($data)){
		
			return "error: duplicate instance name ";
		}
		
		// have to register this in the widget tables
		$this->load->library('widget_utils');
			
		
		if($data['block_id'] == ""){  // insert
			
			$this->db->insert($this->dbtable, $coredata); 
			
			$data['block_id'] = $this->db->insert_id();
			
			foreach($this->dblangtables as $langcode => $dblangtable){
		
							
				${'content_'.$langcode.'_data'}['block_id'] = $data['block_id'];
							
				$this->db->insert($dblangtable, ${'content_'.$langcode.'_data'});
					
			}
			
			$this->widget_utils->register_widget("content_blocks","content_blocks",$data['name']);
						
			
		}else{ // update
		
			// before doing anything we need to get the original instance name
			
			$olddata = $this->getblockdata($data['block_id']);
									
			
			$this->db->where('id', $data['block_id']);
			$this->db->update($this->dbtable, $coredata);
			
			
			foreach($this->dblangtables as $langcode => $dblangtable){
							
				if(  $this->db->get_where($dblangtable, array('block_id' => $data['block_id']))->num_rows() == 0  ){
				
					${'content_'.$langcode.'_data'}['block_id'] = $data['block_id'];
					$this->db->insert($dblangtable, ${'content_'.$langcode.'_data'});
					
				}else{
				
					$this->db->where('block_id', $data['block_id']);
					$this->db->update($dblangtable, ${'content_'.$langcode.'_data'});
				
				}
						
			}
			
						
			$this->widget_utils->register_widget("content_blocks","content_blocks",$olddata['name'], $data['name']);
						
			

		}

		
	}  
	
	
	
	private function checkduplicateinstance($data){
	
		$sql = "SELECT name FROM {$this->dbtable} WHERE name = '{$data['name']}' AND id != '{$data['block_id']}' ";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			return true;
			
			
		}
		
		return false;
	
	}
	
	
	/**
	*
	*
	*/	
	function deleteblock($id){  
		
		$instance_name = $this->getinstancename($id);
		
		$this->db->delete($this->dbtable, array('id' => $id)); 
		
		$tables = array();
				
		foreach($this->dblangtables as $langcode => $dblangtable){
			
			$tables[] = $dblangtable;
		
		}
		

		$this->db->where('block_id', $id);
		$this->db->delete($tables);
		
		$this->load->library('widget_utils');
		
		$this->widget_utils->un_register_widget("content_blocks","content_blocks",$instance_name);
		
		
		
	} 


	/**
	* simply retun the widget name matching the id
	*
	*/
	private function getinstancename($id){
		
		
		$sql = "SELECT name FROM {$this->dbtable} WHERE id = '{$id}' ";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			$row = $query->row(); 
			return $row->name;
			
		}
		
		return false;
		
	}
	
	/**
	*
	*
	*/	
	public function get_slug($instance){
	
				
		$query = $this->db->get_where('widgets', array('module' => 'content_blocks','widget' => 'content_blocks','instance' => $instance));
		
				
		if ($query->num_rows() > 0){
		
			$row = $query->row();
			
			return $row->slug;
		
		}
		
		return FALSE;
			
	}
	
	
	
	
} //end class











