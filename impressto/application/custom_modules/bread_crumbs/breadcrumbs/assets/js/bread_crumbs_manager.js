
var bread_crumbsmanagerbase = appbase.extend({


	construct: function() {
	
	},
		

	save_settings : function(){
	
		$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
		var url = "/bread_crumbs/save_settings/";
		

		$.ajax({
			url: url,
			type: 'POST',
			data: $('#bread_crumbs_management_form').serialize(),
			dataType: 'json',
			success: function( data ) {
			
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
					
			}
		});

	
	}


	
});




var ps_bread_crumbs_manager = new bread_crumbsmanagerbase();



$(document).ready(function(){


});
