<?php

// sample tags
//  [widget type='__skeleton_name__/__skeleton_name__']
//  direct from PHP code Widget::run('__skeleton_name__/__skeleton_name__', array('name'=>'widget_1'));

// within smarty {widget type='__skeleton_name__/__skeleton_name__' name='widget1'}



class __skeleton_name__ extends Widget
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
	
		////////////////////////////////
		// peterdrinnan - May 21, 2012
		//add the path for the widgets module so we can locate the models	
		$this->load->_add_module_paths('__skeleton_name__');
		$this->load->model('__skeleton_name__/__skeleton_name___model');

		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('__skeleton_name__', '__skeleton_name__', $data['name']);


		
			
		// load the news widget language file now...
		$this->lang->load('__skeleton_name__', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
	
	
		if(isset($widget_args['widget_id'])) $widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);

				

				
		$moduleoptions = ps_getmoduleoptions('__skeleton_name__');

		
		// DO NOT USE $this->render unless you want to simply show PHP files
		//$this->render("newsticker/" . $widget_options['template'],$data);
		

		$data['template'] = $moduleoptions['template']; // can also be $widget_options['template'] if we are using instances
		$data['module'] = '__skeleton_name__';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = '__skeleton_name__';	

	
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
		
		
		return;
			

		 
    }
}  

