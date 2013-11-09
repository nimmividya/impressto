<?php

// sample tags
//  [widget type='navigation_menu/navigation_menu']
//  direct from PHP code Widget::run('navigation_menu/navigation_menu'));

// within smarty {widget type='navigation_menu'}



class navigation_menu extends Widget
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
		$this->load->_add_module_paths('navigation_menu');
		$this->load->model('navigation_menu/navigation_menu_model');

		// If the widget is being called form a shortcode and there is no ID, get the id 
		if(!isset($widget_args['widget_id']) && isset($data['name'])) 
		$widget_args['widget_id'] = $this->widget_utils->getwidgetid('navigation_menu', 'navigation_menu', $data['name']);




		//$this->load->helper('widgets/navbarorderlist');
		
		$this->load->library('adjacencytree');

		$this->load->library('template_loader');
		
		$this->load->helper('im_helper');
	
		$lang_avail = $this->config->item('lang_avail');
		
		// the language is auto detected now
		$this->config->set_item('language', $lang_avail[$this->config->item('lang_selected')]); 
				
		$this->language = $this->config->item('lang_selected');
		
		
		$content_table = "{$this->db->dbprefix}content_" . $this->language;
		
		$this->adjacencytree->setdebug(false);
		
		
		$this->adjacencytree->setidfield('node_id');
		$this->adjacencytree->setparentidfield('node_parent');
		$this->adjacencytree->setpositionfield('node_position');
		$this->adjacencytree->setdbtable("{$this->db->dbprefix}content_nodes");
		$this->adjacencytree->setDBConnectionID($this->db->conn_id);
		
		$this->adjacencytree->setjointable($content_table,"CO_node", array("CO_Node","CO_Active", "CO_Public", "CO_MenuTitle","CO_seoTitle","CO_Url"));
		
		$node = $this->adjacencytree->getFullNodesArray();
		
		$this->load->model('page_manager/madmincontent');
		

		$baserootid = $this->madmincontent->getbaserootid();
		
		
		$groups = $this->adjacencytree->getChildNodes($baserootid); //$baserootid);
		
		
		$data['baserootid'] = $baserootid;
		
		$data['groups'] = $groups;
		
		//$data['aj_pagelist'] = $this->navbarorderlist($groups);
		
		
		// load the news widget language file now...
		$this->lang->load('navigation_menu', '', FALSE, TRUE, dirname(dirname(__FILE__)) . '/');	
		
		
		//$widget_options = $this->widget_utils->get_widget_options($widget_args['widget_id']);

		
		$moduleoptions = ps_getmoduleoptions('navigation_menu');


		$data['template'] = $moduleoptions['template']; //$widget_options['template'];
		$data['module'] = 'navigation_menu';
		$data['is_widget'] = TRUE;
		$data['widgettype'] = 'navigation_menu';	

		
		// use this to load witht the correct filters (language, device, docket)
		echo $this->template_loader->render_template($data);
		
		
		return;
		

		
	}
	
	
	/**
	* loop throught the adjacency array to build a view
	* 
	* This function can also be copied over to PHP view templates ... but not smarty templates. We have to get rid of that shyte!
	*/
	function navbarorderlist($items) {
		
		
		global $group_indent, $Image_Color;
		
		$CI =& get_instance();
		
		
		$managegroupspageitems = '';

		if (count($items) && is_array($items)) {
			
			$group_indent ++;
			
			foreach ($items as $cat_id=>$catvals) {
				
				
				$has_childen = false;
				
				if(isset($catvals['children']) && count($catvals['children'])) { 
					$has_childen = true;
				}
				
				
				if($catvals['CO_Active'] == 1 && $catvals['CO_Public'] == 1){
					
					
					
					$code_indent = str_repeat("    ",($group_indent-1)); // sanity saver for lowlife coders
					
					$managegroupspageitems .= "$code_indent<li>";
					
					$managegroupspageitems .=  "<a href=\"/" . $CI->config->item('lang_selected') . "/";
					
					if($catvals['CO_Url'] != "") $managegroupspageitems .= $catvals['CO_Url'];
					else $managegroupspageitems .= $catvals['CO_Node'];
					
					$managegroupspageitems .= "\">\n";
					
					if($catvals['CO_MenuTitle'] != "") $managegroupspageitems .= $catvals['CO_MenuTitle'];
					else $managegroupspageitems .= $catvals['CO_seoTitle'];
					
					$managegroupspageitems .=  "</a>\n";
					
					
					
					if ($has_childen) {
			
						$subitems = $code_indent . $code_indent . $this->navbarorderlist($catvals['children']);
						
						if(trim($subitems) != ""){
							
							$managegroupspageitems .= $code_indent . $code_indent . "\n<ul>\n";
							$managegroupspageitems .= trim($subitems);
							$managegroupspageitems .= $code_indent . $code_indent . "</ul>\n";
							
							
						}
					
					}
					
					$managegroupspageitems .= "</li>\n";
					
				}
	
				
			}
			
			$group_indent --;
			
			
		}


		
		return $managegroupspageitems;
		
	}///////

}  



