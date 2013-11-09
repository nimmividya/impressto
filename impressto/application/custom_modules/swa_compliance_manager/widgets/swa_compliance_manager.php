<?php

// sample tags
//  [widget type='swa_compliance_manager/swa_compliance_manager']
//  direct from PHP cde Widget::run('swa_compliance_manager/swa_compliance_manager', array('name'=>'widget_1'))
// within smarty {widgets type='swa_compliance_manager/swa_compliance_manager' name='widget1'}



class swa_compliance_manager extends Widget
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
		$this->load->_add_module_paths('swa_compliance_manager');
		$this->load->model('swa_compliance_manager_model');

		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('swa_compliance_manager', 'swa_compliance_manager', $data['name']);


		
			
		// load the news widget language file now...
		$this->lang->load('swa_compliance_manager', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
	
	
		$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);

				
		$moduleoptions = ps_getmoduleoptions('swa_compliance_manager');

		
		// DO NOT USE $this->render unless you want to simply show PHP files
		//$this->render("newsticker/" . $widget_options['template'],$data);
		

		$data['template'] = $widget_options['template'];
		$data['module'] = 'swa_compliance_manager';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'swa_compliance_manager';	

	
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
		
		
		return;
			

		 
    }
}  

?>
