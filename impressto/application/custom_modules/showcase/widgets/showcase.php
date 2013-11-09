<?php

// sample tags
//  [widget type='showcase/showcase' bgcolor='#AA22FF' title=wawaewa]
//  direct from PHP code // Widget::run('type',$addon_args);
// within smarty {widget type='showcase/showcase'}

// note that the type shows the parent module
// within content  [widget type='showcase/showcase']

// this widget sets up the initial screen load. All AJAX function calls need to be processed through the main module controller. 
// the module controller has a variabe array named $front_ajax_functions  that contains all the function that will
// not require user authentication to process.

class showcase extends Widget
{
    function run() {
	
		
		$args = func_get_args();
		
		$this->load->model('showcase/showcase_model');	
				
		
		//$this->load->library("formelement");
						
		//$this->load->library('impressto');
		
				

		$data['category_name'] = "";
				
        // if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
					
			if(isset($args[0]['name'])) $instance = $args[0]['name'];
			
			if(isset($widget_args['category_name'])) $data['category_name'] = $widget_args['category_name'];
			
		}
		
		$gallery = $this->showcase_model->getGalleryIdByName($instance);
		
		if(!$gallery ) return;
		
		$data['module'] = 'showcase';
		$data['is_widget'] = TRUE;
					
		$data['settings'] = $this->showcase_model->getGallerySettings($gallery);
		$data['template'] = $data['settings']['template'];

		
		$data['images'] = $this->showcase_model->get_images($gallery, $data['category_name']);
		
		$data['galleryimgbase'] = "/assets/uploads/" . PROJECTNAME . "/showcase";
		
		
		//$data['debug'] = TRUE;
			
		echo $this->template_loader->render_template($data);
				
		return;
				 
    }
	
		
	
}  

