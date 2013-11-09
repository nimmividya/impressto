<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Auth extends PSBase_Controller {
	
	public function __construct(){
		
		parent::__construct();
		
		$this->load->library($this->config->item('authprovider'), null, "authprovider"); 
		
		
	}
	
	public function index()
	{
		
		//redirect to the login page
		redirect('auth/login', 'refresh');
		
		
	}
	
	
	
	/**
	*
	*
	*/	
	public function login($msg = '')
	{
	
		$data['error_msg'] = $msg;
							
		echo $this->authprovider->loginform($data);
				
		
	}
	
	/**
	* validate_credentials
	*
	* @return void
	* @author David Gorman
	**/
	public function validate_credentials()
	{	
		
		//this may be a standard post or an ajax request.  It depends on the auth provider library
		echo $this->authprovider->validate_credentials($this->input->post('request_uri'));
		
	}	
	
	/**
	* removes all authentication data from cookies and sessions
	*
	* @author Galbraith Desmond
	*/
	public function logout()
	{

		echo $this->authprovider->logout();
		
	}
	
	/**
	* process forgot password request
	*
	* @author Galbraith Desmond
	*/
	public function process_forgot_pass($email){
		
		echo $this->authprovider->forgot_pass_process($email);
	
	
	}
	
	
	/**
	*  Used for hybrid auth
	*
	* @author David Gorman
	*/
	public function endpoint()
	{

		echo $this->authprovider->endpoint();

	}
	



}