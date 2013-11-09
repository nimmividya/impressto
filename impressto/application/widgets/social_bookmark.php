<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class social_bookmark extends Widget
{
    function run() {

		$args = func_get_args();
		
		$data = array();

		$this->render('social_bookmark',$data);
		 
    }
} 

