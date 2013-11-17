<?php


/**
* @author - Galbraith Desmond
* @description - reads an sql dump file and runs it. This can also be used to setup initial records
*
*/
class module_installer{

	private $vardata = array();
	//public $sql_file = array();
	
	public function __construct(){	
		

	}
	

	/**
	* Creates a full path of directories. It will create parent directories if
	* they do not exits
	*
	* NOTE: warning turned off in the file function calls because basedir restriction
	* is in effect on some  servers (Media Temple)
	* @author peterdrinnan
	* @param dir string - full directory path to create
	* @secure bool - if TRUE adds a .htaccess file to each folder
	*
	*/
	function create_dirpath($dir,$secure=false){


		$dir_build = $dir;
	
		
		$dir = str_replace("/",DS,$dir);
		
		
		if(!file_exists($dir)){

			$dir_build = "";
			
			$seperated_dirs = explode(DS,$dir);

			$dir_build = $seperated_dirs[0];

			for($i=1; $i < count($seperated_dirs); $i++){

				$dir_build .= DS . $seperated_dirs[$i];
				
					
				if(!@file_exists($dir_build)){

					$oldumask = umask(0);

					@mkdir($dir_build, 0777); 
					
					@chmod($dir_build, 0777);

					@umask($oldumask);

					if(!@file_exists($dir_build.DS."index.htm")){

						$NF = @fopen($dir_build.DS."index.htm","w");

						@fwrite($NF,

						"<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n"
						."<HTML>\n"
						."<HEAD>\n"
						."<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=iso-8859-1\">\n"
						."<META HTTP-EQUIV=Refresh CONTENT=\"1; URL=/\">\n"
						."<TITLE>INDEX</TITLE>\n"
						."</HEAD>\n"
						."<BODY>REDIRECT</BODY>\n"
						."</HTML>\n");

						@fclose($NF);

					}

					if($secure != false && !@file_exists($dir_build.DS.".htaccess") ){

						$htaccessvars = "AuthName \"BC RESTRICT\"\n"
						. "AuthType Basic\n"
						."<Limit GET POST>\n"
						."order deny,allow\n"
						."deny from all\n"
						."</Limit>\n"
						."# Error Document Reporting\n"
						."ErrorDocument 401 /index.php?sv=&errorcode=401\n"
						."ErrorDocument 403 /index.php?sv=&errorcode=403\n"
						."ErrorDocument 404 /index.php?sv=&errorcode=404\n";

						$NF = @fopen($dir_build.DS.".htaccess","w");
						@fwrite($NF,	$htaccessvars);
						@fclose($NF);

					}
				}
			}
		}

		return $dir_build;
	
	}
	
	
	function process_file($sql_file, $data = null){

		if(is_array($data)){
			
			foreach($data as $key=>$val){
				$this->vardata[$key] = $val;
			}
			
		}

		
		$sql_query = @fread(@fopen($sql_file, 'r'), @filesize($sql_file)) or die('problem with $sql_file');


		$sql_query = $this->remove_remarks($sql_query);
		$sql_query = $this->split_sql_file($sql_query, ';');

		$i=1;

							

		
		foreach($sql_query as $sql){
			
			$sql = $this->varparse($sql);
					
			mysql_query($sql) or die('error in query: ' . $sql);
			
		}

	}

	
	
	function copy_assets($controller, $target_dir){
	
	
		$CI =&get_instance();
				
		$CI->load->helper('directory_copy');
		$CI->load->helper('directory');
					
		$srcdir = APPPATH . $controller . "/install/assets";
		
		$dstdir =  $_SERVER['DOCUMENT_ROOT'] . "/assets/" . PROJECTNAME . "/" . $target_dir;
			
		if(file_exists($srcdir)) directory_copy($srcdir, $dstdir);
			
	}
	
	

	/**
* parse the file for php and variables and substititue that in the sql
*
*
*/
	private function varparse($sql){
		
		preg_match_all( '/(\{\$[a-zA-Z_]+[a-zA-Z0-9_]*)(([\[]+[\']*[a-zA-Z0-9_]+[\']*[\]]+)*\})/', $sql, $tagmatches );
		
		$tags = array_unique($tagmatches[0]);
		
		foreach($tags as $tag){
			
			$isvararray = false;
			
			$varname = 	str_replace('{$','', $tag );
			$varname = str_replace('}','', $varname );
			
			if( preg_match( '/\]/', $varname ) ){

				if( preg_match( '/\[/', $varname ) ){
					$isvararray = true;
				}
			}
			
			if($isvararray){
				
				list($var,) = explode( '[', $varname );
				
				if( isset( $this->vardata[$var] ) ){

					$varstart = strpos( $varname, '[' )+1;
					$varend = strpos( $varname, ']' );
					$key = substr( $varname, $varstart, $varend-$varstart );

					
					if( isset( $this->vardata[$var][$key] ) ){
						
						$sql = str_replace($tag,$this->vardata[$var][$key],$sql);

					}else{
						
						$sql = str_replace($tag,'',$sql);
						
					}

				}else{
					
					$sql = str_replace($tag,'',$sql);
					
				}
				
			}else{
				
				$sql = str_replace($tag,$this->vardata[$varname],$sql);
				
			}
			
		}
		
		return $sql;
		
	} // end function parse
	
	

	
	//
	// remove_comments will strip the sql comment lines out of an uploaded sql file
	// specifically for mssql and postgres type files in the install....
	//
	function remove_comments(&$output)
	{
		$lines = explode("\n", $output);
		$output = "";

		// try to keep mem. use down
		$linecount = count($lines);

		$in_comment = false;
		for($i = 0; $i < $linecount; $i++)
		{
			if( preg_match("/^\/\*/", preg_quote($lines[$i])) )
			{
				$in_comment = true;
			}

			if( !$in_comment )
			{
				$output .= $lines[$i] . "\n";
			}

			if( preg_match("/\*\/$/", preg_quote($lines[$i])) )
			{
				$in_comment = false;
			}
		}

		unset($lines);
		return $output;
	}

	//
	// remove_remarks will strip the sql comment lines out of an uploaded sql file
	//
	function remove_remarks($sql)
	{
		$lines = explode("\n", $sql);

		// try to keep mem. use down
		$sql = "";

		$linecount = count($lines);
		$output = "";

		for ($i = 0; $i < $linecount; $i++)
		{
			if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
			{
				if (isset($lines[$i][0]) && $lines[$i][0] != "#")
				{
					$output .= $lines[$i] . "\n";
				}
				else
				{
					$output .= "\n";
				}
				// Trading a bit of speed for lower mem. use here.
				$lines[$i] = "";
			}
		}

		return $output;

	}

	//
	// split_sql_file will split an uploaded sql file into single sql statements.
	// Note: expects trim() to have already been run on $sql.
	//
	function split_sql_file($sql, $delimiter)
	{
		// Split up our string into "possible" SQL statements.
		$tokens = explode($delimiter, $sql);

		// try to save mem.
		$sql = "";
		$output = array();

		// we don't actually care about the matches preg gives us.
		$matches = array();

		// this is faster than calling count($oktens) every time thru the loop.
		$token_count = count($tokens);
		for ($i = 0; $i < $token_count; $i++)
		{
			// Don't wanna add an empty string as the last thing in the array.
			if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
			{
				// This is the total number of single quotes in the token.
				$total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
				// Counts single quotes that are preceded by an odd number of backslashes,
				// which means they're escaped quotes.
				$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);

				$unescaped_quotes = $total_quotes - $escaped_quotes;

				// If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
				if (($unescaped_quotes % 2) == 0)
				{
					// It's a complete sql statement.
					$output[] = $tokens[$i];
					// save memory.
					$tokens[$i] = "";
				}
				else
				{
					// incomplete sql statement. keep adding tokens until we have a complete one.
					// $temp will hold what we have so far.
					$temp = $tokens[$i] . $delimiter;
					// save memory..
					$tokens[$i] = "";

					// Do we have a complete statement yet?
					$complete_stmt = false;

					for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
					{
						// This is the total number of single quotes in the token.
						$total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
						// Counts single quotes that are preceded by an odd number of backslashes,
						// which means they're escaped quotes.
						$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);

						$unescaped_quotes = $total_quotes - $escaped_quotes;

						if (($unescaped_quotes % 2) == 1)
						{
							// odd number of unescaped quotes. In combination with the previous incomplete
							// statement(s), we now have a complete statement. (2 odds always make an even)
							$output[] = $temp . $tokens[$j];

							// save memory.
							$tokens[$j] = "";
							$temp = "";

							// exit the loop.
							$complete_stmt = true;
							// make sure the outer loop continues at the right point.
							$i = $j;
						}
						else
						{
							// even number of unescaped quotes. We still don't have a complete statement.
							// (1 odd and 1 even always make an odd)
							$temp .= $tokens[$j] . $delimiter;
							// save memory.
							$tokens[$j] = "";
						}

					} // for..
				} // else
			}
		}

		return $output;
	}


}


?>

