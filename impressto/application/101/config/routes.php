<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/


$route['en'] = "index/index";
// Nimmitha Vidyathilaka - april 25, 2012
$route['fr'] = "index/index/";

// this nasty routing does allow us to have 5 levels of "directory style" urls
// beyond that I think it is fair to say the web site IA is a disaster anyway
$route['en/(:any)/(:any)/(:any)/(:any)/(:any)'] = "index/index/$5/$4/$3/$2/$1";
$route['en/(:any)/(:any)/(:any)/(:any)'] = "index/index/$4/$3/$2/$1";
$route['en/(:any)/(:any)/(:any)'] = "index/index/$3/$2/$1";
$route['en/(:any)/(:any)'] = "index/index/$2/$1";
$route['en/(:any)'] = "index/index/$1";

$route['fr/(:any)/(:any)/(:any)/(:any)/(:any)'] = "index/index/$5/$4/$3/$2/$1";
$route['fr/(:any)/(:any)/(:any)/(:any)'] = "index/index/$4/$3/$2/$1";
$route['fr/(:any)/(:any)/(:any)'] = "index/index/$3/$2/$1";
$route['fr/(:any)/(:any)'] = "index/index/$2/$1";
$route['fr/(:any)'] = "index/index/$1";

$route['en/(:num)'] = "index/index/$1";
$route['fr/(:num)'] = "index/index/$1";


		
// this is a CMS so we will handle 404 errors as missing pages
// rather than missing controllers
$route['404_override'] = 'index/index';
$route['default_controller'] = "index";


$route['admin'] = 'dashboard';
$route[PROJECTNAME . '-admin'] = 'dashboard';


$route['edit_my_profile'] = 'my_profile_manager';

$route['admin_help/(:any)/(:any)'] = 'admin_help/index/$1/$2';


$route['ps-login'] = 'login';
$route['logout'] = 'login/logout';


$route['admin/image_slider'] = 'image_slider';
$route['admin/image_slider/(:any)'] = 'image_slider/$1';



// rss feed
$route['rss_feed'] = "admin_news/rss_feed/index";
$route['en/rss_feed'] = "admin_news/rss_feed/index/en";
$route['fr/rss_feed'] = "admin_news/rss_feed/index/fr";




/* End of file routes.php */
/* Location: ./application/config/routes.php */
