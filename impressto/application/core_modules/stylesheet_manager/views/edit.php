<!-- scripts -->
<script language="javascript" src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/markitup/sets/default/set.js"></script>

<!-- stylsheets -->
<link rel="stylesheet" type="text/css" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/markitup/skins/markitup/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ASSETURL . PROJECTNAME; ?>/default/third_party/markitup/sets/default/style.css" />

<!-- All the Javascripts that are beign called Dynamicly -->
<?php echo $headerjs; ?>

<script type="text/javascript">
	$(document).ready(function() {
		$("#template_content").markItUp(mySettings);
	});
</script>


<form action="validate.php" method="post" id="edit_template_form">
	<table cellpadding="3" cellspacing="0" style="">
		<tr>
			<td>
				<label>Filename:&nbsp;<br />
					<input name="filename" type="text" style="width:300px;" maxlength="20" value="<?php echo $filename; ?>" />
				</label>
			</td>
			<td>
				<label>Label:&nbsp;<br />
					<input name="label" type="text" style="width:300px;" maxlength="20" value="<?php echo $label; ?>" />
				</label>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				Contents:&nbsp;<br />
				<textarea name="template_content" id="template_content"><?php echo $contents; ?></textarea>
			</td>
		</tr>
	</table>
	
	<div class="footNav editTemplate">
		<input type="hidden" name="id" value="<?php echo $tp_id; ?>"/>
		<input type="hidden" name="old_filename" value="<?php echo $filename; ?>"/>
		<ul>
			<li><a class="btn btn-default" href="javascript:impressto.save();">Save</a></li>
			<li><a class="btn btn-default" href="/admin/templates/">Cancel</a></li>
		</ul>
	</div>	
</form>
