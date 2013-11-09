<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* File tag_list description
*
* This displays a list of tags associated with the current content type and content id 
*
* Sample tags:
*  [widget type='tag_list' content_module='page_manager' content_id='1']
*   direct from PHP code Widget::run('tag_list' , array('content_module'=>'page_manager', 'content_id'=>1));
*   within smarty {widget type='tag_list' content_module='page_manager' content_id='1'}
*
*/

class tag_list extends Widget
{



	function run() {
		
		$args = func_get_args();

		$news_id = $this->input->get_post('news_id');

		$data = array();
		
		$data['tag_key'] = "tag";
		$data['module'] = "";
						
		
		// if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
			
			$widget_args = $args[0];

			if(isset($args[0]['content_id'])) $data['content_id'] = $args[0]['content_id'];			
			if(isset($args[0]['content_module'])) $data['content_module'] = $args[0]['content_module'];
			if(isset($args[0]['tag_key'])) $data['tag_key'] = $args[0]['tag_key'];
			if(isset($args[0]['module'])) $data['module'] = $args[0]['module'];

			$data['target_page'] = isset($args[0]['target_page']) ? $args[0]['target_page'] : "";
					
			
		}
		
			
		
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/core_modules/tags/css/tag_list.css"); 
				
		
		$data['lang'] = $this->config->item('lang_selected');
					
		$data['moduleoptions'] = ps_getmoduleoptions($data['content_module']);
		
		if($data['target_page'] == "") $data['target_page'] = $data['moduleoptions'][$data['content_module'] . '_page_' . $data['lang']];
		
		
	
		$this->load->model('tags/tags_model');
		
		$data['tags'] = $this->tags_model->get_tags($data['lang'], $data['content_module'], $data['content_id']);
		
					
		$this->render('tag_list/tag_list',$data);
		
		
	}
		

}  
