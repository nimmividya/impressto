<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>{$CO_seoTitle} | {$site_title}</title>
    <meta name="keywords" content="{$site_keywords}" />
    <meta name="description" content="{$site_description}" />
	<meta name="robots" content="index, follow" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <!-- favicons -->
    <link rel="shortcut icon" href="/assets/public/images/favicon.ico" type="image/x-icon"/>

    <!-- stylesheets
    <link rel="stylesheet" href="/assets/public/default/css/reset.css" media="all" />
    <link rel="stylesheet" href="/assets/public/default/css/style.css" media="screen" /> -->
	<!--[if lte IE 7]>
		<link rel="stylesheet" type="text/css" media="screen" href="/assets/public/css/ie-7.css" />
	<![endif]-->
	{if isset($output_header_css) && $output_header_css != ''}
		{$output_header_css}
	{/if}

    <!-- scripts -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/assets/public/js/libs/superfish.js"></script>

	
	{if isset($output_header_js) && $output_header_js != ''}
		{$output_header_js}
	{/if}
	
	{if isset($CO_Javascript) && $CO_Javascript != ''}
		<script type="text/javascript">
			{$CO_Javascript}
		</script>
	{/if}
    

	{include file="includes/google_analytics.tpl.php"}


</head>
<body>
<div id="wrapper">