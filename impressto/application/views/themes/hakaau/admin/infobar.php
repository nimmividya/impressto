<script>  function printhelpdoc(){ $('#infobar_body_content').printElement(); } </script>
		
		
		<br />
		
		<div class="msg_box msg_info infobar_container clearfix">
		
			<a href="javascript:ps_base.showinfobar(true);" title="Show Help Documentation">
			Click here for instructions
		</a>
				
	
		</div>
		
		
<div class="infobar_container clearfix">
	<div class="infobar_head">

	</div><!-- [END] .infobar_head -->
	<div id="infobar" class="msg_box msg_info infobar_body clearfix" style="display: <?php if(isset($_COOKIE['showinfobar'])) echo ($_COOKIE['showinfobar'] == "Y") ? "block" : "none" ?>;">
		<div class="infobar_body_head clearfix">
				
			<a class="infobar_print" href="javascript:printhelpdoc()"><i class="icon-print"></i> Print</a>
		
			<span>&nbsp;</span>
			<a href="javascript:ps_base.showinfobar(false);" class="close_infobar" title="Hide Help Documentation">Hide Help Documentation</a>
		</div><!-- [END] .infobar_body_head --> 
		
		<div id="infobar_body_content">
		<?php  echo $infobar_help_section; ?>
		</div>
		
		<a href="javascript:ps_base.showinfobar(false);" class="close_infobar" title="Hide Help Documentation"><img alt="" class="msg_close" src="/assets/images/blank.gif"></a>
		
		
	</div><!-- [END] .infobar_body -->
</div><!-- [END] .infobar_container -->