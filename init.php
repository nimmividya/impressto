<?php

date_default_timezone_set('America/Toronto');

define('ENVIRONMENT', 'development');

define('APPSERIES', '2'); // this is the framework model number, not to be confused with version number

define('PROJECTNUM', '12345');

define('PROJECTNAME', 'impressto');

define('VENDOR', 'Nimmi');
define('VENDORURL', 'http:www.google.com');


define('ASSETURL', '/assets/');
define('ASSET_ROOT', str_replace('\\', '/', realpath(dirname(__FILE__))).ASSETURL);


define('INSTALL_ROOT', str_replace('\\', '/', realpath(dirname(__FILE__))).'/' . PROJECTNAME . '/');

define('TEMPLATEPATH', INSTALL_ROOT.'templates');
define('TEMPLATEURL', '/' . PROJECTNAME.'/templates');


define('DS',DIRECTORY_SEPARATOR); // just easier to type

/*
*---------------------------------------------------------------
* OVERRIDES
*---------------------------------------------------------------
*/



if (defined('STDIN'))
{
	$_SERVER['SERVER_NAME'] = 'localhost';
	$_SERVER['SERVER_PORT'] = 80;
}

/*
*---------------------------------------------------------------
* ERROR REPORTING
*---------------------------------------------------------------
*
* Different environments will require different levels of error reporting.
* By default development will show errors but testing and live will hide them.
*/

switch (ENVIRONMENT)
{
case 'development':
case 'testing':
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	break;
	
case 'production':
	error_reporting(0);
	break;

default:
	exit('The application environment is not set correctly.');
}

/*
*---------------------------------------------------------------
* SYSTEM FOLDER NAME
*---------------------------------------------------------------
*
* This variable must contain the name of your "system" folder.
* Include the path if the folder is not in the same  directory
* as this file.
*
*/
$system_path = INSTALL_ROOT.'codeigniter';



/*
*---------------------------------------------------------------
* APPLICATION FOLDER NAME
*---------------------------------------------------------------
*
* If you want this front controller to use a different "application"
* folder then the default one you can set its name here. The folder
* can also be renamed or relocated anywhere on your server.  If
* you do, use a full server path. For more info please see the user guide:
* http://codeigniter.com/user_guide/general/managing_apps.html
*
* NO TRAILING SLASH!
*
*/
$application_folder = INSTALL_ROOT.'application';







// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
* ---------------------------------------------------------------
*  Resolve the system path for increased reliability
* ---------------------------------------------------------------
*/

// Set the current directory correctly for CLI requests
if (defined('STDIN'))
{
	chdir(dirname(__FILE__));
}

if (realpath($system_path) !== FALSE)
{
	$system_path = realpath($system_path).'/';
}

// ensure there's a trailing slash
$system_path = rtrim($system_path, '/').'/';

// Is the system path correct?
if ( ! is_dir($system_path))
{
	exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
}

/*
* -------------------------------------------------------------------
*  Now that we know the path, set the main path constants
* -------------------------------------------------------------------
*/
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// The PHP file extension
define('EXT', '.php');

// Path to the system folder
define('BASEPATH', str_replace("\\", "/", $system_path));

// Path to the front controller (this file)
define('FCPATH', str_replace(SELF, '', __FILE__));

// Name of the "system folder"
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));





// The path to the "application" folder
if (is_dir($application_folder))
{
	define('APPPATH', $application_folder.'/');
}
else
{
	if ( ! is_dir(BASEPATH.$application_folder.'/'))
	{
		exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
	}

	define('APPPATH', BASEPATH.$application_folder.'/');
}




/*
*---------------------------------------------------------------
* TEMPLATES FOLDER NAME
*---------------------------------------------------------------
*
* These are either smarty or view style templates used by modules and widgets.
*
* NO TRAILING SLASH!
*
*/

$templates_folder = INSTALL_ROOT.'templates';

// The path to the "application" folder
if (is_dir($templates_folder))
{
	define('PSTEMPLATEPATH', $templates_folder.'/');
}
else
{
	if ( ! is_dir(BASEPATH.$templates_folder.'/'))
	{
		exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
	}

	define('PSTEMPLATEPATH', BASEPATH.$templates_folder.'/');
}

