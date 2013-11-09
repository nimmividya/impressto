<?php

class Login extends PSBase_Controller {
	
	function index($msg = '')
	{
	
		$data['error_msg'] = $msg;
		
		$site_settings = $this->site_settings_model->get_settings();
		
		$data['site_title'] = (isset($site_settings['site_title_en']) ? $site_settings['site_title_en'] : "");

		$data['request_uri'] = "";
				
		$this->load->view('login_form',$data);		
				
	}
	
	function validate_credentials()
	{	

	
		$this->load->library('encrypt');
		
		$this->load->library('session');
				
		$this->load->model('ps_auth');

		$query = $this->ps_auth->validate(); // this is a call to the local model
				
		$request_uri = $this->input->post('request_uri');
				
		if($query) // if the user's credentials validated...
		{
		
		
		   if ($query->num_rows() > 0)  $row = $query->row(); 
		

			$data = array(
			
			
				'id' => $row->id,
				'username' => $row->username,
				'email' => $row->email_address,				
				'role' => $row->role,
				'is_logged_in' => true
				
			);
			
				
			$this->session->set_userdata($data);
		
			$this->load->library('im_authlib');
				
			$user_session_data = array(
			
				'username' => $row->usr_username,
				'password' => $this->input->post('password'),
				'session_id'  => $this->session->userdata('session_id'),
						
			);
			
			$rememberme = $this->input->post('rememberme');
			
			$user_session_data['persist'] = ($rememberme == "rememberme") ?  true : false;
			
			// this may be redundant now that we are using db sessions
			$this->im_authlib->set_persistent_session_cookie($user_session_data);
			
		
			if($request_uri != "") redirect($request_uri);
			else redirect(PROJECTNAME . '-admin');
			
		}
		else // incorrect username or password
		{
		
			$this->index("Bad Login Credentials");
		}
	}	
	
	/**
	* removes all authentication data from cookies and sessions
	*
	*/
	function logout()
	{
		$this->load->library('session');
		$this->load->library('im_authlib');
		$this->load->helper('cookie');
				
		$this->session->sess_destroy();
				
		delete_cookie("psakey");
								
		$sessiondata['is_logged_in'] = FALSE; // force this into the session
				
		$this->session->set_userdata($sessiondata);
			
		$this->index();
		
		
	}
	

	
	function process_forgot_pass(){
	
		$return_array = array(
		
			'error' => '',
			'msg' => '',
		
		);
		
		$this->load->library('encrypt');
		
		
		$email = trim($this->input->post('email'));
		
		
		if($email == ""){
		
			
			$return_array['error'] = "email is not set";
	
				
		}else if(!$this->_checkemail($email)){
		
			$return_array['error'] = "email format is not valid";
		
				
			
		}else{
			
			$query = $this->db->get_where("users", array("usr_email_address"=>$email));
			
			if ($query->num_rows() > 0){
			
				$row = $query->row(); 
				
				$usr_password = $this->encrypt->decode($row->usr_password);	
				
				$return_array['msg'] = "Success! Your password has been emailed to you.";
			
				$this->load->library('email');
				
				$base_url = $this->config->item('base_url');
				$base_url = str_replace("https://","",$base_url);
				$base_url = str_replace("http://","",$base_url);
				$domain = str_replace("/","",$base_url);
				
				
				$this->email->from("webmaster@{$domain}", "{$domain} SERVER ADMIN");
				$this->email->to($email);
	
				$this->email->subject("Password recovery {$domain}");
				$this->email->message("Your password is {$usr_password}");
				$this->email->send();
		
		
			}else{
			
				$return_array['error'] = "email not found";
				
				

			}			
			
			// decrypt the password and send if to the user matches what is in the database
			//$this->encrypt->encode($this->input->post('password'))	
				
			
		}
		
		echo json_encode($return_array);
		
		
	
	}
	
	
	

	private function _checkemail($email){
		return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
	}


}