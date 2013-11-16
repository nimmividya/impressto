
var tagsmanagerbase = appbase.extend({


	construct: function() {
	
	},
		

	show_tag_cloud_form : function(){
		
		$('#tag_cloud_name').val('');
		$('#tag_cloud_template').val('');
		$('#tag_cloud_content_module').val('');
		
		$('#new_tagcloud_widget_button_div').fadeOut( function(){
		
			$('#tag_cloud_builder_div').fadeIn();
		});
		
	

		
		
		
	},
	
	cancel_widget :  function(){
	
		$('#tag_cloud_builder_div').fadeOut( function(){
		
			$('#new_tagcloud_widget_button_div').fadeIn();
		});
	},
	
	
	save_widget :  function(){
	
		if(!$("#tag_cloud_widget_form").valid()) return;
			
	
		var url = "/tags/admin_remote/save_widget/";
		
				
		$( '#ajaxLoadAni' ).slideDown( 'slow' );
		

		$.ajax({
			type: 'POST',
			url: url,
			data: $('#tag_cloud_widget_form').serialize(),
			success: function(){
			
				url = "/tags/admin_remote/reload_widgetlist";
				
				$('#cloud_widget_list_div').load(url, function(){
			
					$( '#ajaxLoadAni' ).slideUp( 'slow' );
						
					$('#tag_cloud_builder_div').fadeOut( function(){
		
						$('#new_tagcloud_widget_button_div').fadeIn();
					});
						
	
				});
					
			
					
							
			}
		});
		

	},
	
	delete_widget : function(widget_id){
	
		if (confirm("Delete this widget?")) { 
		
			$( '#ajaxLoadAni' ).slideDown();
					
		
			$.ajax({
				type: "POST",
				url: "/tags/admin_remote/delete_widget/" + widget_id,
				success: function(msg){
					
					url = "/tags/admin_remote/reload_widgetlist";
					
					$('#cloud_widget_list_div').load(url, function(){
			
							$( '#ajaxLoadAni' ).slideUp( 'slow' );
	
					});
				
				}
			});
			
		}
			
	
	},
	
	
	
	save_settings : function(){
	
		$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
		var url = "/tags/admin_remote/save_settings/";
		

		$.ajax({
			url: url,
			type: 'POST',
			data: $('#tags_management_form').serialize(),
			dataType: 'json',
			success: function( data ) {
			
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
					
			}
		});

	
	}


	
});




var ps_tags_manager = new tagsmanagerbase();



$(document).ready(function(){


	$.validator.setDefaults({
		ignore: '' // WYSIWYG hack. This tells the validator to not ignore hidden fields (set by WYSIWYG editors).
	});


	$('#tag_cloud_widget_form').validate({
	
	    rules: {
			
	      tag_cloud_name : { // for now we will only make the english fields required
	        minlength: 2,
	        required: true
	      },
		  
	      tag_cloud_template : {
	        required: true
	      },
		  
		  
	      tag_cloud_content_module : {
	        required: true
	      }
  
  
  
		  		  		  
	    },
	    highlight: function(label) {
	    	$(label).closest('.control-group').addClass('error');
	    },
	    success: function(label) {
	    	label
	    		.text('OK!').addClass('valid')
	    		.closest('.control-group').addClass('success');
	    }
	  });
	  
	  
	  
	$( '#crudTabs' ).tabs({
		fx: { height: 'toggle', opacity: 'fadeIn' }
	}).fadeIn();
	
	
	

});
