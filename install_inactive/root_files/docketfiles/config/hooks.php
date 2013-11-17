<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

//set the system language and mobilize state plus any other system setting that
// will effect the behavior of controllers

/*
$hook['pre_system'] = array(
    'class'    => 'Language',
    'function' => 'get_language',
    'filename' => 'language.php',
    'filepath' => 'hooks'
);  
*/

$hook['pre_controller'] = array(
    'class'    => '',
    'function' => 'initiate',
    'filename' => 'site_settings.php',
    'filepath' => 'core_modules/site_settings'
);


$hook['post_system'] = array(
    'class'    => '',
    'function' => 'hitme',
    'filename' => 'hitcount.php',
    'filepath' => 'core_modules/webtrax'
);
						

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */