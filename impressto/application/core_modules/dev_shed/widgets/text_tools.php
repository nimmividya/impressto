<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// [widget type='dev_shed/text_tools']
//  direct from PHP code Widget::run('dev_shed/text_tools');
//  within smarty {widget type='dev_shed/text_tools'}

class text_tools extends Widget 
{

	function run() {

		
		$data = array();
		
		$args = func_get_args();
		
		// if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
			
			$widget_args = $args[0];
			
		}
				
		if(isset($widget_args['rendermode'])) $data['rendermode'] = $$widget_args['rendermode'];
		else $data['rendermode'] = "";
		
		
		$this->load->library('edittools');
		$this->load->library('asset_loader');
		
		$this->load->model("tags/tags_model");
		
		if($data['rendermode'] != "popup"){
		
			$this->asset_loader->add_header_css("default/core_modules/dev_shed/css/text_tools.css");
			$this->asset_loader->add_header_js("default/core_modules/dev_shed/js/text_tools.js");
			
		}
		


		

		$this->render('text_tools/text_tools',$data);
		
		
		
	}
		

}  
