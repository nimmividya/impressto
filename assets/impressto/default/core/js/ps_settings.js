var pssettings = appbase.extend({

		sortorder : '',
		treenodestates : new Array(),
		construct: function() {
		
		},
		
		save : function(cat_id){
				
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			var url = "/site_settings/save";
				$.ajax({
					url: url,
					type: 'POST',
					data: $('#ps_settings_form').serialize(),
					//dataType: 'json',
					success: function( data ) {
				
						$( '#ajaxLoadAni' ).slideUp( 'slow' );
					
			
					}
				});
		},
		
		clearsmartycache : function(){
			this.slowspinner();
			var url = "/site_settings/remote/clearsmartycache";
			$.get(url);
		}
});
	
var ps_settings = new pssettings();

$(document).ready(function(){

	$( '#crudTabs' ).tabs({
        fx: { height: 'toggle', opacity: 'fadeIn' },
		select: function(event, ui) { 
			
			if(ui.panel.id == "ui-tabs-1"){
			
				//alert('yay');
				$('.footNav').fadeOut();
				
				
			}else{
				$('.footNav').fadeIn();
			
			}
			 
		}
    }).fadeIn();
	
});

