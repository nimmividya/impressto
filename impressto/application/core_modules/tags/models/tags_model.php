<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tags_model extends My_Model{

	
	/**
	* Read ALL tags from the tags table and return then as an array
	* @param module string - name of calling module
	* @param id int - if null return FALSE
	*/
	public function get_all_tags($lang, $content_module){
		
		$return_array = array();
		
		$tags_array = $this->_get_all_tags_array($lang, $content_module);
		
		foreach($tags_array AS $key=>$val){
		
			$return_array[] = $key;
					
		}
		
	
		return $return_array;
		
		
	}

	

	/**
	* Read tags from the tags table and return then as an simle array
	* @param module string - name of calling module
	* @param id int - if null return FALSE
	*/
	public function get_tags($lang, $content_module, $content_id = null){
		
		if(!$content_id) return FALSE;
		
		$return_array = array();
				
		$tags_array = $this->_get_all_tags_array($lang, $content_module, $content_id);
		
		foreach($tags_array AS $key=>$val){
		
			$return_array[] = $key;
					
		}
		
	
		return $return_array;
		
		
	}

	

	
	/**
	* Searches for any content that is linked to the specific tag	
	*
	* @todo - complete this function
	* @param tag string
	* @param module string - specifies a module to search for tags
	*/
	public function search_tags($tag, $module = null){
		
		if(!$id) return FALSE;
		
		$CI =& get_instance();
		
		
		
	}
	
	
	
		
	/**
	* Read tags from the tags table and return then as an array with the ids for each tag
	* @param module string - name of calling module
	* @param id int - if null return FALSE
	* @return array with string keys and int vals
	*/
	public function get_tags_array($lang, $content_module, $content_id = null){
		
		//if(!$content_id) return FALSE;
		
		$return_array = array();
		
		$tags_array = $this->_get_all_tags_array($lang, $content_module, $content_id);
		
		foreach($tags_array AS $key=>$val){
		
			$return_array[$key] = $val['id'];
					
		}
		
		return $return_array;
		
		
	}


	/**
	* Read ALL ags from the tags table and return then as an array with the ids for each tag
	* @param module string - name of calling module
	* @param id int - if null return FALSE
	*/
	private function _get_all_tags_array($lang, $content_module, $content_id = null){
		

		$return_array = array();
		
		$CI =& get_instance();
		
		
		$sql = "SELECT TAGS.id, TAGS.tag, TAGS.frequency FROM {$CI->db->dbprefix}searchtags_{$lang} AS TAGS LEFT JOIN ";
		$sql .= " {$CI->db->dbprefix}searchtags_bridge_{$lang} AS BRIDGE ON TAGS.id = BRIDGE.tag_id WHERE ";
		$sql .= " BRIDGE.content_module = '{$content_module}'";
		
		if($content_id) $sql .= " AND BRIDGE.content_id = '{$content_id}' ";
		
		
		$query = $CI->db->query($sql);
		
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result_array() as $row){
				
				$return_array[$row['tag']] = array("id"=>$row['id'],"frequency"=>$row['frequency']);
				
			}				
			
		}
		
		return $return_array;
		
		
	}
	
	
	
	
} //end class
