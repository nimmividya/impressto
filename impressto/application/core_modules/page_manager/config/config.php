<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'Content Management',
	'description'	=> 'Create and manage pages.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'content',
	'module_type'		=> 'core',
	'version'		=> '1.5',
	'core_version'		=> '2.9',
	'last_updated'		=> 'Oct 25, 2012'	
);

$config['module_roleactions'] = array(
	'CREATE'=>'Can create new page'
	,'READ'=>'Can read all pages'
	,'EDIT'=>'Can edit existing page'
	,'DELETE'=>'Can delete page'
	,'GURU'=>'Is allowed to edit Javascript and CSS'	
	,'MANAGE'=>'Full admin rights'
);
