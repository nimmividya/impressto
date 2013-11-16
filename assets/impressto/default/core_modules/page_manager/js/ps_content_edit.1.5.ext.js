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
			
				$('#page_tags_div, #search_fields_div').show();
				
			}else{

				$('#page_tags_div, #search_fields_div').hide();
		
				
			}
		
		
		},
		

		/**
		* when user selects a new template, this will show a thumbnail if it exists
		*
		*/		
		showtemplatethumb : function(obj){
		
			var nothumbimg = ps_base.templateurl + "/thumbs/" + ps_base.projectnum + "/nothumb.png";
			
			var template_file = obj.value;
						
			template_file = template_file.replace(".php",""); 
			

		
			if(obj.id == "Template"){
			
			
				var thumbimg = ps_base.templateurl + "/thumbs/" + ps_base.projectnum + "/pages/desktop/" +  template_file + ".png";
					
				//alert(thumbimg);
					
				$('#template_preview_thumb').attr('src', thumbimg);
					
				var image_exists = true;
				$('#template_preview_thumb').error(function() {
					image_exists = false;
					$('#template_preview_thumb').attr('src', nothumbimg);
				});
				
				if(image_exists) $('#template_preview_thumb').show();

			
				
			}else if(obj.id == "MobileTemplate"){
						
				var thumbimg = ps_base.templateurl + "/thumbs/" + ps_base.projectnum + "/pages/mobile/" +  template_file + ".png";
								
				$('#mobile_template_preview_thumb').attr('src', thumbimg);
				
				var image_exists = true;
				$('#mobile_template_preview_thumb').error(function() {
					image_exists = false;
					$('#mobile_template_preview_thumb').attr('src', nothumbimg);
				});
				
				if(image_exists) $('#mobile_template_preview_thumb').show();
			
			}
		
		
			
		
		},
		
		
		
		remove_featured_image : function(media){
		
			$( '#ajaxLoadAni' ).slideDown( 'slow' );
			
			var page_id = $('#page_id').val();
			
			if(page_id == "") return;
					
			var url = "/page_manager/admin_remote/remove_featured_image/" + page_id + "/" + this.language + "/" + media;
			
						
			$.get(url, function(data) {
			
				if(media == "mobile"){
					$('#mobile_featured_image_preview').hide();
					$('#mobile_featured_image').val('');
					
				}else{
					$('#featured_image_preview').hide();
					$('#featured_image').val('');
				}
								
				
			
				$( '#ajaxLoadAni' ).slideUp( 'slow'); 
				
			});
			
		}
		
		
		
		
		
		
	});
	
var pscontentedit = new pscontenteditor_ext();


$(function() {
		
});
	
	
	