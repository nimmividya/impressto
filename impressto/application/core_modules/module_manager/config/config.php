<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'Module Manager',
	'description'	=> 'Allows the management of all site modules.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'config',	
	'module_type'		=> 'core',
	'version'		=> '1.0',
	'core_version'		=> '2.9',
	'last_updated'		=> 'Oct 25, 2012'	
);

$config['module_roleactions'] = array(
	'ACCESSIBLE'=>'Can access this module'
	,'READ'=>'Can read all blocks'
	,'EDIT'=>'Can edit existing blocks'
	,'DELETE'=>'Can delete blocks'
	,'MANAGE'=>'Full admin rights'
);
