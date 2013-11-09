<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* IMPORTANT: Make sure to update the config item "migration_version" in /application/config/migration.php
* @author Galbraith Desmond
* @since Nov 05, 2012
*/
class Migration_Version10_update extends CI_Migration
{
	public function up()
	{
		

		if ( ! $this->db->table_exists('user_fields')){
			
			$sql = "CREATE TABLE {$this->db->dbprefix}user_fields (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;	";
			
			$this->db->query($sql);
			
		}
		
		
		$lang_avail = $this->config->item('lang_avail');
		
		foreach($lang_avail AS $langcode=>$language){ 
			
			if (!$this->db->field_exists('content_id', 'searchindex_' . $langcode))
			{
				$this->dbforge->add_column('searchindex_' . $langcode, array(
					'content_id' => array(
					'type'			=> 'int',
					'constraint'	=> 10,
					'null'			=> TRUE,
					)
				));
				
			} 
			
			if (!$this->db->field_exists('priority', 'searchindex_' . $langcode))
			{
				$this->dbforge->add_column('searchindex_' . $langcode, array(
					'priority' => array(
					'type'			=> 'int',
					'constraint'	=> 2,
					'null'			=> FALSE,
					'default'		=> 8
					)
				));
				
			}
			
			
			if (!$this->db->field_exists('change_frequency', 'searchindex_' . $langcode))
			{
				$this->dbforge->add_column('searchindex_' . $langcode, array(
					'change_frequency' => array(
					'type'			=> 'int',
					'constraint'	=> 1,
					'null'			=> FALSE,
					'default'		=> 4
					)
				));
				
			}
			
			
			if (!$this->db->field_exists('slug', 'searchindex_' . $langcode))
			{
				$this->dbforge->add_column('searchindex_' . $langcode, array(
					'slug' => array(
					'type'			=> 'varchar',
					'constraint'	=> 200,
					'default'		=> '',
				
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