<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_remote extends PSBase_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		
		$this->load->model("commento/commento_model");
		
		
		
	}
	
	
	
	/**
	* Save setting from the management page
	*
	*/
	public function processor(){
		

		//@session_start();

		/* PROCESS POST ACTIONS (saves and stuff) that will be sent from ajax */
		if(isset($_REQUEST["post_action"])) {
			
			if ($_REQUEST["post_action"] == "save_cfg") {
			
				if (isset($_REQUEST["template"]))
				$this->commento_model->saveConfiguration("template", $_REQUEST["template"]);
				
				if (isset($_REQUEST["initial_hidden"]))
				$this->commento_model->saveConfiguration("initial_hidden", $_REQUEST["initial_hidden"]);

				if (isset($_REQUEST["notification_email"]))
				$this->commento_model->saveConfiguration("notification_email", $_REQUEST["notification_email"]);
				
				
				if (isset($_REQUEST["maxnumchars"]))
				$this->commento_model->saveConfiguration("maxnumchars", $_REQUEST["maxnumchars"]);
				
				if (isset($_REQUEST["Replymaxnumchars"]))	
				$this->commento_model->saveConfiguration("Replymaxnumchars", $_REQUEST["Replymaxnumchars"]);
				
				if (isset($_REQUEST["mod_comments"]))
				$this->commento_model->saveConfiguration("mod_comments", $_REQUEST["mod_comments"]);
				
				
				if (isset($_REQUEST["ask_web_address"]))
				$this->commento_model->saveConfiguration("ask_web_address", $_REQUEST["ask_web_address"]);
				
				if (isset($_REQUEST["mid_range"]))
				$this->commento_model->saveConfiguration("mid_range", $_REQUEST["mid_range"]);
				
				if (isset($_REQUEST["default_ipp"]))
				$this->commento_model->saveConfiguration("default_ipp", $_REQUEST["default_ipp"]);
				
				if (isset($_REQUEST["conv_url_to_link"]))
				$this->commento_model->saveConfiguration("conv_url_to_link", $_REQUEST["conv_url_to_link"]);
				
				if (isset($_REQUEST["allowed_html"]))
				$this->commento_model->saveConfiguration("allowed_html", $_REQUEST["allowed_html"]);
				
				if (isset($_REQUEST["blacklist"]))
				$this->commento_model->saveConfiguration("blacklist", $_REQUEST["blacklist"]);
				
				if (isset($_REQUEST["display_order"]))
				$this->commento_model->saveConfiguration("display_order", $_REQUEST["display_order"]);
				
				if (isset($_REQUEST["captcha_enabled"]))
				$this->commento_model->saveConfiguration("captcha_enabled", $_REQUEST["captcha_enabled"]);
				
				if (isset($_REQUEST["captcha_width"]))
				$this->commento_model->saveConfiguration("captcha_width", $_REQUEST["captcha_width"]);
				
				if (isset($_REQUEST["captcha_color1"]))
				$this->commento_model->saveConfiguration("captcha_color1", $_REQUEST["captcha_color1"]);
				
				if (isset($_REQUEST["captcha_color2"]))
				$this->commento_model->saveConfiguration("captcha_color2", $_REQUEST["captcha_color2"]);
				
				if (isset($_REQUEST["captcha_color3"]))
				$this->commento_model->saveConfiguration("captcha_color3", $_REQUEST["captcha_color3"]);
				
				if (isset($_REQUEST["captcha_colorbg"]))
				$this->commento_model->saveConfiguration("captcha_colorbg", $_REQUEST["captcha_colorbg"]);
				
				if (isset($_REQUEST["reg_users_only"]))
				$this->commento_model->saveConfiguration("reg_users_only", $_REQUEST["reg_users_only"]);
				
				if (isset($_REQUEST["karma_on"]))
				$this->commento_model->saveConfiguration("karma_on", $_REQUEST["karma_on"]);
				
				if (isset($_REQUEST["karma_type"]))
				$this->commento_model->saveConfiguration("karma_type", $_REQUEST["karma_type"]);
				
				
				echo json_encode(array( 'status' => 1 ));
				
			}
			
			if ($_REQUEST["post_action"] == "app_comm") {
				$result = $this->commento_model->admin_approveComment($_REQUEST["comm_app_id"]);
				if ($result == "1") {
					echo json_encode(array( 'status' => 1 ));
				} else {
					echo json_encode(array( 'status' => 0, 'error' => $result  ));
				}
				
				
			}
			
			if ($_REQUEST["post_action"] == "rem_comm") {
				$result = $this->commento_model->admin_removeComment($_REQUEST["comm_rem_id"]);
				if ($result == "1") {
					echo json_encode(array( 'status' => 1 ));
				} else {
					echo json_encode(array( 'status' => 0, 'error' => $result  ));
				}
			}
			
		}
		
		


	}
	
	

	
	
	
	
	
	
}