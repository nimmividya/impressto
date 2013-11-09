<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// work in progres...  see: http://mobiforge.com/developing/story/a-simple-mobile-site-with-codeigniter
// http://mobiforge.com/designing/story/a-very-modern-mobile-switching-algorithm-part-i

class rss_feed extends PSBase_Controller {  

  
	public function __construct(){
		
		parent::__construct();
		
		$this->load->helper('xml');  
        $this->load->helper('text'); 
		
		$this->load->model('blog_model','posts');  
		
		
    }  
  
    function index($lang = 'en')  
    {  
	
		$site_settings = $this->ps_content->get_site_settings();
		
		$this->config->item('base_url');

		
		$data['moduleoptions'] = ps_getmoduleoptions('admin_blog');
				
		
        $data['feed_name'] = $site_settings['site_title_en'];  
        $data['feed_url'] = $this->_curPageName();  
        $data['page_description'] = $site_settings['site_description_en'];  
        $data['page_language'] = $this->config->item('lang_selected');  

		
        $blog_posts = $this->posts->get_active_items();  
		
		//print_r($blog_posts);
		
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
			$data['url_protocol'] = "https://";
		}else{
			$data['url_protocol'] = "http://";
		}
		
		$data['domain_name'] = $_SERVER['HTTP_HOST'];
		 
		 
		$data['blog_posts'] = $blog_posts['limitedrecords'];
	 
		header("Content-Type: application/rss+xml"); 
		header("Content-Type: text/xml"); 
		//  		
		$this->load->view('rss', $data); 

		exit; // aliased (inline loaded) modules need an exit statement here ... dunno why!
			
	

    }  
	
	
	private function _curPageName() {
	
		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
		
	}

  
} 

