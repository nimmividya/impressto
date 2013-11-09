<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'name'	=> 'Dashboard',
	'description'	=> 'Manage the landing page.',
	'author'		=> 'Galbraith Desmond',
	'admin_menu_section'		=> 'config',
	'module_type'		=> 'core',
	'url'		=> 'dashboard/manage', // sets the link for admin menus
	'version'		=> '1.0',
	'core_version'		=> '2.9', // core version determines if it is safe to install this one
	'last_updated'		=> 'May 01, 2013'			
);

$config['module_roleactions'] = array(
	'MANAGE'=>'Full admin rights'
);

