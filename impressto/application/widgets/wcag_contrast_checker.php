<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class wcag_contrast_checker extends Widget
{
    function run() {

		$args = func_get_args();
		
		$data = array();
		

		$this->render('wcag_contrast_checker',$data);
		 
    }
}  
