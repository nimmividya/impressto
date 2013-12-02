<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link id="page_favicon" href="/favicon.ico" rel="icon" type="image/x-icon" />
	
    <title>Admin | myApp 2.0</title>
	<base href="<?php echo base_url(); ?>" />
	<meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <!-- favicons -->
    <link rel="icon" type="image/png" href="/favicon.png">
	
    <!-- stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url(); ?><?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/core/css/reset.css" media="all" />
    <link rel="stylesheet" href="<?php echo base_url(); ?><?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/core/css/style.css" media="screen" />
	<!--[if lte IE 7]>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>application/assets/css/ie/ie-7.css" />
	<![endif]-->

    <!-- scripts -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	
</head> 
<body> 
	<div id="login_wrapper">
		<div class="login_header">
			<a href="<?php echo base_url(); ?>ps-login">
				<img src="<?php echo ASSETURL; ?>/<?php echo PROJECTNAME; ?>/default/core/images/logo.gif" alt="Logo" />
			</a>
		</div><!-- [END] .login_header -->

<form id="" action="/index/install" method="POST">

Before you run this script, you will need to do the following:
<br />
Create a database for this site. No table are required
<br />
Set the /assets and /<?php echo PROJECTNAME; ?>/user_sessions directoies to read/write


<br />
edit 2 configuration files.
<br />
Go to the folder \<?php echo PROJECTNAME; ?>\application\config\ and locate the following files:
<br />
database.php
<br />
config.php
<br />

<br />
<br />
Open database.php amd update the database connection information.
<br />
<br />
Open config.php and update the $config['base_url'] setting.
<br /><br />

Once complete, you can login with username "admin", and password "password".

<input type="hidden" name="installme" value="true">

    <div>
                <?php
			$data = array(
			  'name'        => 'seoTitle',
			  'id'          => 'seoTitle',
			  'value'       => '',
			  'maxlength'   => '100',
			  'size'        => '50',
			  'class'        => 'txtAbsolute',
			);
			
			//echo form_input($data);
			
		?>
    </div>
	

<input type="submit" value="Install BitHeads Central">

</form>


	</div><!-- [END] #login_wrapper -->
</body> 
</html>



