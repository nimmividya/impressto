<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class file_browser extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
	}
	
	
	/**
	* default page - blank in this case
	*
	*/
	public function index(){

	
		$data = array();

		$site_settings = $this->site_settings_model->get_settings();
		
		$this->config->set_item('admin_theme', isset($site_settings['admin_theme']) ? $site_settings['admin_theme'] : "classic");
		
		$user_session_data = $this->session->all_userdata();	
		

		if($this->input->get('tiny_mce') == 'true' 
			||  
			(strpos(getenv("REQUEST_URI"), "CKEditor=") !== false || strpos(getenv("REQUEST_URI"), "ajpx_targetfield=") !== false)
			
		){	
		
			$content = $this->load->view("themes/" .$this->config->item('admin_theme') . '/admin/elfinder/popupgui', $data, TRUE);
			
		}else{
		
			// kill that cookie		$data['closebodyandpage'] = HTMLWriter::closeBodyAndPage("ajpx_targetfield","");
			//$data['customheadertags'] = $CI->load->view('admin/ajaxplorer/guiheadertags', $data, TRUE);
		
			$user_session_data = $this->session->all_userdata();	
		
		
	
			$this->load->helper("im_helper");
		
			$data['infobar_help_section'] = getinfobarcontent('FILEMANAGERHELP');
				
			$data['infobar'] = $this->load->view("themes/" .$this->config->item('admin_theme') . '/admin/infobar', $data, true);

			
			$data['data'] = $data; // Alice in Wonderland shit here!
								
			
			// now barf it all out into the main core wrapper
			$content = $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/elfinder/gui', $data, TRUE);
		
		
		

		}
		
		echo $content;
		
		
	}	
	
	

	/**
	*
	*
	*/	
	public function elfinder_init()
	{

		$this->load->helper('path');
		$opts = array(
		// 'debug' => true, 
		'roots' => array(
			array( 
				'driver' => 'LocalFileSystem', 
				'path'   => ASSET_ROOT .'uploads/', 
				'URL'    => ASSETURL . 'uploads/',
				'accessControl' => 'access',             // disable and hide dot starting files (OPTIONAL)
				
				// more elFinder options here
				) 
			)
		);
		
		$this->load->library('elfinder_lib', $opts);
		
		
		
	}


	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){

		$this->load->library('module_installer');
		
		$data['dbprefix'] = $this->db->dbprefix;
		
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);


		
	}
	

} //end class