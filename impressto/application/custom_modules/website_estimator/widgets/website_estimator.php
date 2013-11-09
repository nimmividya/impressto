<?php

// sample tags
//  [widget type='website_estimator/website_estimator']
//  direct from PHP code Widget::run('website_estimator/website_estimator', array('name'=>'widget_1'));

// within smarty {widget type='website_estimator/website_estimator' name='widget1'}



class website_estimator extends Widget
{
    function run() {
	
	
		$this->load->library('asset_loader');
		$this->load->library('widget_utils');
		
	
		$args = func_get_args();
		
		$lang_selected = $this->config->item('lang_selected');
		
		
		$data = array();
		
						
        // if paramaeters have been passed to this widget, assign them	and override the defaults for this widget instance
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
					
			if(isset($args[0]['name'])) $data['name'] = $args[0]['name'];
			
		}
	

		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('website_estimator', 'website_estimator', $data['name']);


		
			
		// load the news widget language file now...
		$this->lang->load('website_estimator', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
	
	
		if(isset($widget_args['widget_id'])) $widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);

				

				
		$moduleoptions = ps_getmoduleoptions('website_estimator');

		
		// DO NOT USE $this->render unless you want to simply show PHP files
		//$this->render("newsticker/" . $widget_options['template'],$data);
		

		$data['template'] = $moduleoptions['template']; // can also be $widget_options['template'] if we are using instances
		$data['module'] = 'website_estimator';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'website_estimator';	

	
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
		
		
		return;
			

		 
    }
}  

