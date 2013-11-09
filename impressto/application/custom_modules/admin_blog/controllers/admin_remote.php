<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_remote extends PSBase_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		
		
		
		$this->load->model('admin_blog_model');
		
		$this->load->library("formelement");
		
		$this->load->config('config');
		

		
	}
	
	
	/**
	*
	*
	*/
	public function getwidgetdata($widget_id){
	
		$this->load->library('widget_utils');
				
		$widget_data = $this->widget_utils->get_widget_options($widget_id);
				
		//$widget_data["widget_name"] = $this->widget_utils->get_widget_name($widget_id);
		
		
		echo json_encode($widget_data);

		
	
	}
	
	
	
	/**
	*
	*
	*/
	public function loadwidgetlist(){
	
		$data['widget_list_data'] = $this->admin_blog_model->getwidgetlistdata();
		
		echo $this->load->view('partials/widgetlist', $data, TRUE);
		
	
	}
	
	/**
	*
	*
	*/
	public function deleteblog($id){

		$this->load->library('edittools');
		
		$this->load->helper('im_helper');
				
		
		$lang_avail = $this->config->item('lang_avail');
				

		$this->db->delete('blog', array('blog_id' => $id)); 
		
		// grab the option so we can get the page wrappers
		$moduleoptions = ps_getmoduleoptions('admin_blog');
		
		
		// remove it from the search index too.
		// this really should be a trigger to /core_modules/search/events.php	

		foreach($lang_avail AS $langcode=>$language){ 
					
			$data = array(
				'lang' => $langcode,
				'content_id' =>  $id,
				'content_module' => 'blog', 
			);
			
			$this->edittools->deletesearchindex($data);
			
			if(isset($moduleoptions['admin_blog_page_' . $langcode]) && $moduleoptions['admin_blog_page_' . $langcode] != ""){
				
				$url = rtrim( ltrim($moduleoptions['admin_blog_page_' . $langcode], '/'),'/');
				$url = str_replace($langcode . "/", "", $url);
				$eventdata['CO_Url'] = 	rtrim( ltrim($url, '/'),'/');
				
				$eventdata['lang'] = $langcode;
				$eventdata['query'] = "blog_id={$id}";
				
				Events::trigger('delete_content', $eventdata);
				
				
			}
			
		
		}
		
		echo "deleted";

		
	}

	
	
	/**
	*
	*
	*/
	public function deletewidget($id){
		
		//$return_array = array();
		
		$this->load->library('widget_utils');
				
		$this->widget_utils->delete_widget($id);
		
		echo "deleted";

		
	}
	
	
	public function savewidget(){
	
		$return_array = array();
		
	
		// all we need is thethe widget name
		$widget_instance_name = trim($this->input->get_post('widget_name'));
		$widget_type = $this->input->get_post('widget_type');
		
		
		$widget_template = $this->input->get_post($widget_type . '_template'); 

			
		if($widget_type == "" || $widget_template == "" || $widget_instance_name == ""){
		
			echo "missing data";
			return;
			
		}
		
		
		
		$widget_id = $this->input->get_post('widget_id');
				
		$return_array['widget_template'] = $widget_template;
				
		
		$this->load->library('widget_utils');
		
		if($widget_id == ""){
		
			// fist thing is to create the widget instance
			$widget_id = $this->widget_utils->register_widget($widget_type, 'admin_blog', $widget_instance_name);
			
		}
		
		// update the name in case it was changed
		$sql = "UPDATE {$this->db->dbprefix}widgets SET instance = '{$widget_instance_name}' WHERE widget_id = '{$widget_id}'";
		$this->db->query($sql);

		
		$this->widget_utils->set_widget_option($widget_id, 'template',$widget_template);
		
		$return_array['widget_id'] = $widget_id;
		
		echo json_encode($return_array);
		
	
	}
	
	/**
	* standard save function
	* 
	*/
	public function save_blog(){
	
		$this->load->helper('im_helper');
			
		
		$today = date('Y-m-d H:i:s');
		
		
		$lang_avail = $this->config->item('lang_avail');
				

		foreach($lang_avail AS $langcode=>$language){ 
		
			${"blog_tags_".$langcode} = "";		
			if($this->input->post('blog_tags_'.$langcode) != "") ${"blog_tags_".$langcode} = explode(",",$this->input->post('blog_tags_'.$langcode));
			
		}
		
					
		
		$data = array(

			'blog_id' => $this->input->post('blog_id')
			,'active' => ($this->input->post('blog_active') == 1 ? "1" : "0")
			,'archived' => ($this->input->post('archived') == 1 ? "1" : "0")
			,'modified' => $today
			
		);
		

		foreach($lang_avail AS $langcode=>$language){ 
		
			$data['blogtitle_'.$langcode] =  $this->input->post('blogtitle_'.$langcode);
			$data['author_'.$langcode] =  $this->input->post('author_'.$langcode);
			$data['publish_date_'.$langcode] =  $this->input->post('publish_date_'.$langcode);
			$data['blogshortdescription_'.$langcode] =  $this->input->post('blogshortdescription_'.$langcode);
			$data['blogcontent_'.$langcode] =  $this->input->post('blogcontent_'.$langcode);
			$data['tags_'.$langcode] =  ${"blog_tags_" . $langcode};
			$data['featured_image_'.$langcode] =  $this->input->post('featured_image_'.$langcode);
								
		}
				
		
		$blog_id = $this->admin_blog_model->save_blog($data);
		
		echo json_encode(array("blog_id"=>$blog_id));
							

	}
	
	
	
	/**
	* Called from blog list to quickly toggle publish state
	*
	*/
	public function toggle_active($id, $state){
	
		if($state == 1) $data['active'] = 0;
		else $data['active'] = 1;
			
		$this->db->where('blog_id', $id);
		$this->db->update('blog', $data);
		
		//echo $this->db->last_query();
			
	}
	
	
	/**
	* Called from blog list to quickly toggle archived state
	*
	*/
	public function toggle_archived($id, $state){
	
		if($state == 1) $data['archived'] = 0;
		else $data['archived'] = 1;
			
		$this->db->where('blog_id', $id);
		$this->db->update('blog', $data);
		

			
	}
	
	
	
	/**
	* this saves settings for the blog 
	*
	*/
	public function savesettings(){
	
		$this->load->helper('im_helper');
		
		$lang_avail = $this->config->item('lang_avail');
				
		
		foreach($lang_avail AS $langcode=>$language){ 
		
			$saveoptions['admin_blog_archive_page_'.$langcode] = $this->input->get_post('admin_blog_archive_page_'.$langcode);
			$saveoptions['admin_blog_page_'.$langcode] = $this->input->get_post('admin_blog_page_'.$langcode);
					
		}
		
		//print_r($saveoptions);
		

		$saveoptions['blog_listlimit'] = $this->input->get_post('blog_listlimit');		
		
		ps_savemoduleoptions('admin_blog',$saveoptions);
		
	
		
	}
	
	
	/**
	*
	*
	*/	
	public function getwidgetselector(){
		
		echo $this->admin_blog_model->widget_selector();
		
	}
	
	/**
	*
	*
	*/
	public function remove_featured_image($blog_id, $lang){
	
			
		$this->admin_blog_model->remove_featured_image(array("blog_id"=>$blog_id,"lang"=>$lang));
			
				
		echo "deleted";
	
	}
	
	
}