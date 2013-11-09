<?php

# --------------------------------------------------------------------
# -- NOTE: jQuery AND jQueryUI are required for VisualCaptcha to work!
# --------------------------------------------------------------------

# -- Set your Image path --
# the full path to your publicly available images directory
# this is where the images for visualcaptcha will live 

$config["theme"] = 'food';

$config["public_image_path"] = site_url(ASSETURL . 'sparks/visualcaptcha/images/');
$config["public_audio_path"] = ASSETURL . 'sparks/visualcaptcha/audio';


$config["food_answers"] = array(
		'bananas' => array('bananas.png', 'Bananas'),
		'bok_choy' => array('bok_choy.png', 'Bok Choy'),
		'carrots' => array('carrots.png', 'Carrots'),
		'garlic' => array('garlic.png', 'Garlic'),
		'ginger' => array('ginger.png', 'Ginger'),
		'mushroom' => array('mushroom.png', 'Mushroom'),
		'pear' => array('pear.png', 'Pear'),
		'pepper' => array('pepper.png', 'Pepper'),
		'tomato' => array('tomato.png', 'Tomato'),
		'onion' => array('onion.png', 'Onion')
);

$config['food_completion_prompt'] = "Drag the <captchatext> onto the plate to complete this form.";
$config['food_mobile_completion_prompt'] = "Click the <captchatext> to complete this form.";
		
$config["office_answers"] = array(
		'file_cabinet' => array('file_cabinet.png', 'File Cabinet'),
		'notebook' => array('notebook.png', 'Notebook'),
		'parcel_tape' => array('parcel_tape.png', 'Parcel Tape'),
		'scissors' => array('scissors.png', 'Scissors'),
		'marker' => array('marker.png', 'Marker'),
		'memo' => array('memo.png', 'Memo'),
		'sharpener' => array('sharpener.png', 'Sharpener'),
		'whiteboard' => array('whiteboard.png', 'Whiteboard'),
		'tape_measure' => array('tape_measure.png', 'Tape Measure'),
		'gavel' => array('gavel.png', 'Gavel'),
		'taxi' => array('taxi.png', 'Taxi'),
		'scale' => array('scale.png', 'Scale'),
		
);

$config['office_completion_prompt'] = "Drag the <captchatext> onto the target to complete this form.";
$config['office_mobile_completion_prompt'] = "Click the <captchatext> to complete this form.";


$config["sports_answers"] = array(
		'baseball' => array('baseball.png', 'Baseball'),
		'basketball' => array('basketball.png', 'Basket Ball'),
		'football' => array('football.png', 'Football'),
		'golfball' => array('golfball.png', 'Golf Ball'),
		'soccerball' => array('soccerball.png', 'Soccer Ball'),
		'tennisball' => array('tennisball.png', 'Tennis Ball'),
		'volleyball' => array('volleyball.png', 'Volley Ball'),
		'hockey_puck' => array('hockey_puck.png', 'Hockey Puck'),
		'curling_iron' => array('curling_iron.png', 'Curling Iron'),
		'billiard_ball' => array('billiard_ball.png', 'Billiard Ball'),
		'bicycle_wheel' => array('bicycle_wheel.png', 'Bicycle Wheel'),
		'beach_ball' => array('beach_ball.png', 'Beach Ball'),
		
);

$config['sports_completion_prompt'] = "Drag the <captchatext> onto the target to complete this form.";
$config['sports_mobile_completion_prompt'] = "Click the <captchatext> to complete this form.";



$config["christmas_answers"] = array(
		'bells' => array('bells.png', 'Bells'),
		'candle' => array('candle.png', 'Candle'),
		'chrismas_tree' => array('chrismas_tree.png', 'Chrismas Tree'),
		'christmas_ball' => array('christmas_ball.png', 'Christmas Ball'),
		'cookies' => array('cookies.png', 'Cookies'),
		'gift_box' => array('gift_box.png', 'Gift Box'),
		'glass_ball' => array('glass_ball.png', 'Glass Ball'),
		'reindeer' => array('reindeer.png', 'Reindeer'),
		'santa_claus' => array('santa_claus.png', 'Santa Claus'),
		'sledge' => array('sledge.png', 'Sledge'),
		'snowman' => array('snowman.png', 'Snowman'),
		'sock' => array('sock.png', 'Sock'),
		
);

$config['christmas_completion_prompt'] = "Drag the <captchatext> onto the wreath to complete this form.";
$config['christmas_mobile_completion_prompt'] = "Click the <captchatext> to complete this form.";




# Include jQueryUI?
#	true will include a reference to jQueryUI via http://www.google.com/jsapi
#	false will omit the jQueryUI reference - you should only set this to false if your page has already loaded jQueryUI
$config['include_jqueryui'] = FALSE;

# Show the wrapper UI for VisualCaptcha?
#	true will include the gray box UI styling
#	false will include only the core styling needed for VisualCaptcha
$config['include_wrapper_UI'] = TRUE;


//$config['completion_prompt'] = "Drag the <captchatext> onto the plate to complete this form.";




?>