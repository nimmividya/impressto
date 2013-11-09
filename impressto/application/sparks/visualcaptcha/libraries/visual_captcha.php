<?php

/**
* visualCaptchaHTML class by emotionLoop - 2012.04.26
*
* This class handles a visual image captcha system.
*
* This license applies to this file and others without reference to any other license.
*
* @author emotionLoop | http://emotionloop.com
* @link http://visualcaptcha.net
* @package visualCaptcha
* @license CC BY-SA 3.0 | http://creativecommons.org/licenses/by-sa/3.0/
* @version 4.0
*/


class visual_captcha{

	public $CI;
	private $formId = 'frm_captcha';
	private $type = 0;
	private $fieldName = 'captcha-value';
	private $accessibilityFieldName = 'captcha-accessibility-value';
	private $js = '';
	private $css = '';
	private $html = '';
	private $hash = '';
	private $hashSalt = '';	
	private $include_jqueryui = true;
	private $include_wrapper_UI = true;
	private $completion_prompt = '';
	private $submit_button = '';
	private $answers = array();
	private $uiOptions = array("include_wrapper_UI" => true, "include_jqueryui" => true);
	private $options = array();
	private $optionsProperties = array();
	private $accessibilityOptions = array();
	private $accessibilityFile = '';
	private $accessibilityAnswer = '';
	private $value = '';
	private $valueProperties = array();
	private $jsFile = 'js/visualcaptcha.js';
	private $cssFile = 'css/visualcaptcha.css';
	private $wrapperCss = 'css/sample.css';
	private $htmlClass = 'views/visualcaptcha.class.html.php';
	public  $imagesPath = 'images/visualcaptcha/';
	public  $audiosPath = 'audio/visualcaptcha/';
	public  $audioFile = '/widget_call/run/visualcaptcha_audio'; // this needs to be a direct call into the system. Not sure how to make that work just now...


	public function __construct($params = NULL)
	{
		
		$this->CI = &get_instance();
	
		
		$this->hashSalt = 'emotionLoop::' . $_SERVER['REMOTE_ADDR'] . '::captcha::';
		$this->hash = sha1( $this->hashSalt . $this->nonceTick(1800) . '::tick' );
		
			
		if(isset($params['formId'])) $formId = $params['formId']; 
		if(isset($params['type']))$type = $params['type']; 
		if(isset($params['fieldName']))$fieldName = $params['fieldName']; 
		if(isset($params['submit_button']))$submit_button = $params['submit_button']; 
		if(isset($params['theme']))$theme = $params['theme']; 
		
			

		
		
		if(!isset($theme) || !$theme) $this->theme = $this->CI->config->item('theme');
		else  $this->theme = $theme;
		
		
		$this->include_jqueryui = $this->CI->config->item('include_jqueryui');
		$this->include_wrapper_UI = $this->CI->config->item('include_wrapper_UI');
		$this->completion_prompt = $this->CI->config->item($this->theme . '_completion_prompt');
		
		
		$this->imagesPath =  $this->CI->config->item('public_image_path');
		$this->audiosPath =  $this->CI->config->item('public_audio_path');
			
		
		$this->answers = $this->CI->config->item($this->theme . '_answers');
		
		$this->audioFile = site_url($this->audioFile) . "/";
				
		
		// Setup Accessibility Questions here: array(Answer, MP3 Audio file). You can repeat answers, but it's safer if you don't.
		// You can generate MP3 & Ogg audio files easily using http://stuffthatspins.com/stuff/php-TTS/index.php
		$this->accessibilityOptions = array(
			array('10', $this->audiosPath . '/5times2.mp3'),
			array('20', $this->audiosPath . '/2times10.mp3'),
			array('6', $this->audiosPath . '/5plus1.mp3'),
			array('7', $this->audiosPath . '/4plus3.mp3'),
			array('4', $this->audiosPath . '/add3to1.mp3'),
			array('green', $this->audiosPath . '/addblueandyellow.mp3'),
			array('white', $this->audiosPath . '/milkcolor.mp3'),
			array('2', $this->audiosPath . '/divide4by2.mp3'),
			array('yes', $this->audiosPath . '/sunastar.mp3'),
			array('no', $this->audiosPath . '/yourobot.mp3'),
			array('12', $this->audiosPath . '/6plus6.mp3'),
			array('100', $this->audiosPath . '/99plus1.mp3'),
			array('blue', $this->audiosPath . '/skycolor.mp3'),
			array('3', $this->audiosPath . '/after2.mp3'),
			array('24', $this->audiosPath . '/12times2.mp3'),
			array('5', $this->audiosPath . '/4plus1.mp3'),
		);
		
		
		$this->uiOptions = array(
			"include_wrapper_UI" => $this->include_wrapper_UI,
			"include_jqueryui" => $this->include_jqueryui,
			"completion_prompt" => $this->completion_prompt,
			"theme" => $this->theme
		);



		if (isset($formId) && !is_null($formId)) {
			$this->formId = $formId;
		}
		if (isset($type) && !is_null($type)) {
			if (is_numeric($type)) {
				$this->type = (int) $type;
			} else {
				if ($type == "h") {
					$this->type = 0;
				} else {
					$this->type = 1;
				}
			}
		} else {
			$this->type = 0;
		}
		if (isset($fieldName) && !is_null($fieldName)) {
			$this->fieldName = $fieldName;
		}
		
		if (isset($submit_button) && !is_null($submit_button)) {
			$this->submit_button = $submit_button;
		}
		

		//-- Setup Image Names here: stringID, array(ImagePath, ImageName/Text to show)
		$imgPath = $this->CI->config->item('public_image_path');
		$this->uiOptions["imgPath"] = $imgPath;
		
		
		
	
	}

	public function show()
	{
	
		$this->setNewValue();

		shuffle($this->options);
					

		//-- Include visualCaptchaHTML class
		$this->CI->load->view('visualcaptcha.class.html.php', array(), true);
		
		$params = array(
			"type" => $this->type,
			"fieldName" => $this->fieldName, 
			"submit_button" => $this->submit_button, 
			"formId" => $this->formId, 
			"captchaText" => $this->getText(), 
			"captchaValue" => $this->getValue(), 
			"options" => $this->options, 
			"optionsProperties" => $this->optionsProperties, 
			"jsFile" => $this->jsFile, 
			"cssFile" => $this->cssFile, 
			"wrapperCss" => $this->wrapperCss, 
			"uiOptions" => $this->uiOptions,
			"imagesPath" => $this->imagesPath,
			"audiosPath" => $this->audiosPath,
			"audioFile" => $this->audioFile,
			
			
		
		);

		
		$this->html = visualCaptchaHTML::get($params);

		echo $this->html;
	}

	public function isValid()
	{
		$this->CI->load->library('session');
			
		$ses_answer = $this->CI->session->userdata("hash");
		
		if (isset($_POST[$this->fieldName]) && isset($ses_answer) && ($_POST[$this->fieldName] == $ses_answer)) {
		
			return true;
		}
		
		return false;
	}

	private function setNewValue()
	{
		$this->CI->load->library('session');
		
		
		// Accessibility option. Set question file and answer, encrypted
		$this->accessibilityOptions = $this->shuffle( $this->accessibilityOptions );

		$limit = count( $this->accessibilityOptions );

		$rnd = rand(0, $limit-1);

		$this->accessibilityAnswer = $this->encrypt( $this->accessibilityOptions[$rnd][0] );
		$this->accessibilityFile = $this->accessibilityOptions[$rnd][1];
				
		
		$this->answers = $this->shuffle($this->answers);
		$i = 0;
		switch ($this->type)
		{
		case 0://-- Horizontal
			$limit = 6;
			break;
		case 1://-- Vertical
			$limit = 4;
			break;
		}

		
		$rnd = rand(0, $limit - 1);

		foreach ($this->answers as $answer => $answer_props)
		{
			if ($i >= $limit)
			continue;
			$this->options[] = $answer;
			$this->optionsProperties[$answer] = $answer_props;
			if ($i == $rnd) {
				$ses = array(
					"hash" => $answer,
					"accessibilityAnswer" => $this->accessibilityAnswer,
					"accessibilityFile" => $this->accessibilityFile,
				);
				
			
				// peterdrinnan - there are some fucked up things going on with data caching
				// that is making life hell for cache management.
				$this->CI->session->set_userdata($ses);
				$this->value = $answer;
				

				
				$this->valueProperties = $answer_props;

			}
			++$i;
		}
		
	
		
	}

	private function getValue()
	{
		return $this->value;
	}

	private function getImage()
	{
		return $this->valueProperties[0];
	}

	private function getText()
	{
		return $this->valueProperties[1];
	}

	/**
	* Get the time-dependent variable for nonce creation.
	*
	* This function is based on Wordpress' wp_nonce_tick().
	*
	* @since 1.1
	*
	* @return int
	*/
	private function nonceTick($life = 86400)
	{
		return ceil(time() / $life);
	}

	/**
	* Private shuffle() method. Shuffles an associative array. If $list is not an array, it returns $list without any modification.
	*
	* @since 1.1
	*
	* @param $list Array to shuffle.
	*
	* @return $random Array shuffled array.
	*/
	private function shuffle($list)
	{
		if (!is_array($list))
		return $list;
		$keys = array_keys($list);
		shuffle($keys);
		$random = array();

		foreach ($keys as $key)
		{
			$random[$key] = $list[$key];
		}

		return $random;
	}
	
	/**
	 * Private encrypt method. Encrypts a string using sha1()
	 *
	 * @since 4.0
	 * @param $string String to encrypt
	 * @return $encryptedString String encrypted
	 */
	private function encrypt( $string ) {
		$encryptedString = sha1( $this->hashSalt . $this->nonceTick(1800) . '::encrypt::' . $string );
		return $encryptedString;
	}

	/**
	 * Public getAudioFilePath method. Returns the current audio file path in the session, if set
	 */
	public function getAudioFilePath() {
	
		$this->CI->load->library('session');

		return $this->CI->session->userdata("accessibilityFile");
	

	}
	

}

?>