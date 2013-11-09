<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// sample tags
//  [widget type='visualcaptcha']
//  direct from PHP code Widget::run('visualcaptcha', array('name'=>'header'));
// within smarty {widget type='visualcaptcha'}



class visualcaptcha_audio extends Widget
{
	function run() {

		$this->load->spark('visualcaptcha');
		
		$this->load->library('visual_captcha'); 
			
		$file = getenv("DOCUMENT_ROOT") . $this->visual_captcha->getAudioFilePath();


		if ( ! isset($_GET['t']) ) {
			$_GET['t'] = 'mp3';
		}	

		switch ($_GET['t']) {
		case 'ogg':
			$mimeType = 'audio/ogg';
			$extension = 'ogg';
			$file = str_replace( '.mp3', '.ogg', $file );
			break;
		case 'mp3':
		default:
			$mimeType = 'audio/mpeg';
			$extension = 'mp3';
			break;
		}
		
		header( 'Pragma: public' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Cache-Control: private', false );
		header( 'Content-Type: ' . $mimeType );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Content-Length: '.filesize($file) );
		readfile( $file );
		exit();

			
	}
} 

