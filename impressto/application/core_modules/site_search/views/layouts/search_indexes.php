<?php
/*
@Name: Search Manager
@Type: PHP
@Filename: manager.php
@Description: settings for site search and the search widget
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

<?php 

$languages = $this->config->item('languages');


echo $infobar;

?>

<?php
// this is for the jquery UI 1.9 tabs bug
$request_uri = getenv("REQUEST_URI");
?>


 
	<div id="crudTabs" style="display:none">
	
	
		<ul>
			
		<?php if( in_array("en",$languages)){ ?>
			<li><a href="/site_search/admin_remote/indexed_content">English Indexed Content</a></li>
			
		<?php } ?>
		
		
		<?php if( in_array("fr",$languages)){ ?>
			<li><a href="/site_search/admin_remote/indexed_content/fr">French Indexed Content</a></li>
			
		<?php } ?>
		
		<li><a href="<?=$request_uri?>#settings_div" >Global Settings</a></li>
		<li><a href="<?=$request_uri?>#search_records_div">Search Records</a></li>
		
				
		
		</ul>
		
	
	<div id="settings_div" rel="/site_search/">
			<img style="float:left" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME ?>/default/core/images/horizontal_spinner.gif" />
			<span style="float:left; margin-left:20px; margin-top:22px;">LOADING NEW PAGE</span>
	</div>
	<div id="search_records_div" rel="/site_search/search_records">
			<img style="float:left" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME ?>/default/core/images/horizontal_spinner.gif" />
			<span style="float:left; margin-left:20px; margin-top:22px;">LOADING NEW PAGE</span>
	</div>
	<div class="clearfix"></div>
	</div>
	
	
		
					
				
				