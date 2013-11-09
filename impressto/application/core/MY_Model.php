<?php defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Model extends CI_Model
{


	/**
	 * 
	 * This function is to be extended from other classes and will loop through the data and return an associative array
	 * @param $result
	 */
	function fetch_assoc($result) {
		$data = array();
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}
	
	/**
	* @author peterdrinnan
	*
	*/
	function fetch_row($query) {
	
			
		if ($query->num_rows() > 0){
			
			return $query->row_array();
			
		}
		
		return FALSE;

	}
	
	
	
	



}