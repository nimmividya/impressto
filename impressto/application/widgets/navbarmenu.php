<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: NavBar Menu
@Filename: navbarmenu.php
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1
@Status: complete
@Date: 2012-05
*/

/*

To make this work you need a tile cutter. Use MapTiler Beta from maptiler.org

VERY IMPORTANT: Make image based tiles (not Google Map tiles). If you use the other options
the images will get skewed and so will your brain (it happened to me).


*/

// example of usage
//  [widget type='bg_pos_slider/bg_widget' othername='seomething else' relative=wawaewa]
// OR
// [widget='navbarmenu']
// OR IN SMARTY {widget type='navbarmenu'}
// OPTIONS EXAMPE: {widget type='navbarmenu' li_class='nav-menu-item'}



class navbarmenu extends Widget
{
	function run() {
		
		
		$args = func_get_args();
		
		$data = array();
		
	
		
		$this->load->library('adjacencytree');
		

		
		// if paramaeters have been passed to this widget, assign them	and override the defaults for this widget instance
		if(isset($args[0]) && is_array($args[0])){
			
			$widget_args = $args[0];
			
			if(isset($args[0]['li_class'])) $data['li_class'] = $args[0]['li_class'];
			
		}
		
		
		$content_table = "{$this->db->dbprefix}content_" . $this->language;
		
		$this->adjacencytree->setdebug(false);
		
		
		$this->adjacencytree->setidfield('node_id');
		$this->adjacencytree->setparentidfield('node_parent');
		$this->adjacencytree->setpositionfield('node_position');
		$this->adjacencytree->setdbtable("{$this->db->dbprefix}content_nodes");
		$this->adjacencytree->setDBConnectionID($this->db->conn_id);
		
		$this->adjacencytree->setjointable($content_table,"CO_node", array("CO_Node","CO_Active", "CO_Public", "CO_MenuTitle","CO_seoTitle","CO_Url"));
		
		$node = $this->adjacencytree->getFullNodesArray();
		

		$baserootid = 1; //$this->madmincontent->getbaserootid();
		
		$groups = $this->adjacencytree->getChildNodes($baserootid); //$baserootid);
		
		
		$data['baserootid'] = $baserootid;
		
		
		$data['aj_pagelist'] = "<ul>\n" . $this->navbarorderlist($groups, $data) . "\n</ul>\n";


		
		$this->render('navbarmenu',$data);
		
		
	}
	
	
	
	
	
	


	/**
* loop throught the adjacency array to build a view
*/
	private function navbarorderlist($items, $data) {
		
		global $opcmf, $dispitem, $group_indent, $Image_Color;
		
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
					
					$managegroupspageitems .= "$code_indent<li";
					
					if($data['li_class'] != "") $managegroupspageitems .= " class=\"{$data['li_class']}\" ";
					
					$managegroupspageitems .= ">";
					
					$managegroupspageitems .=  "<a href=\"/" . $CI->config->item('lang_selected') . "/";
					
					if($catvals['CO_Url'] != "") $managegroupspageitems .= $catvals['CO_Url'];
					else $managegroupspageitems .= $catvals['CO_Node'];
					
					$managegroupspageitems .= "\">\n";
					
					if($catvals['CO_MenuTitle'] != "") $managegroupspageitems .= $catvals['CO_MenuTitle'];
					else $managegroupspageitems .= $catvals['CO_seoTitle'];
					
					$managegroupspageitems .=  "</a>\n";
					
					
					
					if ($has_childen) {
						
						

						//$managegroupspageitems .= $code_indent . $code_indent . navbarorderlist($catvals['children']);
						
						$subitems = $code_indent . $code_indent . $this->navbarorderlist($catvals['children'], $data);
						
						if(trim($subitems) != ""){
							
							$managegroupspageitems .= $code_indent . $code_indent . "\n<ul style=\"visibility: hidden;\">\n";
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


