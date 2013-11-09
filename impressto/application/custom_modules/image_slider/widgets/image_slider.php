<?php

// sample tags
//  [widget type='bg_pos_slider/bg_widget' bgcolor='#AA22FF' title=wawaewa]
//  direct from PHP cde Widget::run('image_slider, array()'name'=>'widget_1')
// within smarty {widget type='image_slider' name='widget1'}
// PHP directly
// Widget::run('type',$addon_args);

class image_slider extends Widget
{
    function run() {
	
		$this->load->library('asset_loader');
		$this->load->library('widget_utils');

		$lang = $this->config->item('lang_selected');
					
		$args = func_get_args();
		
				
        // if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
			
			if(isset($widget_args['name']) && !isset($widget_args['instance'])) $widget_args['instance'] = $widget_args['name'];
					
			
		}
		
		if(!isset($widget_args['widget_id']) && isset($widget_args['instance'])){
		
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('image_slider', 'image_slider', $widget_args['instance']);
		}

		$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);
		

	
		$this->load->model('image_slider/image_slider_model');
				
		$data['imagelist'] = $this->image_slider_model->get_public_slidelist($widget_args['instance'], $lang);
		
		//print_r($data['imagelist']);
		
		$data['slideshow_setting'] = $this->image_slider_model->getslideshow_settings($widget_args['instance']);
		
		$data['widget_name'] = $widget_args['instance'];
		
			
		$data['template'] = $widget_options['template'];
		
		$data['module'] = 'image_slider';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = '';			
		
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);

		return;

			

		 
    }
}  
