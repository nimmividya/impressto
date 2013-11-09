<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// sample tags
//  [widget type='visualcaptcha']
//  direct from PHP code Widget::run('visualcaptcha', array('name'=>'header'));
// within smarty {widget type='visualcaptcha'}



class visualcaptcha extends Widget
{
    function run() {


		$args = func_get_args();
		
		$this->config->set_item('no_cache_write',TRUE); //prevent the parent page from writing a cache file
		
		$form_name = $args[0]['form_name'];
		$field_name = $args[0]['field_name'];
			
		$submit_button = $args[0]['submit_button'];

		$theme = $args[0]['theme'];
	
		if($theme == "") $theme = "office";
						
		$type = "h";
				
		$this->load->spark('visualcaptcha');
		
		$params = array(
			'formId' => $form_name,
			'type' =>$type, 
			'fieldName' =>$field_name, 
			'submit_button' =>$submit_button, 
			'theme' =>$theme,
		);

		$this->load->library('visual_captcha',$params);
				
		$this->visual_captcha->show();


		 
    }
} 

