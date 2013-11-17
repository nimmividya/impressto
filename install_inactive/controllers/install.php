<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Install extends CI_Controller {
	
	public static $locations;

	protected $errors = '';
    
	/*
		Var: $curl_error
		Boolean check if cURL is enabled in PHP
	*/
	private $curl_error = 0;
	
	/*
		Var: $curl_update
		Boolean that says whether we should check
		for updates.
	*/
	private $curl_update = 1;
	
	/*
		Var: $pageshaper_install_path
		Boolean that says whether we should check
		for updates.
	*/
	private $pageshaper_install_path = null;

	
	/*
		Var: $pageshaper_app_path
		Boolean that says whether we should check
		for updates.
	*/
	private $pageshaper_app_path = null;
	
	/*
		Var: $writable_folders
		An array of folders the installer checks to make 
		sure they can be written to.
	*/
	

	private $writeable_folders = array();
	

	
	/*
		Var: $reverse_writable_folders
		An array of folders the installer can make unwriteable after 
		installation.
	*/
	private $reverse_writeable_folders = array();
	
	/*
		Var: $writeable_files
		An array of files the installer checks to make
		sure they can be written to.
	*/
	private $writeable_files = array();

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();
		
		$this->pageshaper_install_path = '../' . PROJECTNAME ;

		$this->pageshaper_app_path = '../' . PROJECTNAME  . '/application/';
	
		$this->writeable_folders = array(
			'/' . PROJECTNAME  . '/cache',
			'/' . PROJECTNAME  . '/config'
		);
		

		$this->reverse_writeable_folders = array(
			'/' . PROJECTNAME . '/config',
		);
	

		$this->writeable_files = array(
	
		'/' . PROJECTNAME  . '/config/config.php',
		'/' . PROJECTNAME  . '/config/database.php'
	
		);
		
		
		
		$this->load->helper('form');
		
		$this->output->enable_profiler(false);
		
		$this->lang->load('application');
		$this->lang->load('install');
		
		// check if the app is installed
		$this->load->config('config');
		$this->load->helper('install');

		$this->cURL_check();
	}
	
	//--------------------------------------------------------------------
	

	public function index() 
	{ 
		$view_data = array();
		
		$this->load->library('form_validation');
		


		//$this->form_validation->CI = & $this; // removed due to ci 2.0.8 update
		
		$this->form_validation->set_rules('environment', lang('in_environment'), 'required|trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('hostname', lang('in_host'), 'required|trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('username', lang('bf_username'), 'required|trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('database', lang('in_database'), 'required|trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('db_prefix', lang('in_prefix'), 'trim|strip_tags|xss_clean');

		$view_data['startup_errors'] = $this->startup_check();
		
		if ($this->form_validation->run() !== false)
		{ 
			// Write the database config files
			$this->load->helper('config_file');
			
			$dbname = strip_tags($this->input->post('database'));
			
			// get the chosen environment
			$environment = strip_tags($this->input->post('environment'));
			
			$data = array(
				$environment	=> array(
					'hostname'	=> strip_tags($this->input->post('hostname')),
					'username'	=> strip_tags($this->input->post('username')),
					'password'	=> strip_tags($this->input->post('password')),
					'database'	=> $dbname,
					'dbprefix'	=> strip_tags($this->input->post('db_prefix'))
				),
				'environment' => $environment,
			);
			
			$this->session->set_userdata('db_data', $data);
			if ($this->session->userdata('db_data'))
			{
				//
				// Make sure the database exists, otherwise create it.
				// CRAP! dbutil and database_forge require a running database driver,
				// which seems to require a valid database, which we don't have. To get 
				// past this, we'll deal only with MySQL for now and create things
				// the old fashioned way. Eventually, we'll make this more generic.
				//
				$db = @mysql_connect(strip_tags($this->input->post('hostname')), strip_tags($this->input->post('username')), strip_tags($this->input->post('password')));
				
				if (!$db)
				{
					$view_data['dbase_error'] = message(lang('in_db_no_connect').': '. mysql_error(), 'error');
					
					//$view_data['dbase_error'] = "Unable to create database:<br />" .  mysql_error(); 
														
					$view_data['content'] = $this->load->view('install/index', $view_data, TRUE);
	
						
					$this->load->view('index', $view_data);
							
					return;
							
				}
				else
				{
					$db_selected = mysql_select_db($dbname, $db);
					if (!$db_selected)
					{
						// Table doesn't exist, so create it.
						if (!mysql_query("CREATE DATABASE $dbname", $db))
						{
						
							//die('Unable to create database: '. mysql_error());
							
							$view_data['dbase_error'] = "Unable to create database:<br />" .  mysql_error(); 
														
							$view_data['content'] = $this->load->view('install/index', $view_data, TRUE);
							
							$this->load->view('index', $view_data);
							
							return;
		
							
							
						}
						mysql_close($db);
					}

						
					//redirect('install/account');
					
					// this redirect is giving endless headaches. It may have something to do with 
					// differences between versions of Apach
					
					header('Location: /install/index.php/install/account/');
					
				}
			}
			else
			{
				$view_data['message'] = message(sprintf(lang('in_settings_save_error'), $environment), 'attention');
			}
		}
		
		$view_data['content'] = $this->load->view('install/index', $view_data, TRUE);
	
		$this->load->view('index', $view_data);
	}
	
	//--------------------------------------------------------------------
	
	public function account() 
	{
		$view_data = array();
		

				
		
		if ($this->input->post('submit'))
		{
			$this->load->library('form_validation');
			
			//$this->form_validation->CI =& $this; // removed since CI 2.0.8 update
		
			$this->form_validation->set_rules('site_title', lang('in_site_title'), 'required|trim|strip_tags|min_length[1]|xss_clean');
			$this->form_validation->set_rules('site_projectnum', lang('in_projectnumber'), 'required|trim|strip_tags|min_length[1]|xss_clean');

			$this->form_validation->set_rules('site_verndorname', lang('in_site_verndorname'), 'required|trim|strip_tags|min_length[1]|xss_clean');
			$this->form_validation->set_rules('site_vendorurl', lang('in_site_vendorurl'), 'required|trim|strip_tags|min_length[1]|xss_clean');
			
			$this->form_validation->set_rules('site_languages', lang('in_site_languages'), 'required');
			
			$this->form_validation->set_rules('username', lang('in_username'), 'required|trim|strip_tags|xss_clean');
			$this->form_validation->set_rules('password', lang('in_password'), 'required|trim|strip_tags|alpha_dash|min_length[8]|xss_clean');
			$this->form_validation->set_rules('pass_confirm', lang('in_password_again'), 'required|trim|matches[password]');
			$this->form_validation->set_rules('email', lang('in_email'), 'required|trim|strip_tags|valid_email|xss_clean');
			
			
			if ($this->form_validation->run() !== false)
			{
			
					
				if ($this->setup())
				{
					$view_data['message'] = message(lang('in_success_notification'), 'success');
					$view_data['content'] = $this->load->view('install/success', array(), TRUE);
				}
				else 
				{
					$view_data['message'] = message(lang('in_db_setup_error').': '. $this->errors, 'error');
				}
			}
		}
		
		if (!isset($view_data['content']))
		{
			$account_data = array();
			// if $this->curl_error = 1, show warning on "account" page of setup
			$account_data['curl_error'] = $this->curl_error;
			
			$view_data['content'] = $this->load->view('install/account', $account_data, TRUE);
		}
        
        
		$this->load->view('index', $view_data);
	}
	
	//--------------------------------------------------------------------
	
	
	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------
	
	/*
		Method: startup_check()
		
		Verifies that the folders and files needed are writeable. Sets 
		'startup_errors' as a string in the template if not.
	*/
	private function startup_check() 
	{
	
		$errors = '';
		$folder_errors = '';
		$file_errors = '';
		
		$root_htaccess_file = dirname(dirname(dirname(__FILE__))) . "/.htaccess";
		
		//echo $root_htaccess_file;
		
		if(file_exists($root_htaccess_file)){
			//$errors = "<p>Please remove {$root_htaccess_file} prior to running this installer.</p>";
		}
		
		return $errors;
	}
	
	
	

	private function setup() 
	{
		
				
		// Save the DB details
		$db_data = $db_config_data = $this->session->userdata("db_data");
		
		//print_r($db_config_data);
		$environment = $db_data['environment'];
		unset($db_data['environment']);
		unset($db_config_data['environment']);

				

		$this->load->helper('config_file');
		$this->load->helper('file');
		
		$this->load->library('encrypt');
		$this->load->library('module_installer');
		$this->load->library('file_tools');			
					
		
		$projectnum = $this->input->post('site_projectnum');
		$verndorname = $this->input->post('site_verndorname');
		$vendorurl = $this->input->post('site_vendorurl');
		$projectname = PROJECTNAME;
		$site_url = $this->input->post('site_url');
		
		if(!defined('PROJECTNUM')) define('PROJECTNUM', $projectnum);
					

		$replacement_strings = array(
			'__environment__' => $environment,
			'__projectnum__' => $projectnum,
			'__projectname__' => $projectname,
			'__vendor__' => $verndorname,
			'__vendorurl__' => $vendorurl,
			'__server_name__' => $site_url,
			'__server_port__' => 80,
		);		
			
		
		$server   = $db_data[$environment]['hostname'];
		$username = $db_data[$environment]['username'];
		$password = $db_data[$environment]['password'];
		$database = $db_data[$environment]['database'];
		$dbprefix = $db_data[$environment]['dbprefix'];
		
		if( !$this->db = mysql_connect($server, $username, $password) )
		{
			return array('status' => FALSE, 'message' => lang('in_db_no_connect'));
		}
		
		// use the entered Database settings to connect before calling the Migrations
		$dsn = 'mysql://'.$username.':'.$password.'@'.$server.'/'.$database.'?dbprefix='.$dbprefix.'&db_debug=TRUE';
		$this->load->database($dsn);
		
		
		//
		// Save the information to the settings table
		//
		
		$db_data['dbprefix'] = $dbprefix;
		
		// we will get the current migration version
		include(FCPATH . $this->pageshaper_install_path . '/application/config/migration.php');
		$db_data['migration_version'] = $config['migration_version'];
		$db_data['site_title_en'] = $projectname;


		$this->module_installer->process_file(APPPATH . "/install_data/base.sql",$db_data);
		
		// multilingual support
		
		$languages = $this->input->post('site_languages');
		if(!is_array($languages) || count($languages) == 0) $languages = array("en");
		
				
		foreach($languages as $lang){
		
			//$config_array['lang_avail'][$lang] = $lang_names[$lang];
			
			$db_data['lang'] = $lang;
			$this->module_installer->process_file(APPPATH . "/install_data/base_lang.sql",$db_data);
					
			
		}
		
	
		
		$settings = array(
			'site.title'	=> $this->input->post('site_title'),
			'site.system_email'	=> $this->input->post('email'),
			'updates.do_check' => $this->curl_update,
			'updates.bleeding_edge' => $this->curl_update
		);
		
		foreach	($settings as $key => $value)
		{
			$setting_rec = array('name' => $key, 'module' => 'core', 'value' => $value);
			
			$this->db->where('name', $key);
			if ($this->db->update('options', $setting_rec) == false)
			{
				$this->errors = lang('in_db_settings_error');
				return false;
			}
		}

		
		
		
	
							
						
		
		// Create a unique encryption key
		$this->load->helper('string');
		$encryption_key = random_string('unique', 40);
		
		$config_array = array('encryption_key' => $encryption_key);
		
		// check the mod_rewrite setting
		$config_array['index_page'] = $this->rewrite_check() ? '' : 'index.php';
		
		$config_array['projectnum'] = $this->input->post('site_projectnum');
		
		$config_array['base_url'] = $this->input->post('site_url');


		

		
		////////////////////////
		//

		// need to copy the default template dirs to make a docket version...

		// NOT YET TESTED
		$default_pagestemplatedir = FCPATH . $this->pageshaper_install_path . '/templates/pages/default/';
		$docket_pagestemplatedir = FCPATH . $this->pageshaper_install_path . '/templates/pages/' . $projectnum;
		$this->file_tools->copydir($default_pagestemplatedir, $docket_pagestemplatedir);

		$default_moduletemplatedir = FCPATH . $this->pageshaper_install_path . '/templates/modules/default/';
		$docket_moduletemplatedir = FCPATH . $this->pageshaper_install_path . '/templates/modules/' . $projectnum;
		$this->file_tools->copydir($default_moduletemplatedir, $docket_moduletemplatedir);
		
		$default_widgettemplatedir = FCPATH . $this->pageshaper_install_path . '/templates/widgets/default/';
		$docket_widgettemplatedir  = FCPATH . $this->pageshaper_install_path . '/templates/widgets/' . $projectnum;
		$this->file_tools->copydir($default_widgettemplatedir, $docket_widgettemplatedir);
		
		
		

		$this->file_tools->copydir(dirname(dirname(__FILE__)) . '/root_files/docketfiles', FCPATH . $this->pageshaper_install_path . '/application/' . $projectnum);
				
		$file_content = read_file(dirname(dirname(__FILE__)) . '/root_files/init.php');
				
		foreach($replacement_strings AS $key => $val){
			$file_content = str_replace($key,$val,$file_content);
		}
				
		write_file(dirname(dirname(dirname(__FILE__))) . '/init.php', $file_content);

		copy(dirname(dirname(__FILE__)) . '/root_files/.htaccess', dirname(dirname(dirname(__FILE__))) . '/.htaccess');

		
		// after the config files have been copied, modify them.
		write_db_config($db_config_data);
		

		write_config($environment .'/config', $config_array);

		//////////////////
		// multilingual support added Sept, 2012
		

		
				
		$lang_names = array("en"=>"english","fr"=>"french","zh"=>"mandarin","es"=>"spanish");

		$config_array = array(); // reinitialize this so we don't get wierdness happening.
		
		$config_array['lang_avail'] = array();
		
		foreach($languages as $lang){
		
			$config_array['lang_avail'][$lang] = $lang_names[$lang];
			
		}
				
		write_config('lang_detect', $config_array);
		
		
		//////////////////////////////////////////////////////////////////////
		// Finally install the user in the users table so they can actually login.
		//
		$data = array(
			'role'	=> 1,
			'email'		=> $this->input->post('email'),
			'username'	=> $this->input->post('username'),
		);


		/////////////////
		// we need to make sure the config key used to set the user 
		//pass matches the one we are using in our new config file
		$this->config->set_item('encryption_key',$encryption_key);

			
		$data['password'] = $this->encrypt->encode($this->input->post('password'));
				
		if ($this->db->insert('users', $data) == false)
		{
			$this->errors = lang('in_db_account_error');
			return false;
		}
		
		// now do the editor
		$data = array(
			'role'	=> 2,
			'email'		=> 'editor@mysite.com',
			'username'	=> 'editor_' . $this->rand_string(5),
		);
		
		// use the same password as the admin for now
		
		$data['password'] = $this->encrypt->encode($this->input->post('password'));
				
		if ($this->db->insert('users', $data) == false)
		{
			$this->errors = lang('in_db_account_error');
			return false;
		}
			
			
			
		
		
		// We made it to the end, so we're good to go!
		return true;
	}
	
	//--------------------------------------------------------------------
    
    /*
		Method: cURL_check()
		
		Verifies that cURL is enabled as a PHP extension. Sets 
	   'curl_update' to 0 if not.
	*/
	private function cURL_check() 
	{
        if (!function_exists('curl_version'))
        {
			$this->curl_error = 1;
			$this->curl_update = 0;
        }   
    }
	
	
	//--------------------------------------------------------------------
    
    /*
		Method: rewrite_check()
		
		Verifies that mod_rewrite is enabled as a PHP extension.
	*/
	private function rewrite_check()
	{
        if (!function_exists('rewrite_check'))
        {
			ob_start();
			phpinfo(INFO_MODULES);
			$contents = ob_get_clean();
			return strpos($contents, 'mod_rewrite') !== false;
        }
		
    }//end rewrite_check()
	
	/*
		Method: hash_password()
		
		Generates a new salt and password hash for the given password.
		
		Parameters:
			$old	- The password to hash.
			
		Returns:
			An array with the hashed password and new salt.
	*/
	public function hash_password($old='') 
	{
		if (!function_exists('do_hash'))
		{
			$this->load->helper('security');
		}
	
		$salt = $this->generate_salt();
		$pass = do_hash($salt . $old);
		
		return array($pass, $salt);
	}
	
	//--------------------------------------------------------------------
	
	private function generate_salt() 
	{
		if (!function_exists('random_string'))
		{
			$this->load->helper('string');
		}
		
		return random_string('alnum', 7);
	}
	
	//--------------------------------------------------------------------
	
	private function rand_string( $length ) {
	
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

		$str = "";
			
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}
	
	
	/**
	* @param file
	* @param string  key pair array
	*/
	private function _replace_innerfile_strings($files_array,$replacement_strings,$parent_dir){


		foreach($files_array as $key => $val){
			
			if(is_array($val)){
				
				$dir = $parent_dir . "/" . $key;
				
				$this->_replace_innerfile_strings($val,$replacement_strings,$dir);
				
				
			}else{
				
				$file = $parent_dir . "/" . $val;
					
				$file_content = read_file($file);
				
				foreach($replacement_strings AS $key => $val){
					
					$file_content = str_replace($key,$val,$file_content);
					
				}
				
				write_file($file, $file_content);
			}
			
			
		}
		
	}


	
	//--------------------------------------------------------------------
}

/* get module locations from config settings or use the default module location and offset */
Install::$locations = array(
	APPPATH.'../' . PROJECTNAME  . '/application/custom_modules/' => '../application/custom_modules/',
);
