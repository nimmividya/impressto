<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'cross script experiment',
	'description'	=> 'Provides news feeds.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'module',
	'module_type'		=> 'custom'
);

$config['module_roleactions'] = array(
	'CREATE'=>'Can create new articles'
	,'READ'=>'Can read all articles'
	,'UPDATE'=>'Can update existing articles'
	,'DELETE'=>'Can delete articles'
	,'MANAGE'=>'Full admin rights'
);
