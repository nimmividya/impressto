<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// sample tags
//  [widget type='commento/commento']
//  direct from PHP cde Widget::run('commento/commento, array()'name'=>'widget_1')
//  within smarty {widgets type='commento/commento' name='widget1'}
//  when viewing a full blog item, this widget can be set to displayfull mode


class commento extends Widget
{


	function run() {

		
		$data = array();
		
		$args = func_get_args();
		
		// we will first assume that this is a standard page.
		$data['content_type'] = "article";
		if($this->config->item('page_id') != "") $data['content_id'] = $this->config->item('page_id');
		

		
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
			
			// if the content type and content id is specified, we use that instead
			if(isset($args[0]['content_type'])) $data['content_type'] = $args[0]['content_type'];
			if(isset($args[0]['content_id'])) $data['content_id'] = $args[0]['content_id'];
		}
		
				
		$this->load->library('edittools');
		$this->load->library('asset_loader');
		
		$this->load->model("commento/commento_model");
		


		//@session_start();
		
		// Manual SESSION config override
		//$_SESSION["commento_comments_closed"] = false;					// You don't need to set it to false. It is FALSE by default.
		//$_SESSION["commento_moderated_com"]	= false;					// You don't need to set it to false. It is FALSE by default.


		// ONLY SET THIS TO TRUE AFTER PROCESSING YOUR AUTHENTICATION AND ADMIN LOGGED IS TRUE
		// This will activate admin funcitons.
		//$_SESSION["commento_admin_viewing"]	= false;					// You don't need to set it to false. It is FALSE by default.


		// Manual SESSION USER COMMENT ONLY  (User information)
		// If you choose to have comments only for registered users
		// you need to pass their information into session variables
		//$_SESSION["commento_is_user_logged"]	= false;				// You don't need to set it to false. It is FALSE by default.
		//$_SESSION["commento_user_name"] 		= "USERNAME";			// If you set commento_is_user_logged TRUE - YOU NEED TO SET THIS
		//$_SESSION["commento_user_email"] 		= "USER@email.com";		// If you set commento_is_user_logged TRUE - YOU NEED TO SET THIS
		

		
		$data['comments'] = $this->commento_model->build_comment_system($data['content_type'], $data['content_id']);
		
		$data['numcomments'] = $this->commento_model->nbComments;
		
		$data['template'] = $this->commento_model->getConfigurations("template");
		$data['initial_hidden'] = $this->commento_model->getConfigurations("initial_hidden");
		$data['ask_web_address'] = $this->commento_model->getConfigurations("ask_web_address");
		
		
		$data['module'] = 'commento';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'commento';			
		//$data['debug'] = TRUE;
				
		
		echo $this->template_loader->render_template($data);
		
		
	}
	

}  
