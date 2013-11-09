
<h1>DASHBOARD</h2>
<?php

if($api_key != "") echo Widget::run('dashboard/updater', array());


if($dashboard_content != ""){

	echo $dashboard_content;
	
}else{ ?>


	<img style="float:left;" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/themes/classic/images/leaf.png" />

	<div style="float:left; margin-left:20px;">
	
	<h3>Here are some resources you may find useful:</h3>


	<ul class="list_b">
	<li><a style="color:#000000" href="http://kb.central.bitheads.ca" target="_blank">BitHeads Central</a></li>
	<li><a href="http://www.central.bitheads.ca/changelog_<?=$appseries?>.<?=$new_migration_version?>">BitHeads Central <?=$appseries?>.<?=$new_migration_version?> Change Log</a></li>
	</ul>
	</div>

<?php } ?>


