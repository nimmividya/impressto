{*
@Name: Default
@Type: Smarty
@Filename: default.tpl.php
@Projectnum: 101
@Author: peterdrinnan
@Status: complete
@Date: 2013-05
*}



{widgetzone name='top'}

<div id="content" class="clearfix">
	
		
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
			
				<div id="contentwrapper">
				
					<h1>{$page_title}</h1>
								
					<div class="toolbar clearfix"><span class="muted">{$CO_WhenModified}</span></div>
					
		
					<div class="main_content {$CO_Url}">
				
					{$CO_Body}
				

					<div style="clear: both;">&nbsp;</div>
					</div>
				</div>
	
				<!-- end #sidebar -->
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
	
	


</div>

{widgetzone name='bottom'}

					