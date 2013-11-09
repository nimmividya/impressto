<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


$config['module_config'] = array(

	'description'	=> 'Track user on the site. Nothing more.',
	'author'		=> 'David Gorman, Galbraith Desmond',
	'admin_menu_section'		=> 'hidden'
);


$config['settings'] = array(

		'request_uri' => TRUE
		,'profile' => TRUE
		,'remote_addr' => TRUE
		,'request_device' => TRUE
		,'this_referer' => TRUE
	
	
);


$config['module_roleactions'] = array(

	'READ'=>'Can read all records'

);



