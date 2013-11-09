<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_remote extends PSBase_Controller {

	public $daylog;
	public $webtraxasseturl;

	
	public function __construct(){
		
		parent::__construct();
		
		$this->benchmark->mark('code_start');
		
		$this->load->helper('auth');
		$this->load->model('webtrax_model');
		
		is_logged_in();
		
		$this->webtraxasseturl = ASSETURL  . PROJECTNAME . "/default/core_modules/webtrax/images";

		
		$prevday = 0;
		
		if($this->input->get('prevday') != "") $prevday = $this->input->get('prevday');
		
		
		$daylog = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . date("Ymd") . ".txt";

		$this->daylog = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . date("Ymd") . ".txt";
		
		if($prevday == 0){
			$daylogtitletime = date("l d F, Y");
		}else{
			$daylogtitletime = date("l d F, Y",mktime (0,0,0,date("m"),date("d")-$prevday,date("Y")));
			$this->daylog = APPPATH . PROJECTNUM . DS .  "logs" . DS . "webtrax" . DS . "archive_" .  date("Ymd",mktime (0,0,0,date("m"),date("d")-$prevday,date("Y"))) . ".txt";
		}
		
		
	}
	
	

	
	public function track_user($prevday, $id){
		
		$useIP = FALSE;
		
		if($this->is_valid_ipv4($id)) $useIP = TRUE;
		
		
		$recrows = array();
		

		if($prevday == "") $prevday = 0;
		
		$daylog = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . date("Ymd") . ".txt";
		
		if(!file_exists($daylog) && $prevday == 0){
			$prevday =1;
		}
		
		if($prevday == 0){
			$daylogtitletime = date("l d F, Y");
			$daylogarray = file($daylog);
		}else{
			$daylogtitletime = date("l d F, Y",mktime (0,0,0,date("m"),date("d")-$prevday,date("Y")));
			$daylog = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . "archive_" .  date("Ymd",mktime (0,0,0,date("m"),date("d")-$prevday,date("Y"))) . ".txt";
		}

		
		$data['asseturl'] = ASSETURL  . PROJECTNAME ."/default/core_modules/webtrax/images";
		
		
		$my_domain_name = $this->mydomain();
		
		//echo "IT IS $my_domain_name ";

		if(file_exists($daylog)){
			
			$daylogarray = file($daylog);
			
			foreach($daylogarray as $rec){
				
				
				$recrow = array();
				
				
				$showrec = FALSE;
				
				$dat = explode("|",$rec);
				
				
				$url = $dat[0];
				$id = $dat[1];
				$ip = $dat[2];
				$agent = $dat[3];
				$referrer = $dat[4];
				$time = $dat[5];
				
				
				if($useIP && $ip == $id) $showrec = TRUE;
				else if($dat[1] == $id) $showrec = TRUE;
				
				
				$searchicon = "";
				$exdom_name = "";
				
				$hit_hour = "";
				$hit_minute = "";
							
				
				if($showrec) {
					
					$hit_hour = substr($time,8,2);
					$hit_minute = substr($time,10,2);
					
					if(trim($referrer) != ""){ // domain name
					
					
						
						$exdom_name = str_replace("http://","",$referrer);
						$exdom_name = str_replace("www.","",trim($exdom_name));
						
						if(strpos($exdom_name,"/") !== false){
							$exdom_name = substr(trim($exdom_name), 0, strpos(trim($exdom_name),"/"));
							if(substr_count($exdom_name,".") > 1){
								$exdom_name = substr(trim($exdom_name), strpos(trim($exdom_name),".") +1);
							}
						}
						

						if(strpos($referrer,$my_domain_name) === false){
							
		
							foreach($search_engine_array as $key => $val){
								if(strpos($referrer,$key) !== false) $searchicon = $val;
							}

							
						}
						
					}		

				}	
				
				$recrow['searchicon'] = $searchicon;
				
				$recrow['url'] = $url;
				$recrow['id'] = $id;
				$recrow['ip'] = $ip;
				$recrow['agent'] = $agent;
				$recrow['referrer'] = $referrer;
				$recrow['time'] = $time;
				
				$recrow['hit_hour'] = $hit_hour;
				$recrow['hit_minute'] = $hit_minute;
				$recrow['exdom_name'] = $exdom_name;
				
				$recrow['exdom_name'] = $exdom_name;
				
				
				$recrows[] = $recrow;
				
			}
		
			
		}

		$data['recrows'] = $recrows;
		
		echo $this->load->view('webtraxuserfollow', $data, TRUE);	
		
		
		
	}
	
	
	
	/**
	* 
	*
	*/
	public function load($prevday = 0){
	
		$data['webtraxdayview'] = $this->webtraxdayview($prevday);	
		
		// since this is an initial screen load we want to run initialization code
		
		$data['javascript'] = "<script> ps_webtrax.init(); </script>";
		
			
		echo $this->load->view('webtrax', $data, TRUE);	
		
		
	
	}
	
	
	
	/**
	* 
	*
	*/
	public function showday($prevday){
		
		echo $this->webtraxdayview($prevday);	

	}
	
	
	/**
	* 
	*
	*/
	public function webtraxdayview($prevday){
		
		
		$this->load->helper('webtrax');
		
		$daylog = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . date("Ymd") . ".txt";

		$this->daylog = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . date("Ymd") . ".txt";
		
		if($prevday == 0){
			$daylogtitletime = date("l d F, Y");
		}else{
			$daylogtitletime = date("l d F, Y",mktime (0,0,0,date("m"),date("d")-$prevday,date("Y")));
			$this->daylog = APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . "archive_" .  date("Ymd",mktime (0,0,0,date("m"),date("d")-$prevday,date("Y"))) . ".txt";
		}

		$datestamp = date("Ymd",mktime (0,0,0,date("m"),date("d")-$prevday,date("Y")));
		
	
		$this_datestamp_year = substr($datestamp,0,4);
		$this_datestamp_month = substr($datestamp,4,2);
		$this_datestamp_day = substr($datestamp,6,2);
		
		$dayofweek = date("l",mktime (0,0,0,date("m"),date("d")-$prevday,date("Y")));
		
		$datestamp = "Day Visitors for $dayofweek, " . $this_datestamp_year . "/" . $this_datestamp_month . "/" . $this_datestamp_day;
		

		if(file_exists($this->daylog)){
			
			$daylog_array = file($this->daylog);
			
			list($numuniquevisitors, $uniquevisitors) = $this->ShowUniqueVisitors($daylog_array, $prevday);
			
			$data['numuniquevisitors'] = $numuniquevisitors;
			$data['uniquevisitors'] = $uniquevisitors;
			
			list($numvisitors, $visitors) = $this->ShowVisitors($daylog_array);
			
			$data['visitors'] = $visitors;
			$data['numvisitors'] = $numvisitors;
			
						
		}else{
		
			return "<script> ps_webtrax.disableprevbtn(); </script>";
		
		}
		
		
		return $this->load->view('webtraxdayview', $data, TRUE);	
		
	

	}
	
	
	
	
	///////////////////////////
	//
	// Visitors page
	//
	//////////////////////////
	private function ShowUniqueVisitors($daylog_array, $prevday){


	

		$data = $this->webtrax_model->get_unique_visitors($daylog_array, $prevday);
		
		$data['asseturl'] = ASSETURL  . PROJECTNAME . "/default/core_modules/webtrax/images";
		
		
		$output = $this->load->view('unique_users', $data, true);
		
		return array($data['unique_today'],$output);
		
		

	}



	/**
	*  Visitors Page
	*
	*/
	private function ShowVisitors($daylogarray){

		global $mod, $prevday, $search_engine_array, $prevday, $Searchword_Parser;

		$recordrows = $this->webtrax_model->getvisitors($daylogarray);		

		$data['asseturl'] = ASSETURL  . PROJECTNAME . "/default/core_modules/webtrax/images";
		
		$data['recordrows'] = $recordrows;

		$data['numrecs'] = $numrecs;
		$data['numexternal'] = $numexternal;
		$data['daylogtitletime'] = $daylogtitletime;
		
		$output = $this->load->view('showusers', $data, true);
		
		return array($numrecs, $output);
		

	}
	
	/**
	*
	*
	*/
	private function is_valid_ipv4($ip){
		
		return preg_match('/\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.'.
		'(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.'.
		'(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.'.
		'(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/', $ip) !== 0;
		
	}
	
	private function mydomain(){
		
		//$CI =& get_instance();
		return preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/","$1", $this->config->slash_item('base_url'));
		
	} 
	
	


	
}