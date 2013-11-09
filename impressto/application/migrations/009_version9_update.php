<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version9_update extends CI_Migration
{
	public function up()
	{
	
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
		
			if (!$this->db->field_exists('frequency', 'searchtags_' . $langcode))
			{
				$this->dbforge->add_column('searchtags_' . $langcode, array(
					'frequency' => array(
						'type'			=> 'int',
						'constraint'	=> 8,
						'null'			=> FALSE,
						'default'		=> 0,
					)
				));
				
			} 
					
		
		}
		
		foreach($lang_avail AS $langcode=>$language){ 
		
			if($this->db->table_exists('content_' . $langcode)){
		
				if (!$this->db->field_exists('hits', 'content_' . $langcode)){
			
					$this->dbforge->add_column('content_' . $langcode, array(
						'hits' => array(
							'type'			=> 'int',
							'constraint'	=> 12,
							'null'			=> FALSE,
							'default'		=> 0,
						)
				
					));
				
				} 
			
			}
		
		}
		
		
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
		
		
		
		
		
		

		
	}

	public function down()
	{

		// not in use right now.
	}
}