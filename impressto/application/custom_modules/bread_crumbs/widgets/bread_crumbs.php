<?php

// sample tags
//  [widget type='bread_crumbs/bread_crumbs']
//  direct from PHP code Widget::run('bread_crumbs/bread_crumbs', array('name'=>'widget_1'));

// within smarty {widget type='bread_crumbs/bread_crumbs' name='widget1'}



class bread_crumbs extends Widget
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
		
		//$this->load->_add_module_paths('bread_crumbs');
		
		$this->load->model('bread_crumbs/bread_crumbs_model');

		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('bread_crumbs', 'bread_crumbs', $data['name']);

		
			
		// load the news widget language file now...
		$this->lang->load('bread_crumbs', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
	
		$node_id = $this->config->item('page_node_id');
		$data['lang'] = $this->config->item('lang_selected');
		

		$data['breadcrumbtraildata'] = $this->bread_crumbs_model->get_trail($node_id, $data['lang'] );
		
		
		
	
		$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);

				
		$moduleoptions = ps_getmoduleoptions('bread_crumbs');

		
		// DO NOT USE $this->render unless you want to simply show PHP files
		//$this->render("newsticker/" . $widget_options['template'],$data);
		

		$data['template'] = $moduleoptions['template']; //$widget_options['template'];
		$data['module'] = 'bread_crumbs';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'bread_crumbs';	

	
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
		
		
		return;
			

		 
    }
}  

