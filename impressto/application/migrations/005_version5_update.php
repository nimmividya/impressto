<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version5_update extends CI_Migration
{
	public function up()
	{
	
			if (!$this->db->field_exists('language', 'users')){
		
			$this->dbforge->add_column('users', array(
				'language' => array(
				'type'			=> 'varchar',
				'constraint'	=> 3,
				'null'			=> FALSE,
				'default'		=> 'en'
				)
			
			));
		
			
		} 
		
	
	}

	public function down()
	{

	}
}