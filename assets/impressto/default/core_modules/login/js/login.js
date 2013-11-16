

var psloginbase = appbase.extend({

	newspageurl : '',
	

	construct: function() {
		
		//alert(this.sortorder);
		
	},
	
		


	forgot_pass_prompt: function(){

	
		 $("#forgot_pass_promptbox").overlay().load();
		
	
	},
	
	
	cancel_forgot_pass : function(){
	
		$("#forgot_pass_promptbox").overlay().close();
	
	
	},
	
	process_forgot_pass : function(){

		
		var url = "/login/process_forgot_pass/";
		
		$.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			data: { email: $('#forgot_pass_email').val() },
			success: function( data ) {
			
				if(data.error != ""){
				
					$('#forgot_pass_error_div').html(data.error).fadeIn();
				
				}else if(data.msg != ""){
				
				
					$('#password_retreival_success_notice').show();
					$('#login_info_message').hide();					
					
									//* boxes animation
						form_wrapper = $('.login_box');
							
						target_height = $('#login_form').actual('height');
						
						$(form_wrapper).css({
							'height'		: form_wrapper.height()
						});	
						
						$(form_wrapper.find('form:visible')).fadeOut(400,function(){
							form_wrapper.stop().animate({
								height	: target_height
							},500,function(){
								$('#login_form').fadeIn(400);
								$('.links_btm .linkform').toggle();
								$(form_wrapper).css({
									'height'		: ''
								});	
							});
						});
								
				

				}

			}
		});

	
	}
	
	
});




var pslogin = new psloginbase();


$(function() {

		/*
		$("#forgot_pass_promptbox").overlay({
 
			top: 150,
			mask: {
				color: '#fff',
 				loadSpeed: 200,
 			},
 
			// disable this for modal dialog-type of overlays
			closeOnClick: false,
 
			// load it immediately after the construction
			//load: true
 
		});
		*/
		
});

