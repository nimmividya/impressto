<?PHP /*
@Name: Bullet Style toggle
@Type: PHP
@Author: 
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/09/04
*/ ?>

<?php

$CI = & get_instance();

//echo 'php.ini: ', get_cfg_var('cfg_file_path'); 


?>

<?php


if(!$curl_enabled){ ?>

	<div class="alert alert-error">
	<i class="icon-warning-sign"></i> <strong>Warning!</strong> cURL is not enabled on your server. cURL is required for automatic package updates. Please contact your server administrator.		
	</div>
	
<?php } ?>


<?php if($showversionnotice){ ?>

<div id="ps_version_confirm_notice" class="alert alert-block alert-error fade in">

	<h3 class="alert-heading"><?php echo PROJECTNAME; ?> has been updated</h3>
	<p>Your version of <?php echo PROJECTNAME; ?> has been updated from <?=$appseries?>.<?=$current_migration_version?> to <?=$appseries?>.<?=$new_migration_version?>. 
	<a href="http://www.central.bitheads.ca/en/<?=$appseries?>.<?=$new_migration_version?>_updates">See the full change log</a>.</p>
	
</div>

<?php } ?>


<?php if($showupdatenotice){ ?>

<div id="ps_version_confirm_notice" class="alert alert-block fade in">

	
	<div id="process_core_update_div">
	
	<div style="float:left">
	<h3 class="alert-heading">An update from version <?=$appseries?>.<?=$current_migration_version?> to <?=$appseries?>.<?=$updateversion?> is available</h3>
	</div>
			
	<a style="float:left; margin-left:30px; margin-top:14px;" class="btn" onclick="ps_updater.process_core_update('<?=$appseries?>.<?=$updateversion?>');"><i class="icon-arrow-up"></i> Update Now</a>
	

	
	<div style="clear:both"></div>
	<a style="float:left" onclick="ps_updater.show_full_change_log()">See the full change log</a>.
	
	<div id="full_change_log"><?=$update_info?></div>
	
	</div>
	
	<!-- this is where our progress meter will go -->
	<div style="display:none" id="core_update_progress_div">
	
	
	
		
		<div class="progress progress-info" style="float:left; width:500px; margin: 6px 0 0 0;">
			<div id="core_update_progress_bar" class="bar" style="width:0%"></div>
		</div>
		
		<a id="cancel_core_update_button" style="float:left; margin-left:30px; margin-top:0px;" class="btn" onclick="ps_updater.cancel_core_update();"><i class="icon-stop"></i> Cancel Update</a>

				
		
		<div style="clear:both"></div>
			
		
		<div id="core_update_progress_file_list"></div>
			
					
	</div>
	

			

	
	
	
</div>

<?php } ?>






	