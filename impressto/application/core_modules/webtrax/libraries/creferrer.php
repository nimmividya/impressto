<?php 
/*
*
*	Writed by Setec Astronomy - setec@freemail.it
*
*	This simple class allows to extract the keywords contained in the 
*	HTTP Referrer header provided by the web browser when a client comes 
*	to your site from a search engine query.	
*
*	This script is distributed  under the GPL License
*
*	This program is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* 	GNU General Public License for more details.
*
*	http://www.gnu.org/licenses/gpl.txt
*
*/

class CReferrer 
{
	var $_iniFile;
	var $_iniArray;
	var $_globalFields;	
	
	public function __construct($INIFile = ""){
		
	//function CReferrer($INIFile = ""){

		if (empty ($INIFile))
		{ $this->_iniFile = dirname(__FILE__) . "/engines.ini"; }
		else
		{ $this->_iniFile = $INIFile; }

		$this->_iniArray = @parse_ini_file ($this->_iniFile, true);
		if ($this->_iniArray === false)
		{ 
		print ("<b>CReferrer object creation failed!"); 
		exit;
		}

		$this->_globalFields = array ("q", "p", "query", "qwederr", "qs");

	} 

	function _safe_set (&$var_true, $var_false = "")
	{
		if (!isset ($var_true))
		{ $var_true = $var_false; }
		return $var_true;
	} 
	

	function getKeywords ($URL = "")
	{
		if (empty ($URL) || $this->_iniArray === false)
		{ return false; }

		if(strpos($URL,"http") === false) return "";
			
		$parse_url = @parse_url ($URL);			
		$this->_safe_set ($parse_url["host"], "");
		$parse_url["host"] = strtolower ($parse_url["host"]);
		$this->_safe_set ($parse_url["query"], "");
		parse_str ($parse_url["query"], $parse_query);

		if (!empty ($parse_url["host"]))
		{
			$founded = false;
			foreach ($this->_iniArray as $engine)
			{
				$this->_safe_set ($engine["Host"], "");
				$this->_safe_set ($engine["QueryField"], "");
				$engine["Host"] = strtolower ($engine["Host"]);
		
				$host_pos = strpos($parse_url["host"], $engine["Host"]); 
				if ($host_pos !== false)
				{
					$founded = true;
					if (isset ($parse_query[$engine["QueryField"]]))
					{ 

						//echo $parse_query[$engine["QueryField"]] . "<br>";

						return urldecode ($parse_query[$engine["QueryField"]]); 

					}
				}
			}
			
			if (!$founded)
			{
				foreach ($this->_globalFields as $field)
				{
					if (isset ($parse_query[$field]))
					{ 
						//echo $parse_query[$field] . "<br>";
						return urldecode ($parse_query[$field]); 

					}
				} 
			} 
		} 
	} 
}  
?>