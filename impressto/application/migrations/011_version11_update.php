<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* IMPORTANT: Make sure to update the config item "migration_version" in /application/config/migration.php
* @author Galbraith Desmond
* @since Nov 05, 2012
*/
class Migration_Version11_update extends CI_Migration
{
	public function up()
	{
		
		$lang_avail = $this->config->item('lang_avail');
		
		
		foreach($lang_avail AS $langcode=>$language){ 
			
			if($this->db->table_exists('content_' . $langcode)){
			
			
				if (!$this->db->field_exists('featured_image', 'content_' . $langcode)){
					
					$this->dbforge->add_column('content_' . $langcode, array(
					'featured_image' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
							
				if (!$this->db->field_exists('mobile_featured_image', 'content_' . $langcode)){
					
					$this->dbforge->add_column('content_' . $langcode, array(
					'mobile_featured_image' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
				
				
				
				if (!$this->db->field_exists('prevpage', 'content_' . $langcode)){
					
					$this->dbforge->add_column('content_' . $langcode, array(
					'prevpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
				if (!$this->db->field_exists('mobile_prevpage', 'content_' . $langcode)){
					
					$this->dbforge->add_column('content_' . $langcode, array(
					'mobile_prevpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
				if (!$this->db->field_exists('nextpage', 'content_' . $langcode)){
					
					$this->dbforge->add_column('content_' . $langcode, array(
					'nextpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
				if (!$this->db->field_exists('mobile_nextpage', 'content_' . $langcode)){
					
					$this->dbforge->add_column('content_' . $langcode, array(
					'mobile_nextpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
			}
			
			
			if($this->db->table_exists('contentarchives_' . $langcode)){
			
			
				if (!$this->db->field_exists('featured_image', 'contentarchives_' . $langcode)){
					
					$this->dbforge->add_column('contentarchives_' . $langcode, array(
					'featured_image' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
							
				if (!$this->db->field_exists('mobile_featured_image', 'contentarchives_' . $langcode)){
					
					$this->dbforge->add_column('contentarchives_' . $langcode, array(
					'mobile_featured_image' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
				
				if (!$this->db->field_exists('prevpage', 'contentarchives_' . $langcode)){
					
					$this->dbforge->add_column('contentarchives_' . $langcode, array(
					'prevpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
				if (!$this->db->field_exists('mobile_prevpage', 'contentarchives_' . $langcode)){
					
					$this->dbforge->add_column('contentarchives_' . $langcode, array(
					'mobile_prevpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
				if (!$this->db->field_exists('nextpage', 'contentarchives_' . $langcode)){
					
					$this->dbforge->add_column('contentarchives_' . $langcode, array(
					'nextpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
				if (!$this->db->field_exists('mobile_nextpage', 'contentarchives_' . $langcode)){
					
					$this->dbforge->add_column('contentarchives_' . $langcode, array(
					'mobile_nextpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
			}
			
			
			if($this->db->table_exists('contentdrafts_' . $langcode)){
			
			
				if (!$this->db->field_exists('featured_image', 'contentdrafts_' . $langcode)){
					
					$this->dbforge->add_column('contentdrafts_' . $langcode, array(
					'featured_image' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
							
				if (!$this->db->field_exists('mobile_featured_image', 'contentdrafts_' . $langcode)){
					
					$this->dbforge->add_column('contentdrafts_' . $langcode, array(
					'mobile_featured_image' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
				
				if (!$this->db->field_exists('prevpage', 'contentdrafts_' . $langcode)){
					
					$this->dbforge->add_column('contentdrafts_' . $langcode, array(
					'prevpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				if (!$this->db->field_exists('mobile_prevpage', 'contentdrafts_' . $langcode)){
					
					$this->dbforge->add_column('contentdrafts_' . $langcode, array(
					'mobile_prevpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
				if (!$this->db->field_exists('nextpage', 'contentdrafts_' . $langcode)){
					
					$this->dbforge->add_column('contentdrafts_' . $langcode, array(
					'nextpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				if (!$this->db->field_exists('mobile_nextpage', 'contentdrafts_' . $langcode)){
					
					$this->dbforge->add_column('contentdrafts_' . $langcode, array(
					'mobile_nextpage' => array(
					'type'			=> 'varchar',
					'constraint'	=> 250,
					'default'		=> '',
					)
					
					));
					
				} 
				
				
			}
			
			
			
			
		}
		
		

		
		
		
	}

	public function down()
	{

		// not in use right now.
	}
}