<?php

class admin_remote extends PSBase_Controller {

	private $template_folder;


	
	public function __construct(){
		
		parent::__construct();
		$this->load->helper('auth');
		
		$this->template_folder = $_SERVER["DOCUMENT_ROOT"] . "/" . PROJECTNAME . "/templates/smarty/";
		
		is_logged_in();

		$this->load->library('impressto');
		
		$this->load->model('template_model', 'model');
			
		$this->model->init_impressto();
		
		
		
	
	}
	
	
	
	/**
	* Returns a list of module widgets to
	* be used in a pulldown selector
	* @ author <galbraithdesmond@gmail.com>
	* @todo complete
	* @return JSON
	*/
	public function widget_selectorlist(){
	
	
		$lang = $this->input->get_post('lang');
		$module = $this->input->get_post('module');
		$widgettype = $this->input->get_post('widget');
		$device = $this->input->get_post('device');
		
	
		$this->load->library("widget_utils");
		
		if($module) $widgetlist = $this->widget_utils->get_widgets( $module );
		else $widgetlist = $this->widget_utils->get_widgets();
		
		$widgetoptions = array();
		
		if(is_array($widgetlist)){
		
		foreach($widgetlist AS $key => $val){
		
			// niw check to see if any templates exists for this template
			
			//$lang,$module,$widgettype,$device
			
			$sample = $this->model->listtemplates($lang,$module,$val['name'],$device);
			
			//	echo " ===$key,$val=== ";
			
			if($sample != "") $widgetoptions[$key] = $val;
		
		}
		
			
		}
		
		echo json_encode($widgetoptions);
	
	}
	
	
	
	
	
	public function savetemplate(){
	
		$this->load->library('template_loader');
					
		$template_filepath =  trim($this->input->post('template_filepath'));
				
		$template_filename =  trim($this->input->post('template_filename'));
		$template_name =  trim($this->input->post('template_name'));
		$template_author =  trim($this->input->post('template_author'));
		$template_docket =  trim($this->input->post('template_docket'));
		$template_lang =  trim($this->input->post('template_lang'));
		$template_status =  trim($this->input->post('template_status'));
		$template_date =  trim($this->input->post('template_date'));
		$template_description =  trim($this->input->post('template_description'));
		$template_content =  trim($this->input->post('template_standard_content'));

		$template_content =  str_replace("\n","",$template_content);

		
		$template_file = getenv("DOCUMENT_ROOT") . "/" . $template_filepath;
		
		
		if(file_exists($template_file)){
		
			// get the existing tags and overwrite only the ones that come in here
			
			$template_data = $this->template_loader->template_data($template_file);
			
			$template_data['Filename'] = $template_filename;
			
			if( $template_name != "" ) $template_data['Name'] = $template_name;
			if( $template_lang != "" ) $template_data['Lang'] = $template_lang;
			if( $template_docket != "" ) $template_data['Docket'] = $template_docket;
			if( $template_author != "" ) $template_data['Author'] = $template_author;
			if( $template_status != "" ) $template_data['Status'] = $template_status;
			if( $template_date != "" ) $template_data['Date'] = $template_date;
			if( $template_description != "" ) $template_data['Description'] = $template_description;
			
	
		}	


		if($template_data['Type'] == "Smarty") $new_content = "{*\n";
		else $new_content = "<" . "?php\n/*\n";
		
		foreach($template_data AS $key => $val){
		
			$new_content .= "@$key: $val\n";
		
		}
		
		
		if($template_data['Type'] == "Smarty") $new_content .= "*}\n\n";
		else $new_content .= "*/\n" . "?" . ">\n\n";
		
		$new_content .= $template_content;
		

		//echo $new_content;
		
		
		if(file_exists($template_file)){
			
			file_put_contents($template_file, $new_content);
		
			
		}
		

		
		
	}
	
	
	
	
	public function edit_template(){
		
		$projectnum = $this->config->item('projectnum');
				
		$this->load->helper('im_helper');
		
		$this->load->library('template_loader');
	
			

		$returndata = array("error"=>"","template_data"=>"","template_string"=>"");
		
		
		
		$template = $this->input->post('template');
		$lang = $this->input->post('lang');
			

		$template_file = getenv("DOCUMENT_ROOT") . "/" . $template;

		
		//echo $template_file;
		
		if(file_exists($template_file)){
		
			
			$templatecontent = file_get_contents($template_file);
						
			$template_data = $this->template_loader->template_data($template_file);
			
			if($template_data['Lang'] == "") $template_data['Lang'] = $lang;  // just a cleanup method
			
				
	
			$returndata['template_data']['Name'] = $template_data['Name'];
			$returndata['template_data']['Filename'] = basename($template);
			$returndata['template_data']['filepath'] = $template;
			$returndata['template_data']['Author'] = $template_data['Author'];
			$returndata['template_data']['Docket'] = $template_data['Docket'];
			$returndata['template_data']['Lang'] = $template_data['Lang'];
			$returndata['template_data']['Status'] = $template_data['Status'];
			$returndata['template_data']['Date'] = $template_data['Date'];
			$returndata['template_data']['Description'] = $template_data['Description'];
			
			$returndata['template_data']['Type'] = $template_data['Type'];			
		
			if(strtolower($template_data['Type']) == "smarty"){
				
				$templatecontent = $this->removeTemplateMetaTags($templatecontent, "{*", "*}");
				
			
			}else{
			
				
				$templatecontent = $this->removeTemplateMetaTags($templatecontent, "<" . "?php", "?" . ">");
				
			}
						
			$returndata['templatecontent'] = $templatecontent;
			
			
		}else{
			
			$returndata['error'] = "ERROR OPENING $template_file";
			
			
		}
		
		
		echo json_encode($returndata);
		
	}
	
	
	
	/**
	* Remove template metatags from the string
	*
	*/
	private function removeTemplateMetaTags($string, $beginstr, $endstr){
	
		$first_pos = strpos($string,$beginstr);
		
		$second_pos = strpos($string,$endstr,($first_pos+1)); //we offset so we find the second 
		
		$length = ($second_pos+1) - $first_pos; //get the length of the string between these points
		
		$removalstring = substr($string,$first_pos,$length + 1); 

		return str_replace($removalstring,"",$string);
		
	}
	
	/**
	* returns an html block that is the list for the current type of templates
	* 
	*/
	public function gettemplatelist(){
	
		$outbuf = "";
			
		$template_type = $this->input->post('template_type');
		$widget_type = $this->input->post('widget_type');
		
		if($template_type == "smarty"){
		
			$templatelist = $this->model->getsmartytemplates();
			
		}else if($widget_type != ""){
		
			$templatelist = $this->model->getwidgettemplates();
			
		
		}
		
		if(count($templatelist) > 0){

			$outbuf .= $this->impressto->showpartial("manager.tpl.html",'LISTTABLEHEAD');
		
			foreach($templatelist as $key => $data){
						
				$outbuf .= $this->impressto->showpartial("manager.tpl.html",'LISTROW', $data);
						
			
			}
			
			$outbuf .= $this->impressto->showpartial("manager.tpl.html",'LISTTABLEFOOT');
		
		
	
		
		}

	}

	/**
	* returns a list of templates as HTML
	*
	*/
	public function listtemplates(){
	
		$lang = $this->input->get_post('lang');
		$module = $this->input->get_post('module');
		$widgettype = $this->input->get_post('widget');
		$device = $this->input->get_post('device');
		
	
		$outbuf = $this->impressto->showpartial("admin.tpl.html",'LISTSMARTYHEAD');
		
		$outbuf .= $this->model->listtemplates($lang,$module,$widgettype,$device);
		
		$outbuf .= $this->impressto->showpartial("admin.tpl.html",'LISTSMARTYFOOT');
		
		echo $outbuf;
		
		
		
		
		
	}	

	
	
	public function delete_smarty_template(){
	
		$template = $this->input->post('template');
		
		$template_path = TEMPLATEPATH . "/smarty/";
		
		$template_file = $template_path . $template;
	
		$mobile_template_file = $template_path . str_replace("/standard/","/mobile/", $template);

		if(file_exists($template_file)) unlink($template_file);
		
		if(file_exists($mobile_template_file)) unlink($mobile_template_file);
		
		echo "deleted";
		//echo "deleting $mobile_template_file";	
		
		// delete the mobile version too if it exists
	
	
	}

	
	
	

} //end class