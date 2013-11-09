<?php

class widget_manager_model extends My_Model{


	/**
	* insert a new set of widget rows into the table
	*

	function getwidgetlist(){

		$sql = "SELECT * FROM {$this->tablename} WHERE widget_name = '{$widget_name}'";
		
		$query = $this->db->query($sql);
		
			
		if ($query->num_rows() == 0){
			
			$position = 0;
			
			$sql = "INSERT INTO {$this->tablename} (title, widget_name, slide_img, position) values ('slide_1','{$widget_name}','','0');";
			$this->db->query($sql);

		}
		
	}
	*/	
	

	
	public function get_active_widgets(){
		
		$return_array = array();
		
		// do a quick scan of the widgets and DOCKET/widgets forlders to find adhoc widgets
		
		
		$sql = "SELECT * FROM {$this->db->dbprefix}widgets ORDER BY module, widget, instance ASC";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
				
				$return_array[] = array("id"=>$row->widget_id,"module"=>$row->module,"widget"=>$row->widget,"instance"=>$row->instance, "slug"=>$row->slug);
			}
			
		}
		
		return $return_array;
		
	}
	
	
	/**
	* scans adhoc folders and registers any widgets found there
	* that have not yet beed registered
	* @return null
	*/
	public function scan_adhoc_widgets(){
		
		$projectnum = $this->config->item('projectnum');
		
		// we need to use the template_data function to get the adhoc widget descriptions
		
		$this->load->library('template_loader');
	
		
		$widget_ids = array();
		
		$query = $this->db->get('widgets');
		
		foreach ($query->result() as $row){
			$widget_ids[$row->module . "/" . $row->widget] = $row->widget_id;
		}
		
		$locations = array($projectnum . "/widgets",	"widgets" );
		
		foreach($locations as $location){
			
			$widgetdir = APPPATH . $location;
			
			if(file_exists($widgetdir)){
				
				if ($files_handle = opendir($widgetdir)) {
					
					while (false !== ($file = readdir($files_handle))) {
						

						if($file != "." && $file != ".." && $file != "index.html" && $file != "index.htm" && $file != "config" && $file != "views"){
							
							$widget_name = str_replace(".php","",$file);
							
							// we check is a config file exists. If not don't bother with this widget
							$config_file = $widgetdir . "/config/". $file;
							
							//echo $config_file;
							
							
							if(file_exists($config_file)){
							
								include($config_file);
											
								if(isset($config['widget_config']['name'])){
												
									if(!array_key_exists("/".$widget_name, $widget_ids)){ 
										
										//install this to the modules dir;
										$data = array('module'=>'', 'widget' => $widget_name, 'instance' => '');
										
										$this->db->insert('widgets', $data); 
										
										$widget_ids["/" . $widget_name] = $this->db->insert_id();
										
										
									}
														
									
								}
								
							}	
							
						}

					}
				}
			}
			
		}
		

	}
	
	
	

	
	
	/**
	*
	*
	*/
	function addwidgettozone($widget_id, $zone, $page_id){



	}



	/**
	*
	*
	*/
	function reposition_widget($widget_id, $zone, $page_id){



	}
	
	

	/**
	*
	*
	*/
	function savewidget($widget_id, $zone, $page_id){



	}
	
	
	/**
	* returns a list template widget zones
	*
	*/
	function getzones(){

		$return_array = array("Select a zone"=>"");
		
		$sql = "SELECT * FROM {$this->db->dbprefix}widget_zones ORDER BY position ASC";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
				
				$return_array[$row->name] = $row->id;
			}
			
		}
		
		return $return_array;
		
		

	}
	
	
	/**
	* returns a simple list of page that can be selected for this zone
	*
	*/
	function getpagelist($zone){

		$this->load->helper('pageselector');
		
		$data = array();
		
		$this->load->library('adjacencytree');
		
		$content_table = "{$this->db->dbprefix}content_en";
		
		$this->adjacencytree->setidfield('node_id');
		$this->adjacencytree->setparentidfield('node_parent');
		$this->adjacencytree->setpositionfield('node_position');
		$this->adjacencytree->setdbtable("{$this->db->dbprefix}content_nodes");
		$this->adjacencytree->setDBConnectionID($this->db->conn_id);
		
		$this->adjacencytree->setjointable($content_table,"CO_node", array("CO_Node","CO_MenuTitle","CO_seoTitle","CO_Url"));
		
		$node = $this->adjacencytree->getFullNodesArray();
		
		$baserootid = 1;
		
		$groups = $this->adjacencytree->getChildNodes($baserootid); //$baserootid);
		
		$returnarray = pageselectororderlist($groups);
		
		return $returnarray;
		

	}
	
	/**
	* returns a simple list of page that can be selected for this zone
	*
	*/
	public function getwidgetcollections(){
		
		
		$query = $this->db->get("{$this->db->dbprefix}widget_collections");
		
		$return_array = array();

		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
				
				$return_array[$row->name] = $row->id;
				
			}
			
		}
		
		return $return_array;

	}
	
	
	
	/**
	* returns a simple list of page that can be selected for this zone
	*
	*/
	public function getcollectionname($collection_id){

		$query = $this->db->get_where("{$this->db->dbprefix}widget_collections", array('id' => $collection_id));

		if ($query->num_rows() > 0){
			
			$row = $query->row(); 
			
			return $row->name;
			
		}
		
		return false;

	}
	
	
	
	
	

}// end class
