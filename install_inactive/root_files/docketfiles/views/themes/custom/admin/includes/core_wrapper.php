<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link id="page_favicon" href="/favicon.ico" rel="icon" type="image/x-icon" />
	
    <title>Super Admin Section | PageShaper <?=$this->config->item('ps_version')?></title>
	<base href="<?php echo base_url(); ?>" />
	<meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<?php
	
		//$data['main_content'] = $main_content;
						
		// load up all the header assets after the content is loader
		echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/header_includes', $data, TRUE); 
			
		
	?>
	
	
</head>
<body>

<?php

///////////////
// parse and store the content first so we can get a list of asset load requests for the page header 
echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/template', $data, TRUE);

?>

</body>
</html>
