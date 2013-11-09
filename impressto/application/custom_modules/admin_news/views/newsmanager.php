<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: News Manager
@Type: PHP
@Filename: newsmanager.php
@Description: backend admin listing page for all news items
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

<?php 


echo $newsmanager_header;

 ?>
 
<?php

$request_uri = getenv("REQUEST_URI");

?>

<div class="admin-box">
<h3>News Manager</h3>
<?=$infobar?>

<div id="crudTabs" style="display: none;">

	<ul>
		<li><a href="<?=$request_uri?>#news_item_list">News Items</a></li>
		<li><a href="<?=$request_uri?>#widgets">Widgets</a></li>
		<li><a href="<?=$request_uri?>#news_settings">Setting</a></li>
	</ul>
	

	<div id="news_item_list">
	
	
<h2>News Items</h2>

<br />
	

<table class="table table-striped table-bordered table-condensed">
	<tr style="font-weight: bold; text-align: center;">
		<td>id</td>
		<td>Title</td>
		<td>Active</td>
		<td>Archived</td>
		<td>Published</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>

	<?php 
	foreach($newsrecords as $newsrecord){	

		if($newsrecord['active'] == "1") $active_stateimg = "check";
		else $active_stateimg = "cross";
					
		if( $newsrecord['active'] == "") $newsrecord['active'] = "0";
									
		$active_check = "<img id=\"active_toggle_img_{$newsrecord['news_id']}\" src=\"" . ASSETURL . PROJECTNAME . "/default/core/images/actionicons/checkbox_{$active_stateimg}.gif\" />";
		

		if($newsrecord['archived'] == "1") $archived_stateimg = "check";
		else $archived_stateimg = "cross";
					
		if( $newsrecord['archived'] == "") $newsrecord['archived'] = "0";
									
		$archived_check = "<img id=\"archived_toggle_img_{$newsrecord['news_id']}\" src=\"" . ASSETURL . PROJECTNAME . "/default/core/images/actionicons/checkbox_{$archived_stateimg}.gif\" />";

		
	?>
	
		<tr style="height: 29px; text-align: center;">
			<td><?=$newsrecord['news_id']?></td>
			<td style="text-align:left"><a href="/admin_news/edit/<?=$newsrecord['news_id']?>"><?=$newsrecord['newstitle_en']?></a></td>
			<td><a id="active_toggle_<?=$newsrecord['news_id']?>" ulang="en" is_active="<?=$newsrecord['active']?>" href="javascript:ps_newsmanager.toggle_active('<?=$newsrecord['news_id']?>')"><?=$active_check?></a></td>
			<td><a id="archived_toggle_<?=$newsrecord['news_id']?>" ulang="en" is_archived="<?=$newsrecord['archived']?>" href="javascript:ps_newsmanager.toggle_archived('<?=$newsrecord['news_id']?>')"><?=$archived_check?></a></td>
			<td><?=$newsrecord['published']?></td>
			<td style="width:60px">			
			<a class="btn btn-success-small" href="/admin_news/edit/<?=$newsrecord['news_id']?>"><i class="icon-white icon-edit"></i> Edit</a>
			</td>
			<td style="width:80px">				
			<a class="btn btn-danger-small" href="javascript:ps_newsmanager.delete_news('<?=$newsrecord['news_id']?>')"><i class=" icon-white icon-trash"></i> Delete</a>
			</td>
		</tr>
	<?php }  ?>
</table>


</div>

<div id="widgets">

<div id="widgetlist_mainbody_div">

<div class="clearfix">

<h3 style="float:left">Widgets</h3>

<button type="button" style="float:right" onclick="ps_newsmanager.newwidget()" class="btn btn-default"><i class="icon-white icon-star"></i> New Widget</button>

</div>

<br />



<div id="widgets_list">
<?=$widgetlist?>
</div>



</div>

<div style="clear:both"></div>
<div id="widgetnameinput_div" style="display:none">

	<form id="news_widget_form">
	
		<input type="hidden" name="widget_id" id="widget_id" value="" />
	
		
		
	
		<div style="float:left">
		<?php echo $new_widget_name; ?>
		</div>
		
		
		<div style="float:left">
		<?php echo $widget_type_selector; ?>
		</div>
		
		<div id="newsarticle_template_selector_div" style="float:left; display:none">
		<?php echo $newsarticle_template_selector; ?>
		</div>
		<div id="newsarchives_template_selector_div" style="float:left; display:none">
		<?php echo $newsarchives_template_selector; ?>
		</div>
		<div id="newsticker_template_selector_div" style="float:left; display:none">
		<?php echo $newsticker_template_selector; ?>
		</div>

		
		
		
		<div style="float:right; margin-top:10px;">
				
		
		<button type="button" style="float:right" onclick="ps_newsmanager.cancelnewidgetedit()" class="btn btn-danger">Cancel</button>

		<button type="button" style="float:right; margin-right:10px;" onclick="ps_newsmanager.savewidget()" class="btn btn-success"><i class="icon-white icon-ok"></i> Save</button>
		
		</div>
		
		<div class="clearfix"></div>		
		<br />
		
		

		
	</form>
	
	
</div>



</div>



<div id="news_settings">

<form id="news_settings_form">


<h3>Settings</h3>
<br /><br />



<strong>Listing limit (used for pagination)</strong>
<br />

<?php

$data = array(
              'name'        => 'news_listlimit',
              'id'          => 'news_listlimit',
              'value'       => (isset($moduleoptions['news_listlimit']) ? $moduleoptions['news_listlimit'] : ""),
              'style'       => 'width:50px',
            );

echo form_input($data);

?>

<div class="clearfix"></div>

<hr />

<div style="float:left">
<strong>Newsfeed Title</strong>
<br />
<input type="text" id="news_title_en" name="news_title_en" value="<?php echo isset($moduleoptions['news_title_en']) ? $moduleoptions['news_title_en'] : ""; ?>" />
</div>

<div style="float:left; margin-left:20px;">
<strong>English News Page Wrapper</strong>
<br />

<?php 

$data = array(
	"language" =>"en",
	'name'        => "news_page_en",
	'type'          => 'select',
	'showlabels'          => false,
	'id'          => "news_page_en",
	'width'          => 300,
	'label'          => "",
	'onchange' => "",
	'value'       => (isset($moduleoptions['news_page_en']) ? $moduleoptions['news_page_en'] : '')
	
);

echo get_ps_page_slector($data); 

?>
</div>

<div class="clearfix"></div>



<strong>Newsfeed Description</strong>
<br />
<textarea style="width:650px; height:60px;" id="news_description_en" name="news_description_en"><?php echo isset($moduleoptions['news_description_en']) ? $moduleoptions['news_description_en'] : ""; ?></textarea>


<hr />

<div style="float:left">
<strong>French Newsfeed Title</strong>
<br />
<input type="text" id="news_title_fr" name="news_title_fr" value="<?php echo isset($moduleoptions['news_title_fr']) ? $moduleoptions['news_title_fr'] : ""; ?>" />
</div>

<div style="float:left; margin-left:20px;">
<strong>French News Page Wrapper</strong>

<?php 

$data = array(
	"language" =>"fr",
	'name'        => "news_page_fr",
	'type'          => 'select',
	'showlabels'          => false,
	'id'          => "news_page_fr",
	'width'          => 300,
	'label'          => "",
	'onchange' => "",
	'value'       => (isset($moduleoptions['news_page_fr']) ? $moduleoptions['news_page_fr'] : '')
	
);

echo get_ps_page_slector($data); 

?>
</div>


<div class="clearfix"></div>


<strong>French Newsfeed Description</strong>
<br />
<textarea style="width:650px; height:60px;" id="news_description_fr" name="news_description_fr"><?php echo isset($moduleoptions['news_description_fr']) ? $moduleoptions['news_description_fr'] : ""; ?></textarea>

<div class="clearfix"></div>
<br /><br />

<button type="button" style="float:right" onclick="ps_newsmanager.savesettings()" class="btn btn-success"><i class="icon-white icon-ok"></i> Save</button>
		<div class="clearfix"></div>		
		<br />
	
</form>


</div>


</div>
</div>

