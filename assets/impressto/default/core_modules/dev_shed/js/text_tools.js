

var texttoolsbase = appbase.extend({
	
	
		construct: function() {
		
		},
	
		
		
		random_text_selector : function(){
		
			$('#random_text_selector').show();
		},
		
		
		character_convert : function(){
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
		
			var url = "/dev_shed/remote/character_convert";
			
			$.post(url, { html: $('#text_tools_text').val() }, function(data) {
			
				$('#text_tools_text').val(data);
			
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
				
			});
		},
		
		
		inline_stripper : function(){
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
		
			var url = "/dev_shed/remote/inline_stripper";
			
			$.post(url, { html: $('#text_tools_text').val() }, function(data) {
			
				$('#text_tools_text').val(data);
			
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
				
			});
		},
		
		preview_html : function(){
		
			
			// first thing is to save this data to a temp html file
			var url = "/dev_shed/remote/write_preview_html";
			
			$.post(url, { html: $('#text_tools_text').val() }, function(targetfile) {
			
				
				var settings = { 
			
				"centerBrowser" : 1, // center window over browser window? {1 (YES) or 0 (NO)}. overrides top and left
				"centerScreen" : 1, // center window over entire screen? {1 (YES) or 0 (NO)}. overrides top and left
				"height" :600, // sets the height in pixels of the window.
				"left" :0, // left position when the window appears.
				"location" :0, // determines whether the address bar is displayed {1 (YES) or 0 (NO)}.
				"menubar" :0, // determines whether the menu bar is displayed {1 (YES) or 0 (NO)}.
				"resizable" :0, // whether the window can be resized {1 (YES) or 0 (NO)}. Can also be overloaded using resizable.
				"scrollbars" : 1, // determines whether scrollbars appear on the window {1 (YES) or 0 (NO)}.
				"status" :0, // whether a status line appears at the bottom of the window {1 (YES) or 0 (NO)}.
				"width" :900, // sets the width in pixels of the window.
				"windowName" : "PS Preview", // name of window set from the name attribute of the element that invokes the click
				"windowURL" : targetfile,
				"top" :0, // top position when the window appears.
				"toolbar" : 1 // determines whether a toolbar (includes the forward and back buttons) is displayed {1 (YES) or 0 (NO)}.
			
			};
			
				
			ps_base.popupwindow(settings);
				
			
			

				
			});
		},
		
		
		getrandomtext : function(obj){
			
			if(obj.value != ""){
			
				var url = "/dev_shed/remote/getrandomtext/" + obj.value;
				
				$.get(url, function(data){
				
						
					$('#text_tools_text').val(data);
					
				});
				
				
				
			}
			
		
		}


	
});




var texttools = new texttoolsbase();





$(document).ready(function(){


});


