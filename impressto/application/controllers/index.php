<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends PSFront_Controller {


	public $language = 'en';
	public $page_id = null;
	public $archive_id = null;
	
	
	
	public function __construct(){
		
		parent::__construct();
		
				
		$this->config->item('projectnum');
				
		// this fixes the issue of wrong models being loaded
		$this->load->add_package_path(APPPATH . $this->config->item('projectnum') );
			
				
		$this->load->model('public/ps_content');
		
	}
	
	/**
	* NOTE: we do not use the $lang parameter anymore. It is legacy only
	*
	*/	
	public function index($page_identifier = null)
	{
	
		$data['projectnum'] = $this->config->item('projectnum');
		$data['document_root'] = getenv("DOCUMENT_ROOT");
		
		// Nimmitha Vidyathilaka - june 02, 2012 need to check if this is just an incorrect url before we assume the docket number isn't setup yet.
		// this was an oversight on my part
			
		$this->load->view("setup_instructions", $data);
		
	
	
		
		
	}///////////////
	
	
	

	
	
	
	
}

?>