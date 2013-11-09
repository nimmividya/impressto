// if this extended file exists it will be autoloaded by the asset manager

var pscontenteditor_ext = pscontenteditor.extend({

		quickupdate : false,
		language : '',
				
		
		construct: function() {
		
			//alert(this.sortorder);
		
		},
		
		
		
		
		/**
		* makes font color of tags white so they appear to be gone
		*
		*/
		whiteout_tags: function(){
		

			if( $('#Searchable').is(':checked') ){
			
				$('#page_tags_div').show();
				
			}else{

				$('#page_tags_div').hide();
				
			}
		
		
		}
		
		
		
	});
	
var pscontentedit = new pscontenteditor_ext();


$(function() {


			
			
});
	
	
	