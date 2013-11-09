<?php

class social_following extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
				
		$this->load->helper('auth');
		$this->load->library('impressto');
		
		is_logged_in();
		
		
	}
	
	/**
	* default management page
	*
	*/
	public function index($param = ''){
	
		$this->install();
		
		
		$this->load->helper('im_helper');
		$this->load->library('template_loader');


		
		$data['infobar_help_section'] = getinfobarcontent('SOCIALFOLLOWINGHELP');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		

		
		
		if($this->input->post('template') != "" || $this->input->post('button_layout') != ""){
		
		
			$settings['template'] = $this->input->post('template');
			$settings['button_layout'] = $this->input->post('button_layout');
			$settings['pub_id'] = $this->input->post('pub_id');
			
			if(is_array($this->input->post('uid'))){
	
				$settings['uid'] = serialize($this->input->post('uid'));
							
			}
						
			ps_savemoduleoptions("social_following",$settings);
					
		}
		
		$uids = array(
			"facebook" => null,
			"twitter" => null,
			"linkedin" => null,
			"google" => null,
			"youtube" => null,
			"flickr" => null,
			"vimeo" => null,
			"pinterest" => null,
			"instagram" => null,
			"rss" => null,
		);
		
		
		$uid_names = array(
			"facebook" => "Facebook",
			"twitter" => "Twitter",
			"linkedin" => "LinkedIn",
			"google" => "Google+",
			"youtube" => "YouTube",
			"flickr" => "Flickr",
			"vimeo" => "Vimeo",
			"pinterest" => "Pinterest",
			"instagram" => "Instagram",	
			"rss" => "RSS",
		);
		
		
		$uid_links = array(
			"facebook" => "http://www.facebook.com/",
			"twitter" => "http://twitter.com/",
			"linkedin" => "http://www.linkedin.com/in/",
			"google" => "https://plus.google.com/",
			"youtube" => "http://www.youtube.com/user/",
			"flickr" => "http://www.flickr.com/photos/",
			"vimeo" => "http://www.vimeo.com/",
			"pinterest" => "http://www.pinterest.com/",
			"instagram" => "http://followgram.me/",		
			"rss" => "http://",
		);
		
		$settings = ps_getmoduleoptions("social_following");
		
		
		if(!isset($settings['template'])) $settings['template'] = "";
		if(!isset($settings['button_layout'])) $settings['button_layout'] = "";
		if(!isset($settings['pub_id'])) $settings['pub_id'] = "";
		
		if(!isset($settings['uid'])){
			$settings['uid'] = "";
		}else{
		
			
			$uid_list = unserialize($settings['uid']);
			
			
			foreach($uid_list AS $key => $val){
			
				$uids[$key] = $val;
			}
		}		
		
		$data['uids'] = $uids;
		$data['uid_links'] = $uid_links;
		$data['uid_names'] = $uid_names;
		
		$data['settings'] = $settings;
		

				
		$data['main_content'] = 'settings';
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
	}
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){


		$this->load->library('widget_utils');
		
		
		
		$this->widget_utils->register_widget("social_following","social_following");
		
		
		
	}









} //end class