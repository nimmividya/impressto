<?php defined('BASEPATH') OR exit('No direct script access allowed');

	
	$lang_avail = $this->config->item('lang_avail');
		
	foreach($lang_avail AS $langcode=>$language){ 
			
		if (!$this->db->field_exists('title_' . $langcode, 'image_slider'))
		{
			$this->dbforge->add_column('image_slider', array(
				'title_' . $langcode => array(
				'type'			=> 'varchar',
				'constraint'	=> 100,
				'null'			=> FALSE,
				'default'		=> ''
				)
			));
				
		} 
		
		if (!$this->db->field_exists('caption_' . $langcode, 'image_slider'))
		{
			$this->dbforge->add_column('image_slider', array(
				'caption_' . $langcode => array(
				'type'			=> 'text'
				)
			));
				
		} 
		
		
		if (!$this->db->field_exists('url_' . $langcode, 'image_slider'))
		{
			$this->dbforge->add_column('image_slider', array(
				'url_' . $langcode => array(
				'type'			=> 'varchar',
				'constraint'	=> 255,
				'default'		=> ''
				)
			));
				
		} 
		
		if (!$this->db->field_exists('active_' . $langcode, 'image_slider'))
		{
			$this->dbforge->add_column('image_slider', array(
				'active_' . $langcode => array(
				'type'			=> 'int',
				'constraint'	=> 1,
				'default'		=> 1
				)
			));
				
		} 
		
		

		
		
			
	}
		