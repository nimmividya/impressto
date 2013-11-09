<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class remote extends PSBase_Controller {

	
	
	public function __construct(){
		
		parent::__construct();
		
		
	}
	
	public function save_note(){
		
		$return_array = array("error"=>"","id"=>"");
		
		$this->load->helper('sticky_notes');

		
		$sticky_id = $this->input->post('sticky_id');
		
		
		$sticky_note = $this->input->post('sticky_note');
		$sticky_priority = $this->input->post('sticky_priority');
		
		
		$updated = date("Ymdhi");

		
		$data = array(
		
		"message" => $sticky_note,
		"priority" => $sticky_priority,			
		"updated" => $updated,
		
		);
		
		
		if($sticky_id == ""){
			
			$this->db->insert('stickynotes', $data); 	
			$sticky_id = $this->db->insert_id();
			
		}else{
			
			$this->db->where('id', $sticky_id);
			$this->db->update('stickynotes', $data); 
		}

		
		$return_array['id'] = $sticky_id;
		$return_array['sticky'] = "<h2>somecode</h2>";	
		
		
		echo json_encode($return_array);
		

	}
	
	
	/**
	*
	*
	*/
	public function delete_attachment(){
		
		
		$sticky_id = $this->input->post('id');
		$file = $this->input->post('file');
				
		$delfile = ASSET_ROOT . "upload/".  PROJECTNAME . "/sticky_notes/{$sticky_id}/{$file}";
		
		if(file_exists($delfile)) unlink($delfile);
			
		echo "OK";
		
	}
	
	

		

	

	/**
	*
	*
	*/
	public function upload_attachment(){
		
		
		// this is not actually an AJAX call so we must turn the profiles off manually
		$this->config->set_item('debug_profiling',FALSE);
		$this->output->enable_profiler(FALSE);
		
		$filename = '';
		$error = '';
		
		$data = array();
		

		$this->load->library('file_tools');
		
		
		$sticky_id = $this->input->post('sticky_id');
		
		
		$upload_dir = getenv("DOCUMENT_ROOT"). ASSETURL . "upload/".  PROJECTNAME . "/sticky_notes/" . $sticky_id;
		
		$this->file_tools->create_dirpath($upload_dir);
		
		$config['allowed_types'] = 'gif|jpg|png|doc|docx|pdf';
		$config['upload_path'] = $upload_dir;

		$this->load->library('upload', $config);
		
		$file_element_name = 'sticky_fileToUpload_' . $sticky_id;
		
		
		if (!$this->upload->do_upload($file_element_name)){
			$filename = '';
			$error = $this->upload->display_errors('', '');
		}else{
			$data = $this->upload->data();
			
			//print_r($data);
			
			$filename = $data['file_name'];
		}


		echo json_encode(array('filename' => $filename, 'error' => $error));
		
		
		


	}



	
	/**
	* Add a stickynote to the db and return html for a new sticky note. 
	*
	*/
	public function add_sticky($content_id, $lang, $user_id, $top_pos){
		
		$return_array = array("id"=>"","html"=>"");
		
		
		$data = array(
		
		"content_id" => $content_id,
		"content_lang" => $lang,
		"message" => "",
		"priority" => 1,			
		"user_id" =>  $user_id,
		"top_pos" => ($top_pos + 20),
		"left_pos" => 100,		
		
		);

		$this->db->insert("stickynotes", $data);
		
		$data['sticky_id'] = $this->db->insert_id();
		
		$data['message'] = "";

		$return_array['id'] = $data['sticky_id'];

		$data['newsticky'] = TRUE;
		
		$return_array['html'] = $this->load->view("sticky_note", $data, TRUE);
		
		echo json_encode($return_array);
		
		
		
	}
	
	
	
	
	/**
	* simply registers a drop event with new x/y coords
	*
	*/
	public function move_sticky(){

		$id = $this->input->get_post('id');
		$top_pos = $this->input->get_post('y');
		$left_pos = $this->input->get_post('x');
		
		$data = array(
		"top_pos" => $top_pos,
		"left_pos" => $left_pos,
		);
		
		$this->db->where('id', $id);
		$this->db->update('stickynotes', $data); 
		
		
	}
	
	
	/**
	*
	*
	*/
	public function delete_note($id){
	
		$this->load->library('file_tools');
					
		$this->db->delete('stickynotes', array('id' => $id)); 
		
		$deldir = ASSET_ROOT . "upload/".  PROJECTNAME . "/sticky_notes/{$sticky_id}";
		
		$this->file_tools->deldir($deldir);
		
				
	}

	
	


	
	private function _newid() {
		$id = rand(1000000, 9999999);
		if(file_exists("data/postit")) {
			$file = file("data/postit");
			$cid = Array();
			for($i=0;$i<count($file);$i++) {
				if(isset($file[$i+4])) {
					$cid[] = trim(str_replace("",null,$file[$i+4]));
				}
			}
			while(in_array($id, $cid)) {
				$id = rand(1000000, 9999999);
			}
		}
		return $id;
	}
	

	private function _adjust($a) {
		return trim(str_replace("\n",null,str_replace("\r",null,str_replace("",null,$a))));
		
	}
	
	
}