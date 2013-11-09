<?php

/*
	
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
	
*/	
	/**
	* 
	*
	
	function listwidgettemplates($widget_type){
	
	
		$CI = & get_instance();
		
		$outbuf = "";
		
		$data['rowalt'] = "even";
			
		$templatelist = $CI->model->get_widgettemplate_data($widget_type);
					
	
		if(count($templatelist) > 0){

			$outbuf .= $CI->impressto->showpartial("admin.tpl.html",'LISTWIDGETTEMPLATEHEAD');
		
			foreach($templatelist as $key => $templatedata){
			
			
				if($data['rowalt'] == "even") $data['rowalt'] = "odd";
				else $data['rowalt'] = "even";
						
			
				$data['templatedata'] = $templatedata;
													
				$outbuf .= $CI->impressto->showpartial("admin.tpl.html",'LISTWIDGETTEMPLATEROW', $data);
						
			
			}
			
			$outbuf .= $CI->impressto->showpartial("admin.tpl.html",'LISTWIDGETTEMPLATEFOOT');
				
		}

		return $outbuf;
		
	
	}
	
	*/