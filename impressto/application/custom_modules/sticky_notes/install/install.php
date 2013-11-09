<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// this is similar to the migration script in that is will allow the module to update its own database when necessary
// it will run whenever a user updates the custom module from the module manager

/** 
* version 1.1 updates  
*/


if (!$this->db->field_exists('priority', 'stickynotes'))
{
	$this->dbforge->add_column('stickynotes', array(
		'priority' => array(
		'type'			=> 'int',
		'constraint'	=> 1,
		'null'			=> TRUE,
		'default'  		=> 1,
		)
	));
} 


// create a folder in assets/upload to store any attached documents
$this->load->library('file_tools');

$attachmentsdir = ASSET_ROOT . "/uploads/sticky_notes";

$this->file_tools->create_dirpath($attachmentsdir);
			