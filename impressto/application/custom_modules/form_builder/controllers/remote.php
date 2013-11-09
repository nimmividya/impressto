<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class remote extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->model('form_builder_model');
		

	}


	/**
	*
	*
	*/
	public function submit(){
		
		$return_array = array(
		
		"error" => "",
		"msg" => "",
		
		);
		
		
		$this->load->helper('im_helper');
		
		//$settings = ps_getmoduleoptions('form_builder');
		
		$form_id = $this->input->post('form_id');
		
		
		$settings = $this->form_builder_model->get_form_settings($form_id);
		

		//print_r($settings);
		
		
		
		//form_id
		
	
		if($settings['captcha'] == "visualcaptcha"){
			
			$this->load->spark('visualcaptcha');
		
			$params = array(
				'formId' => "form_builder",
				'type' =>"h", 
				'fieldName' =>"visualcaptcha", 
				'submit_button' =>"form_builder_button",
				'theme' =>$settings['captcha_theme'] 
				
			);

			$this->load->library('visual_captcha',$params);
				
			
			// this is just a double measure. If someone has got this far they either did things right or hacked the javascript.
			if(!$this->visual_captcha->isValid()){
				$return_array['error'] = "invalid visual captcha";
			}else{
				$return_array['msg'] = $settings['success_message'];
			}
			
			
		}else if($settings['captcha'] == "captcha"){
			
			$captcha = $this->input->post('captcha');
			
			if ($captcha != '') {

				$this->load->library('captcha/captcha'); 
				
				$result = $this->captcha->validate($captcha);
				
				if ($result)
				{
					$return_array['msg'] = $settings['success_message'];
				} else {
					$return_array['error'] = "invalid captcha";
				}
			}
			
			
		}else{ // no captcha
		
			$return_array['msg'] = $settings['success_message'];
		
		
		}
		
		// need to do a server side validation in case something slipped past the client side validation.
		

		if($return_array['error'] == ""){
			
			
			$sql = "SELECT * FROM {$this->db->dbprefix}form_builder_fields WHERE active = 1 ORDER BY position ASC";
			
			$query = $this->db->query($sql);
			
			//$field_names = array();
			$field_values = array();
			$mailed_values = array();
			
			$data = array();
			
			
			$data['form_id'] = $form_id;
			
			foreach ($query->result_array() as $row)
			{
				//$field_names[] = $row['field_name'];
				
				$field_val = $this->input->get_post($row['field_name']);
				
				if(is_array($field_val)){
					
					$data[$row['field_name']] = serialize($field_val);
					
					$field_values[] = serialize($field_val);
					$mailed_values[] = $row['field_name'] . ": " . implode(", ",$field_val);
					
				}
				else{
					
					$data[$row['field_name']] = $field_val;
					
					$field_values[] = $field_val;
					$mailed_values[] = $row['field_name'] . ": " . $field_val;
				}
			}
			
			

			$this->db->insert('form_builder_records', $data); 

			
		
			
			if($settings['email_account'] != ""){
			
				// suppress mail server error messages
				ob_start();
				
				
				$message = "You have a new record:\n\n ";
				$message .= "'" . implode("'\n",$mailed_values);
				
				$this->load->library('email');
				
				$this->email->from('webmaster@pageshaper.ca', 'Site Admin');
				$this->email->to($settings['email_account']);
				//$this->email->cc('another@another-example.com');
				//$this->email->bcc('them@their-example.com');

				$this->email->subject('Contact Form Record');
				$this->email->message($message);

				$this->email->send();
				
				ob_end_clean();

			}
		}
		
		echo json_encode($return_array);
				
		
	}
	
	public function captcha_refresh($captcha_wrapper_id){
	
		$this->load->plugin('widget');
		
		echo Widget::run('opencaptcha', array("refresh_action"=>"ps_form_builder.captcha_refresh('{$captcha_wrapper_id}')"));
					
	
	}
	
	
	public function get_captcha_audio($captcha_wrapper_id){
		
		$this->load->plugin('widget');
		
		echo Widget::run('visualcaptcha_audio', array("refresh_action"=>"ps_form_builder.captcha_refresh('{$captcha_wrapper_id}')"));
					
	
	}
	
}

