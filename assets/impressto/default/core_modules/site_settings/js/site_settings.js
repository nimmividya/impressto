

var sitesettings = appbase.extend({
	
	
		construct: function() {
		
		},
		
		save : function(cat_id){
				
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			var url = "/site_settings/save_settings";
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
		},
		
		select_site_admin : function(obj){
		
			$('#site_admin').val(obj.value);

				
	
	}



	
});




var site_settings = new sitesettings();





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


