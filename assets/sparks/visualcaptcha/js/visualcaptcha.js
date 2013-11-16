/**
 * visualCaptchaHTML class by emotionLoop - 2012.04.26
 *
 * This file handles the JS for the main visualCaptcha class.
 *
 * This license applies to this file and others without reference to any other license.
 *
 * @author emotionLoop | http://emotionloop.com
 * @link http://visualcaptcha.net
 * @package visualCaptcha
 * @license CC BY-SA 3.0 | http://creativecommons.org/licenses/by-sa/3.0/
 * @version 3.0
 */
jQuery(document).ready(function($) {
	
	var isMobile = false;
	var isRetina = false;
	var supportsAudio = false;
	

	var uAgent = navigator.userAgent.toLowerCase();

	// Check if the user agent is a mobile one
	if ( uAgent.indexOf('iphone') !== -1 || uAgent.indexOf('ipad') !== -1 || uAgent.indexOf('ipod') !== -1 ||
	uAgent.indexOf('android') !== -1 ||
	uAgent.indexOf('windows phone') !== -1 || uAgent.indexOf('windows ce') !== -1 ||
	uAgent.indexOf('bada') !== -1 ||
	uAgent.indexOf('meego') !== -1 ||
	uAgent.indexOf('palm') !== -1 ||
	uAgent.indexOf('blackberry') !== -1 ||
	uAgent.indexOf('nokia') !== -1 || uAgent.indexOf('symbian') !== -1 ||
	uAgent.indexOf('pocketpc') !== -1 ||
	uAgent.indexOf('smartphone') !== -1 ||
	uAgent.indexOf('mobile') !== -1 ) {
		isMobile = true;
	}
	
	
	// Check if the device is retina-like
	if ( window.devicePixelRatio && window.devicePixelRatio > 1 ) {
		isRetina = true;
	}
	
	
	// Check if the device supports audio, for accessibility
	try {
		var audioElement = document.createElement('audio');
		if ( audioElement.canPlayType ) {
			supportsAudio = true;
		}
	} catch(e) {}

	// If the device is retina-like, update the img src's and the dropzone class
	if ( isRetina ) {
		$('div.eL-captcha img').each(function(index, element) {
			if ( ! $(element).attr('src') ) return;
			
			var newImageSRC = $(element).attr('src').replace(/(.+)(\.\w{3,4})$/, "$1@2x$2");
			$.ajax({
				url: newImageSRC,
				type: "HEAD",
				success: function() {
					$(element).attr('src', newImageSRC);
				}
			});
		});

		$('div.eL-captcha > div.eL-where2go').addClass('retina');
	}

	if ( ! supportsAudio ) {
		$('div.eL-captcha > .eL-accessibility').hide();
	} else {
		$('div.eL-captcha > p.eL-accessibility a').on('click touchstart', function(event) {
			event.preventDefault();

			if ( ! $('div.eL-captcha > div.eL-accessibility').is(':visible') ) {
				$('div.eL-captcha > div.eL-accessibility > audio').each(function() {
				
		
					this.load();
					this.play();
				});

				if ( ! $('#' + window.vCVals.a).length ) {
					var validAccessibleElement = '<input type="text" name="' + window.vCVals.a + '" id="' + window.vCVals.a + '" value="">';
					$('div.eL-captcha > div.eL-accessibility > p').after(validAccessibleElement);
				}
			}

			$('div.eL-captcha > p.eL-explanation').stop().slideToggle('fast');
			$('div.eL-captcha > div.eL-possibilities').stop().slideToggle('fast');
			$('div.eL-captcha > div.eL-where2go').stop().slideToggle('fast');
			$('div.eL-captcha > div.eL-accessibility').stop().slideToggle('fast');
		});
	}
	
	
	
	//isMobile = true;
		
	if (!isMobile) { //-- If it's not mobile, load normal drag/drop behavior
		$('div.eL-captcha > div.eL-possibilities > img').draggable( { 
		
			revert: "invalid",
   			opacity: 0.6, revert: 'invalid' 
						
		});
		
	
		$('div.eL-captcha > div.eL-where2go').droppable( {
		
			accept: function (elm) {
				var $this = $(this);
				if ($this.data("value") == elm.data("value"))
					return true;
        
				return false;
			},
	
	
			drop: function(event, ui) {
			
				
				var dropped_val = $(ui.draggable).data('value');
		
				if(vCVals.cv == dropped_val){
					
					$('#' + vCVals.n).val(dropped_val);
	
					$('#vcaptcha_wrapper').css('background-color','#FCFBE1');
					
					$('#' + vCVals.submit_button).removeAttr("disabled");
					$('#' + vCVals.submit_button).show();
					
					$(this).droppable('disable');
					
					$('#' + vCVals.submit_button).removeAttr("disabled");
					
					// TODO: hide the whole captcha wrapper now
					
				
				}
				

			}
		
		} );
	} else { //-- If it's mobile, we're going to make it possible to just tap an image and move it to the drop area automagically
		$('div.eL-captcha > div.eL-possibilities > img').live('click touchstart', function() { //-- Add tap behavior, but keep click in case that also works. There is no "duplication" problem since this code won't run twice
			var xPos = $('div.eL-captcha > div.eL-where2go').offset().left - 5;
			var yPos = $('div.eL-captcha > div.eL-where2go').offset().top;
			var wDim = $('div.eL-captcha > div.eL-where2go').width();
			var hDim = $('div.eL-captcha > div.eL-where2go').height();
			var iwDim = $(this).width();
			var ihDim = $(this).height();

			//-- If it was dragged already to the droppable zone, move it back to the beginning
			if ($(this).css('position') == 'absolute') {
				if (!$('#' + vCVals.n).length) {
					return false;
				}
				if ($('#' + vCVals.n).val() == $(this).data('value')) {
					$('#' + vCVals.n).remove();
				}

				$(this).css({
					'position': 'relative',
					'left': 'auto',
					'top': 'auto'
				} );
			} else {
				if ($('#' + vCVals.n).length) {
					return false;
				}
				var validElement = '<input type="hidden" name="' + vCVals.n + '" id="' + vCVals.n + '" readonly="readonly" value="' + $(this).data('value') + '" />';
				$('#' + vCVals.f).append(validElement);

				var xPos2Go = Math.round(xPos + (wDim/2) - (iwDim/2));
				var yPos2Go = Math.round(yPos + (hDim/2) - (ihDim/2));

				$(this).css( {
					'position': 'absolute',
					'left': xPos2Go,
					'top': yPos2Go
				} );
			}
		} );
	}
});