

var psstylesheetmanager = appbase.extend({
	
	
construct: function() {
		
		//alert(this.sortorder);
		
	},
	
	
	savecss : function(){
	
		var url = "/stylesheet_manager/admin_remote/savecss";
		
		var css = $('#css_edit_area').val();
		
		var module = $('#module_selector').val();
		var style_file = $('#css_selector').val();
		
		if(module == "" || style_file == "") return;
			
		
								
		this.slowspinner();
		
		$.post(url, { css: css, module: module, style_file: style_file }, function(data) {
			
			if(data != '') alert(data);
		
			
		});
   
		

		
				
	
	},
	
	
	setmodule : function(obj){
	
		this.slowspinner();
		
		var module = obj.value;
		
		if(module == "") {
		
			$('#savecss_button').hide();
			return;
		}
		
				
		var url = "/stylesheet_manager/admin_remote/setmodule/" + module;
		
		$('#css_selector_div').load(url, function(){
		
			$('#css_selector_div').slideDown();
						
		
		});
		
		
		
		
	
	},
	
	
	
	getstyle : function(){
	
		// load the list based on the selected category
		var module = $('#module_selector').val();
		var css = $('#css_selector').val();
		
		if( module == "" || css == "") return;
				
					
		this.slowspinner();
		
		var url = "/stylesheet_manager/admin_remote/getstyle/";

		var data = "css=" +  css;
						
		
		$.ajax({
		
			url: url,
			dataType: 'json',
			data: data,
			success: function(data) {
			
				$('#css_edit_area').val(data.css);
				
				$('#css_file_data').html('<a href="' + data.css_file + '" target="_blank">' + data.css_file + '</a>'); 
				$('#css_file_data').append('   Last Updated: ' + data.last_updated); 
				
				$('#savecss_button').show();			  
			  
			}
		});

			
		
	
	}
	
	
	


	
});




var ps_stylesheetmanager = new psstylesheetmanager();



$(function() {

	$(".lined").linedtextarea(
		{selectedLine: 1}
	);
	
	
	$(".color-picker").miniColors({
		letterCase: 'uppercase',
		change: function(hex, rgb) {
			//logData(hex, rgb);
		}
	});
	
	
		
});


	
	






	