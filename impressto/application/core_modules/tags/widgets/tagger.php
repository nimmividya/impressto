<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class tagger extends Admin_Widget
{



	function run() {

		
		$data = array();
		
		$args = func_get_args();

		$news_id = $this->input->get_post('news_id');

		
		$this->load->library('edittools');
		$this->load->library('asset_loader');
		
		$this->load->model("tags/tags_model");
		

		$this->asset_loader->add_header_css("default/core_modules/tags/css/tagger.css");
		
		$this->asset_loader->add_header_css("vendor/bootstrap/css/bootstrap-tagmanager.css");
		$this->asset_loader->add_header_js("vendor/bootstrap/js/bootstrap-tagmanager.js");
	
		
				
		
		// if paramaeters have been passed to this widget, assign them	
		if(isset($args[0]) && is_array($args[0])){
			
			$widget_args = $args[0];
			
			if(isset($args[0]['name'])) $data['name'] = $args[0]['name'];
			
		}
		
		$lang = $args[0]['lang'] != "" ? $args[0]['lang'] : "en";
		$content_module = $args[0]['content_module'];
		$content_id = $args[0]['content_id'];
		
		$data['field_name'] = $args[0]['field_name'];
		
		$all_tags = $this->tags_model->get_all_tags($lang, $content_module);
		
		
		if($all_tags) $data['all_tags'] = '"' . implode('" ,"',$all_tags) . '"';
		else $data['all_tags'] = "";
		
		if($args[0]['tags']) $data['tags'] = '"' . implode('" ,"',$args[0]['tags']) . '"';
		else $data['tags'] = "";
		
		
		$data['lang'] = $lang;
		
		
		
		$searchtags_table = $this->db->dbprefix . 'searchtags_' . $lang;
		$searchtags_bridge_table = $this->db->dbprefix . 'searchtags_bridge_' . $lang;

					
		$this->render('tagger',$data);
		
		
		
	}
		

}  
