<?php
/*
@Name: Default
@Type: IMPRESSTO
@Filename: form_builder.tpl.php
@Lang: 
@Description: This is a very basic contact form for nerds like me.
@Author: Perter Drinnan
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/09/04
@fulltemplatepath: //pshaper/application/custom_modules/form_builder/widgets/views/standard/form_builder/form_builder.tpl.php
*/
?>

<!-- BEGIN MAINFORM -->
<?php$CI = & get_instance();$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/custom_modules/form_builder/js/form_builder" . $file_version_tag . ".js"); $CI->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/custom_modules/form_builder/css/style" . $file_version_tag . ".css"); 

$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/vendor/bvalidator/jquery.bvalidator.js"); 
$CI->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/vendor/bvalidator/bvalidator.css"); 


if (isset($settings['form_javascript']) && $settings['form_javascript'] != ""){

	$CI->asset_loader->add_header_js_string($settings['form_javascript']); 

}


$CI->load->library('formelement');
		$num1 = rand(1,10); $num2 = rand(1,10); $total = $num1 + $num2;$submitted = false;?><div id="form_builder_wrapper">
<form id="form_builder" name="form_builder" enctype="multipart/form-data" method="POST"><input type="hidden" id="form_id" name="form_id" value="<?=$form_id?>" />



<?=$content?>




</form>

</div><div id="successful_message_form" style="display:none;padding-top:4px;" class="success cornered"></div><div class="clearfix"></div><br /><br /><?php if(isset($settings['mapcode']) && $settings['mapcode'] != ""){ ?><?=$settings['mapcode']?><?php } ?>


<!-- END MAINFORM -->


<!-- BEGIN FORM_FIELDS -->


<?php

$CI = & get_instance();

$CI->load->library('formelement');


	foreach($fields AS $row){ 

		$errorlabel = '<label id="label_'.$row['field_id'].'" class="errorbox cornered" style="display:none;">You have not completed \''.$row['field_name'].'\'</label>';

?>


	<div style="padding:5px">
	
	<?php
	
	if($row['paragraph'] != "") echo "<p>" . $row['paragraph'] . "</p>";
			
	
	$CI->formelement->init();


	
	$fielddata = array(
		'name'        => $row['field_name'],
		'type'        => $row['ftype'],
		'id'          => $row['field_name'],
		'required'    => $row['required'],
		'label'       => $row['field_label'],
		'options'     => $row['options'],
		'value'       => $row['default_value'],
		'orientation' => $row['orientation'],
		'width'       => $row['width'],
		'height'      => $row['height'],
		'onchange'    => $row['onchange'],
	
		
	);

	if($row['showlabel'] == 1) $fielddata['showlabels'] = TRUE;
	else $fielddata['showlabels'] = FALSE;
	
	//print_r($fielddata);
	
	
	echo $CI->formelement->generate($fielddata);
	
	?>	
		
	</div><div><?php echo $errorlabel; ?></div>
	
	<div class="clearfix"></div>
	
	
		
<?php

}

?>


<!-- END FORM_FIELDS -->



<!-- BEGIN SUBMIT_BUTTON -->

<div id="error_form" class="error" style="display:none;">Please complete all the fields.</div>
<div id="error_msg" class="error" style="display:none;"></div>


<div id="captcha_wrapper_div">
<?php

if ($settings['captcha'] == "visualcaptcha" && isset($settings['captcha_theme'])){

	echo Widget::run('visualcaptcha', array("form_name"=>"form_builder","field_name"=>"visualcaptcha","submit_button"=>"form_builder_button","theme"=>$settings['captcha_theme']));
	
}else if($settings['captcha'] == "captcha"){
	
	echo Widget::run('captcha');
	
}
	
?>
</div>



<?php if ($settings['captcha'] == "visualcaptcha"){ ?>

<button disabled="disabled" style="display:block" id="form_builder_button" type="button" onclick="ps_form_builder.submit()" class="btn"><?=$settings['button_value']?></button>

<?php }else{ ?>

<button style="display:block" id="form_builder_button" type="button" onclick="ps_form_builder.submit()" class="btn"><?=$settings['button_value']?></button>

<?php } ?>


<div class="clearfix"></div>

<!-- END SUBMIT_BUTTON -->
