<?php

class mAdminContent extends MY_Model{

	public $content_table;
	public $archive_table; 
	public $alt_language;

	
	/**
	* get the base item
	*
	*/	
	public function getbaserootid(){

		$root_id = null;
				
		
		// first get the lowest id - rhis it the root parent
		$sql = "SELECT MIN(node_parent) AS base_node FROM {$this->db->dbprefix}content_nodes WHERE node_id > 1";
		
		$query = $this->db->query($sql);
				
		if ($query->num_rows() > 0) $root_id =  $query->row()->base_node;
				
				
		return $root_id;
		
	}
	

	
	
	/**
	* get the base item
	*
	*/	
	public function getbaseparents(){

		$returnarray = array();
		
		$root_id =  $this->getbaserootid();
		
		$sql = "SELECT CO_ID, CO_seoTitle FROM {$this->db->dbprefix}contentdrafts_en ORDER BY CO_ID ASC LIMIT 1";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			$row = $query->row();
			
			$returnarray[]['CO_ID'] =  $row->CO_ID;
			$returnarray[]['CO_seoTitle'] =  $row->CO_seoTitle;
			
			
		}
		
		return $returnarray;
		
	}
	
	/**
	* remove content from the list
	*
	*/
	public function deletecontent($node_id){

		
		//$site_settings = $this->site_settings_model->get_settings();
		
		
		$lang_avail = $this->config->item('lang_avail');
		
		
		foreach($lang_avail AS $langcode=>$language){ 
		
			$content_table = "{$this->db->dbprefix}content_" . $langcode;
			$draft_table = "{$this->db->dbprefix}contentdrafts_" . $langcode;
			$archives_table = "{$this->db->dbprefix}contentarchives_" . $langcode;
			
			$this->db->delete($content_table, array('CO_Node' => $node_id)); 
			$this->db->delete($draft_table, array('CO_Node' => $node_id)); 
			$this->db->delete($archives_table, array('CO_Node' => $node_id)); 
			
			
		}
		
		/*
		
		if($site_settings['homepage_fr_id'] != ""){
			
			$content_table = "{$this->db->dbprefix}content_" . "fr";
			$draft_table = "{$this->db->dbprefix}contentdrafts_" . "fr";
			$archives_table = "{$this->db->dbprefix}contentarchives_" . "fr";
			
			$this->db->delete($content_table, array('CO_Node' => $node_id)); 
			$this->db->delete($draft_table, array('CO_Node' => $node_id)); 
			$this->db->delete($archives_table, array('CO_Node' => $node_id)); 
			
		}
		if($site_settings['homepage_en_id'] != ""){
			
			$content_table = "{$this->db->dbprefix}content_" . "en";
			$draft_table = "{$this->db->dbprefix}contentdrafts_" . "en";
			$archives_table = "{$this->db->dbprefix}contentarchives_" . "en";
			
			$this->db->delete($content_table, array('CO_Node' => $node_id)); 
			$this->db->delete($draft_table, array('CO_Node' => $node_id)); 
			$this->db->delete($archives_table, array('CO_Node' => $node_id)); 
			
		}
		
		*/
		

		
		$this->db->where('node_id', $node_id);
		$this->db->delete('content_nodes'); 
		
		
		
		
	}


	/**
	* save the content access rights 
	*
	*/
	public function set_content_rights($node_id,$content_rights){
		
		
		$this->db->delete('content_rights', array('node_id' => $node_id)); 

		$data = array();
		
		
		foreach($content_rights AS $role_id){
		
			$data[] = array('node_id' => $node_id, 'role_id' => $role_id);
			
		}
		
		$this->db->insert_batch('content_rights', $data); 
		
		//echo $this->db->last_query();
		
				

	}
	
	
		
	/**
	* determine if this page is accessible
	*
	*/
	public function get_content_rights($node_id){
		
		$return_array = array();
		$rights_array = array();
		
  		$query = $this->db->get_where('content_rights', array('node_id'=>$node_id));
		
		foreach ($query->result() as $row)
		{
			
			$rights_array[] = $row->role_id;
			
		}
		
		$anonymous_data = array( // the anonymous role does not exist in the roles table but is assigned as id value 0
			
			'role_id' => 0,
			'role_name' => 'Anonymous',
			'accessible' => (in_array(0,$rights_array)  ? 'Y' : 'N'),
			
		);
		
		$return_array[] = $anonymous_data;

		$sql = "SELECT roles.id, roles.name FROM {$this->db->dbprefix}user_roles";
		
  		$query = $this->db->get('user_roles');
		
		foreach ($query->result() as $row)
		{
			
			$row_data = array(
			
				'role_id' => $row->id,
				'role_name' => $row->name,
				'accessible' => (in_array($row->id,$rights_array)  ?  'Y' : 'N'),
			
			);
			
			$return_array[] = $row_data;
			

		}

		
		return $return_array;
		

		
	}
	
	
	/**
	* determine if this page is on the live site yet.
	*
	*/
	public function getcontentdata($item_id, $lang = 'en'){
		
		// check the draft table first. It content exits, use that for editing, otherwise get the live content
		
		$content_table = "{$this->db->dbprefix}content_" . $lang;
		$draft_table = "{$this->db->dbprefix}contentdrafts_" . $lang;
		
		$sql = "SELECT * FROM $draft_table WHERE CO_Node='{$item_id}'";
		
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			$dbtable = $draft_table;
			
		}else{
			
			$dbtable = $content_table;
		}

		
		
		$sql = "SELECT * FROM {$this->db->dbprefix}content_nodes JOIN ".$dbtable." ON {$this->db->dbprefix}content_nodes.node_id = {$dbtable}.CO_Node WHERE {$this->db->dbprefix}content_nodes.node_id='{$item_id}'";

		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
				
			$row = $query->row_array(); 
			
			// cleanup function for newly mirrored pages
			if($row['CO_seoTitle'] == "") $row['CO_seoTitle']= $this->db->get_where("content_en", array("CO_Node"=>$item_id))->row()->CO_seoTitle;
									
			return $row;
			
		}
				
		return null;
		

		
	}
	
	
	/**
	* prevents user from creating duplicate friendly urls. 
	* Adds a unique number to the end of duplicates
	* @param string url (original)
	* @param varchar(2) language
	* @param int node_id
	* @return string url
	*/
	public function get_unique_furl($url, $lang, $node_id = null){
	
		$table = $this->db->dbprefix . "content_" . $lang;
		
		$unique = FALSE;
		
		$i = 0;
		
		while(!$unique){
	
			$sql = "SELECT COUNT(*) AS numrecs FROM {$table} WHERE CO_Node != '{$node_id}' AND CO_Url = '{$url}' ";
				
			if( $this->db->query($sql)->row()->numrecs > 0 ){
			
				
				preg_match('/^([^\d]+)([\d]*?)$/', $url, $match);
				$url = $match[1];
				$number = $match[2] + 1;
				$url .= $number;
					
			}else{
			
				$unique = TRUE;
				break;
			
			}
			
			if($i > 100) break; // this is insurance
			$i++;
		
		}
			
		
		return $url;
	
	
	
	}
	
	
	
	
	
	/**
	* determine if this page is on the live site yet.
	*
	*/
	public function is_published($node_id, $lang = 'en'){

		$is_published = FALSE; 
		
		$content_table = "{$this->db->dbprefix}content_" . $lang;
		
		$sql = "SELECT CO_Node FROM ".$content_table." WHERE CO_Node='{$node_id}' AND CO_Active = '1'";

		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			$is_published = TRUE; 
			
		}
		
		return $is_published;
		
		
	}
	
	/**
	* add content to the system as a new record. This will create a new node in the nodes table
	*
	*/
	public function savedraft($lang,$node_id,$content_data){
		
		$draft_table = "{$this->db->dbprefix}contentdrafts_" . $lang;
		
		$content_fieldnames = array(
		'CO_Node'
		,'CO_seoTitle'
		,'CO_seoDesc'
		,'CO_seoKeywords'
		,'CO_MenuTitle'
		,'CO_Url'
		,'CO_Body'
		,'CO_MobileBody'
		,'CO_Template'
		,'CO_MobileTemplate'
		,'CO_WhenModified'
		,'CO_ModifiedBy'
		,'CO_Searchable'
		,'CO_Public'
		,'prevpage'
		,'nextpage'		
		,'CO_Javascript'
		,'CO_CSS'
		,'CO_MobileJavascript'
		,'CO_MobileCSS'
		,'CO_Color'
		,'CO_externalLink'
		
		);
		
		
		foreach($content_fieldnames as $val){
			
			if(isset($content_data[$val]))  $data[$val] = $content_data[$val];
			else $data[$val] = "";
			
		}
		
	
		
		if($data['CO_Searchable'] == "") $data['CO_Searchable'] = 0;
		
		
		$sql = "SELECT * FROM {$draft_table} WHERE CO_Node = '{$node_id}'";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			$this->db->where('CO_Node', $node_id);
			
			$this->db->update($draft_table, $data);

			//echo $this->db->last_query();
			
			
		}else{
			

			$this->db->insert($draft_table, $data);			
			
		}
		
		//echo $this->db->last_query();
		
		
		
	}
	
	
	
	public function savearchive($page_id, $lang = 'en'){
		
		
		if($page_id == "") return;
		
		$content_table = "{$this->db->dbprefix}content_" . $lang;
		$archive_table = "{$this->db->dbprefix}contentarchives_" . $lang;
		
		
		// purge olderarchives out to limit to 10
		$sql = "SELECT * FROM $archive_table WHERE CO_Node = '{$page_id}' ORDER BY id DESC;";
		
		$query = $this->db->query($sql);
		
		$count = 0;
		
		foreach ($query->result() as $row)
		{
			if($count > 9) $this->db->query("DELETE FROM $archive_table WHERE id = '{$row->id}'");
			$count ++;
		}
		
		
		// get the content from the currently live page and archive it.
		$sql = "SELECT * FROM $content_table WHERE CO_Node = '{$page_id}';";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			
			
			$row = $query->row();

			$sql = "INSERT INTO {$this->db->dbprefix}contentarchives_{$lang} (";
			$sql .= "CO_ID";
			$sql .= ",CO_Node";
			$sql .= ",CO_seoTitle";
			$sql .= ",CO_seoDesc";
			$sql .= ",CO_seoKeywords";
			$sql .= ",CO_MenuTitle";
			$sql .= ",CO_Body";
			$sql .= ",CO_MobileBody";
			$sql .= ",CO_Template";
			$sql .= ",CO_MobileTemplate";
			$sql .= ",prevpage";
			$sql .= ",nextpage";
			$sql .= ",CO_Javascript";
			$sql .= ",CO_CSS";
			$sql .= ",CO_MobileJavascript";
			$sql .= ",CO_MobileCSS";
			$sql .= ",CO_externalLink";
			$sql .= ",CO_ModifiedBy";
			$sql .= ",date";
			
			$sql .= ") VALUES (";
			$sql .= "'{$row->CO_ID}'";
			$sql .= ",'{$row->CO_Node}'";
			$sql .= ",'" . addslashes($row->CO_seoTitle) . "'";
			$sql .= ",'" . addslashes($row->CO_seoDesc) . "'";
			$sql .= ",'" . addslashes($row->CO_seoKeywords) . "'";
			$sql .= ",'" . addslashes($row->CO_MenuTitle) . "'";
			$sql .= ",'" . addslashes($row->CO_Body) . "'";
			$sql .= ",'" . addslashes($row->CO_MobileBody) . "'";
			$sql .= ",'{$row->CO_Template}'";
			$sql .= ",'{$row->CO_MobileTemplate}'";
			$sql .= ",'{$row->prevpage}'";
			$sql .= ",'{$row->nextpage}'";
			$sql .= ",'" . addslashes($row->CO_Javascript) . "'";
			$sql .= ",'" . addslashes($row->CO_CSS) . "'";
			$sql .= ",'" . addslashes($row->CO_MobileJavascript) . "'";
			$sql .= ",'" . addslashes($row->CO_MobileCSS) . "'";
			$sql .= ",'{$row->CO_externalLink}'";
			$sql .= ",'{$row->CO_ModifiedBy}'";
			$sql .= ",NOW()";
			$sql .= ")";
					
			$this->db->query($sql);
		
		}		
		
	}
	
	
	/**
	*
	*
	*/
	public function getarchivelist($page_id,$lang){
		
		$this->set_archive_table($lang);
		
		$return_array = array();
		
		// purge olderarchives out to limit to 10
		$sql = "SELECT * FROM {$this->archive_table} WHERE CO_Node = '{$page_id}' ORDER BY id DESC;";
		
		$query = $this->db->query($sql);
		
		$count = 0;
		
		foreach ($query->result() as $row)
		{
			$return_array["id_" . $row->id] = array("node"=>$row->CO_Node,"date"=>$row->date);
		}
		
		return $return_array;
		
	}
	
	
	/**
	*
	*
	*/
	public function restore_archive($id,$lang){
		
		
		$this->set_archive_table($lang);
		$this->set_content_table($lang);
		
		$sql = "SELECT * FROM {$this->archive_table} WHERE id = '{$id}'";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			$archive_row = $query->row();
			
			$data = array(
			'CO_seoTitle' => $archive_row->CO_seoTitle,
			'CO_seoDesc' => $archive_row->CO_seoDesc,
			'CO_seoKeywords' => $archive_row->CO_seoKeywords,
			'CO_MenuTitle' => $archive_row->CO_MenuTitle,
			'CO_Template' => $archive_row->CO_Template,
			'CO_Body' => $archive_row->CO_Body,
			'CO_WhenModified' => $archive_row->CO_WhenModified,
			'CO_ModifiedBy' => $archive_row->CO_ModifiedBy,
			'CO_Javascript' => $archive_row->CO_Javascript,
			'CO_CSS' => $archive_row->CO_CSS,
			'CO_MobileJavascript' => $archive_row->CO_MobileJavascript,
			'CO_MobileCSS' => $archive_row->CO_MobileCSS,
			);
			
			
			$this->db->update("content_" . $lang, $data, array('CO_ID' => $archive_row->CO_ID));
			
			//echo $this->db->last_query(); 
			
			
			$sql = "DELETE FROM {$this->archive_table} WHERE id = '{$id}'";
			$this->db->query($sql);
			
			echo "OK";
			
			
		} 
		
		
	}
	
	
	
	public function set_archive_table($lang){
		
		$this->archive_table = "{$this->db->dbprefix}contentarchives_" . $lang;
		
	}
	
	public function set_content_table($lang){
		
		$this->content_table = "{$this->db->dbprefix}content_" . $lang;
		
	}
	
	
	
	
	/**
	* save content for an existing item
	*
	*/
	public function savecontent($content_data, $node_id = "", $parent = "", $lang = "en"){
		
		$draft_table = "{$this->db->dbprefix}contentdrafts_" . $lang;
		$content_table = "{$this->db->dbprefix}content_" . $lang;
		
	
		
		if($node_id == ""){
			
			// need to get the highest position for siblings if they exist
			$node_position = $this->get_new_node_position($parent);
			
			$node_data['node_position'] =  $node_position;
			$node_data['node_parent'] =  $parent;
			
			$this->db->insert("content_nodes",$node_data); 
			
			$content_data['CO_Node'] = $this->db->insert_id();
			
			$this->db->insert($content_table, $content_data); 
			
			$node_id = $content_data['CO_Node'];
			
			
			
			
		}else{
			
			
			
			$node_data['node_parent'] = $parent;
			
			$this->db->where('node_id',$node_id);
			$this->db->update("content_nodes",$node_data); 
			
			$this->db->where('CO_Node',$node_id);
			$this->db->update($content_table, $content_data); 
			
			//echo $this->db->last_query();
			
			
			$content_data['CO_Node'] = $node_id;
			
			
		}
		
		

		$this->db->where('CO_Node',$node_id);
		
		//echo $this->db->last_query();
		
		$this->db->delete($draft_table);
		


		
		$site_settings = $this->site_settings_model->get_settings();
		
		$languages = $this->config->item('lang_avail');
		
		foreach($languages AS $key => $val){
			
			if($lang != $key) $this->createstub($content_data, $key);
			
		}
		


		
		
		
		$content_data['title'] = $content_data["CO_seoTitle"];
		$content_data['content'] = $content_data["CO_Body"];
		
		$content_data['content_module'] = "page_manager";
		$content_data['content_id'] = $node_id; // this is a little off because we are using the node_id
		$content_data['lang'] = $lang;
		
		
		
		

		
		if($content_data["CO_Searchable"] == 1){
		
				
			// used for sitemap xml files
			$content_data['change_frequency'] = $this->input->post('change_frequency');	
			$content_data['priority'] = $this->input->post('search_priority');	
			$content_data['slug'] = $content_data["CO_Url"];
				
			
			$this->edittools->addsearchindex($content_data);
			
			//$content_data['tags'] = $tags;
			
			// the tag saving now happens as an event within the tags module
			//$this->edittools->write_tags($content_data);
			
			
		}else{
			
			$this->edittools->deletesearchindex($content_data);
			
			//$this->edittools->delink_tags($content_data);
			
			
			
		}
		
		
		return $node_id;
		
		
		
	}


	
	
	
	/**
	* if the page does not exits, create an empty one 
	* for use later on in the alternative language
	* 
	*/
	private function createstub($content_data, $lang){
		
		$draft_table = "{$this->db->dbprefix}contentdrafts_" . $lang;
		$content_table = "{$this->db->dbprefix}content_" . $lang;
		
		$sql = "SELECT * FROM $content_table WHERE CO_Node = '{$content_data['CO_Node']}'";
		
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 0){
			
			$sql = "INSERT INTO $content_table (";
			
			$sql .= "CO_Node ";
			$sql .= ",CO_seoTitle ";
			$sql .= ",CO_Active ";
			$sql .= ",CO_Color ";			
			$sql .= ",CO_Body ";
			$sql .= ",CO_MobileBody ";
			
			
			$sql .= ") VALUES (";
			
			$sql .= "'{$content_data['CO_Node']}' ";
			$sql .= ",'" . addslashes($content_data['CO_seoTitle']) . "' ";
			$sql .= ",'0' ";
			$sql .= ",'{$content_data['CO_Color']}' ";
			$sql .= ",'' ";
			$sql .= ",'' ";
			$sql .= ");";
			
			$this->db->query($sql);
			
			
		}
		
		
		
	} // end createstub
	

	
	/**
	*
	*/
	private function get_new_node_position($node_parent){
		

		$sql = "SELECT MAX(node_position) as maxpos FROM {$this->db->dbprefix}content_nodes WHERE node_parent = '{$node_parent}' "; 
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			return ($row->maxpos + 1);
			
		} 
		
		
		return FALSE;

	}
	
	
	/**
	* coped directly from widget_manager so this is duplicated code. Soooo bad!
	* returns a simple list of page that can be selected for this zone
	*
	*/
	public function getwidgetcollections(){
		
		
		$query = $this->db->get("widget_collections");
		
		$return_array = array("Select"=>"");
		

		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
				
				$return_array[$row->name] = $row->id;
				
			}
			
		}
		
		return $return_array;

	}
	
	
	public function setwidgetcollection($page_id, $widget_collection){
		
		$sql = "DELETE FROM {$this->db->dbprefix}widget_collection_assignments WHERE page_node = '{$page_id}'";
		$this->db->query($sql);
		
		if(is_numeric($widget_collection)){
			
			$sql = "INSERT INTO {$this->db->dbprefix}widget_collection_assignments SET page_node = '{$page_id}', widget_collection = '{$widget_collection}'";
			$this->db->query($sql);
			
		}
		
		
	}
	
	public function getassignedwidgetcollection($page_id){
		
		
		$query = $this->db->get_where('widget_collection_assignments', array('page_node' => $page_id));
		
		if ($query->num_rows() > 0){
			
			$row = $query->row();
			
			return $row->widget_collection;
			
		}
		
		return "";		
		
	}


	
	public function get_order_array($data){
		
		return $this->get_orderlist($data, "array");
		
		
	}
	
	
	
	public function get_orderlist($data, $return_format = ""){
			
		$lang = (isset($data['lang']) ? $data['lang']  : "en");
		$baserootid = (isset($data['baserootid']) ? $data['baserootid']  : 1);
		$keyword = (isset($data['keyword']) ? $data['keyword']  : "");
		$keyword_match_nodes = (isset($data['keyword_match_nodes']) ? $data['keyword_match_nodes']  : null);
		$pagemanager_listicons = (isset($data['pagemanager_listicons']) ? $data['pagemanager_listicons']  : null);
			
		$content_table = "{$this->db->dbprefix}content_" . $lang;
		$contentdrafts_table = "{$this->db->dbprefix}contentdrafts_" . $lang;
		

		
		$this->load->helper('content_orderlist');
		
		$this->load->library('adjacencytree');
		
		$this->adjacencytree->init();

		$this->adjacencytree->setdebug(FALSE);
		
		$this->adjacencytree->setidfield('node_id');
		$this->adjacencytree->setparentidfield('node_parent');
		$this->adjacencytree->setpositionfield('node_position');
		$this->adjacencytree->setdbtable("{$this->db->dbprefix}content_nodes");
		$this->adjacencytree->setDBConnectionID($this->db->conn_id);
		
		$this->adjacencytree->setjointable($content_table,"co_node", array("CO_MenuTitle","CO_seoTitle", "CO_Active", "CO_Public", "CO_Url", "CO_Color", "CO_WhenModified","CO_ModifiedBy","hits"));

		// additional table are connected using the LEFT JOIN METHOD
		$this->adjacencytree->set_additional_jointable($contentdrafts_table,"CO_Node", array("draft_id"));
		
	
		//$node = $this->adjacencytree->getFullNodesArray();
		
		$groups = $this->adjacencytree->getChildNodes($baserootid);
		
		
		if($return_format == "array"){
			return ordered_array($groups, $lang, $pagemanager_listicons, $keyword, $keyword_match_nodes );
		}else{
			return tabledorderlist($groups, $lang, $pagemanager_listicons, $keyword, $keyword_match_nodes );
		}
	}
	
	
} //end class