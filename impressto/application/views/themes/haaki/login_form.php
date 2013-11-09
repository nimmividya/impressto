<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <link rel="icon" type="image/ico" href="favicon.ico">
    <title>Beoro Admin - Login</title>
	
	<?php
		
		// probably loaded already but loading this so we don't get an error .
		$this->load->library('asset_loader');

		$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/default/core/css/zocial/zocial.css","","all");

		
		$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/default/themes/haaki/css/login.css","","all");

		
		echo $this->asset_loader->output_header_css();
				
	?>
	

    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet'>
	
	<?php
		
		$this->asset_loader->add_header_js_top("third_party/jquery/jquery-" . $this->config->item('jquery_version') . ".js");
		//$this->asset_loader->add_header_js("/assets/" . PROJECTNAME . "/default/themes/liquid/js/jquery.actual.min.js","","all");
		$this->asset_loader->add_header_js("default/third_party/validation/jquery.validate.min.js","","all");
		
		echo $this->asset_loader->output_header_js();
	
	?>
	

    <script type="text/javascript">
        (function(a){a.fn.vAlign=function(){return this.each(function(){var b=a(this).height(),c=a(this).outerHeight(),b=(b+(c-b))/2;a(this).css("margin-top","-"+b+"px");a(this).css("top","50%");a(this).css("position","absolute")})}})(jQuery);(function(a){a.fn.hAlign=function(){return this.each(function(){var b=a(this).width(),c=a(this).outerWidth(),b=(b+(c-b))/2;a(this).css("margin-left","-"+b+"px");a(this).css("left","50%");a(this).css("position","absolute")})}})(jQuery);
        $(document).ready(function() {
            if($('#login-wrapper').length) {
                $("#login-wrapper").vAlign().hAlign()
            };
            if($('#login-validate').length) {
                $('#login-validate').validate({
                    onkeyup: false,
                    errorClass: 'error',
                    rules: {
                        login_name: { required: true },
                        login_password: { required: true }
                    }
                })
            }
            if($('#forgot-validate').length) {
                $('#forgot-validate').validate({
                    onkeyup: false,
                    errorClass: 'error',
                    rules: {
                        forgot_email: { required: true, email: true }
                    }
                })
            }
            $('#pass_login').click(function() {
                $('.panel:visible').slideUp('200',function() {
                    $('.panel').not($(this)).slideDown('200');
                });
                $(this).children('span').toggle();
            });
        });
    </script>
</head>
<body>
    <div id="login-wrapper" class="clearfix">
        <div class="main-col">
		
	
            <img src="/assets/<?php echo PROJECTNAME; ?>/default/themes/haaki/images/login_logo.png" alt="" class="logo_img" />
            <div class="panel" style="width:630px">
			
				<div style="float:left; margin: 0 20px 0 0">
                <p class="heading_main">Account Login</p>
                <form action="/auth/validate_credentials" method="post" accept-charset="utf-8" id="login_form">
                    <label for="login_name">Login</label>
                    <input type="text" id="username" name="username" value="" />
                    <label for="login_password">Password</label>
                    <input type="password" id="password" name="password" value="" />
                    <label for="login_remember" class="checkbox"><input type="checkbox" id="rememberme" name="rememberme" value="rememberme" /> Remember me</label>
                    <div class="submit_sect">
                        <button type="submit" class="btn btn-bitheads-3">Login</button>
                    </div>
                </form>

				</div>
				<div class="social_auth_icons">
			
				<fieldset>
				<legend>Already regsitered?</legend>
				<a href="auth/social_login/Facebook" class="zocial facebook">Sign in with Facebook</a>
				<a href="auth/social_login/Google" class="zocial googleplus">Sign in with Google+</a>
				<a href="auth/social_login/Twitter" class="zocial twitter">Sign in with Twitter</a>
				<a href="auth/social_login/LinkedIn" class="zocial linkedin">Sign in with LinkedIn</a>
				</fieldset>
	
		
				</div>
			
				<div style="clear:both"></div>
			

			
            </div>
			

			


			
		
            <div class="panel" style="display:none">
                <p class="heading_main">Can't sign in?</p>
                <form id="forgot-validate" method="post">
                    <label for="forgot_email">Your email adress</label>
                    <input type="text" id="forgot_email" name="forgot_email" />
                    <div class="submit_sect">
                        <button type="submit" class="btn btn-bitheads-3">Request New Password</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="login_links">
            <a href="javascript:void(0)" id="pass_login"><span>Forgot password?</span><span style="display:none">Account login</span></a>
        </div>
    </div>
	

</body>
</html>