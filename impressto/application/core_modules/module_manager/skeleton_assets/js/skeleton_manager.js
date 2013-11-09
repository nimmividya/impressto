
var __skeleton_name__managerbase = appbase.extend({


	construct: function() {
	
	},
		

	save_settings : function(){
	
		$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
		var url = "/__skeleton_name__/save_settings/";
		

		$.ajax({
			url: url,
			type: 'POST',
			data: $('#__skeleton_name___management_form').serialize(),
			dataType: 'json',
			success: function( data ) {
			
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
					
			}
		});

	
	}


	
});




var ps___skeleton_name___manager = new __skeleton_name__managerbase();



$(document).ready(function(){


});
