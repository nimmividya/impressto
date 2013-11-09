<?php

/**
 * visualCaptchaHTML class by emotionLoop - 2012.04.26
 *
 * This class handles the HTML for the main visualCaptcha class.
 *
 * This license applies to this file and others without reference to any other license.
 *
 * @author emotionLoop | http://emotionloop.com
 * @link http://visualcaptcha.net
 * @package visualCaptcha
 * @license CC BY-SA 3.0 | http://creativecommons.org/licenses/by-sa/3.0/
 * @version 3.0
 
 * Check out how he did the audio part here - http://www.binpress.com/app/demo/app/467
 * or the ../full folder here
 */
class visualCaptchaHTML
{

    public function __construct()
    {
        
    }

    public static function get($params)
    {
	
		$CI = & get_instance();
		
		$CI->load->library('asset_loader');
		
		$CI->asset_loader->add_header_js(ASSETURL . "sparks/visualcaptcha/js/visualcaptcha.js");
		$CI->asset_loader->add_header_css(ASSETURL . "sparks/visualcaptcha/css/visualcaptcha.css");
		$CI->asset_loader->add_header_css(ASSETURL . "sparks/visualcaptcha/css/sample.css");
		
		
		$type = $params['type']; 
		$fieldName = $params['fieldName'];
		$submit_button = $params['submit_button'];
		$formId = $params['formId'];
		$captchaText = $params['captchaText'];
		$captchaValue = $params['captchaValue'];
		$options = $params['options'];
		$optionsProperties = $params['optionsProperties'];
		$jsFile = $params['jsFile']; 
		$cssFile = $params['cssFile'];
		$wrapperCss = $params['wrapperCss'];
		$uiOptions = $params['uiOptions'];
		$imagesPath = $params['imagesPath'];
		if(isset($params['audiosPath'])) $audiosPath = $params['audiosPath'];		
		if(isset($params['audioFile'])) $audioFile = $params['audioFile'];
				
		
							
        $html = '';
        $limit = count($options);
        $wrapperId = "vcaptcha_wrapper";
        if ($type === 1) {
            $wrapperId = "vcaptcha_wrapper-type-1";
        }

        ob_start();
        ?>


        <?php
        if (!empty($uiOptions["include_jqueryui"]) && $uiOptions["include_jqueryui"] === true) {
            ?>
            <script src="http://www.google.com/jsapi"></script>
            <script>
                // if jQuery is already defined, we dont need to reload it
                if (typeof jQuery == 'undefined') {  
                    google.load("jquery", "1.7");
                }
                google.load("jqueryui", "1.8");
            </script>
            <?php
        }
        ?>

        <script>
            var vCVals = {
                'f': '<?php echo $formId; ?>',
                'n': '<?php echo $fieldName; ?>',
	            'cv': '<?php echo $captchaValue; ?>',
				'submit_button': '<?php echo $submit_button; ?>'
							
            };
        </script>
        <script defer="defer">
        <?php //include( $jsFile ); ?>
        </script>

        <style type="text/css" media="screen">
        <?php //include( $cssFile ); ?>
        </style>


        <?php
        if (!empty($uiOptions["include_wrapper_UI"]) && $uiOptions["include_wrapper_UI"] === true) {

		?>

            <style type="text/css" media="screen">
            <?php //include( $wrapperCss ); ?>
            </style>

            <div  id="<?php echo $wrapperId; ?>">
                <div id="content">

        <?php
        }
        ?>


                <div class="eL-captcha type-<?php echo $type; ?>">
                    
					<p class="eL-explanation type-<?php echo $type; ?>">
					<?php echo str_replace("<captchatext>","<strong>{$captchaText}</strong>",$uiOptions["completion_prompt"]); ?>
					</p>
					
                    <div class="eL-possibilities type-<?php echo $type; ?>">
                        <?php
                        for ($i = 0; $i < $limit; $i++)
                        {
                            $name = $options[$i];
                            $image = $optionsProperties[$name][0];
                            $text = $optionsProperties[$name][1];
                            ?>
                            <img src="<?php echo $uiOptions["imgPath"] . "/" . $uiOptions["theme"] . "/" . $image; ?>" class="vc-<?php echo $name; ?>" data-value="<?php echo $name; ?>" alt="" title="" />
                            <?php
                        }
                        ?>
                        <div class="clear"></div>
                    </div>
                    <div class="eL-where2go type-<?php echo $type; ?>" data-value="<?=$captchaValue?>" style="background: transparent url('<?php echo $uiOptions["imgPath"] . "/" . $uiOptions["theme"] . "/dropzone.png"; ?>') center center no-repeat;">
                        <div class="clear"></div>
                    </div>
					<input type="hidden" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" value="" />
                    <div class="clear"></div>
					
				
					<p class="eL-accessibility type-<?php echo $type; ?>">
						<a href="javascript:void(0);" title="<?php echo 'Accessibility option: listen to a question and answer it!'; ?>">
							<img src="<?php echo $imagesPath; ?>/accessibility.png" alt="<?php echo 'Accessibility option: listen to a question and answer it!'; ?>">
						</a>
					</p>
					
					<div class="eL-accessibility type-<?php echo $type; ?>">
					<p><?php echo 'Type below the'; ?> <strong><?php echo 'answer'; ?></strong> <?php echo 'to what you hear. Numbers or words, lowercase:'; ?></p>
					
					<audio preload="preload">
						<source src="<?php echo $audioFile; ?>?t=ogg&amp;r=<?php echo time(); ?>" type="audio/ogg">
						<source src="<?php echo $audioFile; ?>?t=mp3&amp;r=<?php echo time(); ?>" type="audio/mpeg">
						<?php echo 'Your browser does not support the audio element.'; ?>
					</audio>
					</div>
	
                </div>
                <div class="clear"></div>

                <?php
                if (!empty($uiOptions["include_wrapper_UI"]) && $uiOptions["include_wrapper_UI"] === true) {
                    ?>
                </div>
            </div>
            <?php
        }
        ?>






        <?php
        $html = ob_get_clean();
        return $html;
    }

}
?>


