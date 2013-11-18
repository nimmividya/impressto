<?php

// sample tags
//  [widget type='admin_blog/blogticker']
//  direct from PHP cde Widget::run('admin_blog/blogticker', array('name'=>'widget_1'))
// within smarty {widgets type='admin_blog/blogticker' name='widget1'}

// when viewing a full blog item, this widget can be set to displayfull mode

class blogticker extends Widget
{
    function run() {
	
	
		$this->load->library('asset_loader');
		$this->load->library('widget_utils');
		
	
		$args = func_get_args();

		
						
        // if paramaeters have been passed to this widget, assign them	and override the defaults for this widget instance
		if(isset($args[0]) && is_array($args[0])){
		
			$widget_args = $args[0];
					
			if(isset($args[0]['name'])) $data['name'] = $args[0]['name'];
			
		}
	
		////////////////////////////////
		// Nimmitha Vidyathilaka - May 21, 2012
		//add the path for the widgets module so we can locate the models	
		$this->load->_add_module_paths('admin_blog');
		$this->load->model('blog_model');

		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('blogticker', 'admin_blog', $data['name']);
			
			
		// load the blog widget language file now...
		$this->lang->load('blog_widgets', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
				
		$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);
		
		
		
		$moduleoptions = ps_getmoduleoptions('admin_blog');
		
		//print_r($moduleoptions);
		//echo "LANG = " . $this->config->item('lang_selected');
		
		
		$data['blog_page'] = $moduleoptions['admin_blog_page_' . $this->config->item('site_lang')];
		
				
		
		$blogrecords = $this->blog_model->get_blog_items();
			
		$data['blogitems'] = $blogrecords['limitedrecords'];
		$data['totalblogcount'] = $blogrecords['totalrowcount'];
			
		
		// DO NOT USE $this->render unless you want to simply show PHP files
		//$this->render("blogticker/" . $widget_options['template'],$data);
		

		$data['template'] = $widget_options['template'];
		$data['module'] = 'admin_blog';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'blogticker';			

		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
		
		return;
			

		 
    }
}  

?>
