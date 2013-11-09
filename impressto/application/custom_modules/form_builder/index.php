<?php
// Main Index Page
include_once('config.php');
mysql_query('SET NAMES utf8');
mysql_query('SET CHARACTER_SET utf8');
$check_table = mysql_query("SELECT * FROM flexible_settings");
if ($check_table){
}else{
header('Location: ./install/');
die();
}
$num1 = rand(1,10); $num2 = rand(1,10); $total = $num1 + $num2;$submitted = false;
$get_info = mysql_query("SELECT * FROM flexible_settings WHERE id='1'");
$row_info = mysql_fetch_array($get_info);
$fields = mysql_query("SELECT * FROM flexible WHERE flexible_enabled = 1 ORDER BY flexible_order ASC");
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $row_info["page_title"];?></title>
		<link type="text/css" href="style/all.css" rel="stylesheet" media="all" />
		<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/blitzer/jquery-ui.css" rel="stylesheet" media="all" />
		<style media="screen" type="text/css">
			.defaultText {  }
			.defaultTextActive { color: #a1a1a1; font-style: italic ; }
		</style>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>

		<?php
		$q = mysql_query("SELECT * FROM flexible WHERE flexible_enabled='1' AND flexible_type='file'");
		$s = mysql_query("SELECT * FROM flexible WHERE flexible_enabled='1' AND flexible_type='slider'");
		if (mysql_num_rows($q) != 0){
		?>
		<link href="js/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="js/uploadify/swfobject.js"></script>
		<script type="text/javascript" src="js/uploadify/jquery.uploadify.v2.1.4.js"/></script>
		<?php
		}
		?>
	</head>	
	<script>
	  $(function() {
		$(".defaultText").focus(function(srcc){
			if ($(this).val() == $(this)[0].title){
				$(this).removeClass("defaultTextActive");
				$(this).val("");
			}
		});

		$(".defaultText").blur(function(){
			if ($(this).val() == ""){
				$(this).addClass("defaultTextActive");
				$(this).val($(this)[0].title);
			}
		});
		$(".defaultText").each(function(){
			$(this).addClass("defaultTextActive");
			$(this).val(jQuery(this)[0].title);
		}); 
		$(".defaultText").blur();
		$(".file_path").val("blank");
	  <?php
	  if (mysql_num_rows($q) != 0){
		while($filesquery = mysql_fetch_array($q)){
		?>
		  $('#contact_file<?php echo $filesquery['flexible_alias'] ?>').uploadify({
			'uploader'  : 'js/uploadify/uploadify.swf',
			'script'    : 'js/uploadify/uploadify.php',
			'cancelImg' : 'js/uploadify/cancel.png',
			'folder'    : 'uploads/',
			'auto'		:  true,
			'width'		:	'120',
			'height'	:	'30',
			'removeCompleted'	:  false,
			'multi'		: false,
			'onComplete': function(a,b,c,d,e){
				$('#file_path<?php echo $filesquery['flexible_alias'] ?>').val(d);
			},
			'onCancel' : function(){
				$("#file_path<?php echo $filesquery['flexible_alias'] ?>").val("blank");
			},
			<?php 
			$o = mysql_fetch_array(mysql_query("SELECT * FROM flexible_file_settings WHERE flexible_id='".$filesquery['flexible_alias']."' ")); 
			if ($o['flexible_file_ext'] != ""){ ?>
			'fileExt'	: '<?php echo $o['flexible_file_ext']; ?>',
			'fileDesc'    : '<?php echo $o['flexible_file_ext']; ?>',
			<?php }
			if ($o['flexible_file_size'] != ""){ ?>
			'sizeLimit'	: '<?php echo $o['flexible_file_size']; ?>',
			<?php }
			?>
			'onQueueFull': function (event,queueSizeLimit) {
				alert(queueSizeLimit);
				return false;
			}
			});
		<?php	
		}
		}
	if (mysql_num_rows($s) != 0){
		while($sliderquery = mysql_fetch_array($s)){ ?>
			$("#contact_<?php echo $sliderquery['flexible_alias'] ?>").slider({
		<?php	$so = mysql_fetch_array(mysql_query("SELECT * FROM flexible_slider_settings WHERE flexible_id='".$sliderquery['flexible_alias']."' ")); ?>
				min: <?php echo $so["slider_min"]; ?>,
				max: <?php echo $so["slider_max"]; ?>,
				step: <?php echo $so["slider_step"]; ?>,
				<?php if( $so["slider_range"] == 1){ ?>
				range: true,
				values: [<?php echo $so["slider_value_min"]; ?> , <?php echo $so["slider_value_max"]; ?>],
				slide: function( event, ui ) {
				<?php if ( $so["slider_display"] ){ ?>
					$( "#slider_display_amount_<?php echo $sliderquery['flexible_alias']; ?>" ).html( "<?php echo $so["slider_prefix"]; ?>" + ui.values[ 0 ] + " - <?php echo $so["slider_prefix"]; ?>" + ui.values[ 1 ] );
				<?php } ?>
				$("#slider_amount_<?php echo $sliderquery['flexible_alias']; ?>").val( "<?php echo $so["slider_prefix"]; ?>" + ui.values[ 0 ] + " - <?php echo $so["slider_prefix"]; ?>" + ui.values[ 1 ] );
				}
				
				<?php }else{ ?>
				value: <?php echo $so["slider_value"]; ?>,
				slide: function( event, ui ) {
				console.log( ui.value) ;
					<?php if ( $so["slider_display"] ){ ?>
						$("#slider_display_amount_<?php echo $sliderquery['flexible_alias']; ?>").html( "<?php echo $so["slider_prefix"]; ?>" + ui.value );
					<?php } ?>
					$("#slider_amount_<?php echo $sliderquery['flexible_alias']; ?>").val( "<?php echo $so["slider_prefix"]; ?>" + ui.value );
				}
				<?php } ?>
			});
	<?php } } ?>
	$(".date").datepicker({ dateFormat: 'dd/mm/yy',
							onSelect: function(){
								$(this).removeClass("defaultTextActive");
							}
	});
	
    $(".error").hide();
	$('.errorbox').hide();
    $(".button").click(function() {
		$('.errorbox').fadeOut();
		error = false;
	  <?php
	  $reqfields = mysql_query("SELECT flexible_req,flexible_alias,flexible_type,flexible_enabled FROM flexible WHERE flexible_req = 1 AND flexible_enabled='1'");
		while($reqrow = mysql_fetch_array($reqfields)){
		switch ($reqrow['flexible_type']){	
		case "email" :
		?>
		var email_<?php echo 'input'.$reqrow['flexible_alias'] ?> = $("#<?php echo 'contact_'.$reqrow['flexible_alias']; ?>");
		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		if (filter.test(email_<?php echo 'input'.$reqrow['flexible_alias'] ?>.val()) != true || (email_<?php echo 'input'.$reqrow['flexible_alias'] ?>.hasClass("defaultTextActive")) ){
		$("label#label_<?php echo $reqrow['flexible_alias'] ?>").fadeIn(600).css('display', 'inline-table');
		$("#contact_<?php echo $reqrow['flexible_alias'] ?>").focus();
		error = true;
		}
		<?php
		break;
		case "checkbox":
		case "radio":
		?>
		var <?php echo 'input'.$reqrow['flexible_alias'] ?> = $("#<?php echo 'contact_'.$reqrow['flexible_alias'] ?>:checked").val();
  		if (!<?php echo 'input'.$reqrow['flexible_alias']?>) {
        $("label#label_<?php echo $reqrow['flexible_alias'] ?>").fadeIn(600).css('display', 'inline-table');
        $("#contact_<?php echo $reqrow['flexible_alias'] ?>").focus();
		error = true;
		}		
		<?php
		break;
		case "date":?>
			var <?php echo 'input'.$reqrow['flexible_alias'] ?> = $("#<?php echo 'contact_'.$reqrow['flexible_alias'] ?>");
			if (<?php echo 'input'.$reqrow['flexible_alias']?>.val() == "" || <?php echo 'input'.$reqrow['flexible_alias']?>.hasClass("defaultTextActive")) {
				$("label#label_<?php echo $reqrow['flexible_alias'] ?>").fadeIn(600).css('display', 'inline-table');
				error = true;
			}
<?php	break;
		case "file": ?>
			var <?php echo 'input'.$reqrow['flexible_alias'] ?> = $("#<?php echo 'file_path'.$reqrow['flexible_alias'] ?>").val();
			if (<?php echo 'input'.$reqrow['flexible_alias']?> == "blank") {
				$("label#label_<?php echo $reqrow['flexible_alias'] ?>").fadeIn(600).css('display', 'inline-table');
				error = true;
			}
<?php	break;
		case "slider":
		break;
		default: ?>
		var <?php echo 'input'.$reqrow['flexible_alias'] ?> = $("#<?php echo 'contact_'.$reqrow['flexible_alias'] ?>");
  		if (<?php echo 'input'.$reqrow['flexible_alias']?>.val() == "" || <?php echo 'input'.$reqrow['flexible_alias']?>.hasClass("defaultTextActive") ) {
        $("label#label_<?php echo $reqrow['flexible_alias'] ?>").fadeIn(600).css('display', 'inline-table');
        $("#contact_<?php echo $reqrow['flexible_alias'] ?>").focus();
		error = true;
		}
		<?php
		}}
		if ($row_info['captcha'] == 1){
		?>
		if (!(<?php echo $total?> == $("#validation_answer").val())){
        $("label#label_auth").fadeIn(600).css('display', 'inline-table');
		error = true;
		}
		<?php } ?>
		if (error == false){
		var form_data =  $('#form_builder').serializeArray();
			$.ajax({
		   type: "POST",
		   url: "mail.php",
		   data: form_data,
		   success: function(msg){
		   <?php if ($submitted == true){
			$num1 = rand(1,10); $num2 = rand(1,10); $total = $num1 + $num2;$submitted = false;
		   } ?>
			$('#successful_message_form').slideDown().css('display', 'inline-table');
		   }
		 });
		}
    });
  });
  
	</script>
	<body>
	<div id="wrapper">
			
			<div id="header"><h1><?php echo $row_info['page_title'];?></h1></div>
			<div class="cornered" id="content">
			<form id="form_builder" enctype="multipart/form-data" method="POST">
			<h1><?php echo $row_info['title'];?></h1>		
			<p><?php echo $row_info['small_desc'];?></p>
			
			<div id="successful_message_form" style="display:none;padding-top:4px;" class="success cornered"><?php echo $row_info['successful_message'];?></div>
			<table>
<tr><th></th><th></th><th style="width:100px;"></th></tr>
			<?php
			while($row = mysql_fetch_array($fields)){
			$req = '';
			$errorlabel = '<label id="label_'.$row['flexible_alias'].'" class="errorbox cornered" style="display:none;">You have not completed \''.$row['flexible_field_name'].'\'</label>';
			switch($row['flexible_req']){
			case "1":
				$req = '<span class="required">*</span>';
			break;
			}
			  switch($row['flexible_type']){
			  case "text":
			  case "password":
			  ?>
			 <tr>
			 <th><label for="contact_<?php echo $row['flexible_alias'];?>" class="desc"><?php echo $row['flexible_field_name'];?><?php echo $req;?></label></th><th><input type="<?php echo $row['flexible_type'];?>" class="text cornered defaultText" title="<?php echo $row['flexible_choices']; ?>" id="contact_<?php echo $row['flexible_alias'];?>" size="43" name="<?php echo $row['flexible_alias'];?>"></th><th><?php echo $errorlabel; ?></th>
			 </tr>
			  <?php
			  break;
			  case "textarea": ?>
			 <tr>
			 <th valign="middle"><label for="contact_<?php echo $row['flexible_alias'];?>" class="desc"><?php echo $row['flexible_field_name'];?><?php echo $req;?> </label></th><th><textarea cols="40" rows="10" class="text cornered defaultText" title="<?php echo $row['flexible_choices']; ?>" width="43" id="contact_<?php echo $row['flexible_alias'];?>" name="<?php echo $row['flexible_alias'];?>"></textarea></th><th valign="middle"><?php echo $errorlabel; ?></th>
			 </tr>
			  <?php
			  break;
			  case "email":?>
			  <tr><th><label for="contact_<?php echo $row['flexible_alias'];?>" class="desc"><?php echo $row['flexible_field_name'];?> <?php echo $req;?></label></th><th><input type="text" class="text cornered email_valid defaultText" title="<?php echo $row['flexible_choices']; ?>" id="contact_<?php echo $row['flexible_alias'];?>" size="43" name="<?php echo $row['flexible_alias'];?>"></th><th><?php echo '<label id="label_'.$row['flexible_alias'].'" class="errorbox cornered" style="display:none;">Invalid Email Address</label>'; ?>
			  </th></tr>
			  <?php 
			  break;
			  case "date": ?>
				<tr><th><label for="contact_<?php echo $row['flexible_alias'];?>" class="desc"><?php echo $row['flexible_field_name'];?> <?php echo $req;?></label></th><th><input type="text" class="text cornered date defaultText" title="<?php echo $row['flexible_choices']; ?>" id="contact_<?php echo $row['flexible_alias'];?>" size="43" name="<?php echo $row['flexible_alias'];?>"></th><th><?php echo '<label id="label_'.$row['flexible_alias'].'" class="errorbox cornered" style="display:none;">Please provide a Date</label>'; ?>
			  </th></tr>
	<?php	  break;
			  case "subject":
			  ?>
			  <tr><th><label for="contact_<?php echo $row['flexible_alias'];?>" class="desc"><?php echo $row['flexible_field_name'];?> <?php echo $req;?></label></th><th><input type="text" class="text cornered defaultText" title="<?php echo $row['flexible_choices']; ?>" id="contact_<?php echo $row['flexible_alias'];?>" size="43" name="subject"></th><th><?php echo '<label id="label_'.$row['flexible_alias'].'" class="errorbox cornered" style="display:none;">Please provide a subject</label>'; ?>
			  </th></tr>
			  <?php
			  break;
			  case "checkbox":
			  $options = explode("\n",$row['flexible_choices']);
			  ?>
			  <tr><th><label class="desc"><?php echo $row['flexible_field_name'];?> <?php echo $req;?></label></th><th>
			  <?php
			  foreach ($options as $value) {
			  ?>
			  <input type="checkbox" name="<?php echo $row['flexible_alias'];?>[]" value="<?php echo $value;?>" id="contact_<?php echo $row['flexible_alias'];?>"><?php echo $value;?>
			  <?php } ?>
			  </th><th><?php echo '<label id="label_'.$row['flexible_alias'].'" class="errorbox cornered" style="display:none;">Please select an option</label>'; ?>
			  </th></tr>
			  <?php			  
			  break;
 			  case "file":
			  ?>
			  <input type="hidden" class="file_path"name="<?php echo $row['flexible_alias'];?>" value="blank" id="file_path<?php echo $row['flexible_alias']; ?>"/>
			  <tr><th><label class="desc"><?php echo $row['flexible_field_name'];?> <?php echo $req;?></label></th><th>
			  <input type="file" name="<?php echo $row['flexible_alias'];?>" id="contact_file<?php echo $row['flexible_alias'];?>" class="upload">
			  </th><th><?php echo '<label id="label_'.$row['flexible_alias'].'" class="errorbox cornered" style="display:none;">Please upload a file</label>'; ?>
			  </th></tr>			  
			  <?php
			  break;
			  case "slider": 
			  $sod = mysql_fetch_array(mysql_query("SELECT * FROM flexible_slider_settings WHERE flexible_id='".$row["flexible_alias"]."'"));
			  ?>
			  <tr><th><label for="contact_<?php echo $row['flexible_alias'];?>" class="desc"><?php echo $row['flexible_field_name'];?><?php echo $req;?></label></th>
			  <th>
			  <div id="contact_<?php echo $row['flexible_alias'];?>" class="slider" ></div>
				<input type="text" id="slider_amount_<?php echo $row['flexible_alias']; ?>" name="<?php echo $row['flexible_alias']; ?>" value="" style="display:none;" /></th>
				<th>
				<?php if( $sod["slider_display"] == '1'){ 
				if ($sod["slider_range"] == '1'){
				$initial_value = $sod["slider_prefix"].$sod["slider_value_min"]." - ".$sod["slider_prefix"].$sod["slider_value_max"];
				}else{
				$initial_value = $sod["slider_prefix"].$sod["slider_value"];
				}?>
			  <label style="width:20px" id="slider_display_amount_<?php echo $row['flexible_alias']; ?>"><?php echo $initial_value ; ?></label>
				<?php } ?>
				
				<?php echo '<label id="label_'.$row['flexible_alias'].'" class="errorbox cornered" style="display:none;">Please provide a subject</label>'; ?>
			  </th></tr>
	<?php	  break;
			  case "dropdown":
			  $options = explode("\n",$row['flexible_choices']);
			  ?>
			  <tr><th><label class="desc"><?php echo $row['flexible_field_name'];?> <?php echo $req;?></label></th><th>
			  <select name="<?php echo $row['flexible_alias'];?>[]" id="contact_<?php echo $row['flexible_alias'];?>">
			  <?php
			  foreach ($options as $value) {
			  ?>
			  <option value="<?php echo $value;?>"><?php echo $value;?></option>
			  <?php
			  }
			  ?>
			  </select>
			  </th><th><?php echo '<label id="label_'.$row['flexible_alias'].'" class="errorbox cornered" style="display:none;">Please select an option</label>'; ?>
			  </th></tr>
			  <?php			  
			  break;
			  case "radio":
			  $options = explode("\n",$row['flexible_choices']);
			  ?>
			  <tr><th><label class="desc"><?php echo $row['flexible_field_name'];?> <?php echo $req;?></label></th><th>
			  <?php
			  foreach ($options as $value) {
			  ?>
			  <input type="radio" name="<?php echo $row['flexible_alias'];?>" value="<?php echo $value;?>" id="contact_<?php echo $row['flexible_alias'];?>"><?php echo $value;?>
			  <?php
			  }
			  ?>
			  </th><th><?php echo '<label id="label_'.$row['flexible_alias'].'" class="errorbox cornered" style="display:none;">Please select an option</label>'; ?>
			  </th></tr>
			  <?php				  
			  break;
				} }

				if ($row_info['captcha'] == 1){
				?>
			<tr><th><label id="captcha" class="desc"><?php echo $num1.' + '.$num2 ?> =<span class="required">*</span></label></th><th><input type="text" class="text cornered" size="43" id="validation_answer"></th><th><?php echo '<label id="label_auth" class="errorbox cornered"  style="display:none;">Your authentication sum is not correct</label>'; ?>
			</th></tr>
			<?php
			}
			?>
			</table>
			<div class="error" style="display:none;">Please complete all the fields.</div>
			<input type="button" value="<?php echo $row_info['submit_button'];?>" class="button cornered">
			<div class="clearfix"></div>
			</form>

			</div>
			<div class="clearfix"></div>
				
		</div>
	</body>
</html>	