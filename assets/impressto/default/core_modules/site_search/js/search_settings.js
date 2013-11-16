
var pssearch_settings = appbase.extend({


construct: function() {
		//alert(this.sortorder);
	},
	

	savesettings : function(){
	

		var url = "/site_search/savesettings";
			
		$( '#ajaxLoadAni' ).slideDown( 'slow' );
				
		$.post(url, $("#searchadmin_form").serialize(), function(){
		
			$( '#ajaxLoadAni' ).slideUp( 'slow');
			
		
		});


				
	}
	


	
});




var ps_search_settings = new pssearch_settings();



$(document).ready(function(){

	$( '#crudTabs' ).tabs({
        fx: { height: 'toggle', opacity: 'fadeIn' },
		select: function(event, ui) { 
		
			
			if ( $('#' + ui.panel.id).attr('rel') ) {

				location.href = $('#' + ui.panel.id).attr('rel');
			}
			
						 
		}
		
    }).fadeIn();
	
	
});
