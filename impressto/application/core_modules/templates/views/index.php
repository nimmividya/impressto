
<div id="overview"></div>

<div class="admin-box">

<h3><i class="icon-lemon"></i> Template Editor</h3>
<?php echo $infobar; ?>


<div class="alert" id="versioncontrol_alert">

<img style="float:left; margin-right:10px;" src="<?php echo ASSETURL; ?>/<?php echo PROJECTNAME; ?>/default/core/images/old_coder.png" />


<i style="font-size:20px; color:#666666" class="icon-warning-sign"></i> IMPORTANT NOTE FOR DEVELOPERS

<br />
<br />


	
If this site is under version control and you are not currently working on your development server, any changes made here that 
are not copied back to the developement server will likely be lost on the next commit. 


<div style="clear:both"></div>

</div>



<!-- <div style="float:left">
	<?php
		// TODO: peter drinnan turned this pff temporarily while looking for a time machine.
		//echo $template_type_selector;
	?>
</div> -->

<div style="float:right; margin-top:10px;"><?php echo $widget_type_selector; ?></div>

<div class="footNav clearfix smarty_add_button" style="display:none">
	<ul>
		<li>
			<button class="btn btn-default" type="button" id="smarty_add_button" onclick="ps_templatemanager.shownewsmartybox()">New Smarty Template</button>
		</li>
	</ul>
</div>

<div class="clearfix"></div>

<div id="template_filters_div">

<?php
 
$this->load->library('formelement');

?>

<fieldset style="padding: 10px; font-weight:bold; font-size:14px;">
<legend>Filters</legend>
<div style="float:left;">

<?php
		
$selected_lang = "";
 
$languages = $this->config->item('languages');
 
$lang_options = array("Select"=>"Select"); 
 
 
 foreach($languages AS $key => $val){
	$lang_options[$val] = $val;
}

$fielddata = array(
	'name'        => "lang_filter",
	'type'          => 'select',
	'id'          => "lang_filter",
	'label'          => "Language",
	'onchange' => "ps_templatemanager.apply_filter()",
	'options' =>  $lang_options,
	'value'       => $selected_lang,
	'orientation' => 'vertical',
	'width' => '100px'
);
				
echo $this->formelement->generate($fielddata);
		
?>
</div>

<div style="float:left; margin-left:20px;">

<?php

$this->load->library('module_utils');
	
$module_options = array();

$selected_module = "page_manager";

$modules = $this->module_utils->get_modules();


$default_array['Select'] = "";
$default_array['Adhoc'] = "";
	
$foundmodules = array();
	
foreach($modules as $mod_dirname => $moddata){
	
	$foundmodules[$moddata['name']] = $mod_dirname;
					
}
	
ksort($foundmodules);
	
	//array_
$module_options = array_merge($default_array, $foundmodules);
	
	
//print_r($module_options);	
		
$fielddata = array(
	'name'        => "module_filter",
	'type'          => 'select',
	'id'          => "module_filter",
	'label'          => "Module",
	'onchange' => "ps_templatemanager.change_module()",
	'options' =>  $module_options,
	'value'       => $selected_module
);
				
echo $this->formelement->generate($fielddata);

?>

</div>

<div style="float:left; margin-left:20px;">

<?php

$this->load->library("widget_utils");


$widget_options = array("Select"=>"");
if($selected_module == ""){

	// load adhoc widgets
	$widget_list = $this->widget_utils->get_widgets();
	

}else{

	// load the widgets for this specific module
	$widget_list = $this->widget_utils->get_widgets($selected_module);
	
}

if(is_array($widget_list)){

	foreach($widget_list AS $widget){
	
		$widget_options[$widget['desc_name']] = $widget['name'];
	
	
	}

}
	
	
$fielddata = array(
	'name'        => "widget_filter",
	'type'          => 'select',
	'id'          => "widget_filter",
	'label'          => "Widget",
	'onchange' => "ps_templatemanager.apply_filter()",
	'options' =>  $widget_options,
	'value'       => $selected_lang
);
				
echo $this->formelement->generate($fielddata);

?>

</div>


<div style="float:left; margin-left:20px;">

<?php
		
$selected_device = "standard";

$fielddata = array(
	'name'        => "device_filter",
	'type'          => 'select',
	'id'          => "device_filter",
	'label'          => "Device",
	'onchange' => "ps_templatemanager.apply_filter()",
	'options' =>  array("Standard"=>"standard","Mobile"=>"mobile"),
	'value'       => $selected_device,
	'width' => '100px',
);
				
echo $this->formelement->generate($fielddata);

?>



<?php


 $template_cast = "module";
 $template_cast = "widget";
 
 
 $modules = get_modules();
 
 // language selector
 //
 
 //GO BUTTON - redraws the "template_list_div"
 
 
?>

</fieldset>

</div>



<div style="clear:both"></div>


<div id="template_list_div" style="display:none">

</div>


<div id="smartybox" style="display:none">

<form id="template_form">

<div class="alert alert-info">
 


	NOTE: Use this module as a sandbox only. If significant changes are made to a template, they should be added to the SVN repository or there is a risk the
	work done here will be completely lost when pushing to production. 
	
</div>

	  
	<input type="hidden" name="template_lang" id="template_lang" />
	<input type="hidden" name="template_filepath" id="template_filepath" />

	<div style="float:left">
		
	<table class="template_edit_table">
		<tr>
			<td>
				<label for="template_filename">Filename:</label>
				<input style="width:140px;" type="text" name="template_filename" id="template_filename" />
			</td>
			<td>
				<label for="template_type">Type:</label>
				<input style="width:80px;" type="text" name="template_type" id="template_type" readonly />
			</td>
			<td>
				<label for="template_name">Name:</label> 
				<input style="width:100px;" type="text" name="template_name" id="template_name" />
			</td>
			<td>
				<label for="template_author">Author:</label>
				<input style="width:100px;" type="text" name="template_author" id="template_author" />
			</td>
			
			<td>
				<label for="template_docket">Docket:</label>
				<input style="width:60px;" type="text" name="template_docket" id="template_docket" />
			</td>
			
		</tr>
		<tr>

			<td>
				<label for="template_status">Status:</label>
				<input style="width:100px;" type="text" name="template_status" id="template_status" />
			</td>
			<td>
				<label for="template_date">Date:</label>
				<input style="width:80px;" type="text" name="template_date" id="template_date" />
			</td>
			
			<td colspan="3"><label for="template_description">Description:</label> <textarea id="template_description" name="template_description" style="width:300px; height:60px"></textarea></td>
		</tr>
	</table>
	</div>
	
	<div style="float:right; width:280px; margin-top:24px;">
	
		<button class="btn btn-default" type="button" id="smarty_save_button" onclick="ps_templatemanager.quicksavetemplate()"><i class="icon-check"></i> Quick save</button>
		<button class="btn btn-default" type="button" id="smarty_save_button" onclick="ps_templatemanager.savetemplate()"><i class="icon-ok"></i> Save</button>
		<button class="btn" type="button" id="smarty_save_button" onclick="ps_templatemanager.canceledit()">Close</button>

	
	</div>

	<br />
	
	<div style="clear:both"></div>
	
	

	<textarea id="template_standard_content" name="template_standard_content" style="width:95%; height:300px"></textarea>
		
	</form>
</div>

</div>
