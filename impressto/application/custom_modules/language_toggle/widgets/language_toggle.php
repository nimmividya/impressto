<?php

// sample tags
//  [widget type='language_toggle/language_toggle']
//  direct from PHP code Widget::run('language_toggle/language_toggle', array('name'=>'widget_1'));

// within smarty {widget type='language_toggle/language_toggle' name='widget1'}



class language_toggle extends Widget
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
		$this->load->_add_module_paths('language_toggle');
		$this->load->model('language_toggle/language_toggle_model');

		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('language_toggle', 'language_toggle', $data['name']);


		
			
		// load the news widget language file now...
		$this->lang->load('language_toggle', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
	
	
		//$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);

				
		$moduleoptions = ps_getmoduleoptions('language_toggle');

		
		// detect language
		$data['lang_selected'] = $this->config->item('lang_selected');
	
		$node_id = $this->config->item( 'page_node_id' );
	

		$lang_avail = $this->config->item('lang_avail');


		foreach($lang_avail AS $langcode=>$language){ 
		

			$table = 'content_' . $langcode;
				
			$query = $this->db->get_where($table, array('CO_Node' => $node_id ));
	
			if ($query->num_rows() > 0){
		
				$data['url_' . $langcode] = $query->row()->CO_Url;

			}	 
		
		}
		

	
	
		

		$data['template'] = $moduleoptions['template']; // can also be $widget_options['template'] if we are using instances
		$data['module'] = 'language_toggle';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'language_toggle';	

	
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
		
		
		return;
			

		 
    }
}  

