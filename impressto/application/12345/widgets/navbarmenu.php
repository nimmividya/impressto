<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
@Name: NavBar Menu
@Filename: navbarmenu.php
@Author: webdev@acart.com
@Docket: 1001
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
//  [widget name='bg_pos_slider/bg_widget' othername='seomething else' relative=wawaewa]
// OR
// [widget='navbarmenu']
// OR IN SMARTY {widget type='navbarmenu'}


class navbarmenu extends Widget
{
    function run() {

		$args = func_get_args();
		
		$data = array();
		
		$this->load->helper('widgets/navbarorderlist');
		
		$this->load->library('adjacencytree');
		
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
						
		$groups = $this->adjacencytree->getChildNodes(27); //$baserootid);
					
		$data['baserootid'] = $baserootid;
		
			
		$data['aj_pagelist'] = "<ul>\n" . navbarorderlist($groups) . "\n</ul>\n";

		$this->render('navbarmenu',$data);
		 
    }
}  

