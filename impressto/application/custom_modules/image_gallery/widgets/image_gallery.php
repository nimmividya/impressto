<?php

// sample tags
//  [widget type='image_gallery/image_gallery' bgcolor='#AA22FF' title=wawaewa]
//  direct from PHP code // Widget::run('type',$addon_args);
// within smarty {widget type='image_gallery/image_gallery'}

// note that the type shows the parent module
// within content  [widget type='image_gallery/image_gallery']

// this widget sets up the initial screen load. All AJAX function calls need to be processed through the main module controller. 
// the module controller has a variabe array named $front_ajax_functions  that contains all the function that will
// not require user authentication to process.

class image_gallery extends Widget
{
    function run() {
	
		
		$args = func_get_args();
		
		$this->load->model('image_gallery/image_gallery_model');	
				
		
		//$this->load->library("formelement");
						
		//$this->load->library('impressto');
		
				

		$data['category_name'] = "";
				
        // if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
					
			if(isset($args[0]['name'])) $instance = $args[0]['name'];
			
			if(isset($widget_args['category_name'])) $data['category_name'] = $widget_args['category_name'];
			
		}
		
		$gallery = $this->image_gallery_model->getGalleryIdByName($instance);
		
		if(!$gallery ) return;
		
		$data['module'] = 'image_gallery';
		$data['is_widget'] = TRUE;
					
		$data['settings'] = $this->image_gallery_model->getGallerySettings($gallery);
		$data['template'] = $data['settings']['template'];

		
		$data['images'] = $this->image_gallery_model->get_images($gallery, $data['category_name']);
		
		$data['galleryimgbase'] = "/assets/uploads/" . PROJECTNAME . "/image_gallery";
		
		
		//$data['debug'] = TRUE;
			
		echo $this->template_loader->render_template($data);
				
		return;
				 
    }
	
		
	
}  

