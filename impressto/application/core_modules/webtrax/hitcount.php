<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function hitme(){

	global $nullwebstats;
	
	$CI =& get_instance();
	
	// jist load the webtrax config the old fasioned way
	require_once(APPPATH . 'core_modules/webtrax/config/webtrax.php');  
		
	$id = $CI->session->userdata('id');
	
	$CI->load->helper('webtrax');

	
	$REQUEST_URI = getenv("REQUEST_URI");

	if(    strpos($REQUEST_URI,"expandcats=") !== false 
			|| strpos($REQUEST_URI,".gif") !==  false 
			|| strpos($REQUEST_URI,".jpg") !==  false 
			|| strpos($REQUEST_URI,".png") !==  false 
			|| strpos($REQUEST_URI,".jpeg") !==  false 
			|| strpos($REQUEST_URI,".ico") !==  false 
			|| strpos($REQUEST_URI,ASSETURL) !==  false 
			|| strpos($REQUEST_URI,"webtrax") !==  false 
			|| $CI->input->is_ajax_request()
			
			){
		$nullwebstats = TRUE;
	}


	if(!$nullwebstats){


		foreach($_ENV as $envvar => $envval){ ${$envvar} = $envval; }
		foreach($_SERVER as $servervar => $serverval){ ${$servervar} = $serverval; }
		
		if(!file_exists(APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS)){
			$CI->load->library('file_tools');
			$CI->file_tools->create_dirpath(APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS);
		}
		
				
		$todayslog = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . date("Ymd") . ".txt";
		
			
		if(file_exists($todayslog)){ $fp = fopen($todayslog, "a+"); }
		else{ $fp = fopen($todayslog, "w"); }

		if(strpos($REQUEST_URI,"?PHPSESSID") !== false){
			$REQUEST_URI = substr($REQUEST_URI, 0, strpos($REQUEST_URI,"?PHPSESSID"));
		}

		if(strpos($REQUEST_URI,"&PHPSESSID") !== false){
			$REQUEST_URI = substr($REQUEST_URI, 0, strpos($REQUEST_URI,"&PHPSESSID"));
		}

		$REQUEST_URI = str_replace("http://","",$REQUEST_URI);
		$REQUEST_URI = str_replace("https//","",$REQUEST_URI);
		$REQUEST_URI = str_replace("//","/",$REQUEST_URI);

		$this_referer = "";
		

		if(strpos(getenv("HTTP_REFERER"),$CI->config->item('base_url')) === false) {
			$this_referer = getenv("HTTP_REFERER");
		}

		$http_user_agent = getenv("HTTP_USER_AGENT");
		
		$request_device = substr($http_user_agent,strpos($http_user_agent,"("));
		$request_device = str_replace("(compatible; ","(",$request_device);

		$contentOfEntry = "";

		$requested_page = $REQUEST_URI;
		
		$settings = $config['settings'];
		
		if($settings['request_uri']) $contentOfEntry .= $REQUEST_URI;
		$contentOfEntry .= "|";

		if($settings['profile']) $contentOfEntry .= $id; //$pf->profile['Basic']['ID'];
		$contentOfEntry .= "|";

		if($settings['remote_addr']) $contentOfEntry .= $REMOTE_ADDR;
		$contentOfEntry .= "|";

		if($settings['request_device']) $contentOfEntry .= $request_device;
		$contentOfEntry .= "|";

		if($settings['this_referer']) $contentOfEntry .= $this_referer;
		$contentOfEntry .= "|";

		$contentOfEntry .= date("YmdHis") . "|\n";
		
		$write = fputs($fp, $contentOfEntry);

		fclose($fp);


		$prevdayfile = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . date("Ymd",mktime (0,0,0,date("m"),date("d")-1,date("Y"))) . ".txt";

		if(file_exists($prevdayfile)) {
			process_prevday($prevdayfile);
		}


	}

	
	
}

