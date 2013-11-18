<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!isset($data)) $data = array();

// Nimmitha Vidyathilaka - this is intentionally loaded above the header_includes call because we want the assets loaded in the header
//if(ENVIRONMENT != "production" && !isset($data['developer_toolbox'])){

//	$data['developer_toolbox'] = $this->load->view('admin/includes/developer_toolbox', $data, TRUE); 
	
//}

if(!isset($data['utilitynav'])){
	$data['utilitynav'] = $this->load->view($this->config->item('admin_theme') .'/admin/includes/utilitynav', $data, TRUE); 
}

if(!isset($data['leftnav'])){
	$data['leftnav'] = $this->load->view($this->config->item('admin_theme') .'/admin/includes/leftnav', $data, TRUE); 
}

$this->load->view($this->config->item('admin_theme') .'/admin/includes/header',$data); 

if(isset($parsedcontent)){
	echo $parsedcontent;
}else{
	$this->load->view($main_content, $data); 
}

$this->load->view($this->config->item('admin_theme') . '/admin/includes/footer', $data); 

