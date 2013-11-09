
//jQuery.noConflict();

var pbp_manager = appbase.extend({


		
		construct: function() {
		
			//alert(this.sortorder);
		
		}
		
	
		
		
	});
	
var pbpmanager = new pbp_manager();
	


var jcrop_api = ''; // Holder for the API
var current_crop_imagename = '';
var current_crop_thumbname = ''; // holds the url of the thumbnail


function edit_bgp_item(item_id){


	var url = "/bg_pos_slider/edit/" + item_id;
	
	jQuery.ajax({
url: url,
dataType: 'json',
success: function( data ) {
			
			console.log(data.content);
			
			jQuery('#s_edit_id').val(data.id);
			jQuery('#s_title').val(data.title);
			jQuery('#s_leftpos').val(data.leftpos);
			jQuery('#s_content').val(data.content);
			jQuery('#s_content').htmlarea("updateHtmlArea"); 
			
			jQuery('#savebutton_div').show();
			
			jQuery('#bgp_edit_form_div').slideDown(function(){

				jQuery("html, body").animate({ scrollTop: 0 }, "slow");
				
				
			});
			
		}
	});



}


function save_bgp_item(){

	jQuery('#s_content').htmlarea("updateTextArea"); 
	
	var url = "/bg_pos_slider/save/?id=" + jQuery('#s_edit_id').val();
	
	jQuery.post(url,jQuery('#bgp_edit_form').serialize(),function(result){

		console.log(result);
		
		jQuery('#s_edit_id').val('');
		jQuery('#s_title').val('');
		jQuery('#s_leftpos').val('');
		jQuery('#s_content').val('');
		jQuery('#s_content').htmlarea("updateHtmlArea"); 
		
		jQuery('#savebutton_div').fadeOut();
		
		reloadslist();
		
		jQuery('#bgp_edit_form_div').slideUp(function(){
			
			jQuery("html, body").animate({ scrollTop: jQuery(document).height() }, "slow");
			
		});
		
		
		
	});
}

function delete_bgp_item(item_id){

	var answer = confirm("Delete this item?")
	if (answer){

		
		var url = "/bg_pos_slider/delete/?id=" + item_id;
		
		jQuery.post(url,function(result){
			
			jQuery('#bgp_row_' + item_id).remove();
			jQuery("#bgs_datatable tbody tr:nth-child(2n)").addClass("odd");
			
		});
		
		
		
	}
	
}






function ajaxFileUpload(){

	jQuery("#loading")
	.ajaxStart(function(){
		jQuery(this).show();
	})
	.ajaxComplete(function(){
		jQuery(this).hide();
	});

	jQuery.ajaxFileUpload
	(
	{
url:'/bg_pos_slider/doajaxfileupload/',
secureuri:false,
fileElementId:'fileToUpload',
dataType: 'json',
data:{name:'logan', id:'id'},
success: function (data, status)
		{
			if(typeof(data.error) != 'undefined')
			{
				if(data.error != '')
				{
					alert(data.error);
					
				}else
				{		
					
					current_crop_thumbname = data.thumbname;
			

					jQuery('#thumbnail_holder_div').html('<strong>Image thumbnail</strong><br /><img id="preview_thumb" style="margin: 5px 0 0;" src="' + ps_base.asseturl + 'upload/bg_pos_slider/images/thumbs/' + data.thumbname + '"><br /><a style="margin:10px 0 0;display:inline-block;" href="javascript:insertthumb(\'' + data.thumbname  + '\')"><img src="' + ps_base.asseturl + ps_base.appname + '/default/custom_modules/bg_pos_slider/images/add_plus.png" title="Insert Image Into Editor" alt="Add" /></a>&nbsp;<a style="margin:10px 0 0 5px;display:inline-block;" href="javascript:activatecrop(\'' + data.thumbname  + '\')"><img src="' + ps_base.asseturl + ps_base.appname + '/default/custom_modules/bg_pos_slider/images/img_crop.png" title="Crop Image" alt="Crop" /></a><br />');

						
				}
			}
		},
error: function (data, status, e)
		{
			alert(e);
		}
	}
	)
	
	return false;

}


function reloadslist(){

	var url = "/bg_pos_slider/ajax_reloadlist/";

	jQuery.get(url, function(data){
		
		jQuery('#content_list_div').html(data);
		
	});
	
}

function insertthumb(thumbimg){
	
	var obj = document.getElementById('preview_thumb');
	var thumb_src = obj.src;
	
	
	var data = '<a href="' + ps_base.asseturl + 'upload/bg_pos_slider/images/' + thumbimg + '" rel="lightbox"><img border="0" src="' + thumb_src + '" alt="thumb_image" /></a>';
	
	jQuery.myCustomConfig.jhtmlareaobject[typeof jHtmlArea] = jHtmlArea;
	jQuery.myCustomConfig.jhtmlareaobject.pasteHTML(data);
	
	
}



function activatecrop(imagename){

	current_crop_imagename = imagename;
	
	if(jcrop_api == ""){

		// set the source of the image
		jQuery('#crop_box').attr('src',ps_base.asseturl + 'upload/bg_pos_slider/images/' + imagename);
		initJcrop();
		
		
	}else{
		
		jcrop_api.setImage(ps_base.asseturl + 'upload/bg_pos_slider/images/' + imagename);
		
	}
	
	centerPopup();
	//load popup
	loadPopup();
	
		
	
	//jQuery('#image_cropping_div').slideDown();
	
	
}


function savecrop_dimensions(){
	
	var url = "/bg_pos_slider/savecrop/?image=" + current_crop_imagename;
	
	url += "&x=" + jQuery('#x').val();
	url += "&y=" + jQuery('#y').val();
	url += "&w=" + jQuery('#w').val();
	url += "&h=" + jQuery('#h').val();
	
	jQuery.get(url, function(data){
		
		reloadImg('preview_thumb');
		disablePopup();
		//jQuery('#image_cropping_div').slideUp();
		
		
	});
	
}


function reloadImg(id) {

	var obj = document.getElementById(id);
	var src = obj.src;
	var pos = src.indexOf('?');
	if (pos >= 0) {
		src = src.substr(0, pos);
	}
	var date = new Date();
	obj.src = src + '?v=' + date.getTime();
	return false;
}

function updateCoords(c)
{
	jQuery('#x').val(c.x);
	jQuery('#y').val(c.y);
	jQuery('#w').val(c.w);
	jQuery('#h').val(c.h);
};


function initJcrop(){

	jQuery('#crop_box').Jcrop({aspectRatio: 1, onSelect: updateCoords},function(){
		
		jcrop_api = this;
		
		//jcrop_api.animateTo([100,100,400,300]);

	});

};



jQuery(document).ready(function() {

	var fullimage = "";
	var smallimage = "";

	jQuery("#s_content").htmlarea({
		// Override/Specify the Toolbar buttons to show
		
loaded: function() {
			jQuery.myCustomConfig = {jhtmlareaobject : this};
		},
		
toolbar: [
		["html"], ["bold", "italic", "underline", "|","unorderedList", "indent", "outdent", "|", "justifyLeft", "justifyCenter", "justifyRight","link", "unlink", "|", "image"]
		
		]
	});
	

	

});





/***************************/
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = 0;

//loading popup with jQuery magic!
function loadPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#image_cropping_div").fadeIn("slow");
		popupStatus = 1;
	}
}

//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#image_cropping_div").fadeOut("slow");
		popupStatus = 0;
	}
}

//centering popup
function centerPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#image_cropping_div").height();
	var popupWidth = $("#image_cropping_div").width();
	//centering
	$("#image_cropping_div").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	
}


//CONTROLLING EVENTS IN jQuery
$(document).ready(function(){
	
	//LOADING POPUP
	//Click the button event!
	$("#button").click(function(){
		//centering with css
		centerPopup();
		//load popup
		loadPopup();
	});
				
	//CLOSING POPUP
	//Click the x event!
	$("#popupContactClose").click(function(){
		disablePopup();
	});
	//Click out event!
	$("#backgroundPopup").click(function(){
		//disablePopup();
	});
	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});

});



