
var sitesearchbase = appbase.extend({


construct: function() {
		//alert(this.sortorder);
	},
	

	turnpage : function(searchpage){
	
		this.get_results(searchpage);
	
	
				
	},
	
	
	get_results : function(searchpage){
	
		
		var url = "/site_search/remote/process_search";
		
		var data = $('#site_search_form').serialize();
		if(searchpage) data += "&searchpage=" + searchpage;
			
		
		$.ajax({
		
			url: url,
			type: "POST",
			data: data,
			success: function( data ) {
			
				$('#site_search_results').html(data);
					
			}
		

		});

			
				
	},
	
	
	refresh : function(){
	
		$('#search-form-submit-btn').click();
		
	
		//('#site-search-form').submit();
		
	}
	
	


	
});




var ps_sitesearch = new sitesearchbase();


	$(document).ready(function() {
		
		//* check if thumb_view is enabled
        if($('.thumb_view').length) {
            $('.box_trgr').addClass('active');
        } else {
            $('.list_trgr').addClass('active');
        };
        
        //* toggle between list/boxes view
        $(".result_view a").click(function(e){
            if(!$(this).hasClass('active')) {
                $(".result_view a").toggleClass("active");
                $(".search_panel").fadeOut("fast", function() {
                    $(this).fadeIn("fast").toggleClass("box_view");
                });
            }
            e.preventDefault();
        });

	});