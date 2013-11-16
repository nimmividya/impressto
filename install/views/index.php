
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	
	<title>PageShaper Installer</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

	<link rel="stylesheet" type="text/css" href="/install/assets/css/screen.css" media="screen" />
	
</head>
<body>

	<div class="page">
	
		<!-- Header -->
		<div class="head text-right">

			<h1>Site Installer</h1>
		</div>

		<div class="main">

			<?php echo isset($message) ? $message : ''; ?>
			<?php echo isset($content) ? $content : ''; ?>

		</div>	<!-- /main -->
	</div>	<!-- /page -->
	
	<div class="foot">
		<?php if (ENVIRONMENT == 'development') :?>
			<p style="float: right; margin-right: 80px;">Page rendered in {elapsed_time} seconds, using {memory_usage}.</p>
		<?php endif; ?>
		
		<p>Powered by <a href="http://www.pageshaper.ca" target="_blank">PageShaper</a></p>
	</div>
	
	<div id="debug"></div>

</body>
</html>