<?php

$this->load->library('asset_loader');

$this->asset_loader->add_header_js(ASSETURL . APPNAME . "/custom_modules/website_estimator/css/style.css");

?>

<?=$infobar?>

<h2>website_estimator Settings</h2>

<form method="POST">

	<div style="float:left">

	<?php

	$templateselectordata = array(

		'selector_name'=>'template',
		'selector_label'=>'Template',
		'module'=>'website_estimator',
		'value'=> $settings['template'],
		'is_widget' => TRUE,
		'widgettype' => 'website_estimator',
		
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
