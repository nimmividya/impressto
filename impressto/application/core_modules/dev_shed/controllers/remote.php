<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class remote extends PSBase_Controller {

	
	
	public function __construct(){
		
		parent::__construct();
		
		
	}
	
	public function decrypt()
	{
		
		$this->load->library('encrypt');
		
		$original_hash_key = $this->config->item('encryption_key');
		
		$hashkey = $this->input->post('hashkey');
		
		$this->config->set_item('encryption_key',$hashkey);
		
		
		//$config['encryption_key'] = "YOUR KEY";
		
		
		$string = $this->input->post('string');
		
		echo $this->encrypt->decode($string);
		
		$this->config->set_item('encryption_key',$original_hash_key);
		
		
		

	}	
	
	public function encrypt()
	{
		
		$this->load->library('encrypt');
		
		$original_hash_key = $this->config->item('encryption_key');
		
		$hashkey = $this->input->post('hashkey');
		
		
		
		$this->config->set_item('encryption_key',$hashkey);
		
		$string = $this->input->post('string');
		
		echo $this->encrypt->encode($string);
		
		$this->config->set_item('encryption_key',$original_hash_key);
		
	}


	
	
	public function retrieve_password()
	{
		
		$this->load->library('encrypt');
		
		$return_array = array(
		
		'error' => '',
		'msg' => '',
		
		);
		
		$identifier = trim($this->input->post('identifier'));
		
		if($identifier == ""){
			
			
			$return_array['error'] = "email is not set";
			
			
		}else if(!$this->_checkemail($identifier)){
			
			// we will assume it is a password
			$query = $this->db->get_where("users", array("username"=>$identifier));
			
			if ($query->num_rows() > 0){
				
				$row = $query->row(); 
				
				$password = $this->encrypt->decode($row->password);	
				
				$return_array['msg'] = "Success! Password = {$password} ";
				

				
				
			}else{
				
				$return_array['error'] = "username not found";
				
			}
			
			
			
		}else{ // it is an email
			
			$query = $this->db->get_where("users", array("email_address"=>$identifier));
			
			if ($query->num_rows() > 0){
				
				$row = $query->row(); 
				
				$password = $this->encrypt->decode($row->password);	
				
				$return_array['msg'] = "Success! Password = {$password} ";
				

				
				
			}else{
				
				$return_array['error'] = "email not found";
				
				

			}	
			
			
		}
		
		
		echo json_encode($return_array);
		
	}
	
	/**
	* simply utility function for admins
	* 
	*/
	public function get_host_by_address(){
		
		$host_ip = $this->input->post('host_ip');
		
		if(intval($host_ip)>0){
			echo gethostbyaddr($host_ip);
		} else {
			echo $host_ip; // A bad address.
		} 
		
	}
	
	
	public function ip_db_lookup(){
		
		$db_lookup_ip = $this->input->get_post('db_lookup_ip');
		
		if(!intval($db_lookup_ip)>0){
			echo "invalid IP";
			return;
		} 
		
		
		$this->load->library('ip2location_lite');
		
			
		//Load the class
		$this->ip2location_lite->setKey('5cb717be86818f135e97b49724b43becf3f31fb0555113cecf951a8ade9f92df');
		
		//Get errors and locations
		$locations = $this->ip2location_lite->getCity($db_lookup_ip);
		$errors = $this->ip2location_lite->getError();
		
		//Getting the result
		echo "<p>\n";
		echo "<strong>First result</strong><br />\n";
		if (!empty($locations) && is_array($locations)) {
			foreach ($locations as $field => $val) {
				echo $field . ' : ' . $val . "<br />\n";
			}
		}
		
		echo "</p>\n";
		
		//Show errors
		echo "<p>\n";
		echo "<strong>Dump of all errors</strong><br />\n";
		if (!empty($errors) && is_array($errors)) {
			foreach ($errors as $error) {
				echo var_dump($error) . "<br /><br />\n";
			}
		} else {
			echo "No errors" . "<br />\n";
		}
		echo "</p>\n";
		


	}
	
	
	public function generate_timesheet()
	{
		
		$category = $this->input->get('category');	
		
		$this->db->where("category", $category ); 
		$query = $this->db->get('timesheet_samples');
		
		$items = array();
		
		foreach ($query->result() as $row){ 
			
			$items[] = $row->entry;
			
		}
		
		$key = rand(0, count($items)-1);
		
		echo $items[$key];
		
		
		
		
	}
	
	/**
	*
	*
	*/
	public function submit_timesheet()
	{
		
		
		$entry = $this->input->post('entry');
		$category = $this->input->post('category');	
		
		if($entry != ""){
			
			$this->db->insert('timesheet_samples', array('entry' => $entry, 'category' => $category));
			
			
		}
		
	}


	/**
	* Saves html to a temp file for loading in a previe window
	*
	*/
	public function write_preview_html()
	{
		
		$this->load->library('file_tools');
		
		$tempdir = ASSET_ROOT . "upload/" . PROJECTNAME . "/dev_shed/temp";

		$this->file_tools->create_dirpath($tempdir);
		
		$targetfile = $tempdir . "/html_preview.html";
		
		
		//$targeturl = getenv('HTTP_HOST') . str_replace( getenv('DOCUMENT_ROOT') , "", $targetfile);
		$targeturl = str_replace( getenv('DOCUMENT_ROOT') , "", $targetfile);		
		
		$html = $this->input->post('html');
		
		file_put_contents($targetfile, $html);
		
		echo $targeturl;
		
		
	}

	/**
	* Converts all special characters to html entities. Useful for HTML emails
	* 
	*
	*/
	public function character_convert()
	{
		
		$html = $this->input->post('html');

		// here is another way too
		$html = json_encode($html);
		$html = preg_replace('/\\\u([0-9a-z]{4})/', '&#x$1;', $html);
		$html = json_decode($html);
		
		echo $html;
		
	}
	
	/**
	* Remove all inline styles.
	* This is part of the process of preparing PDF converted documents to clean HTML.
	*
	*/
	public function inline_stripper()
	{
		
		$html = $this->input->post('html');

		
		$doc = new DOMDocument();
		
		$doc->loadHTML($html);
		
		$search = new DOMXPath($doc);
		
		$results = $search->evaluate('//*[@style]');
		
		foreach ($results as $result)
		$result->removeAttribute('style');
		
		
		$newhtml = $doc->saveHTML();
		

		echo $newhtml;


		
	}
	
	/**
	*
	*
	*/
	public function php_info(){
		
		
		phpinfo();
		
		
		
	}
	
	/**
	*
	*
	*/
	public function getrandomtext($lang){
		
		$this->load->library('impressto');
		
		$this->impressto->setDir( dirname(dirname(__FILE__)) . "/views/partials/" );
		
		echo $this->impressto->showpartial("random_text.tpl.php","RANDOMTEXT_" . strtoupper($lang));
		
		
		
		
	}
	

	private function _checkemail($email){
		return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
	}
	

	
}