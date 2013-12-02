<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Super Admin Section | <?php echo PROJECTNAME; ?></title>
	<base href="<?php echo base_url(); ?>" />
	

	<?php
	
	//$data['main_content'] = $main_content;
						
	// load up all the header assets after the content is loader
	echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/header_includes', $data, TRUE); 
			
		
	?>
	
	</head>
	<body style="padding:10px;">
	
	<div id="loading_layer" style="display:none"><img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/themes/liquid/img/ajax_loader.gif" alt="loader" /></div>
		
				
	<?php
	
	if(isset($parsedcontent)) echo $parsedcontent;
	else $this->load->view($main_content, $data); 
	
	?>
	
	<div id="ajaxLoadAni">
		<img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/ajax-loader.gif" alt="Ajax Loading Animation" />
		<span>Processing...</span>
	</div><!-- [END] #ajaxLoadAni -->

</body>
</html>