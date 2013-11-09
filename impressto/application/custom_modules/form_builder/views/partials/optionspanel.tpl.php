
<!-- BEGIN FIELDOPTIONSPANELHEAD -->

<div style="padding:3px; border: 1px solid #888888; background-color:#FFFFFF;">


	<div style="width:428px; height:18px; background-color:#DDDDDD; color:#333333; font-weight:bold; padding:2px;">
	
		<span style="float:left">Options</span>
	
		<div style="float:right">
			<img src="{$core_asset_url}/images/actionicons/add.gif" alt="Add" title="Add" onclick="ps_formbuilder_manager.add_option('{$element_id}')">
	</div>
	
	</div>
	<div class="spacer"><img src="{$pfvars[asset_url]}img/empty.gif" style="width:150px; height:2px;"></div>
	<div style="width:182px; float:left; margin-left:22px;"><b>Value</b></div>
	<div style="float:left"><b>Label</b></div>


	<div class="spacer"><img src="{$core_asset_url}/images/empty.gif" style="width:150px; height:2px;"></div>


	


<!-- END FIELDOPTIONSPANELHEAD -->


<!-- BEGIN FIELDOPTIONSPANEL -->

		<ul id="sortable_options_list" style="cursor: move; list-style-type:none; margin:0px; padding:0px;">
		
		{$fieldoptionitems}
		
		</ul>
		
		<div class="clearfix"></div>

<!-- END FIELDOPTIONSPANEL -->

<!-- BEGIN FIELDOPTIONSPANELFOOT -->





</div>

<!-- END FIELDOPTIONSPANELFOOT -->



<!-- BEGIN FIELDOPTIONSITEM -->

<li id="optionitem_{$option_id}" option_id="{$option_id}">

<input name="option_ids[]" id="option_id_{$i}" value="{$option_id}" type="hidden">

<div style="width:416px; background-color: #ffe;">
<div class="optiondrag">&nbsp;</div>
<div style="display:inline"><input name="option_values[]" id="option_value_{$i}" style="width:154px" maxlength="250" autocomplete="off" value="{$option_value}" type="text"></div>
<div style="margin-left:10px; display:inline"><input name="option_labels[]" id="option_label_{$i}" style="width:154px" maxlength="250" autocomplete="off" value="{$option_label}" type="text"></div>

<div onclick="ps_formbuilder_manager.set_default_option('{$i}')" id="option_default_icon_{$i}" class="defaultstar{$defaultstaractiveflag}">&nbsp;</div>
<div onclick="ps_formbuilder_manager.delete_option('{$option_id}')" class="deleteoption_icon">&nbsp;</div>


</li>

<!-- END FIELDOPTIONSITEM -->
