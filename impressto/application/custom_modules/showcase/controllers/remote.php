<?php

class remote extends PSBase_Controller {

	// these methods are "freed" from authentication.
	private $front_ajax_functions = array("ajax_changeslide","ajax_mainpage");
	
	
	
	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->library('impressto');
	
		$this->load->model('showcase_model');
	
		
	}
	
	/**
	* this handles public side ajax requests
	*
	*/
	public function is_frontresponder(){
			
		if(in_array($this->router->method, $this->front_ajax_functions)) return true;
		
		return false;
	
	}
	
	
	private function init_impressto(){
	
		$this->load->library('impressto');
		
		$projectnum = $this->config->item('projectnum');
			   	
		$template_path = dirname(dirname(__FILE__)) . "/widgets/views/ps_templates/";

		$this->impressto->setDir($template_path);
	
	}
	
	
	/**
	* AJAX responder to change top the next image
	* @args = cat id, current slide id
	*/
	public function ajax_changeslide(){
	
		$this->init_impressto();
			
				
		// /
		//  returns json ... shit, meybe we don't even need this here
	
	}
	
	
	/**
	* AJAX responder to change top the next image
	*
	*/
	public function ajax_mainpage(){
	
		$this->init_impressto();
			
		// return the main page as nasty old HTML. 
		
		return $this->load->view('mainpage', $data, true);
		
	
	}
	
	
	/**
	* AJAX responder to change top the next image
	*
	*/
	public function showcat(){
	
		$this->init_impressto();
		
		$this->load->library("formelement");
		$this->load->library("template_loader");
		
		
		$data['category_images'] = $this->showcase_model->get_images($this->input->get('ig_category'));
		
		//get the category layout. 		
		$data['category_options'] = $this->showcase_model->get_category_selector_options();
		
		
		
		// same old nasty old  HTML return typ eof thing
		$data['ig_category'] = $this->input->get('ig_category');
		
		$fielddata = array(
		'name'        => "gallery_category_seletor",
		'type'          => 'select',
		'id'          => "gallery_category_seletor",
		'options'          => $this->showcase_model->get_category_selector_options(),
		'onchange' => 'ps_showcase.loadcategory(this)',
		'value'   => $data['ig_category']
		
		
		);
		
		$data['gallery_category_seletor'] = $this->formelement->generate($fielddata);
				

		$lang = $this->input->get_post("lang");
		 
		 $this->config->set_item('lang_selected', $lang); 
		 
		 
		$data['category_name'] = $this->showcase_model->get_category_name($data['ig_category'], $lang);
		
		

		 // echo " LANG = $lang ";
		
		 
		 
	
	
		//$data['gallerybody'] =  $this->impressto->showpartial("content.tpl.html",'IMAGEGALLERYCATPAGE', $data);
		
		$data['template'] = "content.tpl.html";
		
		$data['module'] = "showcase";
		
		$data['is_widget'] = TRUE;
				
		$data['partial_section'] = "IMAGEGALLERYCATPAGE";
		
		echo $this->template_loader->render_template($data);
					
	
		//echo $data['gallerybody'];
		
		
	
	}
	
	










} //end class