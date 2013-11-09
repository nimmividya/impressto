<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* This update is from the last changes to LacStsixte. 
*
*/

		
	$lang_avail = $this->config->item('lang_avail');
		
	if($this->db->table_exists("image_gallery")){
		
		if (!$this->db->field_exists('hits', 'image_gallery')){
			
			$this->dbforge->add_column('image_gallery', array(
				'hits' => array(
					'type'			=> 'int',
					'constraint'	=> 12,
					'null'			=> FALSE,
					'default'		=> 0,
				)
				
			));
				
		} 
	}
		
		
		
	if($this->db->table_exists("image_gallery_categories")){
		
		if (!$this->db->field_exists('category_image', 'image_gallery_categories')){
			
			$this->dbforge->add_column('image_gallery_categories', array(
				'category_image' => array(
					'type'			=> 'int',
					'constraint'	=> 10,
					'null'			=> TRUE,
				)
				
			));
				
		} 
		
		if (!$this->db->field_exists('name', 'image_gallery_categories')){
			
			$this->dbforge->add_column('image_gallery_categories', array(
				'name' => array(
					'type'			=> 'varchar',
					'constraint'	=> 255,
					'null'			=> FALSE,
					'default'		=> '',
									
				)
				
			));
				
		} 
		
		
		if (!$this->db->field_exists('name_fr', 'image_gallery_categories')){
			
			$this->dbforge->add_column('image_gallery_categories', array(
				'name_fr' => array(
					'type'			=> 'varchar',
					'constraint'	=> 255,
					'null'			=> FALSE,
					'default'		=> '',
									
				)
				
			));
				
		} 
		 
	}
	
		
		
