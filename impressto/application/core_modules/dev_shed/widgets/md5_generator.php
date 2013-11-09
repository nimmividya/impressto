<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// [widget type='dev_shed/text_tools']
//  direct from PHP code Widget::run('dev_shed/text_tools');
//  within smarty {widget type='dev_shed/text_tools'}

class md5_generator extends Widget 
{

	function run() {

		
		$data = array();
		
		$args = func_get_args();
		
		// if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
			
			$widget_args = $args[0];
			
		}
				
		if(isset($widget_args['rendermode'])) $data['rendermode'] = $widget_args['rendermode'];
		else $data['rendermode'] = "";
		
		
		$this->load->library('edittools');
		$this->load->library('asset_loader');
		
		
		if($data['rendermode'] != "popup"){
		
			$this->asset_loader->add_header_css("default/core_modules/dev_shed/css/md5_generator.css");
			$this->asset_loader->add_header_js("default/core_modules/dev_shed/js/md5_generator.js");
			
		}

		$this->render('md5_generator/md5_generator',$data);
				
		
	}
		

}  
