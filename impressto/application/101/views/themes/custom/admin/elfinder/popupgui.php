<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>elFinder 2.0</title>

		<?php
			if(isset($header_includes)){
				echo $header_includes; 
			}
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
		<script type="text/javascript" src="js/i18n/elfinder.en.js"></script>


		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
		
			//var uploadpath = "/assets/upload";
			
				
			
		
		
		   // Helper function to get parameters from the query string.
			function getUrlParam(paramName) {
				var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
				var match = window.location.search.match(reParam) ;
				
				alert( match[1] );
                return (match && match.length > 1) ? match[1] : '' ;
			}
	
			$().ready(function() {
			
			
				<?php
				
				$ajpx_targetfield = "";
				
				if(strpos(getenv("REQUEST_URI"), "CKEditor=") !== false || strpos(getenv("REQUEST_URI"), "ajpx_targetfield=") !== false	){
					if(isset($_GET['ajpx_targetfield']) && $_GET['ajpx_targetfield'] != "") $ajpx_targetfield = $_GET['ajpx_targetfield'];
					else if($_GET['CKEditorFuncNum'] != "") $ajpx_targetfield = $_GET['CKEditorFuncNum'];
				}
				
				$elfinder_callback = "";
				
				if(strpos(getenv("REQUEST_URI"), "CKEditor=") !== false || strpos(getenv("REQUEST_URI"), "callback=") !== false	){
					if(isset($_GET['callback']) && $_GET['callback'] != "") $elfinder_callback = $_GET['callback'];
				}
				
				
				
				?>
				
				window.opener.ps_base.setCookie('ajpx_targetfield', '<?=$ajpx_targetfield?>');
				window.opener.ps_base.setCookie('elfinder_callback', '<?=$elfinder_callback?>');
				
				var ajxplorer_ispopup = 'true';
				
				var elf = $('#elfinder').elfinder({
					url : '/file_browser/elfinder_init/', // connector URL (REQUIRED)
					getFileCallback : function(file) {
					
						var ajpx_targetfield = window.opener.ps_base.getCookie('ajpx_targetfield');
						var elfinder_callback = window.opener.ps_base.getCookie('elfinder_callback');
						
						
						if(window.opener.ps_base.checkIsNumeric( ajpx_targetfield )){
				
							window.opener.CKEDITOR.tools.callFunction(ajpx_targetfield, file);
							
					
						}else{ 
						
							window.opener.ps_base.updatetarget(ajpx_targetfield, file);
							
						}	
						
						
						if(elfinder_callback != "") eval("window.opener." + elfinder_callback); 
						
						
						window.close();
					},
					resizable: false,
					lang: 'en',             // language (OPTIONAL)
				}).elfinder('instance');
			});
		</script>
		
		
				
	</head>
	<body>
	

		
		

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>
		
	
		
	</body>
</html>
		

		

		
