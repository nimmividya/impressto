<?php

// sample tags
//  [widget type='admin_blog/blogarticle']
//  direct from PHP cde Widget::run('admin_blog/blogarticle, array()'name'=>'widget_1')
//  within smarty {widgets type='admin_blog/blogarticle' name='widget1'}
//  when viewing a full blog item, this widget can be set to displayfull mode

class content_list extends Widget
{

	/**
	* Default state for this widget is to list blog articles
	* by the page limit specified in blog settings
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
		$this->load->_add_module_paths('content_list');
		$this->load->model('content_list/content_list_model');
		
		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('content_list', 'content_list', $data['name']);
		
		// load the blog widget language file now...
		//$this->lang->load('blog_widgets', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
				
		$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);

		
		$data['contentlist_items'] = $this->content_list_model->getcontentlist_items($widget_args['widget_id']);
		

		

		$data['template'] = $widget_options['template'];
		
		$data['module'] = 'content_list';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'content_list';			
		
			
		echo $this->template_loader->render_template($data);
				
			
		return;
			

		 
    }
	

	
}  
