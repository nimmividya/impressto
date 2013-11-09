<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class my_profile_manager extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
			
		$this->load->helper('auth');
							
		is_logged_in();
		
		$this->load->model('my_profile_manager_model');
		
		
	}
	
	/**
	* default management page
	*
	*/
	public function index(){
	
		$this->load->model("admin_users/musers");
			
		$data = array();
		
		
		$this->load->helper('im_helper');
		$this->load->library('template_loader');

				
		$this->load->library('formelement');
		$this->load->library('asset_loader');
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/my_profile_manager/js/my_profile_manager.js");
				
	
		$data['infobar_help_section'] = ""; //getinfobarcontent('my_profile_managerHELP');
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);
		
	
		
		if($this->input->post('template') != ""){
				
			$settings['template'] = $this->input->post('template');
			ps_savemoduleoptions("my_profile_manager",$settings);
					
		}
		
		
		$settings = ps_getmoduleoptions("my_profile_manager");
		
		if(!isset($settings['template'])) $settings['template'] = "";
	
		$data['settings'] = $settings;
		
		
		
		// we are going to gather up all the user data here
		
		//Console::log($this->session->all_userdata());

			
		
		$data['profile_field_data'] = $this->musers->get_profile_data($this->session->userdata('id'));
		
		
	
		$profile_template = $this->my_profile_manager_model->get_template($this->session->userdata('id'));
		
		if($profile_template != ""){
		
		
			$this->load->library('template_loader');
				
		
			$data['template'] = $profile_template;
			$data['module'] = 'my_profile_manager';
			$data['is_widget'] = FALSE;
			$data['widgettype'] = '';			
				
			$data['data'] = $data;
	
			$data['parsedcontent'] = $this->template_loader->render_template($data);
		
					
		}else{
		
			$data['main_content'] = "themes/" . $this->config->item('admin_theme') . '/admin/my_profile';
		
			$data['data'] = $data;
				
		}

		
		//$data['parsedcontent'] = "";
		
				
		$data['data'] = $data; // Alice in Wonderland shit here!
		
		
		// now barf it all out into the main core wrapper
		$this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);		


		
	}
	
	public function save_profile(){
	
	
		$this->load->model("admin_users/musers");
		
		$profile_field_attribs = $this->musers->get_profile_field_attribs($this->session->userdata('role'));
					
		$user_id = $this->session->userdata('id');
		
		$data = array();
		$extended_data = array();
			
		
		foreach($profile_field_attribs AS $key => $field_attribs){
		
			$postval = $this->input->post($key);
						
			if(
				$field_attribs['field_type'] == "multiselect"
				||
				$field_attribs['field_type'] == "multicheck"
				||
				$field_attribs['field_type'] == "multicheckbox"
			){
				if(is_array($postval)) $postval = serialize($postval);
			}
									
			
			if($field_attribs['extended'] == TRUE){
			
				// this data goes into the extended table
				$extended_data[$key] = $postval;
			
			}else{
			
				// this data goes into the core table
				$data[$key] = $postval;
				
			
			}
			

		
		}
		
		
		
		$this->db->where('id',$user_id);
		$this->db->update('users',$data);
	
		$query = $this->db->where($this->config->item('profile_join_key'),$user_id)->get($this->config->item('profile_table'));
	
		if ($query->num_rows())
		{
			$this->db->where($this->config->item('profile_join_key'),$user_id);
			$this->db->update($this->config->item('profile_table'),$extended_data);
			
		}else{
		
			$extended_data[$this->config->item('profile_join_key')] = $user_id;
			 $this->db->insert($this->config->item('profile_table'),$extended_data);
						
		}
  			
			
		echo $this->db->last_query();
			
			
	
	}
	
	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
	
		$this->load->library('widget_utils');
	
		$data['dbprefix'] = $this->db->dbprefix;
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		$this->widget_utils->register_widget("my_profile_manager","my_profile_manager");
				
		
	}	
	
	
	public function uninstall(){
	
		$this->load->library('widget_utils');
					
		$this->widget_utils->un_register_widget("my_profile_manager","my_profile_manager");
	}	

	
	
}