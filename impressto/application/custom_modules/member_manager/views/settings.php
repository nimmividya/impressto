<?php

$this->load->library('asset_loader');

$this->asset_loader->add_header_js(ASSETURL . APPNAME . "/custom_modules/member_manager/css/style.css");

?>

<?=$infobar?>

<h2>member_manager Settings</h2>

<form method="POST">

	<div style="float:left">

	<?php

	$templateselectordata = array(

		'selector_name'=>'template',
		'selector_label'=>'Template',
		'module'=>'member_manager',
		'value'=> $settings['template'],
		'is_widget' => TRUE,
		'widgettype' => 'member_manager',
		
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
