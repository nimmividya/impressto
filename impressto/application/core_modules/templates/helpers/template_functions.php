<?php


	
	function listsmartytemplates(){
	
	
		$CI = & get_instance();
		
		$outbuf = "";
		
		$data['rowalt'] = "even";
			
		$templatelist = $CI->model->get_smarty_data();
			
	
		if(count($templatelist) > 0){

			$outbuf .= $CI->impressto->showpartial("admin.tpl.html",'LISTSMARTYHEAD');
		
			foreach($templatelist as $key => $templatedata){
			
			
				if($data['rowalt'] == "even") $data['rowalt'] = "odd";
				else $data['rowalt'] = "even";
						
			
				$data['templatedata'] = $templatedata;
													
				$outbuf .= $CI->impressto->showpartial("admin.tpl.html",'LISTSMARTYROW', $data);
						
			
			}
			
			$outbuf .= $CI->impressto->showpartial("admin.tpl.html",'LISTSMARTYFOOT');
				
		}

		return $outbuf;
		
	
	}
	