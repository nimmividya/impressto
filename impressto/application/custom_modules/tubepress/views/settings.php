

<?=$infobar?>
	

	

	
<h2>Video Player Widgets</h2>
		
<div class="clearfix"></div>

<button id="new_widget_button" type="button" style="float:right" onclick="ps_tubepressmanager.newwidget()" class="btn btn-default"><i class="icon-white icon-star"></i> New Widget</button>

	
<div id="tubepress_widgets_tab" style="clear: both">
		
	<div id="widgetlist_mainbody_div">

		<div class="clearfix"></div>
	
		<br />

		<div id="widgets_list"><?=$widgetlist?></div>

	</div>


	<div style="clear:both"></div>

	<div id="widgetnameinput_div" style="display:none">

		<form id="tubepress_widget_form">
	
		<input type="hidden" name="widget_id" id="widget_id" value="" />
	
			
		<div style="float:right; margin-top:10px;">
				
		<button type="button" style="float:right" onclick="ps_tubepressmanager.cancelnewidgetedit()" class="btn btn-danger">Cancel</button>

		<button type="button" style="float:right; margin-right:10px;" onclick="ps_tubepressmanager.savewidget()" class="btn btn-success"><i class="icon-white icon-ok"></i> Save</button>
		
		</div>
		
		<div class="clearfix"></div>	

		<div style="float:left; margin-left:0px"><?=$new_widget_name?></div>
		<div style="float:left; margin-left:10px""><?=$template_selector?></div>
		<div style="float:left;  margin-left:10px"><?=$theme_selector?></div>
		
		<br />
		<br />
		<br />
		<br />
	
		<div id="widget_settings_div"></div>
	
	</form>
	
	</div>

</div>
