
<a href="javascript:pscontentedit.reset_draft();">
	<img class="action_icon" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/actionicons/undo.gif" alt="Reset the draft copy">
	<span style="font-weight:bold; font-size:12px;color: #000000;">Reset the draft copy</span>
</a>
<hr />

<span style="font-weight:bold; font-size:12px">Archives</span>
<hr />

<table id="archive_list_table" style="padding:5px; text-align:left;">

	<tr>
		<th>Date</th>
		<th>Preview</th>
		<th>Restore</th>
	</tr>

	<tr>
		<?php
			foreach($archivelist as $key=>$val){


				$archive_id = str_replace("id_","",$key);
				
				echo "<tr id=\"archiverow_{$archive_id}\">\n";
				
				echo "<td valign=\"top\" style=\"padding:4px;\">{$val['date']}</td>\n";	
				echo "<td valign=\"top\" align=\"center\" style=\"padding:4px;\"><a href=\"javascript:pscontentedit.preview_archive('{$archive_id}');\"><img class=\"action_icon\" src=\"". ASSETURL . PROJECTNAME . "/default/core/images/actionicons/preview.gif\" alt=\"Preview\"></a></td>\n";
				echo "<td valign=\"top\" align=\"center\" style=\"padding:4px;\"><a href=\"javascript:pscontentedit.restore_archive('{$archive_id}');\"><img class=\"action_icon\" src=\"". ASSETURL . PROJECTNAME . "/default/core/images/actionicons/restore.gif\" alt=\"Restore\"></a></td>\n";

				echo "</tr>\n";
				

			}
		?>
	</tr>
</table>


