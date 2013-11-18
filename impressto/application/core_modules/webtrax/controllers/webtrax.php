<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* web trax is a simple web user tracking package
*
*/

class webtrax extends PSBase_Controller {


	public function __construct(){
	
		parent::__construct();
		
		$this->load->helper('auth');
		is_logged_in();
		
		$this->load->library('session');

		$this->load->library('encrypt');
		
	}

	
	public function index(){
		
		
		
		$user_session_data = $this->session->all_userdata();	
		$data['user_role'] = $user_session_data['role']; 
		
		$this->load->helper("im_helper");
		
		$this->load->library('asset_loader');
		
		$this->load->library('formelement');
		
		$this->load->helper('html');

			
		
		

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/webtrax/js/webtrax.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/admin_users/js/user_manager.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/admin_users/js/user_field_manager.js");
		$this->asset_loader->add_header_js("default/vendor/jquery/plugins/validate/jquery.validate.min.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/jquery/jquery.tablednd.js");

	

		$this->asset_loader->add_header_js("/vendor/bootstrap/js/bootstrap-tooltip.js");
		$this->asset_loader->add_header_js("/vendor/bootstrap/js/bootstrap-dropdown.js");
		
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME."/core_modules/admin_users/css/style.css");		
				
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/themes/" . $this->config->item('admin_theme') . "/css/tables.css");	
		
		
		
		$data['infobar_help_section'] = getinfobarcontent('USERSHELP');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
		$data['roles'] = $this->mUsers->get_roles();
		
		
				
		$fielddata = array(
		'name'        => "input_type",
		'id'          => "input_type",
		'type'          => 'select',
		'showlabels'          =>  FALSE,	
		'onchange'          =>  "userfield_manager.set_field_type(this)",	
		'usewrapper'          => TRUE,
		'options' => array(
		"Text" => "text"
		,"Email" => "email"
		,"Textarea" => "textarea"
		,"Checkbox" => "checkbox"
		,"Checkboxes" => "multicheck"
		,"Radio" => "radio"
		,"Dropdown" => "dropdown"
		,"Multiselect-Dropdown" => "multiselect"
		,"static Content" => "static_content" // this is not a field but rather a place to put content
		,"Date" => "date"
		
		),
		);
		
		
		$data['input_type_selector'] = $this->formelement->generate($fielddata);
		
		
		$this->load->library('table');
		
		$tmpl = array (
		  'table_open'          => '<table class="settings-table" id="box-table-a" style="width:100%">',
		  'heading_row_start'   => '<tr>',
		  'heading_row_end'     => '</tr>',
		  'heading_cell_start'  => '<th scope="col">',
		  'heading_cell_end'    => '</th>',
		  'row_start'           => '<tr>',
		  'row_end'             => '</tr>',
		  'cell_start'          => '<td>',
		  'cell_end'            => '</td>',
		  'table_close'         => '</table>'
		);
		
		$this->table->set_template($tmpl);      
		
		//-- Header Row
		$this->table->set_heading('Setting','Setting value' , 'Description');
	
		$this->table->add_row("Auto Activate", 
		anchor("/settings/",img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"To enable user accounts to be activated upon registration"
		);
		
		$this->table->add_row("Admin Activate", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"New user accounts to be activated only by admin"
		);
		
		$this->table->add_row("Signup", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"Enable/disable user registration"
		);
		
		$this->table->add_row("Facebook Connect", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"Allow users to login using facebook"
		);
		
		$this->table->add_row("Facebook AppID", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"The appID for the facebook application to used by the system"
		);
		
		$this->table->add_row("Facebook Secret Key", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"The appID for the facebook application to used by the system"
		);
		
		$this->table->add_row("Captcha", 
		anchor("/settings/", img(array('src'=> ASSETURL . PROJECTNAME . "/default/core/images/actionicons/check.gif")),
		array('title' => "some value")),
		"Enable/disable captcha during signup."
		);
		
		
		$data['advanced_settings_table'] = $this->table->generate(); 
		
		
		
			
		
		$data['main_content'] = 'users';
		
		$site_settings = $this->site_settings_model->get_settings();
		
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
	}
	
	public function read(){
		
		// Set some headers for our JSON
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		echo json_encode( $this->mUsers->getAll() );
	}
	
	public function delete($id = null){
		if( is_null ( $id ) ){
			echo 'ERROR: ID not provided.';
			return;
		}
		
		$this->mUsers->delete( $id );
		echo 'Record Deleted Successfully!';
	}
	
	public function getById($id){
		if(isset($id)){
			
			
			// Set some headers for our JSON
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			
			echo json_encode($this->mUsers->getById($id));
			
		}
		
	}
	
	public function update(){
	
	
		if(!empty($_POST)){
		
			$this->mUsers->update();		
			
			echo 'Record update Successfully!';
		}
	}
	
	public function create(){
		if(!empty($_POST)){
			$this->mUsers->create();
			echo 'New uses Created Successfully!';
		}
	}
	

} //end class
	


	




	
	
}