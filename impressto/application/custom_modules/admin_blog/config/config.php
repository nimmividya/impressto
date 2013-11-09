<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'Blog',
	'description'	=> 'Provides blogs.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'module',
	'module_type'		=> 'custom',
	'version'		=> '1.0',
	'core_version'		=> '2.9',
	'last_updated'		=> 'Oct 25, 2012'			
);

$config['module_roleactions'] = array(
	'CREATE'=>'Can create new articles'
	,'READ'=>'Can read all articles'
	,'UPDATE'=>'Can update existing articles'
	,'DELETE'=>'Can delete articles'
	,'MANAGE'=>'Full admin rights'
);
