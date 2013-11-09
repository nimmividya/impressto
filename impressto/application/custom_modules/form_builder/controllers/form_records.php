<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class form_records extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		$this->load->helper('auth');
		
		is_logged_in();
		
		
		$this->load->library('grocery_crud');	
			
		

	}
	
	
	
	
	/**
	* prevents user from creating duplicate friendly urls. 
	* Adds a unique number to the end of duplicates
	* @param string url (original)
	* @param varchar(2) language
	* @param int node_id
	* @return string url
	*/
	public function index($form_id){
	
		$this->load->library('asset_loader');
	
		//$this->grocery_crud->set_theme('datatables');
		$this->grocery_crud->set_table($this->db->dbprefix . 'form_builder_records');
		$this->grocery_crud->set_subject('Record');
		$this->grocery_crud->required_fields('option_value');
		$this->grocery_crud->where('form_id', $form_id);
		
		
		
		//$this->grocery_crud->columns('option_id','element_id','option_value','option_label');
		
		$this->grocery_crud->set_default_language_path(APPPATH . "language/");
		$this->grocery_crud->set_default_config_path(APPPATH . "config");
		$this->grocery_crud->set_default_assets_path(ASSET_ROOT . "vendor/grocery_crud");

		$this->grocery_crud->unset_jquery();		
		$this->grocery_crud->unset_jquery_ui();
		
	
		
		//Tell the admin templates that this is a third part popup so no need to load all the standard assets
		$this->config->set_item('thirdpartypopup', TRUE);
		
						
		$output = $this->grocery_crud->render();
		
		$data['parsedcontent'] = $this->load->view('records',$output, TRUE);	
				
		$data['data'] = $data; // Alice in Wonderland stuff here!
		
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/popup_wrapper', $data);	
			

		
		
	}
	
	
	private function _example_output($output = null)
	{
		return $this->load->view('records',$output, TRUE);	
	}
	
	
	
	
	
}

