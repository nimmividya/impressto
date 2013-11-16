

// this is for tinymce language specific page lists
var ps_editorlang = '';

/////////////////////////////////////
// page base class
var appbase = appclass.extend({

	lang : 'en',
	ismobile : 'false', // is this a mobile user
	domobile : 'false', // if this is a mobile user, does the user want to remain on the mobile site
	appname : '', // can be changed
	asseturl : '/assets/', // can be changed
	projectnum : '', // can be changed

	
	
	

	construct: function() {

	
	},
	
	checkIsNumeric: function(val){
		
		return jQuery.isNumeric( val );
				
	},
		

	/**
	* @param state - true = mobile, false = desktop
	* @param location - destination on alternate site
	*/
	setmobile : function(state, url){
	
		$.cookie('domobile',state, { path: '/'}); 
		
		if(url == ""){
			parent.location.hash = '';
			window.location.href=window.location.href.slice(0, -1);
		}else{
	
			window.location.href=url;
		}

		
		
		
	},
	
	// The jQuery cookie plugin is bunk! This is a simple replacement.
	setCookie: function(c_name,c_value,c_expiredays){

		var exdate=new Date();
		exdate.setDate(exdate.getDate()+c_expiredays);
		document.cookie=c_name+ "=" +escape(c_value)+ ((c_expiredays==null) ? "" : ";expires="+exdate.toGMTString());
	
			
	},
	
	// The jQuery cookie plugin is bunk! This is a simple replacement.
	getCookie: function(name){
		
		name += '=';
		var parts = document.cookie.split(/;\s*/);
		for (var i = 0; i < parts.length; i++){
			var part = parts[i];
			if (part.indexOf(name) == 0)
				return part.substring(name.length)
		}
		
		return null;
		
	},
	
	// needed for AjaxFileManager	
	updatetarget: function(field,value){
	
	
		$("#" + field).val(value);
	},
		
		
	showinfobar : function (bShow){

	document.cookie = "showinfobar=" + (bShow ? "Y" : "N") + "; expires=Thu, 31 Dec 2035 23:59:59 GMT; path=/;";

	ctlInfoBar = document.getElementById("infobar");
		
	if(ctlInfoBar){
		if(bShow){
			jQuery("#infobar").slideDown();
		}else{
			jQuery("#infobar").slideUp();
		}
	}
},


togglevisibility: function(obj_id) {

		var obj = document.getElementById(obj_id);

		if(obj) {

			if(obj.style.display == '') {
				obj.style.display='none';
			}else{
				obj.style.display='';
			}
		}
		
	},
	
	
	
	popupwindow : function (settings){
	
	
		/* example 
			var settings = { 
			
				"centerBrowser" : 1, // center window over browser window? {1 (YES) or 0 (NO)}. overrides top and left
				"centerScreen" : 1, // center window over entire screen? {1 (YES) or 0 (NO)}. overrides top and left
				"height" :800, // sets the height in pixels of the window.
				"left" :0, // left position when the window appears.
				"location" :0, // determines whether the address bar is displayed {1 (YES) or 0 (NO)}.
				"menubar" :0, // determines whether the menu bar is displayed {1 (YES) or 0 (NO)}.
				"resizable" :0, // whether the window can be resized {1 (YES) or 0 (NO)}. Can also be overloaded using resizable.
				"scrollbars" :0, // determines whether scrollbars appear on the window {1 (YES) or 0 (NO)}.
				"status" :0, // whether a status line appears at the bottom of the window {1 (YES) or 0 (NO)}.
				"width" :1000, // sets the width in pixels of the window.
				"windowName" : "PS Preview", // name of window set from the name attribute of the element that invokes the click
				"windowURL" : "/" + this.language + "/archive_preview::" + id, // url used for the popup
				"top" :0, // top position when the window appears.
				"toolbar" : 0 // determines whether a toolbar (includes the forward and back buttons) is displayed {1 (YES) or 0 (NO)}.
			
			};
			
		*/
		
		var windowFeatures =    'height=' + settings.height +
								',width=' + settings.width +
								',toolbar=' + settings.toolbar +
								',scrollbars=' + settings.scrollbars +
								',status=' + settings.status + 
								',resizable=' + settings.resizable +
								',location=' + settings.location +
								',menuBar=' + settings.menubar;
								
		settings.windowName = settings.windowName;
		settings.windowURL = settings.windowURL;
				
		var centeredY,centeredX;
			
		if(settings.centerBrowser){
						
			if ($.browser.msie) {//hacked together for IE browsers
				centeredY = (window.screenTop - 120) + ((((document.documentElement.clientHeight + 120)/2) - (settings.height/2)));
				centeredX = window.screenLeft + ((((document.body.offsetWidth + 20)/2) - (settings.width/2)));
			}else{
				centeredY = window.screenY + (((window.outerHeight/2) - (settings.height/2)));
				centeredX = window.screenX + (((window.outerWidth/2) - (settings.width/2)));
			}
				
			window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + centeredX +',top=' + centeredY).focus();
				
		}else if(settings.centerScreen){
			centeredY = (screen.height - settings.height)/2;
			centeredX = (screen.width - settings.width)/2;
			window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + centeredX +',top=' + centeredY).focus();
		}else{
			window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + settings.left +',top=' + settings.top).focus();	
		}
			
	},
	
	/**
	* this assumes the loading div is on the page
	*
	*/
	slowspinner: function(){

		$("#ajaxLoadAni")
			.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
	
	
	}
	


});

var ps_base = new appbase();


