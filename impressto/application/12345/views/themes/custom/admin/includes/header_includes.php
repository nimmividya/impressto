<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// probably loaded already but loading this so we don't get an error .
$this->load->library('asset_loader');

?>

	<!-- favicons -->
	<link rel="icon" type="image/png" href="/favicon.png">

	<!-- stylesheets -->

	<?php

		$this->asset_loader->add_header_css_top("/assets/".PROJECTNAME."/core/css/reset.css","","all");
		//$this->asset_loader->add_header_css_top("/assets/".PROJECTNAME."/core/css/style.css");
		
		$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/default/themes/classic/css/style.css","","all");
		
		$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/core/css/smoothness/jquery-ui-1.8.2.custom.css");	
		$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/core/css/ps_forms.css");	
		


		
		
	?>
	
	<!--[if lte IE 7]>
		<link rel="stylesheet" type="text/css" media="screen" href="/assets/<?php echo PROJECTNAME; ?>/core/css/ie/ie-7.css" />
	<![endif]-->
	
	<?php
	if(isset($this->asset_loader->header_css)){
		echo $this->asset_loader->output_header_css();
	}
	?>
	
	<!-- scripts -->
	<?php
	
	$this->asset_loader->add_header_js_top("core/js/jquery.min.js");	
	//$this->asset_loader->add_header_js_top("core/js/jquery-1.7.js");	
	
	
	//$this->asset_loader->add_header_js_top("core/js/jquery.min.js");	
	
	$this->asset_loader->add_header_js_top("core/js/jquery-ui.min.js");		
	$this->asset_loader->add_header_js_top("core/js/libs/jquery-templ.js");		
	
	$this->asset_loader->add_header_js_top("core/js/appbase.js");		
	$this->asset_loader->add_header_js_top("core/js/ps_form.js");		
	$this->asset_loader->add_header_js_top("core/js/jquery.cookie.js");

	$this->asset_loader->add_header_js_top("core/js/jquery.cookie.js");	

	$this->asset_loader->add_header_js_string_top(" ps_base.appname = '" . PROJECTNAME . "'; ");
	
	$this->load->helper('mobile');
		
		
	$ismobile = (ps_ismobile() == true) ? 'true' : 'false';
	$domobile = (ps_domobile() == true) ? 'true' : 'false';
		
	$this->asset_loader->add_header_js_string_top(" ps_base.ismobile = '{$ismobile}'; ps_base.domobile = '{$domobile}'; ");
	
	
	?>

	<?php
		// some modules will need to output specific css libraries here
		if(isset($customheadertags)){
			echo $customheadertags; 
		}
	?>	
	
	<?php 
	if(isset($this->asset_loader->header_js)){
	
	
		echo $this->asset_loader->output_header_js();
	}
	?>
	