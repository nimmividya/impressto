<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This script has a lot of migration functions that really belong someplace else
*
*  TODO: move the migration scripts elsewhere
*/



/**
* This is the admin landing page controller
*
*/
class Dashboard extends PSAdmin_Controller {
	
	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		
		is_logged_in();
		
		
		
		$this->load->library('session');
		
		$this->load->model('dashboard_model');
		
		
	}
	
	/**
	* Main controller for the dashboard landing page
	*
	*/
	public function index() {
		

		
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		
		//print_r($this->session->userdata);
			
		
		$data['showversionnotice'] = FALSE;
		
		$data['appseries'] = APPSERIES; // this is the prefix version number such as 2.x or 3.x
		
		$this->load->library('asset_loader');
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/dashboard/js/updater.js");	
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/core_modules/dashboard/css/updater.css");	
	
		$migration_data = $this->run_migration_script();
		
		$data['current_migration_version'] = $migration_data['current_migration_version'];
		$data['new_migration_version'] = $migration_data['new_migration_version'];
		$data['showversionnotice'] = $migration_data['showversionnotice'];
				

		$site_options = $this->config->item('site_options');
		
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		// the template should be coming from the role table.
		// it only defaults to the one below if nothing is set
		
		$data['dashboard_content'] = "";
		
		$data['api_key'] = '';	// we need to hook this up at some point to allow extra functionality based on the system api key
			
		
		
		$dashboard_template = $this->dashboard_model->get_template($this->session->userdata('role'));
		$dashboard_page = $this->dashboard_model->get_page($this->session->userdata('role'));

		$data['CO_Body'] = "";
		
		
		if($dashboard_page){
			
			
			$this->load->library('widget_utils');
			
			$this->load->model('public/ps_content');
			
			$this->ps_content->set_content_table("{$this->db->dbprefix}content_en"); // english for now at least
			
			$dashboard_content = $this->ps_content->getcontentdata($dashboard_page);
			
			$data['dashboard_content'] = $dashboard_content[0]['CO_Body'];
			
			$data['CO_Body'] = $dashboard_content[0]['CO_Body'];
			
			$this->load->library('widget_utils');
									
			$data['dashboard_content'] = $this->widget_utils->process_widgets($data['CO_Body']);

		
			
		}
		
		
		if($dashboard_template != ""){
			
			$this->load->library('template_loader');
			
			
			$data['template'] = $dashboard_template;
			$data['module'] = 'dashboard';
			$data['is_widget'] = FALSE;
			
			$data['is_page'] = TRUE;
			
			$data['widgettype'] = '';	
			
			$data['data'] = $data;
			
			//$data['debug'] = TRUE;
			
			
			// use this to load witht the correct filters (language, device, docket)
			//echo $this->template_loader->render_template($data);
			
			$data['parsedcontent'] = $this->template_loader->render_template($data);
			

		}else{
			
			$data['main_content'] = "themes/" . $this->config->item('admin_theme') . '/admin/dashboard';
			$data['data'] = $data;
		
		}
		
		
		$data['current_module'] = "dashboard";

					
		$this->load->library($this->config->item('authprovider'), null, "authprovider");
	
		
		$full_user_profile = $this->authprovider->full_user_profile($this->session->userdata('id'));
		
		
				
		$data['api_key'] = $this->config->item('api_key');
						
		// now barf it all out into the main core wrapper
		$this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);		

		
	}
	
	/**
	* Main management page lets you assign different pages to different users, roles and user groups,
	* slect the dashboard template, etc.
	* 
	*/
	public function manage(){
		
		
		$this->load->library('asset_loader');
	
		// See http://loudev.com/	
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/third_party/multiselect/js/jquery.multi-select.js");	
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/third_party/multiselect/css/multi-select.css");	
		// optional component for searching select lists
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/third_party/multiselect/js/jquery.quicksearch.js");
		

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core/js/knockout-2.2.1.js");
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/dashboard/js/manager.js");
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/core_modules/dashboard/css/manager.css");			
	
		$data = array();

		$site_options = $this->config->item('site_options');
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		// get an array of all the template assignments to roles, uers and user groups

		// get an array of all the pages assigned to users, user groups and roles


		/*
		$template = isset($moduleoptions['template']) ? $moduleoptions['template'] : '';
						
		$templateselectordata = array(
		
		'selector_name'=>'dashboard_template',
		'selector_label'=>'Template',
		'module'=>'dashboard',
		'value'=> $settings['template'],
		'is_widget' => TRUE,	
		'widgettype' => 'dashboard'
				
		);
		
		$data['template_selector'] = $this->template_loader->template_selector($templateselectordata);
		*/
		
		
		$data['parsedcontent'] = $this->load->view('manage', $data, TRUE); 
		
		
		
		
				
		$data['data'] = $data; // Alice in Wonderland shit here!
					
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}

	
	
	/**
	* Ajax responder to update the system version in the options table
	* @return - not a damn thing
	*/
	public function setversionconfirm(){
		
		
		// now we will run the migration scripts
		$this->load->library('migration');
		
		
		if ( ! $this->migration->version(26)){
			show_error($this->migration->error_string());
		}
		
		echo "complete";

		
	}
	
	
	
	/**
	* takes an uploaded zip file and install it.
	* For this function to work, the zip library must be installed on your server.
	* see: http://www.php.net/manual/en/zip.installation.php
	* @status - incomplete
	* @date - Sept 22, 2012
	*/
	public function process_core_update($version, $api_key = ''){
		
		$this->load->library('file_tools');
		
		$files_array = array();
		
		
		$status = '';
		$msg = '';
				
		$data = array();
		
		$tempdir = APPPATH . PROJECTNUM . "/temp/core_update";
		
		$uploadedzip = $tempdir . "/core_updates_{$version}.zip";
		
		$zip_ready = FALSE;
		
		if(file_exists($uploadedzip)){
		
			$zip_ready = TRUE;
		
		}else{
		
			$this->file_tools->create_dirpath($tempdir);
			
			$unpackfolder = APPPATH . PROJECTNUM . "/temp/core_update/{$version}";
		
			// if this folder exists, empty it
			if(file_exists($unpackfolder)) $this->file_tools->cleardir($unpackfolder);
			else $this->file_tools->create_dirpath($unpackfolder);
		
			$ch = curl_init();
			$source = "http://central.bitheads.ca/assets/upload/ps_updates/core_updates_{$version}.zip";

			curl_setopt($ch, CURLOPT_URL, $source);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec ($ch);
			curl_close ($ch);

			if($data){
		
				$uploadedzip = $tempdir . "/core_updates_{$version}.zip";
				$file = fopen($uploadedzip, "w+");
				fputs($file, $data);
				fclose($file);

				$zip_ready = TRUE;
						
			
			}
			
		}
		
		if($zip_ready){
					
			
			$zip = new ZipArchive;

				
			if ($zip->open($uploadedzip) === TRUE) {
		
				$zip->extractTo($unpackfolder);
				$zip->close();
		
				unlink($uploadedzip);
						
				$this->load->helper('directory_helper');
								
				$files_array = $this->directory_paths($unpackfolder);
						
				$status = "OK";
				$msg = "";
						
			
			} else {
				$status = 'error';
				$msg = "failed to decompress install file";				
			}

		
			
		}else{
		
			$status = 'error';
			$msg = "failed to download installer file";	
			
		}
	
		echo json_encode(array('status' => $status, 'msg' => $msg, 'files_array' => $files_array));

	
	}	
	
	
	
	/**
	* Does not really belong in this class but this is a prototype
	* process each file and return a flag for success or fail
	* @param api key required to validate any update call
	*
	*/	
	public function copy_next_core_file($api_key = ''){
	
		$this->load->library('file_tools');
			
		$file_path = $this->input->post('file_path');
		$version = $this->input->post('version');
		
		$return_array = array(
		
			"msg" => "",
			"color" => "#B2B2B4", // grey
		);
		
		
		//$file_path = str_replace("/" . APPNAME . "/","/" . PROJECTNAME . "/", $file_path);

		// DO NOT OVERWRITE THIS FILE WHILE TESTING THIS FUNCTION
		//if(basename($file_path) == "dashboard.php"){
			
		//	echo json_encode($return_array);
		//	return;
		
		//}
				
		
		$backup_dir = APPPATH . PROJECTNUM . "/temp/core_backup/{$version}" . dirname($file_path);
				
		$this->file_tools->create_dirpath($backup_dir);
		
		$original_file = getenv("DOCUMENT_ROOT") . dirname($file_path) . "/" . basename($file_path);


		// make a backup if the file already exists
		if(file_exists($original_file)){ 
		
			copy($original_file, $backup_dir . "/" . basename($file_path));
			$return_array['msg'] .= "<i class=\"icon-copy\"></i> ";
			
		}
		
		$file_to_copy = APPPATH . PROJECTNUM . "/temp/core_update/{$version}" . $file_path;

		if(!file_exists($original_file)){
	
			// new file so indicate it as such
			$return_array['msg'] .= "<i class=\"icon-asterisk\"></i> ";
		
		}
		// make sure the target directory exits
		$this->file_tools->create_dirpath(dirname($original_file));
						

		if(copy($file_to_copy, $original_file)){
		
			$return_array['msg'] .= "<i class=\"icon-ok\"></i> {$file_path}";
			$return_array['color'] = "#19740F"; // green
				
		
		}else{
		
			$return_array['msg'] = "<i class=\"icon-warning-sign\"></i> ERROR COPYING {$file_path}";
			$return_array['color'] = "#EE0000";
		
		}
			
		
		echo json_encode($return_array);
		
			
		
	
	}
	
	

	/**
	* recursively build a flat list of file paths that will be used to copy the files one by one
	* instead of in bulk. This is a good idea for automatic updates. Trust me!
	*/
	private function directory_paths($srcdir){
	
		static $filepaths, $root_folder;

        //preparing the paths
        $srcdir=rtrim($srcdir,'/');
		
		if(!is_array($filepaths)) $filepaths = array();
		if(!isset($root_folder)) $root_folder = $srcdir;
                
        //Mapping the directory
        $dir_map=directory_map($srcdir);

        foreach($dir_map as $object_key=>$object_value)
        {
		
			// make sure you NEVER have docket folders in your core update or it will blow up here
			if(is_numeric($object_key)){ 
				$filepaths[] = str_replace($root_folder,"",$srcdir).'/'.$object_value;
			}else{
				$this->directory_paths($srcdir.'/'.$object_key);//this is a dirctory
			}
		}
		
		return $filepaths;
				
    }
	
	



	
	/**
	* read data from the install.info.txt file
	*
	*/
	private function install_info( $file ) {
		
	
		$default_headers = array(
			'Name' => 'Name',
			'Type' => 'Type',
			'Description' => 'Description',		
			'Author' => 'Author',
			'Version' => 'Version',
			'Date' => 'Date'
			);
		
		
		// We don't need to write to the file, so just open for reading.
		$fp = fopen( $file, 'r' );

		// Pull only the first 8kiB of the file in.
		$file_data = fread( $fp, 8192 );

		// PHP will close file handle, but we are good citizens.
		fclose( $fp );

		$all_headers = $default_headers;

		foreach ( $all_headers as $field => $regex ) {
			
			// this expression allows *, # and @ before the variable names
			preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, ${$field});
			
			if ( !empty( ${$field} ) )
			${$field} = ${$field}[1];
			else
			${$field} = '';
			
			${$field} = trim(${$field});
		}

		 
		$file_data = compact( array_keys( $all_headers ) );
		
		return $file_data;
		
	}
	
	
	public function run_migration_script(){
	
		$this->load->library('migration');

		$data = array();
		
		$data['showversionnotice'] = FALSE;
	
		
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
		
		return $data;
	
	}
	
	/**
	*
	*
	*/		
	public function run_cleanup_script($version, $api_key = ''){
			
		$this->load->library('file_tools');
		
		
		$cleanupfile = APPPATH . PROJECTNUM . "/temp/core_update/{$version}/core_update_{$version}_cleanup.php";
		
		if(file_exists($cleanupfile)){
		
			
			include($cleanupfile);
			
			if(isset($cleanup_delete_files) && is_array($cleanup_delete_files)){
			
				foreach($cleanup_delete_files AS $file_path){
				
					$file_path = getenv("DOCUMENT_ROOT") . $file_path;
										
					if(file_exists($file_path)){
					
						if(is_dir($file_path)){
							
							$this->file_tools->deldir($file_path);
							
							//echo "DELETING DIRECTORY $file_path ";
							
						
						}else{
						
							unlink($file_path);
							
							//echo "DELETING FILE $file_path ";
						
						
						}
					}
				}
				
			}
				
		
		}
		
	
	
	
	}
	
	
	
	

}