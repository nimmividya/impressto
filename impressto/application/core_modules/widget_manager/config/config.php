<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'Widget Manager',
	'description'	=> 'Manage widget zones and assign widgets to them for display withing Smarty templates.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'config',
	'module_type'		=> 'core',
	'version'		=> '1.0',
	'core_version'		=> '2.9',
	'last_updated'		=> 'Oct 25, 2012'	
);

$config['module_roleactions'] = array(
	'CREATE'=>'Can create new widgets'
	,'READ'=>'Can read all widgets'
	,'EDIT'=>'Can edit existing widgets'
	,'DELETE'=>'Can delete widgets'
	,'MANAGE'=>'Full admin rights'
);

