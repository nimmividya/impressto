<?php

// sample tags
//  [widget type='admin_news/newsticker']
//  direct from PHP cde Widget::run('admin_news/newsticker', array('name'=>'widget_1'))
// within smarty {widgets type='admin_news/newsticker' name='widget1'}

// when viewing a full news item, this widget can be set to displayfull mode

class newsticker extends Widget
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
		//$this->load->_add_module_paths('admin_news');
		
		
		$this->load->model('admin_news/news_model');

		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('newsticker', 'admin_news', $data['name']);


		
			
		// load the news widget language file now...
		$this->lang->load('news_widgets', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
	

		
		$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);

	
				
		$moduleoptions = ps_getmoduleoptions('admin_news');
		
		if(!isset($moduleoptions['admin_news_page_' . $lang_selected])){
		
			$data['newspageurl'] = $this->current_url();
					
			$error = " MISSING news page link. See news settings ";
			
		}else{
			$data['newspageurl'] = $moduleoptions['admin_news_page_' . $lang_selected];
		}
		
		if(!isset($moduleoptions['news_title_' . $lang_selected])){
		
			$data['newspagetitle'] = ""; 
			
		}else{
			$data['newspagetitle'] = $moduleoptions['news_title_' . $lang_selected];
		}
		
		
		$newsrecords = $this->news_model->get_news_items();
		

		
		
		$data['newsitems'] = $newsrecords['limitedrecords'];
		$data['totalnewscount'] = $newsrecords['totalrowcount'];
		

		
		// DO NOT USE $this->render unless you want to simply show PHP files
		//$this->render("newsticker/" . $widget_options['template'],$data);
		

		$data['template'] = $widget_options['template'];
		$data['module'] = 'admin_news';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'newsticker';	

	
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
		
		
		return;
			

		 
    }
	
	private function current_url() {
		
		//global $_SERVER;

		$pageURL = 'http';
		//if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}

		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
}  


