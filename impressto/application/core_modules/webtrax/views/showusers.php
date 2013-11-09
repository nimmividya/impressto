<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th>Hits</th>
			<th>Views</th>
			<th><abbr title="Identification Number">ID</abbr></th>
			<th>Time</th>
			<th>Browser</th>
			<th><abbr title="Internet Protocol">IP</abbr></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($recordrows as $row){
		
		$search_image_name = $row['search_image_name'];
		$keywords = $row['keywords'];
		$request_device = $row['request_device'];
		$referrer = $row['referrer'];	

		$start_time = $row['start_time'];	
		$end_time = $row['end_time'];	

		$page_hits = $row['page_hits'];	
		$username = $row['username'];	
		$user_ip = $row['user_ip'];	
		$visitor_id = $row['visitor_id']; ?>
			<tr>
				<td>
					<?php echo $page_hits; ?>
				</td>
				<td style="text-align: center;">
				<?php if($visitor_id != ""){ ?>
					<a class="webtrax_user_link" rel="tooltip" data-original-title="<?php echo $username; ?>" href="javascript:ps_webtrax.trackuser('<?php echo $visitor_id; ?>');">
					<img src="<?php echo $asseturl; ?>/track_registered.gif" width="19" height="19" alt="Registered User" />
				<?php }else{ ?>	
					<a rel="tooltip" href="javascript:ps_webtrax.trackuser('<?php echo $user_ip; ?>');">
					<img src="<?php echo $asseturl; ?>/trackuser.gif" width="19" height="19" alt="un-Registered User" />
				<?php } ?></a>
				</td>				
				<td>
					<?php echo $visitor_id; ?> 
				</td>
				<?php if($start_time == ""){ ?>
					<td width="50"><?php $end_time; ?></td>
				<?php }else { ?>
					<td width="100"><?php echo $start_time; ?> to <?php echo $end_time; ?></td>
				<?php } ?>
				<td><?php echo $request_device; ?></td>
				<td><?php echo $user_ip; ?></td>
			</tr>
		<?php } // end foreach loop ?>
	</tbody>
</table>