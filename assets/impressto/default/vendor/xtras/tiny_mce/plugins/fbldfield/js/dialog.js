tinyMCEPopup.requireLangPack();

var FBLDFieldDialog = {
	init : function() {
	
		var f = document.forms[0];

		// Get the selected contents as text and place it in the input
		//f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.selected_fbldfield.value = ''; //tinyMCEPopup.getWindowArg('some_custom_arg');
		
		//alert('huh');
		
	},

	insert : function() {
		// Insert the contents from the input into the document
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, document.forms[0].selected_fbldfield.value);
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(FBLDFieldDialog.init, FBLDFieldDialog);


function assign_fbldfield(field_id, slug){

	$('#selected_fbldfield').val(slug);
	
	$('#fbldfield_list_div td').each(function() {
		  
		$(this).removeClass("fbldfield_item_selector_active");
		
		  		  
      });
	  
	  
	  $('#fbldfield_selector_item_' + field_id).addClass("fbldfield_item_selector_active");
	 	 
	 
}
