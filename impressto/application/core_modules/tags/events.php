<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Events_Tags {

    protected $ci;

    protected $fallbacks = array();

    public function __construct()
    {
        $this->ci =& get_instance();
		
		$this->ci->load->model("tags/tags_model");
						
		
		Events::register('edit_content', array($this, 'get_tags'));
		Events::register('save_content', array($this, 'save_tags'));
		
		
		
    }


	
	/**
	* 
	* @package /modules/search
	*/
	public function get_tags( $data )
    {
        $CI =& get_instance();	
		
		$return_array = array();
		
		
		$content_module = $data['content_module']; 
		$content_id = $data['content_id']; 
		$lang = isset($data['lang']) ? $data['lang'] : "en"; 
		
		$tags = array();
		
		if($content_id){

			$tags = $CI->tags_model->get_tags($lang, $content_module,$content_id);
						
		}
		
	
		return $tags;
		
		
    }
	
	
	/**
	* 
	* @package /modules/search
	*/
	public function save_tags( $data )
    {
        $CI =& get_instance();
		
				
		$content_module = $data['content_module']; 
		$content_id = $data['content_id']; 
		$tags = $data['tags']; 
		$lang = isset($data['lang']) ? $data['lang'] : ""; 
		$delink_tags = isset($data['delink_tags']) ? $data['delink_tags'] : FALSE; 

	
		if($delink_tags){
			
			$this->_delink_tags($lang, $content_module, $content_id);
				
		}else{

			$this->_write_tags($lang, $tags, $content_id, $content_module);
			
		}
		
		
    }
	
	/**
	* Add tags to the tags table for the specified resource
	* 
	* sort of thinking this function belongs in the tags events file
	*
	* @param tags array
	* @param module string - name of calling module
	* @param id int - if null return FALSE
	*/
	private function _write_tags($lang, $tags, $content_id, $content_module){
		
	
		$CI =& get_instance();
		
		if(!is_array($tags)) $tags = array(); // just to stop php from complaining
		
		
		if(!isset($content_id) || !isset($lang) ) return FALSE;
		
		//echo " FLAGA ";
		
		// need to get all the tags that are currently associated with this content and remove the ones that no longer apply
		$current_tags = $CI->tags_model->get_tags_array($lang, $content_module,$content_id);
	
		
		$cleaned_tags_array = array();
		

		foreach($tags as $tag) $cleaned_tags_array[] = trim($tag);
		
		
		foreach($current_tags as $tag => $tag_id){
			
			if(!in_array($tag,$cleaned_tags_array)){
				
				$CI->db->where('tag_id', $tag_id);
				$CI->db->where('content_module', $content_module);
				$CI->db->where('content_id', $content_id);
				
				$query = $CI->db->delete('searchtags_bridge_' . $lang);
				
			}
			
		}
		
	
		foreach($cleaned_tags_array as $tag){
			
			$tag = trim($tag);
			
			if($tag == "") continue;
			
			
			$tag_existed = FALSE;
			// if the tag does not exists add it otherwise just get the tag id 
			$query = $CI->db->get_where('searchtags_' . $lang, array('tag' => strtolower($tag)) );
			
			if ($query->num_rows() > 0){
				
				
				$row = $query->row(); 
				
				$tag_id = $row->id;
				
				$tag_existed = TRUE;
				
			}else{
				
			
				$CI->db->insert('searchtags_' . $lang, array('tag' => strtolower($tag)));
				
				$tag_id = $CI->db->insert_id();
				
			} 

			// now we hava an ID we can make the relationship
			
			$bridgedata = array('tag_id' => $tag_id, 'content_module' => $content_module , 'content_id' => $content_id );
			
		
			if($tag_existed){ // this tag is not new so it may already be linked to this content
				
				
				$CI->db->where('tag_id', $tag_id);
				$CI->db->where('content_module', $content_module );
				$CI->db->where('content_id', $content_id );
				
				$query = $CI->db->get('searchtags_bridge_' . $lang);
				
				
				if ($query->num_rows() == 0){ // nothing found so lets addd it
					
					$CI->db->insert('searchtags_bridge_' . $lang, $bridgedata );
					
				}
				
			}else{
				
				// the tag did not exist so definitely we will add it
				$CI->db->insert('searchtags_bridge_' . $lang, $bridgedata );
				
			}
			
		
		}
		
		// now do a little cleanup
		$this->_purge_orphan_tags($lang);
		
		$this->_update_tag_counts($lang, $content_module);
					
		
	}
		
		
	/**
	* Removed the association of content to tags. Removed any tags that are orphaned
	*
	* @param content_type string
	* @param content_id int
	*
	*/
	private function _delink_tags($lang, $content_module, $content_id){

		//$this->_delink_tags($lang, $tags, $content_id, $content_module);
	

		$CI =& get_instance();
		
		$CI->db->where('content_module', $content_module);
		$CI->db->where('content_id', $content_id);
		$query = $CI->db->delete('searchtags_bridge_' . $lang);
			
		$this->_purge_orphan_tags($lang);

		//$this->_update_tag_counts($lang, $tag_id);
		
		
		
	}	
	
	
	/**
	* Removed the association of content to tags. Removed any tags that are orphaned
	*
	* @param content_type string
	* @param content_id int
	*
	*/
	private function _update_tag_counts($lang, $content_module){
	
		$CI =& get_instance();
		
		$tags = $CI->tags_model->get_tags_array($lang, $content_module);
		
		
		foreach($tags AS $tag => $tag_id){
						
			// get the frequency of any existing tags used for this module type
			$sql = "SELECT COUNT(*) AS numrecs FROM {$CI->db->dbprefix}searchtags_bridge_{$lang} WHERE tag_id ='{$tag_id}'";
			
			$frequency = $CI->db->query($sql)->row()->numrecs;
			
			$CI->db->where('id', $tag_id);
			$CI->db->update('searchtags_' . $lang, array('frequency' => $frequency ));
			
		}
		
			
	}
	
		
	/**
	* Clears any orphan tags
	*
	*/
	private function _purge_orphan_tags($lang){
		
		$CI =& get_instance();

		$query = $CI->db->get("searchtags_{$lang}");
		
		foreach ($query->result() as $row){
			
			$tag_id = $row->id;
			
			// now do a tag purge on anything that just got removed.
			$sql = "SELECT COUNT(*) as NumRecs FROM {$CI->db->dbprefix}searchtags_bridge_{$lang} WHERE tag_id = '{$tag_id}'";
			
			$query = $CI->db->query($sql);
			
			if ($query->num_rows() > 0){
				
				$row = $query->row();
				
				if($row->NumRecs == 0){
					
					
					$CI->db->where('id', $tag_id);
					$query = $CI->db->delete('searchtags_' . $lang);
								
					
				}		
				
			}
			
		}
	
		
	}
	
	

	
}
/* End of file events.php */