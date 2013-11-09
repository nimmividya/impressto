<?php

class webtrax_model extends My_Model{

	private $usertable;
	
	/**
	* get the base item
	*
	*/	
	public function user_record($id){
		
		$data = array();
		
		$this->usertable =  $this->db->dbprefix('users');
		
		$this->db->where('id =', $id);
		$query = $this->db->get($this->usertable);
		
		if ($query->num_rows() > 0){
			
			$row = $query->row();
			
			$data['username'] = $row->username;
			$data['email'] = $row->email_address;	
			
		}
		
		return $data;
		
	}
	

	
	/**
	*  Visitors Page
	*
	*/
	public function getvisitors($daylogarray){

		global $mod, $prevday, $search_engine_array, $prevday, $Searchword_Parser;
		
		$this->load->library('creferrer');
		
		
		$recordrows = array();

		$unique_ip_array = array();

		$daylogarray = array_reverse($daylogarray);

		/////////////////////////
		//

		foreach($daylogarray as $rec){

			$rec = trim($rec);
			$dat = explode("|",$rec);


			$inputval = trim($dat[2]);
			
			//if(!in_array($inputval,$unique_ip_array)) 
			$unique_ip_array[] = $inputval; // use the IP as the identifier
				
			

		}
		
		//
		////////////////////////	
		
		

		$new_unique_ip_array = array_count_values($unique_ip_array);

		$numrecs = 0;

		$daylogdat = array();

		foreach($daylogarray as $rec){
		
			$daylogdat[] = explode("|",$rec);
			
		}

		$numexternal = 0;

		$recorddata = array();
		
		// main loop
		
		foreach($new_unique_ip_array as $key => $val){

			$user_ip = "";
			$this_userid = "";

			$this_user_ip = $key; 
			
			$page_hits = $val;

			$start_time = "";
			$end_time = "";
			$request_device = "";
			$this_referrer = "";
			$visitor_id = "";

			foreach($daylogdat as $daylogdatrec){

				if(($this_user_ip != "" && $daylogdatrec[2] == $this_user_ip)){ // || ($this_userid != "" && $daylogdatrec[1] == $this_userid) ){

					if($end_time == ""){

						$end_time_year = substr($daylogdatrec[5],0,4);
						$end_time_month = substr($daylogdatrec[5],4,2);
						$end_time_day = substr($daylogdatrec[5],6,2);
						$end_time_hour = substr($daylogdatrec[5],8,2);
						$end_time_minute = substr($daylogdatrec[5],10,2);

						$end_time = "$end_time_hour:$end_time_minute";


						$request_device = substr($daylogdatrec[3],strpos($daylogdatrec[3],"("));
						$request_device = str_replace("(compatible; ","(",$request_device);

					}else if($end_time != "" && $page_hits > 1){

						$start_time_year = substr($daylogdatrec[5],0,4);
						$start_time_month = substr($daylogdatrec[5],4,2);
						$start_time_day = substr($daylogdatrec[5],6,2);
						$start_time_hour = substr($daylogdatrec[5],8,2);
						$start_time_minute = substr($daylogdatrec[5],10,2);

						$start_time = "$start_time_hour:$start_time_minute";
					}

					if(trim($daylogdatrec[1]) != ""){
						$visitor_id = $daylogdatrec[1];
					}
					
					$user_ip = $daylogdatrec[2];
					

					if(trim($daylogdatrec[4]) != "" && $this_referrer == ""){

						if(strpos($daylogdatrec[4],$pf->domain_name) === false){
							$this_referrer = $daylogdatrec[4];
							$numexternal ++;
						}
					}

				}
				
			}

			$numrecs++;

			/* if($this_referrer != ""){

				
				$recorddata['referrer'] = $this_referrer; 
				
				
				$recorddata['search_image_name'] = "";
				
				
				foreach($search_engine_array as $key2 => $val2){
					
					if(strpos($this_referrer,$key2) !== false){
						$recorddata['search_image_name'] = "<img src=\"". $this->webtraxasseturl. "/images/" . $val2 . "\" border=0>";
					}
					
				}
				
				
				$data['keywords'] = $this->creferrer->getKeywords($this_referrer);
				

				
			} */
			
			$recorddata['page_hits'] = $page_hits; 
			
			$data['prevday'] = $prevday;
			$recorddata['user_ip'] = $user_ip;	

			$recorddata['visitor_id'] = $visitor_id;
			
			$recorddata['username'] = "";
			
			if($visitor_id != ""){

				$usrdata = $this->user_record($visitor_id);
				
				if($usrdata['email'] != ""){

					$recorddata['username'] =$usrdata['username'] . " &lt; "  .  $usrdata['email'];

				}else{
					
					$recorddata['username'] = $usrdata['username'];
					
				}


				
			}
			

			$recorddata['start_time'] = $start_time;
			$recorddata['end_time'] = $end_time;
			
			$recorddata['request_device'] = $request_device;

			$recordrows[] = $recorddata;
			


		}

		return $recordrows;
		
		

	}
	
	
	
	///////////////////////////
	//
	// Visitors page
	//
	//////////////////////////
	public function get_unique_visitors($daylog_array, $prevday){
					
		$outbuf = "";

		$unique_visitors_array = array();

		foreach($daylog_array as $rec){
			$rec = trim($rec);
			if($rec != ""){
				$dat = explode("|",$rec);
				$unique_visitors_array[] = $dat[2];
			}
		}

		$unique_visitors_array = array_count_values($unique_visitors_array);
		$unique_today = 0;


		$thisday_numeric = date("d",mktime (0,0,0,date("m"),date("d")-($prevday-1),date("Y")));

		foreach($unique_visitors_array as $key => $val){ 
			$unique_today ++; 
		}

		$month_counts = 0;

		$monthtag = date("Ym", mktime (0,0,0,date("m"),date("d")-$prevday,date("Y")));
	
		$daymonthtag = date("Ymd", mktime (0,0,0,date("m"),date("d")-$prevday,date("Y")));

		$this_uvfile =  APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . $monthtag . "_unique_perday.txt";

		if(file_exists($this_uvfile)){

			$month_unique_array = file($this_uvfile);

			foreach($month_unique_array as $rec){
			
				list($daycount,$day) = explode("|",$rec);
				
				if($day = $thisday_numeric){
					break;
				}

			}
		}


		$total_counts = 0;

		$totalfilenamearray = array();

		$sincetag = 100000000;


		if ($handle = opendir( APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax")) {

			while (false !== ($file = readdir($handle))) { 

				if ($file != "." && $file != ".." && strpos($file,"unique_perday") !== false) { 

					$month_unique_array = file( APPPATH . PROJECTNUM . DS . "logs" . DS . "webtrax" . DS . $file);

					foreach($month_unique_array as $rec){
					
						$rec = trim($rec);
						
						if($rec == "") continue;
							
						list($daycount,$day) = explode("|",$rec);

						$test_month = str_replace("_unique_perday.txt","",$file);

						$test_monthtag = $test_month;

						$test_month .= $day;

						settype($test_monthtag, "integer");
						settype($test_month, "integer");
						settype($daymonthtag, "integer");
						settype($monthtag, "integer");

						if($test_month >= $daymonthtag){
							break; 
						}else{

							if($test_monthtag == $monthtag){
								$month_counts += $daycount;
							}

							$total_counts += $daycount;

							if($sincetag > $test_month) $sincetag = $test_month;

						}
						

					}

				}
			}
			closedir($handle); 
		}

		$thismonthdisp = date("Y M", mktime (0,0,0,(date("m")),(date("d")-$prevday),date("Y")));

		$sincetag_year = substr($sincetag,0,4);
		$sincetag_month = substr($sincetag,4,2);
		$sincetag_day = substr($sincetag,6,2);

		$data['unique_today'] = $unique_today;
		$data['thismonthdisp'] = $thismonthdisp;
		$data['sincetag_month'] = $sincetag_month;
		$data['sincetag_day'] = $sincetag_day;
		$data['sincetag_year'] = $sincetag_year;
		$data['month_counts'] = $month_counts;

		
		$data['total_counts'] = $total_counts;
		
		return $data;
		
		
	}
	
	
	
} //end class