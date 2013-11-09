{*
@Name: 404 ERROR
@Type: smarty
@Filename: 404.tpl.php
@Lang: 
@Description: 
@Author: peterdrinnan
@Docket: 1001
@Version: 
@Status: complete
@Date: 2012-09-21
*}
<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>404 - Page Not Found</title>
<link rel="stylesheet" type="text/css" media="screen" href="/assets/public/{$projectnum}/css/404.css" />
</head>

<body>
<div id="wrapper"> 
  <div id="main">
    <div id="header">
      <h1><img class="icon" src="/assets/public/{$projectnum}/images/404_icon.png" alt="Warning, 404" />404</h1>
    </div>
    <div id="content">
      <h2>The page you were looking for could not be found.</h2>
      
      <div class="utilities">
	  
		<p>Please checking the url for errors, then hit the refresh button on your browser.</p>
	    <div class="button-container right"><a class="button" href="/">Go Back...</a></div>
        <div style="clear: both"></div>
      </div>
    </div>

  </div>
</div>
</html>
