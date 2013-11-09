<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class remote extends PSBase_Controller {

	
	
	public function __construct(){
		
		parent::__construct();
		
		$this->load->model('module_manager_model');
		

		
	}

	/**
	* This simply reloads the module list
	*
	*/
	public function loadlist()
	{
		
		$this->load->helper('im_helper');
		
		$module_list = get_modules();
		
		$data['module_list'] = $module_list;
		
		$this->load->view('partials/module_table', $data);
		
		
	}	
	
	/**
	* uset this to reload the left nav bar whenever any modules are activated or deactivated
	* 
	*/
	public function refresh_leftnav(){
	
	
		$this->config->set_item('current_menu_section','config');
		$this->config->set_item('router_class','module_manager');
		
		ob_start();
		
		include(APPPATH . "/views/themes/liquid/admin/includes/leftnav.php");
				
		$outbuf = ob_get_contents();
		
		ob_end_clean();
		
		echo $outbuf;
		
		die();
	
	}
	
	
	/**
	* Do you really need a descriotion of this? Really!!!
	*
	*/
	public function deactivatemodule()
	{
		
		// turn off buffering because there can be spaces coming from the installer 
		ob_start();
		
		$module = $this->input->get('module');
		
		$record = array('name'=>$module, 'active'=>'N');
		
		$query = $this->db->get_where('modules', array('name'=>$module), 1, 0);
		
		if ($query->num_rows() == 0) {
			// A record does not exist, insert one.
			$query = $this->db->insert('modules', $record);
			
		} else {
			// A record does exist, update it.
			$query = $this->db->update('modules', $record, array('name'=>$module));
		}
		
		if ($this->db->affected_rows() > 0) {
			
			
			$this->load->library('module_installer');
			
			$modules_locations = $this->config->item('modules_locations');
			
			
			foreach ($modules_locations as $ml_fullpath => $ml_rel) {	
				
				$controller_file = "{$ml_fullpath}{$module}/controllers/{$module}.php";
				
				if (is_file($controller_file)){
					
					modules::run("{$module}/uninstall");
					break;
				}
				
			}
			
			ob_end_clean();
			
			
			return TRUE;
		}
		
		ob_end_clean();
		
		
		// finally clear all the left menu caches 
		$this->cache->delete_group("adminleftnav_");
		
		
		return FALSE;
		
		
	}	
	

	
	
	
	/**
	* Do you really need a descriotion of this? Really!!!
	*
	*/
	public function activatemodule()
	{
	

		// turn off buffering because there can be spaces coming from the installer 
		//ob_start();
		
		$module = $this->input->get('module');
		
		$activated = $this->module_manager_model->activatemodule($module);
		
		// finally clear all the left menu caches 
		$this->cache->delete_group("adminleftnav_");
		
		if($activated) echo "activated";
		
		
	}	



	/**
	* Do you really need a descriotion of this? Really!!!
	*
	*/
	public function reinstall()
	{
	
		$this->activatemodule();


	}


	/**
	* Ajax responder that checks the central.bitheads.ca server to determine if any updates are available for 
	* a specific module
	* @param string  module_dirname
	* @param int module current version
	* @return string with notiification message regarding availablility
	*/
	public function check_for_module_update($module_dirname, $module_type, $version = null){
	
		if($version == "N/A") $version = "";
		
		// here is where the API is fired up. This method will actuall be called indirectly through the API.
		// the API call will be used to determine if the API key of the requesting user matched the licence
		// requirements of this module. If a client has not paid for an update licence, they can't get.
			
		// when the update request comes in, we check the licence terms and most recent version for this module 
		// and compare it to the API key for the user by checking the purchased packages in the 
		// data table package_licences.

		// this will all be in a new module called "package_manager" which is propritary to Acart.
		
		
		$return_array = array("error"=>"", "version"=>2.3, "module_type" => $module_type, "last_updated"=>"October 20, 2012", "status"=>"beta");
						
		echo json_encode($return_array);
			
	
		// user curl here to connect to the the application API server to request module info
	
	
	
	}

	
	public function install_module_update($module_dirname, $module_type, $version){
	
		$return_array = array("msg"=>"","extra_msg"=>"");
			
		$this->load->library('unzip');
		$this->load->library('file_tools');
		
		$module_dirname = strtolower(str_replace(" ","_",$module_dirname)); // just a paranoid safety check here...
		
		$package_path = APPPATH . PROJECTNUM . DS . "cache" . DS . "ps_api" . DS . "modus" . DS . $module_dirname;
		
		// make sure the temp folder is ready to deceive the download
		$this->file_tools->create_dirpath($package_path);
		
		// here's what we will be unpacking
		$zip_package = $package_path . DS . $module_dirname . "_" . $version . ".zip";
		
		// here's where the unpacked files will ultimately end up
		$target_dir = APPPATH . $module_type . "_modules" . DS . $module_dirname;
		

		$sourceurl = "http://central.bitheads.ca/assets/upload/ps_updates/modules/" . $module_dirname . "/" . $module_dirname . "_" . $version . ".zip";
		
	
		if($this->copyRemoteFile($sourceurl,$zip_package)){

	
		
				if(file_exists($zip_package)){
				
					
					if($this->unzip->extract($zip_package, $target_dir)){

					
						// once it is extracted run the installer
					
						ob_start(); // don't let the installed echo out stuff the messes with the json return.
						
						$activated = $this->module_manager_model->activatemodule($module_dirname);
						
						$extra_msg = ob_get_contents();
						
						ob_end_clean();
						
						if($activated){
							
							$return_array['msg'] = "Update complete";
							$return_array['extra_msg'] = $extra_msg;
							
						}else $return_array['msg'] = "Failed to run update script.";
						
					}else{
					
						$return_array['msg'] = "Error extracting package.";
						
					
					}
				}
				
		}else{
			
			$return_array['msg'] = "Could not locate the package";
		
		}
			
		echo json_encode($return_array);
	
	}
	
	
	
	/**
	* populate the permissions dialoge for the selected module
	*
	*/	
	public function loadpermissions(){
		
		$this->load->helper('im_helper');
		
		$module_id = $this->input->get_post('module_id');
		
		$data['module_id'] = $module_id;
		
		$module_permissions = load_module_permissions($module_id);

		
		
		ksort($module_permissions);
		
		$data['module_permissions'] = $module_permissions;
		
		$defined_roles = load_defined_roles();
		
		//print_r($defined_roles);
		
		ksort($defined_roles);
		
		$data['defined_roles'] = array_flip($defined_roles);
		
		$this->load->view('partials/module_permissions', $data);
		
		
	}
	
	
	
	/**
	* save the role based permissions for a module
	*
	*/	
	public function saverolepermissions(){
		
		$module_id = $this->input->post('module_id');

		$role_permissions = $this->input->post('role_permissions');
		
		$this->db->delete('module_permissions', array('module_id' => $module_id));
		
		foreach($role_permissions as $val){
			
			list($action,$role) = explode("__",$val);
			
			
			$data = array(
			'module_id' => $module_id,
			'role' => $role,
			'action' => $action
			);
			

			$this->db->insert('module_permissions',$data);
			
		}
				
		echo "deleting cache ";
		// finally clear all the left menu caches 
		$this->cache->delete_group("adminleftnav_");
		
		
		
	}

	/**
	* takes an uploaded zip file and install it.
	* For this function to work, the zip library must be installed on your server.
	* see: http://www.php.net/manual/en/zip.installation.php
	* @status - incomplete
	* @date - Sept 22, 2012
	*/
	public function install_module(){
	
		$unpackfolder = $this->input->post('unpackfolder');
		$type = $this->input->post('type');
		$module_name = $this->input->post('module_name');
		
	
		$module_name = str_replace(" ","_",$module_name );
		$module_name = preg_replace('/[^a-zA-Z0-9\-_%\[().\]\\/-]/s', '', $module_name);
				
			
		
		$this->load->library('file_tools');
				
		
		
		if(file_exists($unpackfolder)){
		
		
			$assetfiles = $unpackfolder . "/assets";
			$modulefiles = $unpackfolder . "/module";

			$target_asset_folder =  ASSET_ROOT . PROJECTNAME . "/default/" . $type . "_modules/" . $module_name;
			$target_module_folder =  APPPATH . $type . "_modules/" . $module_name;
			
			// copy the files
			
			$this->file_tools->copydir($assetfiles, $target_asset_folder);
			$this->file_tools->copydir($modulefiles, $target_module_folder);
						
			// delete the unpack folder
			
			
		
		}
	
	}
	
	
	/**
	* takes an uploaded zip file and install it.
	* For this function to work, the zip library must be installed on your server.
	* see: http://www.php.net/manual/en/zip.installation.php
	* @status - incomplete
	* @date - Sept 22, 2012
	*/
	public function upload_module(){
	
		$this->load->library('file_tools');
		
		
		// this is not actually an AJAX call so we must turn the profiles off manually
		$this->config->set_item('debug_profiling',FALSE);
		$this->output->enable_profiler(FALSE);
		
		
		
		$status = '';
		$msg = '';
				
		$data = array();
		
		
		$tempdir = APPPATH . PROJECTNUM . "/temp";

		$this->file_tools->create_dirpath($tempdir);
		
		

		
		// accepts an uploaded zip file,  unzips it to temp folder
		// reads the config, creates correct folders and copies files
		// then runs the install slq and install php
		// registers the module
		
		// open the file and read the install.txt file. This will tell us
		// where to install the module files and assets
		
		$zip = new ZipArchive;

		// first thing is to open the zip and copy it to a temp folder. From there we will
		// read the install.info file which will tell us where to copy the application files and assets to
		
		$config['upload_path'] = $tempdir;
		$config['allowed_types'] = 'zip';

		$this->load->library('upload', $config);
		
		$file_element_name = 'fileToUpload';
		
		if (!$this->upload->do_upload($file_element_name))
		{
			$status = 'error';
			$msg = $this->upload->display_errors('', '');
		}
		else
		{
			$data = $this->upload->data();

			$uploadedzip = $tempdir . "/" . $data['file_name'];
					
			
			$status = "success";
			
			$unpackfolder = $tempdir . "/" . str_ireplace(".zip","",$data['file_name']);
				
			
	
			if ($zip->open($uploadedzip) === TRUE) {
		
				$zip->extractTo($unpackfolder);
				$zip->close();
		
				unlink($uploadedzip);
				
		
				
				$info_file = $unpackfolder . "/install.info.txt";

					
				if(file_exists($info_file)){
			
					$install_info = $this->install_info($info_file);
	
				}
			
				$install_info['unpackfolder'] = $unpackfolder;

				// now check to see if this module is already installed. If so, send a warning
				
				$type = strtolower($install_info['Type']);
				$module_name = str_replace(" ","_",$install_info['Name'] );
				$module_name = preg_replace('/[^a-zA-Z0-9\-_%\[().\]\\/-]/s', '', $module_name);
				
				$target_module_folder =  APPPATH . $type . "_modules/" . $module_name;
			
				//echo "target_module_folder = $target_module_folder ";
			
				if(file_exists($target_module_folder)){
					
					$status = "warning";
					$msg = "module has already been installed";	
							
				}
				
				
				
			
			} else {
				$status = 'error';
				$msg = "failed to decompress install file";				
			}


			
			
		}
	  

		echo json_encode(array('status' => $status, 'msg' => $msg, 'install_info' => $install_info));
	
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
	
	
	
	/**
	* creates a new skeleton app in the custom_modules folder
	* This is meant to improve consistence for new modules
	*
	*/
	public function create_new_module(){

		$this->load->library('file_tools');
		$this->load->helper('file_helper');
		$this->load->helper('directory_helper');
		
		$skeleton_files_dir = dirname(dirname(__FILE__)) . "/skeleton_files/";
		$skeleton_assets_dir = dirname(dirname(__FILE__)) . "/skeleton_assets/";
		
		$new_module_name = $this->input->post('new_module_name');
		$new_module_description = $this->input->post('new_module_description');
		$new_module_author = $this->input->post('new_module_author');
		$new_module_docket = $this->input->post('new_module_docket');
		
		$new_module_descriptive_name = $new_module_name;
		
		$new_module_name = $this->_filename_safe($new_module_name);
		
		
		$replacement_strings = array(
			
			'__skeleton_name__' => $new_module_name,
			'__skeleton_descriptive_name__' => $new_module_descriptive_name,
			
			'__skeleton_description__' => $new_module_description,
			'__skeleton_author__' => $new_module_author,
			'__skeleton_docket__' => $new_module_docket,
			'__skeleton_date__' => date("Y/m/d"),
			
		);
			
			
		// do the module files first. The asset files last
		
		
		$target_folder = APPPATH . "custom_modules";
		
		if($new_module_docket != "" ) $target_folder = APPPATH . $new_module_docket . "/modules";
		
		$this->file_tools->create_dirpath($target_folder); // just make sure the parent folder exists
		
		$new_module_folder = $target_folder . "/" . $new_module_name;
		
		if(file_exists($new_module_folder)){ 

			// nothing to do because module already exits
			echo " module already exists.";
			return;
		}
		
		$this->file_tools->copydir($skeleton_files_dir, $new_module_folder);
		
		// now we will rename the files
		
		
		
		if(file_exists($new_module_folder)){  // the copy went ok so we can proceed
			

			rename($new_module_folder . "/controllers/skeleton.php", $new_module_folder . "/controllers/{$new_module_name}.php");
			rename($new_module_folder . "/language/english/skeleton_lang.php", $new_module_folder . "/language/english/{$new_module_name}_lang.php");
			rename($new_module_folder . "/language/french/skeleton_lang.php", $new_module_folder . "/language/french/{$new_module_name}_lang.php");
			rename($new_module_folder . "/models/skeleton_model.php", $new_module_folder . "/models/{$new_module_name}_model.php");
			rename($new_module_folder . "/widgets/skeleton.php", $new_module_folder . "/widgets/{$new_module_name}.php");
			rename($new_module_folder . "/widgets/config/skeleton.php", $new_module_folder . "/widgets/config/{$new_module_name}.php");
			
			// renaming a directory here
			rename($new_module_folder . "/widgets/views/standard/skeleton", $new_module_folder . "/widgets/views/standard/{$new_module_name}");

			rename($new_module_folder . "/widgets/views/standard/{$new_module_name}/skeleton_en.tpl.php", $new_module_folder . "/widgets/views/standard/{$new_module_name}/{$new_module_name}_en.tpl.php");
			rename($new_module_folder . "/widgets/views/standard/{$new_module_name}/skeleton_fr.tpl.php", $new_module_folder . "/widgets/views/standard/{$new_module_name}/{$new_module_name}_fr.tpl.php");
			
			
			//rename($new_module_folder . "/widgets/views/standard/skeleton_en.tpl.php", $new_module_folder . "/widgets/views/standard/{$new_module_name}_en.tpl.php");
			//rename($new_module_folder . "/widgets/views/standard/skeleton_fr.tpl.php", $new_module_folder . "/widgets/views/standard/{$new_module_name}_fr.tpl.php");
			

			
			
			$files_array = directory_map($new_module_folder);
			
			$this->_replace_innerfile_strings($files_array,$replacement_strings,$new_module_folder);
			

			
		}
		
		// now do tha asset files
		
				
		$target_folder = ASSET_ROOT . PROJECTNAME . "/default/custom_modules";
				
		if($new_module_docket != "" )  $target_folder = ASSET_ROOT . PROJECTNAME . "/{$new_module_docket}/custom_modules";
				
		$this->file_tools->create_dirpath($target_folder); // just make sure the parent folder exists
		
		$new_module_folder = $target_folder . "/" . $new_module_name;
		
		if(file_exists($new_module_folder)){ 

			// nothing to do because module already exits
			echo " module already exists.";
			return;
		}
		
		$this->file_tools->copydir($skeleton_assets_dir, $new_module_folder);
		
		
		if(file_exists($new_module_folder)){  // the copy went ok so we can proceed
			

			rename($new_module_folder . "/js/skeleton.js", $new_module_folder . "/js/{$new_module_name}.js");
			rename($new_module_folder . "/js/skeleton_manager.js", $new_module_folder . "/js/{$new_module_name}_manager.js");
			
			$files_array = directory_map($new_module_folder);
			
			$this->_replace_innerfile_strings($files_array,$replacement_strings,$new_module_folder);
			
		}
		
		
		
	}
	
	/**
	* @param file
	* @param string  key pair array
	*/
	private function _replace_innerfile_strings($files_array,$replacement_strings,$parent_dir){


		foreach($files_array as $key => $val){
			
			if(is_array($val)){
				
				$dir = $parent_dir . "/" . $key;
				
				$this->_replace_innerfile_strings($val,$replacement_strings,$dir);
				
				
			}else{
				
				$file = $parent_dir . "/" . $val;
					
				$file_content = read_file($file);
				
				foreach($replacement_strings AS $key => $val){
					
					$file_content = str_replace($key,$val,$file_content);
					
				}
				
				write_file($file, $file_content);
			}
			
			
		}
		
	}
	
	
	/**
	*
	*
	*/
	private function _filename_safe($filename) {
		$temp = $filename;

		// Lower case
		$temp = strtolower($temp);

		// Replace spaces with a '_'
		$temp = str_replace(" ", "_", $temp);

		// Loop through string
		$result = '';
		for ($i=0; $i<strlen($temp); $i++) {
			if (preg_match('([0-9]|[a-z]|_)', $temp[$i])) {
				$result = $result . $temp[$i];
			}
		}

		// Return filename
		return $result;
	}
	
	/**
	* yeah yeah I know Curl would be better but some of the super shitty
	* web hosts we have to deal with don't have it enabled. Cheap hosting! What a joke!
	* It always ends up costing the client magnitudes more in development costs.
	*/
	private function copyRemoteFile($sourceurl,$targetfile){
    
		$file = fopen ($sourceurl, "rb");
		if (!$file) return false; else {
			$fc = fopen($targetfile, "wb");
			while (!feof ($file)) {
				$line = fread ($file, 1028);
				fwrite($fc,$line);
			}
			fclose($fc);
			return true;
		}
	} 
	
}

