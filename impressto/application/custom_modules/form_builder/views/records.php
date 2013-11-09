<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Contact Form Manager
@Type: PHP
@Filename: manager.php
@Description: Form field management interface
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

<?php 

$CI =& get_instance(); 

$CI->load->library('asset_loader');
		

foreach($css_files as $file) $CI->asset_loader->add_header_css($file); 

foreach($js_files as $file) $CI->asset_loader->add_header_js($file); 


?>
<div class="admin-box">

<h3 style="margin:0px;">Contact Form Records</h3>

	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
	
</div>


