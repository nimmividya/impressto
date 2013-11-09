<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_remote extends PSBase_Controller {


	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		is_logged_in();
		
		
		
		$this->load->model('content_blocks_model','model');
		
		$this->load->library("formelement");
		
		$this->load->config('config');
		
		
				
		
	}
	
	
	/**
	* save this block
	*
	*/
	public function saveblock(){
	
			
		$this->load->helper('htmlpurifier');
		

		$data = array(
		 'block_id' => $this->input->post('block_id'),
		 'blockmobile' => $this->input->post('blockmobile'),
		 'css' => $this->input->post('css'),
		 'javascript' => $this->input->post('javascript'),
		 'name' => $this->input->post('name'),
		 'template' => $this->input->post('template')

		 );
		 
		 
		 
		$lang_avail = $this->config->item('lang_avail');

		 
		foreach($lang_avail AS $langcode=>$language){ 
		
			if($this->input->post('content_'.$langcode) != ""){
				$data['content_'.$langcode] = $this->input->post('content_'.$langcode);
			}else{
				$data['content_'.$langcode] = $this->input->post('ck_content_'.$langcode);
			}
			
		
		}

		
		
		$this->model->saveblock($data);
	

	}
	
	
	/**
	* edit a blok by loading the content via JSON
	*
	*/	
	public function editblock($id=''){
	
		$return_array = array();
		
		//echo $this->admin_news_model->widget_selector();
		
		$return_array = $this->model->getblockdata($id);
		
		if($id != "" && count($return_array) == 0) $return_array['error'] = "no record found";
		else $return_array['error'] = "";
						
		// Set some headers for our JSON
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		echo json_encode($return_array);
						
		
	}
	
	/**
	*
	*
	*/	
	public function deleteblock($id){
	
		$this->model->deleteblock($id);
	
	}
	
	
	/**
	*
	*
	*/	
	public function loadblocklist(){
	
		$data['blocklistdata'] = $this->model->getblocklist();
		
		
		echo $this->load->view('blocklist', $data, true);	
				
		
	}
	
	
	
	
}