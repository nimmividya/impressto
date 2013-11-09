<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class remote extends PSBase_Controller {


	public function __construct(){
		
		parent::__construct();
		//$this->load->helper('auth');
		//is_logged_in();
		
		$this->load->model("commento/commento_model");
		
		
		
	}
	
	public function processor(){
		
		
		@session_start();

		if ( (isset($_REQUEST["type"])) and ( ($_REQUEST["type"] === "reply") or ($_REQUEST["type"] === "comment") ) ) {
			// Post comment or reply request
			
			
			// checks if there is an ID sent, meaning we are receiving a reply post request
			if (isset($_REQUEST["id"]))
			$parentID = $_REQUEST["id"];
			else
			$parentID = "";
			
			// Include the class file. MUST BE ON SAME FOLDER AS THIS FILE.
			// and instantiate it to a var
			//require_once str_replace('\\','/',dirname(__FILE__)) . "/commento.class.php";
			//$Ccommento = new Ccommento();
			
			// This array is going to be populated with either the data that was sent to the script, or the error messages.
			$arr = array();
			
			// Call VALIDATION function before anything else
			$validates = $this->commento_model->validate($arr, $_REQUEST["type"], $parentID);
			
			// Is a comment or a reply
			if ((isset($_REQUEST["type"])) and ($_REQUEST["type"] === "reply")) {
				$isReply = true;
			} else {
				$isReply = false;
			}
			
			if ($validates) {
				
				// Insert comment to database:
				$arr = $this->commento_model->insert_new_comment($arr);
				
				// The data in $arr is escaped for the mysql query, but we need the unescaped variables, so we apply, stripslashes to all the elements in the array:
				$arr = array_map('stripslashes',$arr);
				
				// Now process comment for markup
				$insertedComment = $this->commento_model->process_comment($arr);
				
				$notification_email = $this->commento_model->getConfigurations("notification_email");
				
				if($notification_email != ""){
				
					$this->load->library('email');

					$this->email->from($notification_email, 'Commento System');
					$this->email->to($notification_email);
					$this->email->subject('Notification from Commento');
					// this ain't working right!
					$this->email->message('You have a new comment. Moderate is by clicking here');
					$this->email->send();
							
				}
		
				
				// Outputting the markup of the just-inserted comment:
				echo json_encode(array( 'status' => 1, 'html' => $this->commento_model->pre_Markup($isReply, true) ));
				
			} else {
				/* Outputtng the error messages */
				echo '{"status":0,"errors":'.json_encode($arr).'}';
			}
			
			
			
		} else if ((isset($_REQUEST["type"])) and ($_REQUEST["type"] === "ajax_paginate")) {
			// Comments pagination operation request
			
			/* Calls class build_comment_system() wich builds up the comments for the specific id and return the XHTML for the whole system (comments + form) */
			$comments = $this->commento_model->build_comment_system($_POST["content_type"],$_POST["content_id"]);
			
			/* Output the whole comment system (Comments + form) */
			echo $comments;
			
			
			
			
		} else if ((isset($_REQUEST["type"])) and ($_REQUEST["type"] === "getConfig")) {
			// Get Ajax Configurations request
			
			// Call VALIDATION static function before anything else
			echo $this->commento_model->getJSConfig();
			
			
			
			
		} else if ((isset($_REQUEST["type"])) and ($_REQUEST["type"] === "rem")) {
			// Remove comment request
			
			// Call VALIDATION static function before anything else
			echo $this->commento_model->removeComment($_REQUEST["id"]);
			
			
			
			
			
		} else if ((isset($_REQUEST["type"])) and ($_REQUEST["type"] === "app")) {
			// Approve comment request

			
			// Call approveComment() function, and echo it's reply
			echo $this->commento_model->approveComment($_REQUEST["id"]);
			
			
			
			
			
		} else if ((isset($_REQUEST["type"])) and ($_REQUEST["type"] === "karma_vote")) {
			
			
			// Call karma_vote() function, and echo it's reply
			echo $this->commento_model->karma_vote($_REQUEST["ID"], $_REQUEST["voteUPorDOWN"]);
			
			
			
			
		} else {
			die("Not valid operation nor direct access");
		}


		
	}
	
	/**
	*
	*
	*/
	public function commento_captcha(){
	
	
		$this->load->model("commento_captcha");
		
		//$captcha = new Ccommento_captcha();
		$this->commento_captcha->CreateCaptcha();
		
		die();

			
	}

	
	
	
	
}