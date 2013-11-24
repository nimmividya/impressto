<?php

// sample tags
//  [widget type='dashboard/updater']
//  direct from PHP code Widget::run('dashboard/updater', array());

// within smarty {widget type='dashboard/updater'}



class updater extends Widget
{
	function run() {
		
		
		
		//$this->load->library('asset_loader');
		$this->load->library('widget_utils');
		$this->load->library('template_loader');
			
		
		
		$args = func_get_args();
		
		$lang_selected = $this->config->item('lang_selected');
		
		
		$data = array();
		
		
		// if paramaeters have been passed to this widget, assign them	and override the defaults for this widget instance
		if(isset($args[0]) && is_array($args[0])){
			
			$widget_args = $args[0];
			
			if(isset($args[0]['name'])) $data['name'] = $args[0]['name'];
			
		}
		

		$data['showversionnotice'] = FALSE;
		
		
		
		$data['appseries'] = APPSERIES; // this is the prefix version number such as 2.x or 3.x
		
		//if(ENVIRONMENT == "development" || ENVIRONMENT == "testing"){ // we do not run migrations on live sites.

		$this->load->library('migration');
		
		if (!$this->db->table_exists('migrations') )
		{
			
			
			if ( ! $this->migration->current())
			{
				show_error($this->migration->error_string());
			}
			
			$data['current_migration_version'] = 0;
			
			
			
		}else{
			
			$query = $this->db->get('migrations');
			$row = $query->row();
			$data['current_migration_version'] = $row->version;
			
		}	

	
		$this->config->load('migration');
		$data['new_migration_version'] = $this->config->item('migration_version');
		
		if($data['new_migration_version'] > $data['current_migration_version'] ){
			
			if ( ! $this->migration->version($data['new_migration_version'])){
				show_error($this->migration->error_string());
			}else{
				$data['showversionnotice'] = TRUE;
			}
			
		}
		
		//}
		
		$data['curl_enabled'] = $this->cURL_check();
		
		
		$data['update_info'] = "";
				
				
		$data['showupdatenotice'] = FALSE;
		
		// here we check for a newer version of the application. If one is found, download the update description and
		// show it on screen. It the user decides to run the update, the full package or updated files will be downloaded to this server
		// unzipped and copied to the temp folder, the script will then co though all the update foolders and files and copy the old file to
		// the folder "backup".
		
		// at a later date we will be making the outbound call along with an API key to the the application API server which will validate
		// to see if this site is eligable for automatic updates.
				
		
		$updateurl = "http://impressto.com/assets/upload/ps_updates/core_update_" . APPSERIES . "." . ($data['new_migration_version'] + 1) . ".markdown";

		
		$handle = @fopen($updateurl,"r");
		
		if ($handle !==false) { 
			
			fclose($handle);
			
			// load the markdown spark
			$this->load->spark('markdown');
				
			$update_info = file_get_contents($updateurl);
			
			if($update_info != ""){
	
				if(strpos($update_info,"<title>404")  === false){
			
					$data['update_info'] = parse_markdown($update_info);
				
					$data['updateversion'] = ($data['new_migration_version'] + 1);
			
					$data['showupdatenotice'] = TRUE;
				}
			
			
			}
			
		}
		
			

		$data['template'] = 'updater.tpl.php';
		$data['module'] = 'dashboard';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'updater';	

		
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
		
		
		return;
		

		
	}
	
	/**
	*
	*/	
	private function number_pad($number,$n) {
		return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
	}
	
	
	private function cURL_check() 
	{

		if (!function_exists('curl_version'))
        {
			return FALSE;
	
		}
		
		return TRUE;
    }
	

}  

