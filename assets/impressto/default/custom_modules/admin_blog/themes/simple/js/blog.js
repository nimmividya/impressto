

var psblog = appbase.extend({

	construct: function() {
		
		//alert(this.sortorder);
		
	},
	
	
	changepage: function (page){
		
		var url = "/en/blog/?blog_pager=" + page;
		document.location = url;
		
	},
	

	process_search: function(){
	
	
	
	},



	openarticle: function(blog_id){

		
	
	}
	

	
});




var ps_blog = new psblog();


$(function() {


		
});

