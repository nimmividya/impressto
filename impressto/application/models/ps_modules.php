<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Modules model
 *
 * @author Galbraith Desmond
 *
 */
class ps_modules extends MY_Model
{
	protected $_table = 'modules';

	
	/**
	 * Get Modules
	 *
	 */
	public function get_all()
	{
		$modules = array();


		$this->db->where('active', 'Y');

		$result = $this->db->get($this->_table)->result();

		foreach ($result as $row)
		{

			$modules[$row->name] = $row->name;
		}
		
		ksort($modules);

		return array_values($modules);
	}







	

}