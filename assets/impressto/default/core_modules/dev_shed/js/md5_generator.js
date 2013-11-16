

var md5generatorbase = appbase.extend({
	
	
		construct: function() {
		
		},
	
		
		
		get_md5 : function(){
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
					
					
			var url = "/dev_shed/md5_generator_widget/generate_md5";
			
			$.post(url, { unencrypted_md5: $('#unencrypted_md5').val() }, function(data) {
			
				$('#encrypted_md5').val(data);
			
				$( '#ajaxLoadAni' ).slideUp( 'slow' );
				
			});
		}
	
});




var md5generator = new md5generatorbase();





$(document).ready(function(){

	$("#encrypted_md5").focus(function(){
		this.select();
	});




});


