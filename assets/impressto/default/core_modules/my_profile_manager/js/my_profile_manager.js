
var my_profile_managerbase = appbase.extend({


	construct: function() {

	
	},
	
	save_profile : function(){
	
		var url = "/my_profile_manager/save_profile";
			
		$( '#ajaxLoadAni' ).slideDown( 'slow' );
		
		$.ajax({
			url: url,
			type: "POST",
			data: $('#my_profile_form').serialize(),
		}).success(function(msg) { 
		
			//$(this).addClass("done");
			//alert(msg);
			
			$( '#ajaxLoadAni' ).slideUp( 'slow' );
					
		
		});
		
	
	}
	
	
		


	
});




var ps_my_profile_manager = new my_profile_managerbase();



$(document).ready(function(){


	
});
