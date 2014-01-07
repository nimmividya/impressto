<?php
// Start session with @ to avoid SESSION ALREADY STARTED NOTICE
// It might have been started on your page. Still... it might not ;) 
//@session_start();


class Commento_captcha extends commento_model {
	
	private $color1;
	private $color2;
	private $color3;
	private $bgcolor;
	private $bg_transparent = true;
	
	private $final_width;
	
	// set defaults for very large image
	private $width 				= 1000;
	private $height 			= 400;
	private $font_size 			= 300;
	
	private $first_rotation 	= -5;
	private $second_rotation 	= 0;
	private $third_rotation 	= 5;
	
	private $first_x 			= 50;
	private $second_x 			= 40;
	private $third_x 			= 30;
	
	private $first_y 			= 260;
	private $second_y 			= 300;
	private $third_y 			= 340;
	
	public function __construct() {
		parent::__construct();
		$this->final_width = $this->captcha_width;
		
		$this->color1 	= $this->captcha_color1;
		$this->color2 	= $this->captcha_color2;
		$this->color3 	= $this->captcha_color3;
		$this->bgcolor 	= $this->captcha_colorbg;
	}
	
	public function CreateCaptcha() {
		
		// generate random number
		$randomnr = rand(1000, 9999);
		
		// MD5 it and store in session
		//$_SESSION['commento_random_number'] = md5($randomnr);
		
		$sessiondata = array('commento_random_number'  => md5($randomnr));
		$this->session->set_userdata($sessiondata);

		
		// Generate image
		$im = imagecreatetruecolor($this->final_width, $this->crossMultiply($this->height));
		imagesavealpha($im, true);
		
		// Colors:
		if ($rgb_color1 = $this->hex2RGB($this->color1))
			$color_1 	= imagecolorallocate($im, $rgb_color1["red"], $rgb_color1["green"], $rgb_color1["blue"]);
		else
			$color_1 	= imagecolorallocate($im, 120, 180, 240);
		
		
		if ($rgb_color2 = $this->hex2RGB($this->color2))
			$color_2 	= imagecolorallocate($im, $rgb_color2["red"], $rgb_color2["green"], $rgb_color2["blue"]);
		else
			$color_2 	= imagecolorallocate($im, 120, 180, 240);
		
		
		if ($rgb_color3 = $this->hex2RGB($this->color3))
			$color_3 	= imagecolorallocate($im, $rgb_color3["red"], $rgb_color3["green"], $rgb_color3["blue"]);
		else
			$color_3 	= imagecolorallocate($im, 120, 180, 240);
		
		
		if ($rgb_bgcolor = $this->hex2RGB($this->bgcolor))
			$background = imagecolorallocate($im, $rgb_bgcolor["red"], $rgb_bgcolor["green"], $rgb_bgcolor["blue"]);
		else
			$background = imagecolorallocatealpha($im, 0, 0, 0, 127);
		
		
		imagefill($im, 0, 0, $background);
		
		//path to font:
		$fontpath = str_replace('\\','/',dirname(dirname(__FILE__))) . '/fonts/';
		
		// Array with font (you can add more fonts and random one will be picked from the array
		$fonts = array(
			'Candice'  => array('spacing' =>-1.5,'minSize' => 28, 'maxSize' => 31, 'font' => 'Candice.ttf'),
		);
		
		// Pick random font from the array
		$fontcfg  = $fonts[array_rand($fonts)];
		
		// Full path of font file
		$fontfile = $fontpath.$fontcfg['font'];
		
		//draw text:
		imagettftext($im, $this->crossMultiply($this->font_size), $this->first_rotation, $this->crossMultiply($this->first_x), $this->crossMultiply($this->first_y), $color_1, $fontfile, $randomnr);
		imagettftext($im, $this->crossMultiply($this->font_size), $this->second_rotation, $this->crossMultiply($this->second_x), $this->crossMultiply($this->second_y), $color_2, $fontfile, $randomnr);
		imagettftext($im, $this->crossMultiply($this->font_size), $this->third_rotation, $this->crossMultiply($this->third_x), $this->crossMultiply($this->third_y), $color_3, $fontfile, $randomnr);
		
		// prevent client side  caching
		header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		//send image to browser
		header ("Content-type: image/png");
		imagepng($im);
		imagedestroy($im);
		
	}
	
	function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
		$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
		$rgbArray = array();
		if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
			$colorVal = hexdec($hexStr);
			$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
			$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
			$rgbArray['blue'] = 0xFF & $colorVal;
		} else if (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
			$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
			$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
			$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
		} else {
			return false; //Invalid hex color code
		}
		return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
	}
	
	function crossMultiply($value) {
		$out = ($this->final_width * $value) / $this->width;
		return $out;
	}
	
}


?>