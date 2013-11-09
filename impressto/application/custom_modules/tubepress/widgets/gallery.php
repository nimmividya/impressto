<?php

// sample tags
//  [widget type='videos/youtube']
//  direct from PHP cde Widget::run('admin_news/newsarticle, array()'type'=>'widget_1')
//  within smarty {widgets type='admin_news/newsarticle' type='widget1'}
//  when viewing a full news item, this widget can be set to displayfull mode

class gallery extends Widget
{

	/**
	* Default state for this widget is to list news articles
	* by the page limit specified in news settings
	*
	*/
    function run() {
	
		$error = "";
	
		$this->load->library('asset_loader');
		$this->load->library('widget_utils');
	
		$args = func_get_args();

		
		$lang_selected = $this->config->item('lang_selected');
	
        // if paramaeters have been passed to this widget, assign them	and override the defaults for this widget instance
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
				
			if(isset($args[0]['name'])) $data['name'] = $args[0]['name'];
			
		}
	
		
		////////////////////////////////
		// peterdrinnan - May 21, 2012
		//add the path for the widgets module so we can locate the models	
		//$this->load->_add_module_paths('tubepress');
		$this->load->model('tubepress/tubepress_model');
		
	

		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])){
		
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('gallery','tubepress', $data['name']);
			
	
		}
		
		
		
		$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);
			
		
		$settings = $this->tubepress_model->get_settings($widget_args['widget_id']);
					
					
					
		
		global $tubepress_asset_url, $tubepress_base_url;
		
		
		$tubepress_base_url = '/' . PROJECTNAME . '/vendor/tubepress_pro';
		$tubepress_asset_url =  ASSETURL  . 'vendor/tubepress_pro';
		
		
		include_once (INSTALL_ROOT . '/vendor/tubepress_pro/sys/classes/TubePressPro.class.php');
		
		$header_asset_calls = TubePressPro::getHtmlForHead(false);
			
		$this->asset_loader->add_misc_header_assets("tubepress",$header_asset_calls );
			
		// these key/pair values come from the model
		
		$shortcodevals = "";
		
		$debugging_enabled = FALSE;
		
		$data['debug_data'] = FALSE;
		
		foreach($settings AS $key => $val){
		
			if($val != "") $shortcodevals .= "$key='$val' ";

			if($key == "debugging_enabled" && $val == "true") $debugging_enabled = TRUE;
						
		}
	
		
		$shortcodevals = trim($shortcodevals);
		
		if($debugging_enabled){
		
			$data['debug_data'] = array();
				
			foreach($settings AS $key => $val){
		
				if($val != "") $data['debug_data'][$key] = $val;
				
			}
			
		}
				
		//echo $shortcodevals;
		
		
		$data['widgetbody'] = TubePressPro::getHtmlForShortcode($shortcodevals); 

		
		$data['template'] = $widget_options['template'];
			
		$data['module'] = 'tubepress';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'gallery';			
		
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);

		
		return;
			

		 
    }
	
	
	
	private function current_url() {
		
		//global $_SERVER;

		$pageURL = 'http';
		//if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}

		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
}  
