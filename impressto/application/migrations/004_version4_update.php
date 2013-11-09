<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version4_update extends CI_Migration
{
	public function up()
	{
	
		$fields = array(
		
           'password' => array(
               'constraint'	=> 255,
			),
		);
		
		// need to fix this one
		//$this->dbforge->modify_column('users', $fields);
		

	
	}

	public function down()
	{

	}
}