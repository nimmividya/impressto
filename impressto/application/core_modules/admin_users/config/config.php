<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'User Manager',
	'description'	=> 'Users administratoin.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'users',
	'module_type'		=> 'core',
	'version'		=> '1.0',
	'core_version'		=> '2.9',
	'last_updated'		=> 'Oct 25, 2012'			
);

$config['module_roleactions'] = array(
	'CREATE'=>'Can create new users'
	,'READ'=>'Can read all users'
	,'EDIT'=>'Can edit existing users'
	,'DELETE'=>'Can delete users'
	,'MANAGE'=>'Full admin rights'
);
