<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'Content Blocks',
	'description'	=> 'Provides news feeds.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'widget',
	'module_type'		=> 'core',
	'version'		=> '1.8',
	'core_version'		=> '2.9', // core version determines if it is safe to install this one
	'last_updated'		=> 'Oct 25, 2012'			
);

$config['module_roleactions'] = array(
	'CREATE'=>'Can create new blocks'
	,'READ'=>'Can read all blocks'
	,'EDIT'=>'Can edit existing blocks'
	,'DELETE'=>'Can delete blocks'
	,'MANAGE'=>'Full admin rights'
);

