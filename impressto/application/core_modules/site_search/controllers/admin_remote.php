<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// work in progres...  see: http://mobiforge.com/developing/story/a-simple-mobile-site-with-codeigniter
// http://mobiforge.com/designing/story/a-very-modern-mobile-switching-algorithm-part-i

class admin_remote extends PSBase_Controller {  
  
	public function __construct(){
		
		parent::__construct();
	
		// run the installer here to setup the widget???
		// or do we need this to be in the module manager
		
    }  
  
  	/**
	*
	*
	*/
	public function search_records($lang = 'en'){
			
	
		$data = array(
		
			'lang' => $lang,
		);
		
		
		$this->load->view('partials/search_records', $data);	
				
		
		
	}
	
	
	/**
	*
	*
	*/
	public function indexed_content($lang = 'en'){
			
		$data = array(
		
			'lang' => $lang,
		);
		
		
		
		$this->load->view('partials/search_indexes', $data);	
	
		
	}
	
	
	
	
	
	
	public function get_file_tags(){
	
		$return_array = array(
		
			"tags" => "",
			"description" => "",
		
		);

		//tags =  array();
			
		//$this->load->library("edittools");
				
		$this->load->model('tags/tags_model');
				

	
		$file_path = $this->input->post('file_path');
		
		$dirname = ASSETURL . dirname($file_path);
		
		$dirname = str_replace("\\","/",$dirname);
	
		$dirname = str_replace("//","/",$dirname);
	
		$filename = basename($file_path);
		
				
		$this->db->where('directory', $dirname);
		$this->db->where('file', $filename);
		
		$query = $this->db->get('files');
		
	
		
		if ($query->num_rows() > 0){

			$row = $query->row();
			
			$return_array['description'] = $row->description;
		
			$tags = $this->tags_model->get_tags("en", "file_browser", $row->id);
			
			$return_array['tags'] = implode(",",$tags);
			
		}
		
			
			
		echo json_encode($return_array);
	
	}
	
	
	
    public function tag_file()  
    {  

		$this->load->library("edittools");

		$this->load->library("events");
		
		
		$tag_data = array();
		
		$db_data = array();
		
		$file_path = $this->input->post('file_path');
		$tags = $this->input->post('tags');
		$mime = $this->input->post('mime');
		
		
		$tags = trim($tags);
		$tags = explode(",",$tags);
		
		$tag_data['description'] = $db_data['description'] = $this->input->post('description');
		
		$dirname = ASSETURL . dirname($file_path);
			
		
		$dirname = str_replace("\\","/",$dirname);
		
		$dirname = str_replace("//","/",$dirname);
	
		
		$filename = basename($file_path);
		
		$this->db->where('directory', $dirname);
		$this->db->where('file', $filename);
		
		$query = $this->db->get('files');
				
		if ($query->num_rows() > 0){
				
			$row = $query->row();

			$tag_data['content_id'] = $row->id;

			$this->db->where('id', $row->id);
			$this->db->update('files',$db_data);

			
		}else{

			$db_data['directory'] = $dirname;
			$db_data['file'] = $filename;
			$db_data['mime'] = $mime;
				
			$this->db->insert('files',$db_data);
			
			$tag_data['content_id'] = $this->db->insert_id();
			
		}		
		
		/*
		
		//This need to be an event trigger for the tags events class
		//$tag_data['content_module'] = "files";
		//$tag_data['lang'] = "en";
		//$tag_data['tags'] = $tags;
		//	$this->edittools->write_tags($tag_data);
		*/		

		$eventdata['content_module'] = "admin_blog";
		$eventdata['content_id'] = $data['blog_id'];
		$eventdata['lang'] = $langcode;
		$eventdata['tags'] =  $data["tags_".$langcode];
			
		Events::trigger('save_content', $eventdata);
			
    }  
	

	
	
} 

