<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'Template Editor',
	'description'	=> 'Template Editor.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'config',
	'module_type'		=> 'core',
	'version'		=> '1.0',
	'core_version'		=> '2.9',
	'last_updated'		=> 'Oct 25, 2012'	
);

$config['module_roleactions'] = array(
	'CREATE'=>'Can create new templates'
	,'READ'=>'Can read all templates'
	,'EDIT'=>'Can edit existing templates'
	,'DELETE'=>'Can delete templates'
	,'MANAGE'=>'Full admin rights'
);

