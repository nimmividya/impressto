<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* IMPORTANT: Make sure to update the config item "migration_version" in /application/config/migration.php
* @author Galbraith Desmond
* @since Nov 05, 2012
*/
class Migration_Version12_update extends CI_Migration
{
	public function up()
	{
		


		if ( ! $this->db->table_exists('user_priority_fields')){
			
			$sql = "CREATE TABLE {$this->db->dbprefix}user_priority_fields (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`field_name` varchar(255) NOT NULL,
			`field_source` varchar(255) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;	";
			
			$this->db->query($sql);
			
		}
		
		if ( ! $this->db->table_exists('user_groups')){
			
			$sql = "CREATE TABLE {$this->db->dbprefix}user_groups (
			`u_group_id` INT(11) NOT NULL AUTO_INCREMENT,
			`user_group` VARCHAR(255) NOT NULL,
			`activate` INT(11) NOT NULL DEFAULT '1',
			`u_group_parent` INT(11) NOT NULL DEFAULT '1',
			`group_position` INT(4) NOT NULL DEFAULT '0',
			PRIMARY KEY (`u_group_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;	";
			
			$this->db->query($sql);
			
		}
		
		if (!$this->db->field_exists('provider_name', 'users')){
					
				$this->dbforge->add_column('users', array(
					'provider_name' => array(
					'type'			=> 'varchar',
					'constraint'	=> 50,
					'default'		=> '',
					)
					
				));
					
		} 
		
		
		if (!$this->db->field_exists('provider_uid', 'users')){
					
				$this->dbforge->add_column('users', array(
					'provider_uid' => array(
					'type'			=> 'varchar',
					'constraint'	=> 50,
					'default'		=> '',
					)
					
				));
					
		} 
		
	}

	public function down()
	{

		// not in use right now.
	}
}