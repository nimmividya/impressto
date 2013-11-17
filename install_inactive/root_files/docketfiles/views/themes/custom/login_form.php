<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
    <title>Login | pageShaper 2.0</title>
	<base href="<?php echo base_url(); ?>" />
	<meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <!-- favicons -->
    <link rel="icon" type="image/png" href="/favicon.png">
	
	<?php
		// probably loaded already but loading this so we don't get an error .
		$this->load->library('asset_loader');
		
		$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/core/css/reset.css","","all");
		$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/core/css/style.css");
	
		$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/core/css/smoothness/jquery-ui-1.8.2.custom.css");	
		$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/core/css/ps_forms.css");	
		
	?>
	
    <!-- stylesheets -->
	<?php
	if(isset($this->asset_loader->header_css)){
		echo $this->asset_loader->output_header_css();
	}
	?>
	<!--[if lte IE 7]>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/<?php echo PROJECTNAME; ?>/core/css/ie/ie-7.css" />
	<![endif]-->

    <!-- scripts -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	
	
	
</head> 
<body> 
	<div id="login_wrapper">
	


		<div class="login_form">
			<div class="login_form_header">
				<h1>Login</h1>
			</div><!-- [END] .login_form_header -->
				<form action="/login/validate_credentials" method="post" accept-charset="utf-8">	
				
				<?php
					if(!isset($error_msg)){
				?>
					<div class="alert alert-error" style="width: 241px;">
						<?php echo '<span>&bull; ' . $error_msg . '</span>'; ?>
					</div><!-- [END] .error_box -->
				<?php } ?>
					<div>
						<label for="username">Username</label>
						<input type="text" id="username" name="username" value="" maxlength="50"/>
					</div>
					<div>
						<label for="password">Password</label>
						<input type="password" id="password" name="password" value="" maxlength="50"/>
					</div>
					<div class="rememberme">
						<label for="rememberme">
							Remember Me
							<input type="checkbox" id="rememberme" name="rememberme" value="rememberme" />
						</label>
					</div>
				
					<button class="btn btn-default" type="submit">Enter</button>
				</form>
			<div class="login_form_footer"></div><!-- [END] .login_form_footer -->
		</div><!-- [END] .login_form -->
		<div class="login_footer">
		</div><!-- [END] .login_footer -->
	</div><!-- [END] #login_wrapper -->
</body> 
</html>