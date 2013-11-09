<?php

/**
* Similar to WP Dashboard Widgets in concept
* Admin Widget for the content editor
* creates a new tab and adds a new interface to the admin interface
* allowing banners to be uploaded and linked to pages
*
* This is the first example of a hook-in widget for use in the backend 
* It is setup in module config folder under the widget_hooks.config.php file
*
*/


class banner_picker extends Widget
{
    function run() {
	
		
		$args = func_get_args();
		
		
        // if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
					
			if(isset($widget_args['category_name'])) $data['category_name'] = $widget_args['category_name'];
			
		}
		

				 
    }
	
		
	
}  

