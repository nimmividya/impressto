<?php

$this->load->library('asset_loader');

$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/__skeleton_name__/css/style.css");

?>

<?=$infobar?>

<h2>__skeleton_name__ Settings</h2>

<form method="POST">

	<div style="float:left">

	<?php

	$templateselectordata = array(

		'selector_name'=>'template',
		'selector_label'=>'Template',
		'module'=>'__skeleton_name__',
		'value'=> $settings['template'],
		'is_widget' => TRUE,
		'widgettype' => '__skeleton_name__',
		
	);

	echo $this->template_loader->template_selector($templateselectordata);
	
?>
</div>
		


<div class="clearfix"></div>

<br />


	<div class="clearfix" style="float: right;">
		<input class="btn btn-default" type="submit" value="Save" />
	</div>

</form>
