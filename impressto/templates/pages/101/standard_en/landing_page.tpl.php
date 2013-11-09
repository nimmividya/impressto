<?php /*
@Name: Landing Page
@Type: PHP
@Filename: landing_page.tpl.php
@Lang: 
@Description: Used to redirect non-authenticated users to the login screen
@Author: peterdrinnan
@Projectnum: 4660
@Version: 
@Status: complete
@Date: 2012-02
@fulltemplatepath:  //PROJECTNAME/templates/pages/101/standard_en/dashboard.tpl.php
*/
?>


<?php 

//check if the user is authenticated 

$CI =& get_instance();
$CI->load->helper('auth');
	
	
if ( ci_user_logged_in() ) {

	//redirect to the dashbard
	header( 'Location: /admin/' );
	
	
} else {

	header( 'Location: /login/' );
	
}


?>