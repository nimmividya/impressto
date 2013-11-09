<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author		Galbraith Desmond <galbraithdesmond@gmail.com>
 * @version		1.0.1 (2012-01-07)
 */
 

/** 
* This functions along the same lines as the auth check in Wordpress
*
*/
function ci_user_logged_in(){


	$CI =& get_instance();
	
	$CI->load->library($CI->config->item('authprovider'), null, "authprovider"); 
	
	return $CI->authprovider->logged_in();
	

}

 
/**
* Check thatuser is logged in
*
*/
function is_logged_in()
{


	$CI =& get_instance();
	
	$CI->load->library($CI->config->item('authprovider'), null, "authprovider"); 
	
	if(!$CI->authprovider->logged_in()){
	
			$data['error_msg'] = 'You don\'t have permission to access this page.';
			
			$site_settings = $CI->site_settings_model->get_settings();
		
			$data['site_title'] = (isset($site_settings['site_title_en']) ? $site_settings['site_title_en'] : "");

			$data['request_uri'] = getenv('REQUEST_URI');
	
			//echo $CI->load->view('login_form', $data, TRUE);
			
			//redirect("/auth/login/");
			
			$CI->authprovider->loginform($data);
			
			
	
			exit;
			
		
	}
	
	
	
}

	
