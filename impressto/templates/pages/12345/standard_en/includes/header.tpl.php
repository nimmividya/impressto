<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>{$CO_seoTitle} | {$site_title}</title>
    <meta name="keywords" content="{$site_keywords}" />
    <meta name="description" content="{$site_description}" />
	<meta name="robots" content="index, follow" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- change these GEOLOCATION tags for specific clients -->
	<meta name="location" content="CA, ON, Ottawa" />
	<meta name="geo.position" content="43;-76" />
	<meta name="geo.region" content="CA-ON" />
	<meta name="geo.placename" content="Ottawa" />
	<meta name="abstract" content="Website Design and Development" />
	<meta name="classification" content="Website Design and Development" />
	
	<!-- 
		
	WE NEED A CODE METATAG GENERATOR HERE 
	
	-->
	
		
	
    <!-- favicons -->
    <link rel="shortcut icon" href="/assets/public/images/favicon.ico" type="image/x-icon"/>


	<!--[if lte IE 7]>
		<link rel="stylesheet" type="text/css" media="screen" href="/assets/public/css/ie-7.css" />
	<![endif]-->
	
    <!-- scripts -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	

	{if isset($output_misc_header_top_assets) && $output_misc_header_top_assets != ''}
		{$output_misc_header_top_assets}
	{/if}
	
		
	{if isset($output_header_css) && $output_header_css != ''}
		{$output_header_css}
	{/if}
	
	
	{if isset($output_header_js) && $output_header_js != ''}
		{$output_header_js}
	{/if}
	
	{if isset($CO_Javascript) && $CO_Javascript != ''}
		<script type="text/javascript">
			{$CO_Javascript}
		</script>
	{/if}
    
	
	{if isset($output_header_misc_assets) && $output_header_misc_assets != ''}
		{$output_header_misc_assets}
	{/if}
	
	

</head>
<body>
<div id="wrapper">

