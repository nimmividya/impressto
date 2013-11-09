<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>elFinder 2.0</title>

		<?php
		
		echo $this->load->view("themes/" .$this->config->item('admin_theme') . '/admin/includes/header_includes', $data, TRUE); 
				
		?>
		
		<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
		<script type="text/javascript" src="js/elfinder.min.js"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<script type="text/javascript" src="js/i18n/elfinder.ru.js"></script>


		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			$().ready(function() {
				var elf = $('#elfinder').elfinder({
					url : '/file_browser/elfinder_init/'  // connector URL (REQUIRED)
					// lang: 'ru',             // language (OPTIONAL)
				}).elfinder('instance');
			});
		</script>
		
		
				
	</head>
	<body>
	
	<div id="wrapper">

	<div id="header">
		<div class="logo">
			<a href="/admin" title="PageShaper"><img src="<?php echo ASSETURL; ?>/<?php echo PROJECTNAME; ?>/default/core/images/logo.gif" alt="Pageshaper Logo" /></a>
		</div><!-- [END] .logo -->
		<?php
		
		echo $this->load->view("themes/" .$this->config->item('admin_theme') . '/admin/includes/utilitynav', $data, TRUE); 
				
		?>
	</div>
   	<div id="wrapper1">
    	<h1><?php //echo $psTitle; ?></h1>
    </div>
  	<div id="wrapper2">
 
		<?php
		
		echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/leftnav', $data, TRUE); 
				
		?>
		
        <div id="main_content">
		
		

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>
		
	
		<?php
		
		echo $this->load->view("themes/" . $this->config->item('admin_theme') . '/admin/includes/footer', $data, TRUE); 
				
		?>
		
