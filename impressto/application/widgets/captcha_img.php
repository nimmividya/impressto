<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// sample tags
//  [widget type='visualcaptcha']
//  direct from PHP code Widget::run('visualcaptcha', array('name'=>'header'));
// within smarty {widget type='visualcaptcha'}
// DIRECT URL CALL:  /widget_call/run/captcha_img


class captcha_img extends Widget
{
	function run() {
		
		$this->load->library('captcha/captcha'); 
		
		/**/
		$settings = array(
			'font_dir'		=> APPPATH . 'libraries/captcha/fonts',
			'wordlist'		=> APPPATH . 'libraries/captcha/wordlist.php',
			'log_dir'		=> APPPATH . 'libraries/captcha/logs'
		);

		//$c = new Captcha();
		$this->captcha->set_variables($settings);
		
		echo $this->captcha->create();
		
		
		die();
					
	}
} 

