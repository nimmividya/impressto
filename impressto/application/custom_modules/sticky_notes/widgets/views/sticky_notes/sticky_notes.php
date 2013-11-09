<?PHP /*
@Name: sticky note
@Description: QA tool for managing change requests on individual pages
@Type: PHP
@Author: peter drinnan
@Projectnum: 1001
@Version: 1.0
@Status: development
@Date: 2012/10/18
*/ ?>

<script>

$(function() {

	ps_stickies.current_page_id = '<?=$content_id?>';
	ps_stickies.current_lang = '<?=$lang?>';
	ps_stickies.user_id = '<?=$user_id?>';
});

</script>


<div id="sticky_note_controller">
 <div id="sticky_note_pulldown" style="width:116px;">

 
 	<div id="viewstickyreport_link" onclick="ps_stickies.viewstickyreport();">
		<img src="<?php echo  ASSETURL . PROJECTNAME; ?>/default/custom_modules/sticky_notes/img/report_icon.png" /> View Report</div>
	
	
	<div id="addsticky_link" onclick="ps_stickies.add_sticky();">
		<img src="<?php echo  ASSETURL . PROJECTNAME; ?>/default/custom_modules/sticky_notes/img/plus_icon.png" /> Add Note
	</div>
		
	<div style="clear:both"></div>
	
	<div style="float:left; margin-top: 0px; width:100%; height:40px;" onclick="ps_stickies.toggle_stickies();">
	
		<div class="sticky_note_arrow sna_down"></div>
	
	
	</div>
 
 </div>

 
</div>

<?php echo showpostits($content_id,$lang); ?>
