<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

 /*
error_reporting(E_ALL);
 
include("./pshaper/mobile_detect.php");

if(domobile()){

	define("CIWORDPRESSED", false);
 
}else{

	define("CIWORDPRESSED", true);

	// when we include this file, wordpress takes over for all the page urls
	// but we can still access the pageshaper backend
	// NOTE: including wp-load.php will screw up the /en/ or /fr/ page calls in CI.
	// This occurs due to the WP qtranslate plugin qtrans_init function that somehow hijacks any URL with /en/, /fr/, etc.
	// In this case for CI we have to use /_en/ or /_fr/ instead :(

	$request_uri = $_SERVER['REQUEST_URI'];

	require_once './wp-load.php';
	
	// restore the normal REQUEST_URI fucked up by Qian Qin's shitty qtranslate code. 
	$_SERVER['REQUEST_URI'] = $request_uri ;
	

}

*/

include("psboot.php");
	

?>