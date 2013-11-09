<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Generic function for detecting mobile devices and mobile user presentation preferences
* @author		Galbraith Desmond <galbraithdesmond@gmail.com>
*
* @version		1.0.0 (2012-03-10)
*/


/**
* Check if the mobileuser wants to use the desktop or mobile version
*
*/
function ps_domobile(){

	$CI =& get_instance();
	
	if($CI->config->item('onlymobile') == TRUE) return TRUE;
		
	$mobilized = $CI->config->item('mobilized');
	
	// if this site has a mobile option, we can check to see if it should be loaded
	if($mobilized) return init_domobile();
	else return false;
	

}


/**
* pre-codeigniter load function
* determines if the user has opted out of the mobile site. If
* no cookie has been set, determin if this is a mobile device 
*
*/
function init_domobile(){
	
	if(isset($_COOKIE['domobile']) && $_COOKIE['domobile'] == "false") 	return false;
	else  return ps_ismobile();

}


/**
* determins if it is a desktop, tablet or mobile
* We are not using the CodeIgnter agent library because it seems out of date
* @return device type
*/
function get_device_type(){

	$device_type = "desktop"; // default
	
	//Detect special conditions devices
	$iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
	$iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
	$iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
	if(stripos($_SERVER['HTTP_USER_AGENT'],"Android") && stripos($_SERVER['HTTP_USER_AGENT'],"mobile")){
		$Android = true;
	}else if(stripos($_SERVER['HTTP_USER_AGENT'],"Android")){
		$Android = false;
		$AndroidTablet = true;
	}else{
		$Android = false;
		$AndroidTablet = false;
	}
	
	$webOS = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
	$BlackBerry = stripos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
	$RimTablet= stripos($_SERVER['HTTP_USER_AGENT'],"RIM Tablet");
	

	if( $iPod || $iPhone ) 	$device_type = "mobile";
	else if($iPad) 	$device_type = "tablet";
	else if($Android) $device_type = "mobile";
	else if($AndroidTablet) $device_type = "tablet";
	else if($webOS) $device_type = "desktop";
	else if($BlackBerry) $device_type = "mobile";
	else if($RimTablet) $device_type = "tablet";
	else $device_type = "desktop";
	
	return $device_type;


}



/**
* Simply return whether or not the user has a mobile
* device regardless of preferences. 
*/
function ps_ismobile(){

	if(get_device_type() == "tablet") return false;
	if(get_device_type() == "desktop") return false;
	if(get_device_type() == "mobile") return true;
		

}

// just a dumb legacy alias call to ps_ismobile()
function ismobile(){

	return ps_ismobile();
	
}


