<h3>Total Unique Visitors Since <?php echo $sincetag_year; ?>/<?php echo $sincetag_month; ?>/<?php echo $sincetag_day; ?> = <u><?php echo ($total_counts + $unique_today); ?></u></h3>
<br />
<div class="webTraxDiv">
	<?php
		$month_counts += $unique_today;
		echo bar_graph("hBar","$unique_today,$month_counts","Today, $thismonthdisp","#C0D0C0,#80D080","#E0E0E0",1,"");
	?>
</div>