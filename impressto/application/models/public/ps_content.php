<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ps_content extends CI_Model{

	public $nodes_table; 	
	public $content_table; 
	public $contentarchives_table;
	

	public function __construct(){
	
		$this->nodes_table = $this->db->dbprefix . "content_nodes";
			
	}
	
	
	
	/**
	*
	*
	*/	
	public function get_site_settings(){
	
		
		$return_array = array();
		
		$sql = "SELECT * FROM {$this->db->dbprefix}options WHERE module='core'";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
				
				$return_array[$row->name] = $row->value;
			}
				
		}
		
	
		return $return_array;

		
	}
	
	
	/**
	* get the base item
	*
	*/	
	public function gethomepageid($lang='en'){
	
		$root_id = null;
		
			
		// first get the lowest id - rhis it the root parent
		$sql = "SELECT value FROM {$this->db->dbprefix}options WHERE name = 'homepage_{$lang}_id'";
				
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			$row = $query->row();
			$root_id =  $row->value;
				
		
		}
		
		// failsafe to 2nd node
		if(!$root_id){
		
			$sql = "SELECT CO_Node FROM {$this->content_table} ORDER BY CO_ID ASC LIMIT 2";
						
			$query = $this->db->query($sql);
		
			if ($query->num_rows() > 0){
			
				foreach ($query->result() as $row)
{
					//$row = $query->row();
					$root_id =  $row->CO_Node;
				}  
		
			}
		
		}
		
		return $root_id;
		
	}
	
	/**
	* alias call for getfriendlyurl function
	*
	*/
	public function getslug($node_id, $lang='en'){
	
		return $this->getfriendlyurl($node_id, $lang);
			
	}
		
	
	/**
	* Used for error free language toggling
	*
	*/	
	public function getfriendlyurl($node_id, $lang='en'){
	
		if($node_id > 0){
		
			$sql = "SELECT CO_Url FROM {$this->db->dbprefix}content_{$lang} WHERE CO_Node = '{$node_id}'";
			return $this->db->query($sql)->row()->CO_Url;
			
		}else{
			return "";
		}
			
	
	}
	
	
	
	
	public function set_content_table($content_table){
		$this->content_table = $content_table;
	}
	
	public function set_contentarchives_table($table){
		$this->contentarchives_table = $table;
	}
	
	public function set_contentdrafts_table($table){
		$this->contentdrafts_table = $table;
	}
	
	
	
	
	/**
	* get the base item
	*
	*/	
	public function getbaseparents(){

		$returnarray = array(); //'CO_ID'=>'','CO_seoTitle'=>'');
		
		$root_id =  $this->getbaserootid();
				
		$sql = "SELECT CO_ID, CO_seoTitle FROM {$this->content_table} ORDER BY CO_ID ASC LIMIT 1";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			$row = $query->row();
			
			$returnarray[]['CO_ID'] =  $row->CO_ID;
			$returnarray[]['CO_seoTitle'] =  $row->CO_seoTitle;
			
			
		}
		
		return $returnarray;
		
	}
	

	

	
	
	/**
	* get the page id of the archive being previewed
	*
	*/	
	public function get_archive_pageid($id){


		$sql = "SELECT CO_Node FROM {$this->contentarchives_table} WHERE id='{$id}'";
		$query = $this->db->query($sql);
	
		if ($query->num_rows() > 0){
			
			$row = $query->row();
			
			
			return $row->CO_Node;
			
		
		}
		
		return false;
		
		
	}
	
	
	
	public function get_page_rights($node_id){
		
		$rights_array = array();
		
  		$query = $this->db->get_where('content_rights', array('node_id'=>$node_id));
		
		foreach ($query->result() as $row)
		{
			
			$rights_array[] = $row->role_id;
			
		}
		
		
		
		return $rights_array;
		

		
	}
	
	
	
	
	
	/**
	* remove content from the list
	*
	*/
	public function deletecontent($item_id){

		
		$this->db->delete('contentdrafts_en', array('CO_ID' => $item_id)); 

		$this->db->delete('contentdrafts_fr', array('CO_ID' => $item_id)); 
		
		$this->db->delete('content_en', array('CO_ID' => $item_id)); 
		
		$this->db->delete('content_fr', array('CO_ID' => $item_id)); 
		
		
	}
	
	/**
	* return a friendly url page id
	*
	*/
	public function get_pageid_by_friendly_url($item_id){

		$sql = "select CO_Node from {$this->content_table} where CO_Url = '" . $item_id . "'";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			$row = $query->row();
			
			return $row->CO_Node;
				
		}
			
		return null;
		
		
	}
	
	
	
	
	
	/**
	* determine if this page is on the live site yet.
	*
	*/
	public function getcontentdata($node_id){
		
		// the reason we join here is because some plugins may need to know the parent of the page
				
 		$sql = "SELECT NODES.node_parent AS CO_Parent, CONTENT.* ";
			
		$sql .= ", USERS.username ";
		
		$sql .= " FROM {$this->nodes_table} AS NODES ";
		$sql .= " LEFT JOIN {$this->content_table} AS CONTENT ";
		$sql .= " ON NODES.node_id = CONTENT.CO_Node ";
		$sql .= " LEFT JOIN {$this->db->dbprefix}users AS USERS ";
		$sql .= " ON CONTENT.CO_ModifiedBy = USERS.id  ";		
		$sql .= " WHERE CONTENT.CO_Node='{$node_id}'";
		
				
		$query = $this->db->query($sql);
		
		
		if ($query->num_rows() > 0){
		
						
			$row = $query->result_array(); //

			return $row;
			
		} 
		
		return null;
		

		
	}
	
	
	/**
	* get the draft version of the page and return the live version if no draft exists
	*
	*/
	public function get_draftcontent_data($node_id){
		
		// the reason we join here is because some plugins may need to know the parent of the page
	
 		$sql = "SELECT NODES.node_parent AS CO_Parent, CONTENT.* FROM {$this->nodes_table} AS NODES ";
		$sql .= " LEFT JOIN {$this->contentdrafts_table} AS CONTENT ";
		$sql .= " ON NODES.node_id = CONTENT.CO_Node ";
		$sql .= " WHERE CONTENT.CO_Node='{$node_id}'";
				
		$query = $this->db->query($sql);
		
		
		if ($query->num_rows() > 0){
			
			$row = $query->result_array(); 
					
			return $row;
			
		}else{
		
			$sql = "SELECT NODES.node_parent AS CO_Parent, CONTENT.* FROM {$this->nodes_table} AS NODES ";
			$sql .= " LEFT JOIN {$this->content_table} AS CONTENT ";
			$sql .= " ON NODES.node_id = CONTENT.CO_Node ";
			$sql .= " WHERE CONTENT.CO_Node='{$node_id}'";
					
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0){
			
				$row = $query->result_array(); 
				
				return $row;
			}
					
		
		}
		
		
		return null;
		
		
	}
	
	
	
	
	/**
	* get the archived version of the page.
	*
	*/
	public function get_archivedcontent_data($node_id){
		
		// check if live version is active
				
		$sql = "SELECT NODES.node_parent AS CO_Parent, CONTENT.* FROM {$this->nodes_table} AS NODES ";
		$sql .= " LEFT JOIN {$this->contentarchives_table} AS CONTENT ";
		$sql .= " ON NODES.node_id = CONTENT.CO_Node ";
		$sql .= " WHERE CONTENT.id='{$node_id}'";
		
		
		$query = $this->db->query($sql);
		
		
		if ($query->num_rows() > 0){
			
			$row = $query->result_array(); 
					
			return $row;
			
		} 
		
		return null;
		
		
	}
	
	
	
	/**
	* determine if this page is on the live site yet.
	*
	*/
	public function is_published($item_id, $lang = 'en'){

		$is_published = FALSE; 
		
		$meLiveTable="{$this->db->dbprefix}content_" . $lang;
		
		$sql = "SELECT * FROM {$this->content_table} WHERE CO_ID='{$item_id}'";

		$result = mysql_query($sql);
		
		if($result){
			
			$row = mysql_fetch_array($result);
			
			if (isset($row["CO_ID"]))   $is_published = TRUE; 
			
		}
		
		
		return $is_published;
		
		
	}
	

	/**
	* Determine if the link if for a page, a module, a file or an external resource
	*
	*/
	public function find_alias($url){
	
		// do a little cleanup of the url
		$languages = $this->config->item('lang_avail');
						
		foreach($languages AS $key=>$val){
			$url = str_replace("/" . $key . "/","",$url);
		}


		$return_array = array(
		
			'module' => FALSE,
			'page' => FALSE,
			'extenal_link' => FALSE,
			
		);
		
		if( preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url) ) {

			$return_array['extenal_link'] = $url;
			return $return_array; // don't waste any nore time 
				
		}else if(pathinfo($url, PATHINFO_EXTENSION) != ""){
		
			$return_array['extenal_link'] = $url;
			return $return_array;
				
		}else{ // now we go heavy
		
			// first look for a friendly url
			// then look for 
			
			$query = $this->db->get_where("content_" . $this->config->item('lang_selected'),array("CO_Url"=>$url));
	
			
			if ($query->num_rows() > 0){
			
				$row = $query->row();

				$return_array['page'] = $row->CO_Node;
   			
				return $return_array;
						
			}else if(($pos = strrpos($url, '/')) != FALSE) { // no match found for the friendly url so now try a module
			
			
				$method = substr($url, $pos + 1);		
				$module = preg_replace("/^\//","", substr($url, 0, $pos) ); // strip the leading slash
				
				$return_array['module'] = $module . "/"  . $method;
   			
				return $return_array;
			
			}
	
		
		}
		
		
		
		return $return_array;
		
		
		
	
	
	}

	
	
	
} //end class