<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class remote extends PSBase_Controller {

	
	
	public function __construct(){
		
		parent::__construct();
		
		$this->load->model('site_settings_model');
				
	}
	
	/**
	* Do you really need a descriotion of this? Really!?!?
	*
	*/
	public function clearsmartycache()
	{
	
		$smartycachedir = APPPATH . PROJECTNUM . DS . "cache" .  DS . "smarty" . DS;
		
		if ($cachehandle = opendir($smartycachedir)) {
			while (false !== ($file = readdir($cachehandle))) {
				if ($file != "." && $file != "..") {
					$file2del = $smartycachedir."/".$file;
					unlink($file2del);     
				}
			}
			closedir($cachehandle);
		}
		
		
		$pagecachedir = APPPATH . PROJECTNUM . DS . "cache" .  DS . "pages" . DS;
		
		if ($cachehandle = opendir($pagecachedir)) {
			while (false !== ($file = readdir($cachehandle))) {
				if ($file != "." && $file != "..") {
					$file2del = $pagecachedir."/".$file;
					unlink($file2del);     
				}
			}
			closedir($cachehandle);
		}
		
		echo 'Cached cleared.';
	
	}	
	

	
}

?>