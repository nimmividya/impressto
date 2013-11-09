<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th width="100">Page Request</th>
			<th>Time</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($recrows as $recrow){
			$hit_hour = $recrow['hit_hour'];
			$hit_minute = $recrow['hit_minute'];
			$exdom_name = $recrow['exdom_name'];
			$searchicon = $recrow['searchicon'];
			$referrer = $recrow['referrer'];
			$url = $recrow['url'];
			$hit_minute = $recrow['hit_minute'];
			$hit_hour = $recrow['hit_hour'];
		?>
		<tr>
			<td style="width:400px"><a style="color: #000000;" href="<?php echo urldecode($url); ?>" target="_blank"><?php echo urldecode($url); ?></a></td>
			<td align="center" style="text-align: center;"><?php echo "{$hit_hour}:{$hit_minute}"; ?></td>
		</tr>
		<?php } ?>	
	</tbody>
</table>