<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
* Input Extendsions
* @author Galbraith Desmond <galbraithdesmond@gmail.com>
* 
*
*/
class MY_Input extends CI_Input {

	/**
	* Check if the current request is an AJAX call
	* @author Galbraith Desmond <galbraithdesmond@gmail.com>
	* @return bool
	*/
	function isAjax() {
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest");
	}  


}