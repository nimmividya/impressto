<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'Stylesheet Manager',
	'description'	=> 'Edit stylesheets for all modules and public views.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'assets',
	'module_type'		=> 'core',
	'version'		=> '1.0',
	'core_version'		=> '2.9',
	'last_updated'		=> 'Oct 25, 2012'	
);

$config['module_roleactions'] = array(
	'CREATE'=>'Can create new stylesheets'
	,'READ'=>'Can read all stylesheets'
	,'EDIT'=>'Can edit existing stylesheets'
	,'DELETE'=>'Can delete stylesheets'
	,'MANAGE'=>'Full admin rights'
);

