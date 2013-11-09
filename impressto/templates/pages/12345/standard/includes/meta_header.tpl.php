<!DOCTYPE html>
<html>
	<head>
		<!-- Meta -->
		<meta charset = "UTF-8" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1">
		
		
		<!-- Title -->
		<title>{$meta_page_title} | {$site_title}</title>
		<meta name="keywords" content="{$site_keywords}" />
		<meta name="description" content="{$site_description}" />
		
		
		<meta name="google-site-verification" content="UMVCLSdmZEHtFpdeFCGCW8OBoXeFlR7aHR74v8eStgw" />
		
	
	<!-- change these GEOLOCATION tags for specific clients -->
	<meta name="location" content="CA, ON, Ottawa" />
	<meta name="geo.position" content="43;-76" />
	<meta name="geo.region" content="CA-ON" />
	<meta name="geo.placename" content="Ottawa" />
	<meta name="abstract" content="Website Design and Development" />
	<meta name="classification" content="Website Design and Development" />
		
		<!-- Fonts -->
		<link href = 'http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic|Open+Sans:400,400italic,600,800' rel = 'stylesheet' type = 'text/css'>
		
		<link rel="stylesheet" href="/assets/{$projectname}/default/core/css/jquery/jquery_ui/smoothness/jquery-ui-1.9.1.custom.css" media="screen" />
		
		
		<!-- IE -->

		
		<!--
		<link rel="stylesheet" href="/assets/public/1001/css/reset.css" media="all" />
		<link rel="stylesheet" href="/assets/public/1001/css/style.css" media="screen" />
		<link rel="stylesheet" href="/assets/public/1001/css/style.en.css" media="screen" />
		-->
	
		

		{if isset($output_header_css) && $output_header_css != ''}
			{$output_header_css}
		{/if}
	
	
		<!-- scripts -->
		
		
		<script type = "text/javascript" src = "/assets/public/1001/js/jquery-1.8.3.min.js"></script>
		
		
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		
		<!-- Scripts -->
		<script type = "text/javascript" src = "/assets/public/1001/js/jquery.easing.js"></script>
		<!-- <script type = "text/javascript" src = "/assets/public/1001/js/jquery_cookie.js"></script> -->
		<!-- <script type = "text/javascript" src = "/assets/public/1001/js/scripts.js"></script> -->
		
		<!-- Plugins -->
		<!-- 
		<script type = "text/javascript" src = "/assets/public/1001/plugins/colorbox/jquery.colorbox.js"></script>
		<script type = "text/javascript" src = "/assets/public/1001/plugins/flexslider/jquery.flexslider-min.js"></script>
		<script type = "text/javascript" src = "/assets/public/1001/plugins/mediaelement/mediaelement.min.js"></script>
		-->
		
		
		<script type = "text/javascript" src = "/assets/public/1001/plugins/social/jquery.social.js"></script>
		<script type = "text/javascript" src = "/assets/public/1001/plugins/quicksand/jquery-animate-css-rotate-scale.js"></script>
		<script type = "text/javascript" src = "/assets/public/1001/plugins/quicksand/jquery-css-transform/jquery-css-transform.js"></script>
		<script type = "text/javascript" src = "/assets/public/1001/plugins/quicksand/jquery.quicksand.js"></script>
		
		<!--[if lt IE 9]>
			<script src = "/assets/public/1001/js/ie/scripts.js" type = "text/javascript"></script>
		<![endif]-->
		
		



	{if isset($output_misc_header_top_assets) && $output_misc_header_top_assets != ''}
		{$output_misc_header_top_assets}
	{/if}
	
	
	{if isset($output_header_js) && $output_header_js != ''}
		{$output_header_js}
	{/if}
	
	{if isset($CO_Javascript) && $CO_Javascript != ''}
		<script type="text/javascript">
			{$CO_Javascript}
		</script>
	{/if}
    

	{if isset($site_google_analytics_key) && $site_google_analytics_key != ''}
	 <!-- analytics --> 
	 <script type="text/javascript"> 
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', '{$site_google_analytics_key}']);
      _gaq.push(['_trackPageview']);
 
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
	{/if}
	
	{if isset($output_header_misc_assets) && $output_header_misc_assets != ''}
		{$output_header_misc_assets}
	{/if}
	
	
	</head>
