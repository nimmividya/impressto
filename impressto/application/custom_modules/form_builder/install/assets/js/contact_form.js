
var psform_builder = appbase.extend({

	construct: function() {
		
		//alert(this.sortorder);
		
	},
	
	
	submit: function (){
		
		
		$.ajax({
		type: "POST",
		url: "/form_builder/remote/submit",
		data: $('#form_builder').serialize(),
	   
	   success: function(msg){

	   }
	   
	 });
		
	}


	
});




var ps_form_builder = new psform_builder();


$(function() {


		
});




$(function() {

$(".defaultText").focus(function(srcc){
			if ($(this).val() == $(this)[0].title){
				$(this).removeClass("defaultTextActive");
				$(this).val("");
			}
		});

		$(".defaultText").blur(function(){
			if ($(this).val() == ""){
				$(this).addClass("defaultTextActive");
				$(this).val($(this)[0].title);
			}
		});
		$(".defaultText").each(function(){
			$(this).addClass("defaultTextActive");
			$(this).val(jQuery(this)[0].title);
		}); 
		$(".defaultText").blur();
		$(".file_path").val("blank");

		
	$(".date").datepicker({ dateFormat: 'dd/mm/yy',
							onSelect: function(){
								$(this).removeClass("defaultTextActive");
							}
	});
	
    $(".error").hide();
	$('.errorbox').hide();
	
	
});
	
    
