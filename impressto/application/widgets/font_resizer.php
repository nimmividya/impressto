<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class font_resizer extends Widget
{
    function run() {

		$args = func_get_args();
		
		$data = array();
		

		$this->render('font_resizer',$data);
		 
    }
}  
