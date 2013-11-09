<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'Sticky Notes',
	'description'	=> 'This is a QA tool for tracking of change requests on individual pages.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'module',
	'module_type'		=> 'custom',
	'version'		=> '1.0',
	'core_version'		=> '2.10', // this is just @since
	'last_updated'		=> 'Dec 01, 2012'	
	
);


$config['module_roleactions'] = array('ACCESSIBLE'=>'Can access this module');

