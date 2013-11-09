<?php

class module_manager_model extends My_Model{


	
	/**
	* get the base item
	*
	*/	
	public function get_module_list(){
	
		$module_array = array();
		
		$projectnum = $this->config->item('projectnum');
		
		
	
		// scour all the filders to find
		$module_folders = array();
		
		$module_folders[] = $projectnum . "/modules";		
		$module_folders[] = "custom_modules";
		$module_folders[] = "core_modules";


		foreach($module_folders as $val){
		
		
			//$module_name
			

			if(!array_key_exists($module_name, $module_array)){
			
			
				$module_array[] = $module_data;
			
			
			}
				
		}
		
	}
	
	
	
	/**
	* Do you really need a descriotion of this? Really!!!
	*
	*/
	public function activatemodule($module)
	{
		
		
		$record = array('name'=>$module, 'active'=>'Y');
		
		$query = $this->db->get_where('modules', array('name'=>$module), 1, 0);
		
		if ($query->num_rows() == 0) {
			// A record does not exist, insert one.
			$query = $this->db->insert('modules', $record);
			
		} else {
		
			// A record does exist, update it.
			$query = $this->db->update('modules', $record, array('name'=>$module));
		}
		
		
		
		//if ($this->db->affected_rows() > 0) {
			
			
			$this->load->library('module_installer');
			
			$modules_locations = $this->config->item('modules_locations');
			
			
			foreach ($modules_locations as $ml_fullpath => $ml_rel) {	
				
				$controller_file = "{$ml_fullpath}{$module}/controllers/{$module}.php";
								
				
				if (is_file($controller_file)){

					// They'll probably be using dbforge
					$this->load->dbforge();
					
					
					$debugmode = $this->config->item('debugmode') == TRUE ? TRUE : FALSE;
						
					$install_result = modules::run("{$module}/install", $debugmode);
					
					//echo $install_result;
					
					if($this->config->item('unit_testing') == TRUE){
						$test = 'activated';
						$expected_result = 'activated';
						$test_name = 'Install Success test';
						echo $this->unit->run($test, $expected_result, $test_name);
					}
				
						
					return TRUE;
					
					break;
				}
				
			}
			
			
			
			
		//}
		
		return FALSE;
				
	}	
	
	
	
	public function get_widget_list($module){
	

		
	
	}

	
	
} //end class