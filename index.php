<?php

//NOTE: psboot is no longer used because we are using pre controller hooks instead to do wierdo wordpressy things.


// Check if the install folder exists - if so then show the installer app
if (is_dir('./install'))
{
	header('Location: install');
	exit;
}

require("init.php");


/*
* --------------------------------------------------------------------
* LOAD THE BOOTSTRAP FILE
* --------------------------------------------------------------------
*
* And away we go...
*
*/
require_once BASEPATH.'core/CodeIgniter'.EXT;

/* End of file index.php */
/* Location: ./index.php */