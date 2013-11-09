<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// sample tags
//  [widget type='visualcaptcha']
//  direct from PHP code Widget::run('visualcaptcha', array('name'=>'header'));
// within smarty {widget type='visualcaptcha'}
// DIRECT URL CALL:  /widget_call/run/captcha

class captcha extends Widget
{
	function run() {

		//$this->load->spark('visualcaptcha');
		
		//$this->load->library('captcha'); 
		
		$data = array();
		
		
		$this->render('captcha',$data);

	}
} 

