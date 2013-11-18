<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Copy a whole Directory
 *
 * Copy a directory recrusively ( all file and directories inside it )
 *
 * @access    public
 * @param    string    path to source dir
 * @param    string    path to destination dir
 * @return    array
 */    
if(!function_exists('directory_copy'))
{
    function directory_copy($srcdir, $dstdir)
    {
        //preparing the paths
        $srcdir=rtrim($srcdir,'/');
        $dstdir=rtrim($dstdir,'/');

        //creating the destenation directory
        if(!is_dir($dstdir))mkdir($dstdir);
        
        //Mapping the directory
        $dir_map=directory_map($srcdir);
		
		
        foreach($dir_map as $object_key=>$object_value)
        {
            if(is_numeric($object_key)){
				
				if(!file_exists($dstdir.'/'.$object_value)) copy($srcdir.'/'.$object_value,$dstdir.'/'.$object_value);//This is a File not a directory
            
			}else
                directory_copy($srcdir.'/'.$object_key,$dstdir.'/'.$object_key);//this is a dirctory
        }
    }
	
	/**
	* Creates a full path of directories. It will create parent directories if
	* they do not exits.
	*
	* This is an exact copy of the same function that is in the common file_tools library
	*
	* NOTE: warning turned off in the file function calls because basedir restriction
	* is in effect on some  servers (Media Temple)
	* @author Nimmitha Vidyathilaka
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

					if(!@file_exists($dir_build.DS."index.html")){

						$NF = @fopen($dir_build.DS."index.html","w");

						@fwrite($NF,

						"<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n"
						."<HTML>\n"
						."<HEAD>\n"
						."<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=iso-8859-1\">\n"
						."<TITLE>FOLDER RESTRICTED</TITLE>\n"
						."</HEAD>\n"
						."<BODY>FOLDER RESTRICTED</BODY>\n"
						."</HTML>\n");

						@fclose($NF);

					}

					if($secure != false && !@file_exists($dir_build.DS.".htaccess") ){

						$htaccessvars = "AuthName \"BC RESTRICT\"\n"
						. "AuthType Basic\n"
						."<Limit GET POST>\n"
						."order deny,allow\n"
						."deny from all\n"
						."</Limit>\n";
						
						$NF = @fopen($dir_build.DS.".htaccess","w");
						@fwrite($NF,	$htaccessvars);
						@fclose($NF);

					}
				}
			}
		}

		return $dir_build;
	
	}

	
}  

