<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version6_update extends CI_Migration
{
	public function up()
	{
	
		/*
		$user_roles = $this->db->get('user_roles')->row();
		
		if ( ! isset($user_roles->template))
		{
			
			
			$this->dbforge->add_column('user_roles', array(
				'template' => array(
					'type' => 'VARCHAR',
					'constraint' => 100,
					'null' => FALSE,
					'default' => ''
				),
			));
			
		}
		*/
		
		$sql = "
			CREATE TABLE IF NOT EXISTS {$this->db->dbprefix}user_fields (
			 `id` int(11) NOT NULL AUTO_INCREMENT,
			 `user_id` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		";
		
		$this->db->query($sql);
		
		
		// MAKE SURE THESE DB STRUCTURES ARE COPIED TO THE CORE SYSTEM INSTALLER TOO
		
	}

	public function down()
	{

		// not in use right now.
	}
}