<?php

$this->load->library('asset_loader');

//$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/social_following/js/image_slider_manager.js");
$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/custom_modules/social_following/css/style.css");

?>

<?=$infobar?>

<h2>Social Bookmark Settings</h2>

<form method="POST">

	<div style="float:left">

	<?php

	$templateselectordata = array(

		'selector_name'=>'template',
		'selector_label'=>'Template',
		'module'=>'social_following',
		'value'=> $settings['template'],
		'is_widget' => TRUE,
		'widgettype' => 'social_following',
		
	);

	echo $this->template_loader->template_selector($templateselectordata);
	
?>
</div>
		
<div style="float:left; margin-left:20px;">

<?php

	$fielddata = array(
		'name'        => "pub_id",
		'type'          => 'text',
		'id'          => "pub_id",
		'width'          => "200",
		'label'          => "AddToAny key",
		'usewrapper'          => TRUE,				
		'orientation' => "vertical",
		'value'       =>  (isset($settings['pub_id']) ? $settings['pub_id'] : "")
	);

	echo $this->formelement->generate($fielddata);
	
?>
</div>


<div class="clearfix"></div>

<br />

<strong>Button layout</strong>

		
<?php

		

	$options = array(
		"Small Horizontal Follow"=>"small-horizontal",
		"Large Horizontal Follow"=>"large-horizontal",
		"Small Vertical Follow"=>"small-vertical",
		"Large Vertical Follow"=>"large-vertical",
		"Horizontal Sharing"=>"horizontal-sharing",
		"Vertical Sharing"=>"vertical-sharing",
	);

	$fielddata = array(
		'name'        => "button_layout",
		'type'          => 'radio',
		'id'          => "button_layout",
		'width'          => 4,
		'usewrapper'          => false,
		'orientation' => "horizontal",
		'options' =>  $options,
		'value'       =>  (isset($settings['button_layout']) ? $settings['button_layout'] : "")
	);

	echo $this->formelement->generate($fielddata);
	
	
	


	?>

	<div class="clearfix" style="width:400px">
		<?php foreach($uids as $key => $val){  ?>
		
			<div class="clearfix">
				<div style="float:left; margin-top: 5px;">
					<label class="at15t at15t_<?=$key?>" for="follow-<?=$key?>"><?=$uid_names[$key]?></label>
				</div>
				<div style="float:right;">
					<?=$uid_links[$key]?> 
					<input type="text" value="<?=$val?>" size="15" name="uid[<?=$key?>]" id="follow-<?=$key?>">
				</div>
			</div>				
		<?php } ?>
	</div>

	<br />
	<br />

	<div class="clearfix" style="float: right;">
		<input class="btn btn-default" type="submit" value="Save" />
	</div>

</form>
