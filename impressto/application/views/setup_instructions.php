<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
    <title>BitHeads Central Setup</title>
	<meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <!-- favicons -->
    <link rel="icon" type="image/png" href="/favicon.png">
	
	<link rel="stylesheet" href="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/css/reset.css" media="all" />

	<link rel="stylesheet" href="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/css/style.css" media="screen" />


	
	
</head> 
<body> 

		<div style="padding:10px; text-align: left; width: 750px; height: 500px; background: white; padding: 5px; margin: 0 auto; ">
		
		<h1>Looks like this is a new project.  A few steps to follow before we can continue</h1>
				
		<br />
		<p>
		You can use the sample default controller from the the application docket folder (1001). It is located at:
		<br />
		<?=$document_root?>/<?php echo PROJECTNAME; ?>/application/1001/controllers/index.php
		<br />
		<br />
		Create a new docket controller folder:<br />
				
		<?=$document_root?>/<?php echo PROJECTNAME; ?>/application/<?=$projectnum?>/controllers/index.php
		
		<p>
		Other docket folders will need to be setup also:
		</p>
		<ul>
		<li><?=$document_root?><?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/<?=$projectnum?>/  </li>
		<li><?=$document_root?>/<?php echo PROJECTNAME; ?>/templates/modules/<?=$projectnum?>/  </li>
		<li><?=$document_root?>/<?php echo PROJECTNAME; ?>/templates/smarty/<?=$projectnum?>/  </li>
		<li><?=$document_root?>/<?php echo PROJECTNAME; ?>/templates/widgets/<?=$projectnum?>/  </li>
		</ul>
		
		<p>
		If you are adding this project to SVN, there are some folder and files you will need to NOT commit to your repository. Some of these files will need to be manually copied
		to the server. Others will be automatically generated. Here is the list:
		
		<ul>
		
		<li> FILE psinit.php	</li>
		<li> FILE <?=$document_root?>/<?php echo PROJECTNAME; ?>/vendor/xtras/elfinder/server/cache/plugins_cache.ser	</li>
		<li> FILE <?=$document_root?>/<?php echo PROJECTNAME; ?>/vendor/xtras/elfinder/server/cache/plugins_requires.ser	</li>
		<li> FOLDER install_inactive </li>
		<li> FOLDER <?=$document_root?>/<?php echo PROJECTNAME; ?>/application/cache/smarty	</li>
		<li> FOLDER <?=$document_root?>/<?php echo PROJECTNAME; ?>/application/cache/user_sessions	</li>
		</ul>
		
		
		</div>
		
</body> 
</html>