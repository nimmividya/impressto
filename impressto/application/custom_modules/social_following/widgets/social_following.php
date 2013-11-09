<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class social_following extends Widget
{
    function run() {

		$args = func_get_args();
		
		$data = array();
				
		$settings = ps_getmoduleoptions("social_following");
				
		if(!isset($settings['template']) || !isset($settings['button_layout']) || !isset($settings['pub_id']) ){
					
			echo "SOCIAL BOOKMARK NOT INITIALIZED";
			return;			
		}
		if($settings['template'] == ""){
			
			echo "SOCIAL BOOKMARK TEMPLATE NOT SET";
			return;		
		}
		if($settings['button_layout'] == ""){
			
			echo "SOCIAL BOOKMARK LAYOUT NOT SET";
			return;		
		}
		if($settings['pub_id'] == ""){
			
			echo "SOCIAL BOOKMARK ID NOT SET";
			return;		
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
		
		
		if($settings['uid'] != ""){
	

			$uid_vals = unserialize($settings['uid']);
			
			foreach($uid_vals AS $key => $val){
			
				$uids[$key] = $val;
			}
		}		
		
		
		$data['uids'] = $uids;
		$data['uid_links'] = $uid_links;
		$data['uid_names'] = $uid_names;
		
					
		
		$data['settings'] = $settings;
				
		$data['template'] = $settings['template'];
		
		$data['module'] = 'social_following';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'social_following';			
		
		
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
		
		//$this->render('social_bookmark/social_bookmark',$data);
		 
    }
} 

