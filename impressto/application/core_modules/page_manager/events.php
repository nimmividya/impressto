<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Events_Page_Manager {

    protected $ci;

    protected $fallbacks = array();

    public function __construct()
    {
        $this->ci =& get_instance();
			

        //register the page_manager_save event
        //Events::register('delete_content', array($this, 'clear_cache'));

		// this is used by the page manager and widget modules such as news and blog which require their wrapper page cache to be cleared 
		Events::register('save_content', array($this, 'clear_cache')); 

		Events::register('rebuild_cache', array($this, 'rebuild_cache'));
		
    }

	/**
	* 
	* @package /modules/search
	*/
	public function clear_cache( $data )
    {
        $CI =& get_instance();	
		

		if($data['lang'] != "" && $data['CO_Url'] != ""){
		
			$cachefile = APPPATH . PROJECTNUM . "/cache/pages/";
			
			$page_identifier = $data['lang'] . "/" . $data['CO_Url'];
			if(isset($data['query'])) $page_identifier .= "?" . $data['query'];
			
			$cachefile .= urlencode($page_identifier);
			
			$cachefile .= ".html";
			
		}
		
		
		if(file_exists($cachefile)) unlink($cachefile);
	
    }
		

	/**
	* 
	* @package /modules/search
	*/
	public function rebuild_cache( $data )
    {
	
        $CI =& get_instance();	
		
		if($data['lang'] != "" && $data['CO_Url'] != ""){
		
			$cachefile = APPPATH . PROJECTNUM . "/cache/pages/";

			$page_identifier = $data['lang'] . "/" . $data['CO_Url'];
			if(isset($data['query'])) $page_identifier .= "?" . $data['query'];
			
			$cachefile .= urlencode($page_identifier);
			
			
			$cachefile .= ".html";
			
		}
		
			
		$CI->load->library('file_tools');
		$CI->load->library('template_loader');
		
		$outbuf = "";

		$CI->file_tools->create_dirpath(APPPATH . PROJECTNUM . "/cache/pages/");
	
		if(isset($cachefile) && file_exists($cachefile)) unlink($cachefile);
		
		
		$outbuf = $CI->template_loader->render_template($data);

		if(isset($cachefile)) file_put_contents($cachefile, $outbuf);
		
		
		return $outbuf;
			
		
    }
	
}
/* End of file events.php */