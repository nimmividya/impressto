<script>  function printhelpdoc(){ $('#infobar_body_content').printElement(); } </script>
		
<div class="infobar_container clearfix">
	<div class="infobar_head">
		<a href="javascript:ps_base.showinfobar(true);" title="Show Help Documentation">
			<i>Information Bubble</i>
			Click the info icon for instructions
		</a>
	</div><!-- [END] .infobar_head -->
	<div id="infobar" class="infobar_body clearfix" style="display: <?php if(isset($_COOKIE['showinfobar'])) echo ($_COOKIE['showinfobar'] == "Y") ? "block" : "none" ?>;">
		<div class="infobar_body_head clearfix">
				
			<a class="infobar_print" href="javascript:printhelpdoc()"><i class="icon-print"></i> Print</a>
		
			<span>&nbsp;</span>
			<a href="javascript:ps_base.showinfobar(false);" class="close_infobar" title="Hide Help Documentation">Hide Help Documentation</a>
		</div><!-- [END] .infobar_body_head --> 
		
		<div id="infobar_body_content">
		<?php  echo $infobar_help_section; ?>
		</div>
	</div><!-- [END] .infobar_body -->
</div><!-- [END] .infobar_container -->