<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// [widget type='sticky_notes/sticky_notes']
//  direct from PHP code Widget::run('sticky_notes/sticky_notes');
//  within smarty {widget type='sticky_notes/sticky_notes'}

//class sticky_notes extends Admin_Widget{


class sticky_notes extends Admin_Widget{

	function run() {
	
		$data = array();

		$args = func_get_args();
		
		// if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
			
			$widget_args = $args[0];
			
		}
	
		$data['content_id'] = $widget_args['content_id'];
		$data['lang'] = $widget_args['lang'];
		$data['user_id'] = $widget_args['user_id'];
		$data['sticky_id'] = isset($widget_args['sticky_id']) ? $widget_args['sticky_id'] : "";
		
		
		$this->load->library('edittools');
		$this->load->library('asset_loader');
		
		$this->load->helper('sticky_notes/sticky_notes');
				
		$module_version = $this->_get_module_version('sticky_notes');
		
		return $this->render('sticky_notes/sticky_notes',$data, TRUE);
		
	}
	


}


