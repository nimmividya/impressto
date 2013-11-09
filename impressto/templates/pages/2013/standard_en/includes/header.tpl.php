<!DOCTYPE html>
<html {if $html_declarations != ''}{$html_declarations}{/if}>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$CO_seoTitle} | {$site_title}</title>
    <link href="/assets/public/2013/skin/main/style/style.css" rel="stylesheet" type="text/css" />
    <link href="/assets/public/2013/skin/main/style/basic.css" rel="stylesheet" type="text/css" />
    <link href="/assets/public/2013/skin/main/style/uploaddialog.css" rel="stylesheet" type="text/css" />    
    <link href="/assets/public/2013/skin/main/style/message.css" rel="stylesheet" type="text/css" />
    <link href="/assets/public/2013/skin/main/style/jquery.Jcrop.css" rel="stylesheet" type="text/css" />    
    
	
	<script type="text/javascript" src="/assets/motuha/default/core/js/appclass.js"></script>
		
    <script type="text/javascript" src="/assets/motuha/default/third_party/jquery/jquery-1.8.2.min.js"></script>
   	<!-- Calendar -->
   	<script src="/assets/public/2013/includes/calendar/js/coda.js" type="text/javascript"> </script>
	<!-- Calendar -->
   
    <script src="/assets/public/2013/includes/js/jquery-ui-1.8.6.min.js" type="text/javascript"></script>
    <script src="/assets/public/2013/includes/js/jquery.scrollTo-1.4.2-min.js" type="text/javascript"></script>
    <script src="/assets/public/2013/includes/js/scripts.js" type="text/javascript"></script>

    <script src="{$asseturl}/{$projectname}/default/third_party/angular/angular.min.js" type="text/javascript"></script>
	
	
	
    <script type='text/javascript' src='/assets/public/2013/includes/js/uploader.js'></script>  
    <script type='text/javascript' src='/assets/public/2013/includes/js/ajaxupload.3.5.js'></script>  

    <script type='text/javascript' src='/assets/public/2013/includes/js/msg.js'></script>  
    <script type='text/javascript' src='/assets/public/2013/includes/js/jquery.simplemodal.js'></script>
	<script type='text/javascript' src='/assets/public/2013/includes/js/basic.js'></script>

    <script type="text/javascript" src="/assets/public/2013/includes/js/pinnotes.js"></script>
    
   
    <script type="text/javascript" src="/assets/public/2013/includes/js/move.js"></script>
    <script type="text/javascript" src="/assets/public/2013/includes/js/jquery_002.js"></script>

	<!-- HomePage Image Slider -->
	<!-- Including Mousewheel jQuery plugin -->
    <script type="text/javascript" src="/assets/public/2013/includes/slider/js/jquery.mousewheel.js"></script>
    <!-- Including ulslide jQuery plugin -->
    <script type="text/javascript" src="/assets/public/2013/includes/slider/js/jquery.ulslide.js"></script>
	
	
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
	
	  <script type="text/javascript" src="/assets/public/2013/js/common.js"></script>



</head>
<body>



