<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version2_update extends CI_Migration
{
	public function up()
	{
	


		if ( ! $this->db->table_exists($this->db->dbprefix . "user_data" ) ){
		
				
			$this->db->query("
				CREATE TABLE `".$this->db->dbprefix . "user_data` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`user_id` INT(11) NOT NULL,
				PRIMARY KEY (`id`)
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
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(50) NOT NULL,
				`friendly_name` VARCHAR(255) NOT NULL,
				`order` INT(11) NOT NULL,	
				`type` VARCHAR(50) NOT NULL,
				`options` TEXT NULL,
				`width` VARCHAR(25) NULL DEFAULT NULL,
				`default` VARCHAR(200) NULL DEFAULT NULL,
				`required` TINYINT(1) NOT NULL,
				`private` TINYINT(1) NOT NULL,
				`help_text` TEXT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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