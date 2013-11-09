<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// sample tags
//  [widget type='content_blocks/content_blocks' bgcolor='#AA22FF' name=widgetname]
//  direct from PHP code Widget::run('content_blocks', array('name'=>'widgetname'));
// within smarty {widget type='content_blocks' name='widgetname'}

// when viewing a full news item, this widget can be set to displayfull mode

class content_blocks extends Widget
{
    function run() {
	

		$args = func_get_args();
		
		$this->load->library('template_loader');
		$this->load->library('file_tools'); // we do not actually need this but for some reason it is expected somehwere in the depths of mordor ...
				
	
        // if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
		

		
			$widget_args = $args[0];
					
			if(isset($args[0]['instance'])) $instance = $args[0]['instance'];

			if(isset($args[0]['name'])) $instance = $args[0]['name'];
			
			$this->load->model('content_blocks/content_widget_model','widget_model');
			
		
			
			$data = $this->widget_model->getwidgetdata($instance);
			
			if($data['javascript'] != "" || $data['css'] != ""){
			
				$this->load->library('asset_loader');
				
				if($data['javascript'] != "") $this->asset_loader->add_header_js_string($data['javascript']);
				
				if($data['css'] != "") $this->asset_loader->add_header_css_string($data['css']);			
				
			}

					
			$data['content'] = $this->phpparse_string($data['content']);
			
			$data['content'] = $this->process_sub_widgets($data['content']);
			
					

			$data['module'] = 'content_blocks';
			$data['is_widget'] = TRUE;
		
			
			echo $this->template_loader->render_template($data);
			
			
	
		}
		
		return;
			

		 
    }
}  

?>
