<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version2_update extends CI_Migration
{
	public function up()
	{
	


		if ( ! $this->db->table_exists($this->db->dbprefix . "user_profile" ) ){
		
				
			$this->db->query("
				CREATE TABLE `".$this->db->dbprefix . "user_profile` (
				`user_id` int(11),
				`first_name` VARCHAR(255) NOT NULL,
				`last_name` VARCHAR(255) NOT NULL,
				`oauth_provider` VARCHAR(50) NOT NULL,
				`oauth_provider_name` VARCHAR(75) NOT NULL, 
				`oauth_uid` VARCHAR(75) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			");
		
		}
		
		
		/* this simply keeps track of fields in the table above so they can be assigned to roles
		 and used as different types of data
		field_name is the join key 
		*/
		if ( ! $this->db->table_exists($this->db->dbprefix . "user_fields" ) ){
		
				
			$this->db->query("
				CREATE TABLE `".$this->db->dbprefix . "user_fields` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`field_name` VARCHAR(100) NOT NULL, 
				`input_type` VARCHAR(25) NOT NULL, 
				`field_value` TEXT NOT NULL,
				`default_value` TEXT NULL,
				`paragraph` TEXT,
				`visible` INT( 1 ) NOT NULL DEFAULT '1', 
				`active` INT( 1 ) NOT NULL DEFAULT '1',
				`width` VARCHAR( 6 ) NOT NULL DEFAULT '',
				`height` VARCHAR( 6 ) NOT NULL DEFAULT '',
				`required` INT(1) NOT NULL DEFAULT '0',
				`orientation` ENUM('horizontal','vertical') NOT NULL DEFAULT 'horizontal',
				`onchange` TEXT,
				`position` INT(4) NOT NULL DEFAULT '0',
				`updated` DATETIME NULL DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			");
		
		}
		
		if ( ! $this->db->table_exists($this->db->dbprefix . "user_field_options" ) ){
		
				
			$this->db->query("
				CREATE TABLE `".$this->db->dbprefix . "user_field_options` (
				`option_id` int(11) NOT NULL auto_increment,
				`field_id` int(11) NOT NULL default '0',
				`option_value` varchar(255) default NULL,
				`option_label` varchar(255) default NULL,
				`position` int(11) NOT NULL default '0',
				PRIMARY KEY  (`option_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
		
		}

		
		if ( ! $this->db->table_exists($this->db->dbprefix . "user_role_fields" ) ){
		
				
			$this->db->query("
				CREATE TABLE `".$this->db->dbprefix . "user_role_fields` (
				`field_id` int(11) NOT NULL,
				`role_id` INT(11) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			");
		
		}
		

	
	}

	public function down()
	{

	}
}