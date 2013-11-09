<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h4>Stickies Report</h4>

<div>
<img src="<?php echo ASSETURL . PROJECTNAME; ?>/default/custom_modules/sticky_notes/img/pdf.png" /> <a href="/sticky_notes/report_to_pdf" target="_blank">Save as PDF</a>
</div>



<table class="stickyreport">
<thead>
<tr>
<th>Page</th>
<th>Notes</th>
<th>Date</th>
<th></th>
</tr>
</thead>
<tbody>

<?php

foreach($report_data AS $row){

?>
	
<tr id="sticky_report_row_<?=$row['id']?>">
<td><a href="<?=$row['page_link']?>" target="_blank"><?=$row['page_title']?></a></td>
<td><?=$row['message']?></td>
<td><?=$row['update_stamp']?></td>
<td><img src="<?php echo ASSETURL . PROJECTNAME; ?>/default/custom_modules/sticky_notes/img/delete.gif" onclick="ps_stickies.delete_report_sticky('<?=$row['id']?>')" /></td>

</tr>

<?php } ?>

</tbody>
</table>