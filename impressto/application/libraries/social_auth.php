<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* authentication library - functions to assist in validating and setting user sessions 
*
* @package		im_auth
* @author		Galbraith Desmond <galbraithdesmond@gmail.com>
* @description Assists in validating and setting user sessions.
*
*/


class social_auth {
	
	var $user_session_folder; 

	public function __construct()
	{
		
		$CI =& get_instance();
		
		$this->user_session_folder = $CI->config->item('user_sessions_dir');
		
		if(!file_exists($this->user_session_folder)){
			
			$CI->load->library("file_tools");
			$CI->file_tools->create_dirpath($this->user_session_folder);
			
		}
		
	}
	
	
	public function loginform($data = ''){
	
		$CI =& get_instance();
			
		//$CI->load->helper('url');
		


		if($CI->load->is_model_loaded('site_settings_model')){
			
			$site_settings = $CI->site_settings_model->get_settings();
		
			$data['site_title'] = (isset($site_settings['site_title_en']) ? $site_settings['site_title_en'] : "");
		
		}else{
		
			$data['site_title'] = "";
			
		}
		

		$data['request_uri'] = "";
		
	
		if($CI->config->item('admin_theme') != ""){

			return $CI->load->view("themes/" . $CI->config->item('admin_theme') . '/login_form', $data, TRUE); 

		}else{
		
			return $CI->load->view('login_form',$data, TRUE); 
		}		
	}	
	
	
	public function logged_in(){


		$CI =& get_instance();
	
		$is_logged_in = $CI->session->userdata('is_logged_in');
		
		//$is_logged_in = FALSE; // debug
		
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			
			// FAILSAFE TEST BEFORE KICKING THE USER OUT
			// check the /appname/sessions/ directory for a sesion id matching the users pskey cookie
			// if the key sesion file exists, read it and decrypt the username and password, then do a authentication check
			//of the authenticatio passes, set the local session and continue

			$sessiondata = $this->cookie_session_validate();
			
			if($sessiondata){
				
				$sessiondata['is_logged_in'] = TRUE; // force this into the session
				
				$CI->session->set_userdata($sessiondata);
				
				return TRUE;
				
				
			}else{
				return FALSE;

			}
			
			
			
		}
		
		return TRUE;
		

	}

	
	/**
	* validate_credentials
	* @param string request_uri
	* @return void
	* @author Galbraith Desmond
	**/
	function validate_credentials($request_uri = '')
	{	
		
		$return_array = array("error"=>"","redirect"=>"");
				
		$CI =& get_instance();
		
		$CI->load->library('session');
		$CI->load->model($CI->config->item('authprovider'). "_model", "authprovider_model");

		
		// this is where the hybridauth magic happens...
		$query = $CI->authprovider_model->validate(); // this is a call to the local model
		
		
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
			
			$data['user_group'] = "";
			$data['authtype'] = "";
			
			
			$CI->session->set_userdata($data);
			
			
			$user_session_data = array(
			
			'username' => $row->username,
			'password' => $row->password,
			'session_id'  => $CI->session->userdata('session_id'),
			
			);
			
			$rememberme = $CI->input->post('rememberme');
			
			$user_session_data['persist'] = ($rememberme == "rememberme") ?  true : false;
			
			// this is used to pick up sessions that are to be resumed
			$this->set_persistent_session_cookie($user_session_data);
			
			if($request_uri == "") $request_uri = PROJECTNAME . '-admin';
			
			//else return PROJECTNAME . '-admin';
						
			redirect($request_uri);
			
			return "";
				
			
			
		}
		else // incorrect username or password
		{
			
			redirect("/auth/login/");
			
			return "";
			
		}
		
		return "";
			

		
	}	
	
	
	/**
	* cookie_session_validate
	*
	* @return bool
	* @author David Gorman
	**/
	public function cookie_session_validate()
	{
		
		global $_COOKIE;
		
		$CI =& get_instance();
		
		
		if(isset($_COOKIE['psakey']) && $_COOKIE['psakey'] != ""){
			
			// here we will try to open the cache session file which them points us\
			// to the CI db session record

			$sessionfile = $this->user_session_folder. md5($_COOKIE['psakey']);
			
			// look for the session file in /appname/user sessions
			if(file_exists($sessionfile)){
				
				// read the user session file and set $usrername and $password
				
				$sessiondata = file_get_contents($sessionfile);
				
				$sessiondata  = unserialize($sessiondata);
				
				
				$CI->db->where('username', $sessiondata['username']);
				$CI->db->where('password', $sessiondata['password']);
				
				$query = $CI->db->get("{$CI->db->dbprefix}users");
				
				
				if($query->num_rows == 1)
				{
					$row = $query->row_array(); 
					return $row;
					
				}else{
					
					return false;
					
				}
				
			}			
		}

		
	}
	
	/**
	* set_persistent_session_cookie
	* Set a cookie that point to the server side session record
	*
	* @param mixed data
	*
	* @return void
	* @author Galbraith Desmond
	**/
	public function set_persistent_session_cookie($data){
		
		// now set the cookie with the random key
		$cookieval = $this->_genrandomstring();
		
		
		
		$session_file = $this->user_session_folder. md5($cookieval);
		
		
		file_put_contents($session_file, serialize($data));
		

		if(isset($data['persist']) && $data['persist'] == true){
			
			setcookie("psakey", $cookieval, time()+(60*60*24*365), "/"); // one year
			
		}else{
			
			setcookie("psakey", $cookieval, time()+(60*60*24), "/"); // 24 hours 

		}
		
	}
	
	
	/**
	* logout
	*
	* @return void
	* @author Galbraith Desmond
	**/
	function logout()
	{
		
		$CI =& get_instance();
		
		$CI->load->library('session');
		$CI->load->helper('cookie');
		
		$CI->session->sess_destroy();
		
		delete_cookie("psakey");
		
		$sessiondata['is_logged_in'] = FALSE; // force this into the session
		
		$CI->session->set_userdata($sessiondata);
		
		redirect("/auth/login/");
		
		return "";
		

		
	}
	
	
	/**
	* genRandomString
	*
	* @return string
	* @author Galbraith Desmond
	**/
	private function _genrandomstring() {
		
		$length = 20;
		
		$characters = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()";
		
		$string = "";    

		for ($p = 0; $p < $length; $p++) {
			
			$char = mt_rand(0, strlen($characters)-1);
			
			$string .= $characters[$char];
			
		}

		return $string;
		
	}

	/**
	* forgot_pass_process
	*
	* @param string email
	* @return array
	* @author Galbraith Desmond
	**/
	function forgot_pass_process($email=''){
		
		$CI =& get_instance();
		
		$return_array = array('error' => '', 'msg' => '');
		
		$CI->load->library('encrypt');
		
		if($email == ""){
			
			$return_array['error'] = "email is not set";
			
		}else if(!$CI->_checkemail($email)){
			
			$return_array['error'] = "email format is not valid";
			
			
		}else{
			
			$query = $CI->db->get_where("users", array("email_address"=>$email));
			
			if ($query->num_rows() > 0){
				
				$row = $query->row(); 
				
				$password = $CI->encrypt->decode($row->password);	
				
				$return_array['msg'] = "Success! Your password has been emailed to you.";
				
				$CI->load->library('email');
				
				$base_url = $CI->config->item('base_url');
				$base_url = str_replace("https://","",$base_url);
				$base_url = str_replace("http://","",$base_url);
				$domain = str_replace("/","",$base_url);
				
				
				$CI->email->from("webmaster@{$domain}", "{$domain} SERVER ADMIN");
				$CI->email->to($email);
				
				$CI->email->subject("Password recovery {$domain}");
				$CI->email->message("Your password is {$password}");
				$CI->email->send();
				
				
			}else{
				
				$return_array['error'] = "email not found";
				
			}			
			
			
		}
		
		return json_encode($return_array);
		

		
	}
	
	
	/**
	*
	*
	*/
	function process_forgot_pass(){
	
		echo $response = $this->authprovider->logout();
				
		echo json_encode($response);
		
	}
	
	
	
	/**
	*  Used for hybrid auth
	*
	* @author David Gorman
	*/
	public function endpoint()
	{

		log_message('debug', 'controllers.HAuth.endpoint called.');
		log_message('info', 'controllers.HAuth.endpoint: $_REQUEST: '.print_r($_REQUEST, TRUE));

		if ($_SERVER['REQUEST_METHOD'] === 'GET')
		{
			log_message('debug', 'controllers.HAuth.endpoint: the request method is GET, copying REQUEST array into GET array.');
			$_GET = $_REQUEST;
		}

		log_message('debug', 'controllers.HAuth.endpoint: loading the original HybridAuth endpoint script.');
		require_once APPPATH.'/third_party/hybridauth/index.php';

	}
	
	
	
	/**
	* in_group
	*
	* @param mixed group(s) to check
	* @param bool user id
	* @param bool check if all groups is present, or any of the groups
	*
	* @return bool
	* @author Galbraith Desmond
	**/
	public function in_group($check_group, $id=false, $check_all = false)
	{
		$this->ion_auth_model->trigger_events('in_group');

		$id || $id = $this->session->userdata('id');

		if (!is_array($check_group))
		{
			$check_group = array($check_group);
		}

		if (isset($this->_cache_user_in_group[$id]))
		{
			$groups_array = $this->_cache_user_in_group[$id];
		}
		else
		{
			$users_groups = $this->ion_auth_model->get_users_groups($id)->result();
			$groups_array = array();
			foreach ($users_groups as $group)
			{
				$groups_array[$group->id] = $group->name;
			}
			$this->_cache_user_in_group[$id] = $groups_array;
		}
		foreach ($check_group as $key => $value)
		{
			$groups = (is_string($value)) ? $groups_array : array_keys($groups_array);

			/**
			* if !all (default), in_array
			* if all, !in_array
			*/
			if (in_array($value, $groups) xor $check_all)
			{
				/**
				* if !all (default), true
				* if all, false
				*/
				return !$check_all;
			}
		}

		/**
		* if !all (default), false
		* if all, true
		*/
		return $check_all;
	}

	
	private function _checkemail($email){
		return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
	}
	
}

