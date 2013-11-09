<?php

class gen_pass_encrypt extends PSBase_Controller {
	
	public function __construct(){
		
		parent::__construct();

		
	}
	
	public function index() {
	
		$this->load->library('encrypt');
			
		$pass = $this->_randString('12');
			
		echo $pass . "<br />" .  $this->encrypt->encode($pass);

	
	}
	
	
	
	private function _randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}



	

}