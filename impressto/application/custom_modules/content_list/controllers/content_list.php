<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class content_list extends PSAdmin_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		
		
		$this->load->model('content_list_model');
			
		if(!$this->db->table_exists('content_list')) $this->install();
		
	
	}
	
	
	/**
	* Index Page for this controller.
	*
	*/
	public function index(){
		
		
		$this->load->library('asset_loader');
		$this->load->helper('im_helper');
		$this->load->library('template_loader');
		$this->load->library('formelement');
		$this->load->library('widget_utils');
		$this->load->library('edittools');
								
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/content_list/js/content_list_manager.js");
				
		$templateselectordata = array(
		
		'selector_name'=>'list_template',
		'selector_label'=>'Template',
		'module'=>'content_list',
		'value'=>'',
		'is_widget' => TRUE,	
		'widgettype' => 'content_list'
				
		);
		
		$data['template_selector'] = $this->template_loader->template_selector($templateselectordata);
		
	

		
		$fielddata = array(
		'name'        => "widget_name",
		'type'          => 'text',
		'id'          => "widget_name",
		'label'          => "Widget Name",
		'width'          => "200"
		
		);
		
		$data['new_widget_name'] = $this->formelement->generate($fielddata);
			
		
		$data['widget_selector'] = ""; //$this->admin_blog_model->widget_selector();
		
							
		$this->load->helper("im_helper");
		
		$data['moduleoptions'] = ps_getmoduleoptions('content_list');
		
		
		
		$data['infobar_help_section'] = getinfobarcontent('CONTENTLISTHELP','custom_modules');
		
		$data['infobar'] = $this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/infobar', $data, true);

		
		$data['widget_list_data'] = $this->widget_utils->get_widgets_attributes_by_module('content_list','content_list');
		
		
		$data['widgetlist'] = $this->load->view('partials/widgetlist', $data, TRUE);
		
		

			
		
		$doc_path ="/";
		$psTitle ="";
		$data['doc_path'] = $doc_path;
		$data['psTitle'] = $psTitle;

		
		//$data['main_content'] = 'manager';
				
		$data['parsedcontent'] = $this->load->view('manager', $data, TRUE); 
		
		
		$site_settings = $this->site_settings_model->get_settings();
		$this->config->set_item('admin_theme', isset($site_settings['admin_theme']) ? $site_settings['admin_theme'] : "classic");
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
								
			
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}

	
	/**
	*
	*
	*/
	public function delete($blog_id = ''){
		
		$sql = "DELETE FROM {$this->db->dbprefix}blog WHERE blog_id = '$blog_id'";
		
		mysql_query($sql);
		echo'<script>window.location="/admin/blog"</script>';
		
	}
	

	/**
	* AJAX responder
	* Edit the content list
	*
	*/
	public function edit($id = null){
	

		$return_array = array('msg' => '');
		
		
		// need to get the name of the widget
		
		if($id){
		
			$widget_name = $this->widget_utils->get_widget_name($id);
			
			$widget_options = $this->widget_utils->get_widget_options($id);

			
			
			
			$return_array['name'] = $widget_name;
			
			foreach($widget_options AS $option_name => $option_value){
			
				$return_array[$option_name] = $option_value;
			
			}
			
			
	
		}else{
		
			$return_array['msg'] = "new";
						
		}
					
		
		echo json_encode($return_array);
		
	
		
	}
	
	
	
	/**
	* AJAX responder
	* Edit the content list
	*
	*/
	public function edit_list_item($id = null){
	

		$return_array = array();
		
		
		if($id){
			
			$return_array = $this->content_list_model->get_list_item($id);
		
		}
							
		echo json_encode($return_array);
			
		
	}
	
	
	
	
	/**
	* Save the content list item
	*
	*/
	public function save_list_item(){
	
		$data['title_en'] = $this->input->post('content_item_title_en');
		$data['title_fr'] = $this->input->post('content_item_title_fr');
		
		$data['content_en'] = $this->input->post('ck_list_item_content_en');
		$data['content_fr'] = $this->input->post('ck_list_item_content_fr');
		

		//////////////////////////////////
		// This is a CK Editor Hack
		if($data['content_en'] == "") $data['content_en'] = $this->input->post('list_item_content_en');
		if($data['content_fr'] == "") $data['content_fr'] = $this->input->post('list_item_content_fr');
		//
		////////////////////////////
		
		$id = $this->input->post('content_list_item_id');

		$data['widget_id'] = $this->input->post('content_list_item_widget_id');
		
	
		if($id == ""){
		
			$this->db->insert('content_list_items', $data); 
			
			$id  = $this->db->insert_id();
		
		}else{
		

			$this->db->where('id', $id);
			$this->db->update('content_list_items', $data); 
			
		
		}
		
			
		$data['widget_list_data'] = $this->content_list_model->getcontentlist_items($data['widget_id']);
		
		echo $this->load->view('partials/content_list', $data, TRUE);
	
				
	
	}
	
	
	
	/**
	* AJAX responder
	* Edit the content list
	*
	*/
	public function delete_list_item($id, $widget_id){
	
		
		$this->db->delete('content_list_items', array('id' => $id)); 
		
		$data['widget_list_data'] = $this->content_list_model->getcontentlist_items($widget_id);
		
		echo $this->load->view('partials/content_list', $data, TRUE);
			
		
	}
	

	
	
	/**
	* AJAX responder
	*
	*/
	public function reload_content_lists(){
	
	
		$data['widget_list_data'] = $this->widget_utils->get_widgets_attributes_by_module('content_list','content_list');
			
		
		echo $this->load->view('partials/widgetlist', $data, TRUE);
		
	
	}
	
	
	
	/**
	* AJAX responder
	*
	*/	
	public function load_list_items($widget_id = null){
	
			
		$data['widget_list_data'] = $this->content_list_model->getcontentlist_items($widget_id);
		
		echo $this->load->view('partials/content_list', $data, TRUE);
	
	}
	
	
	

	
	/**
	* AJAX responder for checking is a widget name is already in use for another widget
	*
	*/	
	public function check_existing_widget_name($name, $id = ''){
	
		$return_data = array('msg' => '');
		
		
		$data = $this->db->get_where('widgets', array('module'=>'content_list','widget'=>'content_list','instance'=>$name))->row();
	
		if ( isset($data->widget_id) && $data->widget_id != $id ){ // the widget name already exists
		
			$return_data['msg'] = "EXISTS";
						
		}else{
		
			$return_data['msg'] = "UNIQUE";
		
		}
		
		echo json_encode($return_data);
			
	
	}
	
	
	/**
	*  forget this , it should be a widget
	*
	*/
	public function save_widget(){

		$data['name'] = $this->input->post('content_list_name');
		$data['id'] = $this->input->post('contentlist_id');
		$data['template'] = $this->input->post('list_template');
		
		
		$data['clone_id'] = $this->input->post('clone_id');
		
		if($data['clone_id'] != ""){
		
			// duplicate the widget setting and the widget lists
			
		
		}
		
		
		
		
	
		$olddata = $this->db->get_where('widgets', array('module'=>'content_list','widget'=>'content_list','widget_id'=>$data['id']))->row();
		
		
		
		if ( isset($olddata->widget_id) && $olddata->widget_id ){
		
			//echo " FLAG2 ";
		
			$widget_id = $this->widget_utils->register_widget("content_list","content_list",$olddata->instance, $data['name']);
			
		}else{
		
			//echo " FLAG3 ";
		
			$widget_id = $this->widget_utils->register_widget("content_list","content_list",$data['name']);
			
		}
			
		
		
		//if the id != null get the old name of the widget and compare it to the new name
		// change if necessary
				

		
		
		
		$this->widget_utils->set_widget_option($widget_id, 'name',$data['name']);
		$this->widget_utils->set_widget_option($widget_id, 'template',$data['template']);		
		
		// save the widget options
		
		
	
	}
	
	

	/**
	* AJAX responder for sortable calls 
	*
	*/	
	public function reposition_items(){
	
	
		$ids = $this->input->post('ids');
		
		//	
		print_r($ids);
		
		$i = 0;
		
		foreach($ids AS $id){
		
			$sql = "UPDATE {$this->db->dbprefix}content_list_items SET position = '{$i}' WHERE id='{$id}'";
			$this->db->query($sql);
						
			$i ++;
			
		
		}
	
	
	
	}
	

	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){
	
	
		$this->load->library('module_installer');
		$this->load->library('widget_utils');
	
		$data['dbprefix'] = $this->db->dbprefix;
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		

	}

	
}