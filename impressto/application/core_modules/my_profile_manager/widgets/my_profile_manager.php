<?php

// sample tags
//  [widget type='my_profile_manager/my_profile_manager']
//  direct from PHP cde Widget::run('my_profile_manager/my_profile_manager', array('name'=>'widget_1'))
// within smarty {widgets type='my_profile_manager/my_profile_manager' name='widget1'}



class my_profile_manager extends Widget
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
		// Nimmitha Vidyathilaka - May 21, 2012
		//add the path for the widgets module so we can locate the models	
		$this->load->_add_module_paths('my_profile_manager');
		$this->load->model('my_profile_manager/my_profile_manager_model');

		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('my_profile_manager', 'my_profile_manager', $data['name']);


		
			
		// load the news widget language file now...
		$this->lang->load('my_profile_manager', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
	
	
		//$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);

				
		$moduleoptions = ps_getmoduleoptions('my_profile_manager');

		
		$profile_template = $this->my_profile_manager_model->get_template($this->session->userdata('id'));
		
		if($profile_template != ""){
		
		
			$this->load->library('template_loader');
				
		
			$data['template'] = $profile_template;
			$data['module'] = 'my_profile_manager';
			$data['is_widget'] = FALSE;
			$data['widgettype'] = '';			
				
			$data['data'] = $data;

			// use this to load witht the correct filters (language, device, docket)
			//echo $this->template_loader->render_template($data);
			
			echo $this->template_loader->render_template($data);
		
		
			
		}else{
		
			//$data['main_content'] = "themes/" . $this->config->item('admin_theme') . '/admin/my_profile';
		
			$this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/my_profile', $data); 
		

			
		}
		
		
		return;
			

		 
    }
}  

