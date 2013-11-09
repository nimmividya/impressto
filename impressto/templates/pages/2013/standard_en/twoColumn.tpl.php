{*
@Name: Two column
@Type: Smarty
@Filename: twoColumn.tpl.php
@Docket: 1001
@Author: peterdrinnan
@Status: complete
@Date: 2012-02
*}


{include file="includes/header.tpl.php"}


{widgetzone name='top'}

<div id="content" class="clearfix">
		
		
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
			
				<div id="contentwrapper">
			
					<div class="main_content {$CO_Url}">
				
					{$CO_Body}
				

					<div style="clear: both;">&nbsp;</div>
					</div>
				</div>
				<!-- end #content -->
				<div id="sidebar">
				
				{widgetzone name='sidebar'}
				
				</div>
				<!-- end #sidebar -->
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
	
	


</div>

{widgetzone name='bottom'}

					