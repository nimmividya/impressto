<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class md5_generator_widget extends PSRemote_Controller {

	public function __construct(){
		
		parent::__construct();
		

		
	}
	
	
	public function generate_md5(){
	
		echo md5($this->input->post('unencrypted_md5'));
	
		
	}	
	
	


	
	
}