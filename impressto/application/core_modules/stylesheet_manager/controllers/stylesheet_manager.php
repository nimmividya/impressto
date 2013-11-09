<?php

class stylesheet_manager extends PSAdmin_Controller {

	private $template_folder;


		
	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		

		
		$this->load->model('stylesheet_manager_model');
			
				
	}
	
	/**
	* default management page
	*
	*/
	public function index(){
	
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		
		
	
		
		$this->load->library('asset_loader');
		$this->load->library('formelement');
		

		
		
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME  . "/default/third_party/mincolors/jquery.miniColors.css");
		


		
		$this->asset_loader->add_header_css(ASSETURL . 'third_party/linedtextarea/jquery-linedtextarea.css');

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME  . "/default/third_party/mincolors/jquery.miniColors.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . '/default/core_modules/stylesheet_manager/js/stylesheet_manager.js');
		$this->asset_loader->add_header_js(ASSETURL . 'third_party/linedtextarea/jquery-linedtextarea.js');
		
		
		$modules = $this->stylesheet_manager_model->getmodules();
		
		
		$fielddata = array(
		'name'        => "module_selector",
		'type'          => 'select',
		'id'          => "module_selector",
		'label'          => "Module",
		'onchange' => "ps_stylesheetmanager.setmodule(this)",
		'options' =>  $modules,
		'showlabels'=> true,
		'colors'=> array("public"=>"#FCFA95"),
		'textcolors'=> array("public"=>"#333333"),
		'value'       => ''
		);
		
		

		
				
		$data['module_selector'] = $this->formelement->generate($fielddata);
		
		
		$data['infobar_help_section'] = getinfobarcontent('STYLESHEETMANAGERHELP');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);

		
		
		
			
		$data['main_content'] = 'manager';
		
		
		$site_settings = $this->site_settings_model->get_settings();
		$this->config->set_item('admin_theme', isset($site_settings['admin_theme']) ? $site_settings['admin_theme'] : "classic");
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
	}
	
	

	public function delete($item_id){

		$this->madmincontent->deletecontent($item_id);
		
		echo "done";
		
	}
	
	public function save(){
		
		global $_POST;
		
	

		$tablename = "impressto";
	
		$error = "";

		// something really wierd happens with windows characters.
		$_POST["template_content"] = str_replace("\n","",$_POST["template_content"]);
		

	
		if($_POST['id'] != ""){
		
			// purge the extension from the file in case somebody added one
			$_POST["filename"] = str_replace(".tpl","",$_POST["filename"]);
			$_POST["filename"] = str_replace(".php","",$_POST["filename"]);
							
			$_POST["filename"] .= ".tpl.php";
			$_POST["old_filename"] .= ".tpl.php";
			
			// now add the extension back onto this template file
			$old_filename = $this->template_folder.$_POST["old_filename"];
			$new_filename = $this->template_folder.$_POST["filename"];
			
			if (($old_filename != $new_filename) && file_exists($new_filename)) {

				$error = "You can not use this filename, it already exists. Please choose a different name.";
				
			} else {

				$sql  = "UPDATE ".$tablename." SET ";
				$sql .= "TP_file='".mysql_real_escape_string($_POST["filename"])."', ";
				$sql .= "TP_label='".mysql_real_escape_string($_POST["label"])."' ";
				$sql .= "WHERE TP_ID='".mysql_real_escape_string($_POST["id"])."'";
					
				$this->db->query($sql);
						
				if ($old_filename != $new_filename){
					
					if (!rename($old_filename,$new_filename)) {
						$error =  "A file rename error has accured. Please contact your system administrator.";
					}
				}
					
				
				if (!file_put_contents($new_filename, $_POST["template_content"])) {
					$error =  "A file write error has accured. Please contact your system administrator.";
				}
			}		

			
		}else{
		
			$sql  = "INSERT INTO ".$tablename." (TP_file, TP_label) VALUES (";
			$sql .= "'" . mysql_real_escape_string($_POST["filename"]) ."',"."'".mysql_real_escape_string($_POST["label"])."'".")";

			$this->db->query($sql);
			
			$contents = f_get_file_contents($template_folder."sample.tpl");
			
			if (!file_put_contents($new_template_path, $contents)) {
				$error =  "A file error has accured. Please contact your system administrator.";
			}
		
		}
		
		echo $error;

		
	}	
	

	
	

} //end class