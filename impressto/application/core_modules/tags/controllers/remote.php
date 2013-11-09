<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class remote extends PSBase_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		
		
				
		
	}

	
	
	
	
}