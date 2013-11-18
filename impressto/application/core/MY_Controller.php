<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class PSBase_Controller extends MX_Controller {
	
	
	//--------------------------------------------------------------------
	
	public function __construct() 
	{
	
		parent::__construct();
		
		// some basic safeguards
		$top_folder = strtolower(trim(trim(basename(getenv("DOCUMENT_ROOT")), '/'), '\'')); 
			
		if($top_folder == strtolower(PROJECTNUM)){
			$msg = "<p>CONFIG ERROR: Your PROJECTNUM variable cannot equal your document base name.</p>";
			$msg .= "<p>Please rename your base filder name or modify the value set for PROJECTNUM in init.php.</p>";
			show_error($msg , 500 );
			die();
		}
		

	}
	
	//--------------------------------------------------------------------
	
}

class PSFront_Controller extends PSBase_Controller {
	
	//--------------------------------------------------------------------
	
	public function __construct() 
	{
		parent::__construct();

		
	}
	
	
	/**
	* This should be replaced by the function in widget_utils
	*/	
	protected function process_widgets($string){
			
		$this->load->library('widget_utils');
		
		return $this->widget_utils->process_widgets($string);
		
		
	}////////////////////
	
	
	
	/**
	* Stores page hits from non-admin users
	*
	*/
	protected function _record_hit(){
	
		// make sure that this is not an admin user. Just record non-admin or anonymous users
		$user_role = $this->session->userdata('role');
		
		if($user_role != 1){
	
			$sql = "UPDATE {$this->db->dbprefix}content_{$this->language} SET hits = hits + 1 WHERE CO_Node = '{$this->page_id}'";
			$this->db->query($sql);
			
			//echo $sql;
		
		}
	
	}
	
	
	
	
	//--------------------------------------------------------------------
	
}


class PSAdmin_Controller extends PSBase_Controller {
	
	//--------------------------------------------------------------------
	
	public function __construct() 
	{
		parent::__construct();
		
		// if the open left nav section has been declared, leave it at that.
			
		if($this->config->item('current_menu_section') == ""){
		
			// here we are identifying what left nav section is the currently open one
			$module = $this->router->fetch_module();
		
			$this->load->config($module . "/config", TRUE);
		
			$module_configs = $this->config->item('config');
			
			// load the whole config for the currentmodule into memory so you don't have 
			// to waste resources later polling the config file			
			if(isset($module_configs['module_config']) && is_array($module_configs['module_config'])){
				$this->config->set_item('module_config', $module_configs['module_config']);
			}
	
			// this part is sort of redundant but specific for the admin navigation menus
			if(isset($module_configs['module_config']['admin_menu_section'])){
				$this->config->set_item('current_menu_section',	$module_configs['module_config']['admin_menu_section']);
			}

		}
		
		// Added Dec 06, 2012 to fix issue with Chrome v23 cache
		$this->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
		$this->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		$this->output->set_header('Pragma: no-cache');
		
		

		
	}
	
	//--------------------------------------------------------------------
	
}

/**
* Ajax responder - requires session data
*/
class PSAdminRemote_Controller extends PSBase_Controller {
	
	//--------------------------------------------------------------------
	
	public function __construct() 
	{
		parent::__construct();
		
		// Added Dec 06, 2012 to fix issue with Chrome v23 cache
		$this->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
		$this->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		$this->output->set_header('Pragma: no-cache');
		

		
	}
	
	//--------------------------------------------------------------------
	
}


/**
* Ajax responder
*
*/
class PSRemote_Controller extends PSBase_Controller {
	
	//--------------------------------------------------------------------
	
	public function __construct() 
	{
		parent::__construct();
		
		
		// Added Dec 06, 2012 to fix issue with Chrome v23 cache
		$this->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
		$this->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		$this->output->set_header('Pragma: no-cache');
		

		
	}
	
	//--------------------------------------------------------------------
	
}

