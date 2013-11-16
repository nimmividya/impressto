/**
* The extended version of a base javascript library can override
* the default functions of the parent library. Extensions are used for 
* customizing module functionality for clients without having to modify
* the core library.
*/	

var pstemplatemanager_extension = pstemplatemanager.extend({

	construct: function() {
		
	},
		
	sayhi : function(){
	
		alert('hello meathead');
		
	},


});



	
var ps_templatemanager = new pstemplatemanager_extension();




