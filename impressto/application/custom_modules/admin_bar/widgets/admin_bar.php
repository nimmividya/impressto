<?php

// sample tags
//  [widget type='admin_bar/admin_bar']
//  direct from PHP code Widget::run('admin_bar/admin_bar', array('name'=>'widget_1'));

// within smarty {widget type='admin_bar/admin_bar' name='widget1'}



class admin_bar extends Widget
{
    function run() {
	
		// if the ure role is not correct just bail here.
		if($this->session->userdata('role') != 1) return;

	
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
		$this->load->_add_module_paths('admin_bar');
		$this->load->model('admin_bar/admin_bar_model');

		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('admin_bar', 'admin_bar', $data['name']);


		
			
		// load the news widget language file now...
		$this->lang->load('admin_bar', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
	
	
		if(isset($widget_args['widget_id'])) $widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);

				
		$moduleoptions = ps_getmoduleoptions('admin_bar');

		
		// DO NOT USE $this->render unless you want to simply show PHP files
		//$this->render("newsticker/" . $widget_options['template'],$data);
		

		$data['template'] = $moduleoptions['template']; // can also be $widget_options['template'] if we are using instances
		$data['module'] = 'admin_bar';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'admin_bar';	
		
		$data['page_id'] = $this->config->item('page_id');
		$data['site_lang'] = $this->config->item('site_lang');
		
		
		if($data['page_id'] != ""){
		
			$this->load->model('public/ps_content');
					
			$pagedata = $this->ps_content->getcontentdata($data['page_id']);
			
			$data['pagedata'] = $pagedata[0];
			
		}
		
		// use this to load witht the correct filters (language, device, docket)
		return $this->template_loader->render_template($data);
		
		//return;
			

		 
    }
}  

