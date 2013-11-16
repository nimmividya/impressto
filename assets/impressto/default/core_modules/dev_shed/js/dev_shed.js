

var devshedbase = appbase.extend({
	
	
		construct: function() {
		
		},
		
		

		
		encrypt : function(cat_id){
				
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			var url = "/dev_shed/remote/encrypt";
				$.ajax({
					url: url,
					type: 'POST',
					data: { string: $('#ci_encryption_string').val(), hashkey: $('#ci_hash_key').val()  },
					//dataType: 'json',
					success: function( data ) {
			
						$( '#encrypt_result' ).html(data).fadeIn();
	
						$( '#ajaxLoadAni' ).slideUp( 'slow' );
						
						
					
			
					}
				});
		},
		

		decrypt : function(cat_id){
				
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			var url = "/dev_shed/remote/decrypt";
				$.ajax({
					url: url,
					type: 'POST',
					data: { string: $('#ci_encryption_string').val(), hashkey: $('#ci_hash_key').val()  },
					//dataType: 'json',
					success: function( data ) {
			
						$( '#encrypt_result' ).html(data).fadeIn();
	
						$( '#ajaxLoadAni' ).slideUp( 'slow' );
					
			
					}
				});
		},
		
		
		 password_recovery : function(cat_id){
				
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			var url = "/dev_shed/remote/decrypt";
				$.ajax({
					url: url,
					type: 'POST',
					data: { string: $('#ci_encryption_string').val(), hashkey: $('#ci_hash_key').val()  },
					//dataType: 'json',
					success: function( data ) {
			
						$( '#encrypt_result' ).html(data).fadeIn();
	
						$( '#ajaxLoadAni' ).slideUp( 'slow' );
					
			
					}
				});
		},
		
		

		
		submit_timesheet : function(){
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
		
			var url = "/dev_shed/remote/submit_timesheet";
			
			$.post(url, { entry: $('#timesheet_entry').val(), category: $('#timesheet_category').val() }, function(data) {
			
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
				
			});
		},
		
		generate_timesheet : function(){
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			var url = "/dev_shed/remote/generate_timesheet/?category=" + $('#timesheet_category').val();
			
			$.get(url, function(data) {
			
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
						
				 $('#timesheet_entry').val(data);
  			
			});
		},
		
		retrieve_password : function(){
		
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			$('#password_recovery_fail, #password_recovery_result').fadeOut(function(){
			
			
	
			
			var url = "/dev_shed/remote/retrieve_password";
		
			$.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			data: { identifier: $('#identifier').val() },
			success: function( data ) {
			
				if(data.error != ""){
				
					$('#password_recovery_fail').html(data.error).fadeIn();
				
				}else if(data.msg != ""){
				
					$( '#password_recovery_result' ).html(data.msg).fadeIn();
				
				}
				
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
				

			}
		});
		
		});
				

	
		
		},
		

		get_host_by_address : function(){
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
		
			var url = "/dev_shed/remote/get_host_by_address";
			
			$.post(url, { host_ip: $('#host_ip').val() }, function(data) {
			
				$('#host_name').val(data);
			
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
				
			});
		},
		
		
		ip_db_lookup : function(){
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
		
			var url = "/dev_shed/remote/ip_db_lookup";
			
			$.post(url, { db_lookup_ip: $('#db_lookup_ip').val() }, function(data) {
			
				$('#db_lookup_ip_info').html(data);
			
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
				
			});
		},
		
		
	
});




var devshed = new devshedbase();





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
	
	$("#host_name").focus(function(){
		this.select();
	});
	

	
});


