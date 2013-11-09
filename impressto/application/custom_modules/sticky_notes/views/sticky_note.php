<?php

// globalize variables as workaround to weird extract bug
//global $title, $message, $sticky_id, $left_pos, $top_pos;

if($newsticky){

	$topstyle = "cursor:move; left:" . $left_pos  . "px; top: -200px;";

	
}else{
	$topstyle = "cursor:move; left:" . $left_pos  . "px;top:" . $top_pos . "px;";
}

$imgfolder = ASSETURL . PROJECTNAME . "/default/custom_modules/sticky_notes/img";

	
?>


<div class="sticky_note_holder" id="sticky_<?=$sticky_id?>" save="true" style="<?=$topstyle?>">

<div class="sticky_spinner"></div>



<a class="attachments_link" onclick="ps_stickies.toggle_attachment('<?=$sticky_id?>')"><img border="0" src="<?=$imgfolder?>/attach.png" /> Attachments</a>

<div class="sticky_attachment_div" id="sticky_<?=$sticky_id?>_attachment_div">

<form class="sticky_attachment_form" name="sticky_<?=$sticky_id?>_form" action="" method="POST" enctype="multipart/form-data">	

	<input name="sticky_fileToUpload_<?=$sticky_id?>" id="sticky_fileToUpload_<?=$sticky_id?>" type="file" />
	<button type="button" style="float:left; width:48%" onclick="ps_stickies.upload_attachment('<?=$sticky_id?>');"><img src="<?=$imgfolder?>/upload.png" /> Upload</button>
	<button type="button" style="float:left; width:48%" onclick="ps_stickies.cancel_attachment('<?=$sticky_id?>');"><img src="<?=$imgfolder?>/minus_icon.png" /> Cancel</button>
	<div style="clear:both"></div>

</form>

<ul id="sticky_<?=$sticky_id?>_attachment_list" class="sticky_attachment_list">

<?php 

foreach($sticky_attachments AS $file){  

	if($file != "index.html") echo "<li id=\"{$sticky_id}_file\" data-fname=\"{$file}\"><a target=\"_blank\" href=\"{$sticky_folder_url}/{$file}\">{$file}</a>&nbsp;<a href=\"javascript:ps_stickies.deletefile('{$sticky_id}','{$file}');\">&nbsp;&nbsp;<img border=\"0\" src=\"{$imgfolder}/delete.png\" /></a></li>";
	
}

?>

</ul>
	
		
</div>


<div id="stickynote_<?=$sticky_id?>_message_div">
 
<form id="stickynote_<?=$sticky_id?>_form" style="margin:0;padding:0">

<input type="hidden" name="sticky_id" value="<?=$sticky_id?>" />		

Priority <select name="sticky_priority">
<?php

$priorities = array("Highest"=>1,"High"=>2,"Medium"=>3,"Low"=>4,"Lowest"=>5);

foreach($priorities AS $priokey => $prioval){

	echo "<option value=\"{$prioval}\" ";
	
	if($prioval == $priority) echo " selected=\"selected\" ";
	
	echo ">{$priokey}</option>\n";
	

}

?>
</select>

<br />


<textarea class="sticky_note_message" id="sticky_note_<?=$sticky_id?>" name="sticky_note"><?=$message?></textarea>


</form>
</div>


<div class="sticky_action_buttons">
<button type="button" onclick="ps_stickies.save_note('<?=$sticky_id?>')"><img src="<?=$imgfolder?>/save_icon.png" />&nbsp;Post it&nbsp;&nbsp;</button>
<button type="button" onclick="ps_stickies.delete_note('<?=$sticky_id?>')"><img src="<?=$imgfolder?>/minus_icon.png" />&nbsp;Delete&nbsp;&nbsp;</button>
</div>


</div>

			


