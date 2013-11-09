
var language_togglemanagerbase = appbase.extend({


	construct: function() {
	
	},
		

	save_settings : function(){
	
		$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
		var url = "/language_toggle/save_settings/";
		

		$.ajax({
			url: url,
			type: 'POST',
			data: $('#language_toggle_management_form').serialize(),
			dataType: 'json',
			success: function( data ) {
			
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
					
			}
		});

	
	}


	
});




var ps_language_toggle_manager = new language_togglemanagerbase();



$(document).ready(function(){


});
