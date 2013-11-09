<?php

class tubepress_model extends My_Model{



	/**
	*
	*/
	function delete_tubepress_widget_settings($widget_id){
		
				
		$this->db->where(array("widget_id" => $widget_id));
		$this->db->delete("tubepress");
			
	
		
	}///////////////
	
	
	/**
	*
	*/
	function save_tubepress_widget_settings($data){
		
		
		$settings_table = $this->db->dbprefix . "tubepress";
		
		$this->db->where(array("widget_id" => $data['widget_id']));
		$this->db->delete("tubepress");
			
		
		foreach($data['widget_settings'] AS $option_name => $option_value){
			
			$sql = "INSERT INTO $settings_table (widget_id, option_name, option_value) VALUES ('{$data['widget_id']}', '$option_name','$option_value')";
			
			$this->db->query($sql);
			
		}

		
		
		
		
		
	}///////////////
	
	
	/**
	*
	*/
	public function get_settings($widget_id = 0){
	
		$return_array = array();
		
		$query = $this->db->get_where( 'tubepress', array('widget_id' => $widget_id) );
	
		foreach ($query->result() as $row)
		{
		
			$key = $row->option_name;
			$val = $row->option_value;
			
			$return_array[$key] = $val;
			
		}
		
	
		return $return_array;
		

	}


	/**
	* 
	*
	*/
	public function getwidgetlistdata(){
		
		$this->load->library('widget_utils');
		
		$return_array = array();
		
		
		$this->db->where('module', 'tubepress');
		$query = $this->db->get('widgets');

		
		if ($query->num_rows() > 0){
			
			foreach ($query->result() as $row){
				
				
				$subdata = array();
				
				$subdata['widget_id'] = $row->widget_id;
				$subdata['widget_module'] = $row->module;
				$subdata['widget_type'] = $row->widget;
				$subdata['widget_instance'] = $row->instance;
				
				$this->db->select('name, value');
				$this->db->where('widget_id', $subdata['widget_id']);
				$query2 = $this->db->get('widget_options');
				
				if ($query2->num_rows() > 0){
					
					foreach ($query2->result() as $q2row){
						
						$subdata["widget_" . $q2row->name] = $q2row->value;
						
					}
					
				}
				
				$return_array[] = $subdata;
				
			}
			
		}
		
		return $return_array;
		
		
	}
	
	
	/**
	* Return a list of all the theme folders that are available for the TubePress Widget
	* 
	*
	*/
	public function get_tubepress_themes(){
	
		$themes = array("Select"=>"");
			
	
		//	Theme folders are located at /appname/vendor/tubepress_pro/sys/ui/themes and /appname/vendor/tubepress_pro/tubepress-content/ 
		
		$locations = array( 

			INSTALL_ROOT . "/vendor/tubepress_pro/tubepress-content/themes",
			INSTALL_ROOT . "/vendor/tubepress_pro/sys/ui/themes",
				
		);
		
		foreach($locations as $location){
			
			if(file_exists($location)){
				
				if ($files_handle = opendir($location)) {

					while (false !== ($file = readdir($files_handle))) {
						
						if(is_dir($location . "/". $file) && $file != "." && $file != ".."){
												
							$themes[$file] = $file;
							
								
							
						}

					}
				}
			}
			
		}
		
		return $themes;
	
	
	}

	
	
} //end class











