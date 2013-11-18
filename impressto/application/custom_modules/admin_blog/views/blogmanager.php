<?php
/*
@Name: Blog Manager
@Type: PHP
@Filename: blogmanager.php
@Description: backend admin listing page for all blog items
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

<div class="admin-box" ng-controller="ps_blogmanager.blogCtrl">
<h3>Blog Manager</h3>
<?php 

echo $infobar; 

echo $blogmanager_header;

?>

<?php

$request_uri = getenv("REQUEST_URI");

?>

<div id="crudTabs" style="display: none;">

	<ul>
		<li><a href="<?=$request_uri?>#blog_item_list">Blog Items</a></li>
		<li><a href="<?=$request_uri?>#widgets">Widgets</a></li>
		<li><a href="<?=$request_uri?>#blog_settings">Setting</a></li>
	</ul>
	

	<div id="blog_item_list">
	
	
<h4>Blog Items</h4>

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
	foreach($blogrecords as $blogrecord){ 
	
	
			if($blogrecord['active'] == "1") $active_stateimg = "check";
			else $active_stateimg = "cross";
			
			if($blogrecord['archived'] == "1") $archived_stateimg = "check";
			else $archived_stateimg = "cross";
			
			if( $blogrecord['active'] == "") $blogrecord['active'] = "0";
			if( $blogrecord['archived'] == "") $blogrecord['archived'] = "0";
						
			
			$active_check = "<img id=\"active_toggle_img_{$blogrecord['blog_id']}\" src=\"". ASSETURL . PROJECTNAME . "/default/core/images/actionicons/checkbox_{$active_stateimg}.gif\" />";
			$archived_check = "<img id=\"archived_toggle_img_{$blogrecord['blog_id']}\" src=\"". ASSETURL . PROJECTNAME . "/default/core/images/actionicons/checkbox_{$archived_stateimg}.gif\" />";
						
	?>
	
		<tr style="height: 29px; text-align: center;">
			<td><?=$blogrecord['blog_id']?></td>
			<td style="text-align:left"><?=$blogrecord['blogtitle_en']?></td>
			<td><a id="active_toggle_<?=$blogrecord['blog_id']?>" is_active="<?=$blogrecord['active']?>" href="javascript:ps_blogmanager.toggle_active('<?=$blogrecord['blog_id']?>')"><?=$active_check?></a></td>
			<td><a id="archived_toggle_<?=$blogrecord['blog_id']?>" is_archived="<?=$blogrecord['archived']?>" href="javascript:ps_blogmanager.toggle_archived('<?=$blogrecord['blog_id']?>')"><?=$archived_check?></a></td>

		
			<td><?=$blogrecord['publish_date_en']?></td>
			<td style="width:60px">				
			<a class="btn btn-success-small" href="/admin_blog/edit/<?=$blogrecord['blog_id']?>"><i class="icon-white icon-edit"></i> Edit</a>
			</td>
			<td style="width:80px">				
			<a class="btn btn-danger-small" href="javascript:ps_blogmanager.delete_blog('<?=$blogrecord['blog_id']?>')"><i class=" icon-white icon-trash"></i> Delete</a>
			</td>
		</tr>
	<?php }  ?>
</table>


</div>

<div id="widgets">

<div id="widgetlist_mainbody_div">

<div class="clearfix">

<h3 style="float:left">Widgets</h3>

<button type="button" style="float:right" ng-click="newwidget()" class="btn btn-default"><i class="icon-white icon-star"></i> New Widget</button>

</div>

<br />



<div id="widgets_list">
<?=$widgetlist?>
</div>



</div>

<div style="clear:both"></div>
<div id="widgetnameinput_div" style="display:none">

	<form id="blog_widget_form">
	
		<input type="hidden" name="widget_id" id="widget_id" value="" />
	
	
		<div style="float:left">
		<?php echo $new_widget_name; ?>
		</div>
		
		
		<div style="float:left">
		<?php echo $widget_type_selector; ?>
		</div>
		
		<div id="blogarticle_template_selector_div" style="float:left; display:none">
		<?php echo $blogarticle_template_selector; ?>
		</div>
		<div id="blogarchive_template_selector_div" style="float:left; display:none">
		<?php echo $blogarchive_template_selector; ?>
		</div>
		<div id="blogticker_template_selector_div" style="float:left; display:none">
		<?php echo $blogticker_template_selector; ?>
		</div>
		
		<div style="float:right; margin-top:10px;">
				
		
		<button type="button" style="float:right" onclick="ps_blogmanager.cancelnewidgetedit()" class="btn btn-danger">Cancel</button>

		<button type="button" style="float:right; margin-right:10px;" onclick="ps_blogmanager.savewidget()" class="btn btn-success"><i class="icon-white icon-ok"></i> Save</button>
		
		</div>
		
		<div class="clearfix"></div>		
		<br />
		
		

		
	</form>
	
	
</div>



</div>



<div id="blog_settings">

<form id="blog_settings_form">


<h3>Settings</h3>
<br /><br />



<strong>Listing limit (used for pagination)</strong>
<br />

<?php

$data = array(
              'name'        => 'blog_listlimit',
              'id'          => 'blog_listlimit',
              'value'       => (isset($moduleoptions['blog_listlimit']) ? $moduleoptions['blog_listlimit'] : ""),
              'style'       => 'width:50px',
            );

echo form_input($data);

?>

<div class="clearfix"></div>
<br />

<div style="float:left;">
<strong>English Blog Page Wrapper</strong>
<br />

<?php 

$data = array(
	"language" =>"en",
	'name'        => "admin_blog_page_en",
	'type'          => 'select',
	'showlabels'          => false,
	'id'          => "admin_blog_page_en",
	'width'          => 300,
	'label'          => "",
	'onchange' => "",
	'value'       => (isset($moduleoptions['admin_blog_page_en']) ? $moduleoptions['admin_blog_page_en'] : '')
	
);

echo get_ps_page_slector($data); 

?>
</div>

<div class="clearfix"></div>
<br />

<div style="float:left;">
<strong>English Archived Blog Page</strong>
<br />

<?php 

$data = array(
	"language" =>"en",
	'name'        => "admin_blog_archive_page_en",
	'type'          => 'select',
	'showlabels'          => false,
	'id'          => "admin_blog_archive_page_en",
	'width'          => 300,
	'label'          => "",
	'onchange' => "",
	'value'       => (isset($moduleoptions['admin_blog_archive_page_en']) ? $moduleoptions['admin_blog_archive_page_en'] : '')
	
);

echo get_ps_page_slector($data); 

?>
</div>


<div class="clearfix"></div>
<br />


<div style="float:left">
<strong>French Blog Page</strong>

<?php 

$data = array(
	"language" =>"fr",
	'name'        => "admin_blog_page_fr",
	'type'          => 'select',
	'showlabels'          => false,
	'id'          => "admin_blog_page_fr",
	'width'          => 300,
	'label'          => "",
	'onchange' => "",
	'value'       => (isset($moduleoptions['admin_blog_page_fr']) ? $moduleoptions['admin_blog_page_fr'] : '')
	
);

echo get_ps_page_slector($data); 

?>
</div>


<div class="clearfix"></div>
<br />

<div style="float:left;">
<strong>French Archived Blog Page</strong>

<?php 

$data = array(
	"language" =>"fr",
	'name'        => "admin_blog_archive_page_fr",
	'type'          => 'select',
	'showlabels'          => false,
	'id'          => "admin_blog_archive_page_fr",
	'width'          => 300,
	'label'          => "",
	'onchange' => "",
	'value'       => (isset($moduleoptions['admin_blog_archive_page_fr']) ? $moduleoptions['admin_blog_archive_page_fr'] : '')
	
);

echo get_ps_page_slector($data); 

?>
</div>


<div class="clearfix"></div>
<br /><br />

<button type="button" style="float:right" onclick="ps_blogmanager.savesettings()" class="btn btn-success"><i class="icon-white icon-ok"></i> Save</button>
		<div class="clearfix"></div>		
		<br />
	
</form>


</div>


</div>

</div>


