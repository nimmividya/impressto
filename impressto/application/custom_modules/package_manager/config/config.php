<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'Package Manager',
	'description'	=> 'Acart proprietary module to control what PageShaper users are allowed to access in the package library.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'module',	
	'module_type'		=> 'custom',
	'version'		=> '1.0',
	'min_core_version'		=> '2.0',
	'max_core_version'		=> '2.9',
	'last_updated'		=> 'Oct 25, 2012'	
);


$config['module_roleactions'] = array('ACCESSIBLE'=>'Can access this module');
