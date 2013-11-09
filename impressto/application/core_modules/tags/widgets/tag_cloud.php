<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* File tag_list description
*
* This displays a list of tags associated with the current content type and content id 
*
* Sample tags:
*  [widget type='tag_list' content_type='page_manager' content_id='1']
*   direct from PHP code Widget::run('tag_list' , array('content_type'=>'page_manager', 'content_id'=>1));
*   within smarty {widget type='tag_list' content_type='page_manager' content_id='1'}
*
*/

class tag_cloud extends Widget
{


	function run() {
		
		$args = func_get_args();

		$data = array();
		
		// if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
			
			$widget_args = $args[0];
			
			if(isset($args[0]['name'])) $data['name'] = $args[0]['name'];
			
		}
		
		
		

		
		
		
		$lang = $this->config->item('lang_selected');
			
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
			$widget_args['widget_id'] = $this->widget_utils->getwidgetid('tag_cloud', 'tags', $data['name']);
			
						
		$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);
	
		$content_module = $widget_options['content_module'];
		
		$moduleoptions = ps_getmoduleoptions('tags');

		$data['tag_target'] = $moduleoptions[$content_module . '_tag_target'];
		
	
		$searchtags_table = $this->db->dbprefix . 'searchtags_' . $lang;
		$searchtags_bridge_table = $this->db->dbprefix . 'searchtags_bridge_' . $lang;
		
		///////////////////
		// this stuff should all be in a model
		$sql = "SELECT MAX(frequency) as num FROM {$searchtags_table}";
		$num = $this->db->query($sql)->row()->num; 
			

	
		if($num <10) $num = 10;
		
		$data['factor'] = $num/7;
		  
		$sql = "SELECT TAGS.tag, TAGS.frequency "
		. " FROM {$searchtags_table} AS TAGS "
		. " LEFT JOIN {$searchtags_bridge_table} AS TBRIDGE ON TAGS.id = TBRIDGE.tag_id ";
		
		if($content_module != "") $sql .= " WHERE TBRIDGE.content_module = '{$content_module}'";
	
	
		$query = $this->db->query($sql);
		
		$data['tags_array'] = array();
		
		$data['maxfrequency'] = 0;
		
				
		foreach ($query->result() as $row){
		
			if($row->frequency > $data['maxfrequency']) $data['maxfrequency'] = $row->frequency;
			
			$data['tags_array'][$row->tag] = $row->frequency;
		}
		
		//
		//////////////////////

					
		$this->render('tag_cloud/tag_cloud',$data);
		
		
	}
		

}  
