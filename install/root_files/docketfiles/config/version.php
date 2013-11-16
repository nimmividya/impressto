<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$config['ps_version'] = '2.5'; // June 20th, 2012
$config['ps_version_change_notes'] = array(

	'Added database support, tagging and search indexing for elFinder',
	'Updated MY_Controller to allow us to run modules from within modules. Used right now for creating calls to modules from alias pages',
		
);


// June 01, 2012 - previous version notes -  this all has to go into the migrations folder so
// the method here is temporary only
//
//	'added support for events',
//	'fixes to fallback template paths',


/* End of file version.php */
