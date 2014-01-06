
var commentobase = appbase.extend({


	construct: function() {
			
		
	},
	
	
	show_comments : function(){
	
		$('.show_commentos_link').slideUp(function(){
			$('#commento_wrapper').slideDown(function(){
				$('.hide_commentos_link').fadeIn();
				
			});	
		});	
			
	},
	
	
	hide_comments : function(){
	
		$('.hide_commentos_link').slideUp(function(){
			$('#commento_wrapper').slideUp(function(){
				$('.show_commentos_link').fadeIn();
			});	
		});	
	
	},
	
	
	
});

var commento = new commentobase();



$(document).ready(function(){
	
	/* The following code is executed once the DOM is loaded */
	
	// Configure your application path please. This is where it's located the Commento files (mainly commento.processor.php and commento_captcha.php)
	var commentoPostUrl	= "/commento/remote/";
	
	// First get all the configuration variables from comment.class.php
	$.post(commentoPostUrl+'processor/?type=getConfig',function(data) {
		// config vars
		maxCharsAllowed 		= data.maxchars;
		maxReplyCharsAllowed 	= data.replymaxchars;
		theDisplayOrder 		= data.display_order;
		// translatable strings
		L_WORKING 				= data.L_WORKING;
		L_SUBMIT 				= data.L_SUBMIT;
		L_YESREM 				= data.L_YESREM;
		L_NO 					= data.L_NO;
		L_REMOVE 				= data.L_REMOVE;
		L_YESAPP 				= data.L_YESAPP;
		L_APPROVE 				= data.L_APPROVE;
		L_LOADING 				= data.L_LOADING;
		L_REPLY 				= data.L_REPLY;
		L_CANCELREPLY 			= data.L_CANCELREPLY;
	},'json');
	
	
	// ACTIVATE reply and admin links
	function activate_replies() {
		$('.reply_btn').each(function(index) {
			$(this).fadeIn("fast");
		});
		$('.admin_tools').each(function(index) {
			$(this).fadeIn("fast");
		});
	}
	activate_replies();
	
	
	// ACTIVATE COMMENT FORM
	function activate_forms() {
		$('.no_javascript_no_form').hide();
		$('.yes_javascript_yes_form').fadeIn();
	}
	activate_forms();
	
	
	
	// Now we set a flag that will prevent multiple submits
	var working = false;
	
	
	/***********************************************
			COMMENT AND REPLY FORM SUBMITS
	***********************************************/
	
	// Comment form submit listener
	$('#addCommentForm').live('submit', function(e){

 		e.preventDefault();
		if(working) return false;
		
		working = true;
		$('#submit').val(L_WORKING);
		$('span.error').remove();
		
		/* Sending the form fileds to commento.processor.php: */
		$.post(commentoPostUrl+'processor/?type=comment',$(this).serialize(),function(msg){

			working = false;
			$('#submit').val(L_SUBMIT);
			
			if(msg.status){

				/*  If the insert was successful, add the comment below the last comment */
				if (theDisplayOrder == "DESC") {
					if ($(".comment:first").length != 0) {
						$(msg.html).hide().insertBefore('.comment:first').slideDown();
					} else {
						$("#commento_container").find("p:first").remove();
						$(msg.html).hide().insertBefore('#addCommentContainer').slideDown();
					}
					
					offsett = $('.comment:first').offset();
					offsett = offsett.top - 500;
					$('html,body').animate({scrollTop: offsett},'fast');
					
				} else {
					if ($(".commento_bottom_paginator").length != 0) {
						$(msg.html).hide().insertBefore('.commento_bottom_paginator').slideDown();
					} else {
						$(msg.html).hide().insertBefore('#addCommentContainer').slideDown();
					}
				}
				$('#body').val('');
				$('.comment_char_counter').html(maxCharsAllowed);
				$(".commento_captcha_img").attr("src", commentoPostUrl+'commento_captcha/?'+Math.random()).animate({ opacity: 1 }, 500);
				
			} else {

				/* If there were errors, loop through the msg.errors object and display them on the page appending spans */
				$.each(msg.errors,function(k,v){
					if ((k.substring(0, 13) == "reply_content_id_") || (k == "content_id") || (k.substring(0, 13) == "reply_parent_") || (k == "parent")) {
						$('#addCommentForm').find('#'+k).insertAfter('<span class="error">'+v+'</span>');
					} else {
						$('#addCommentForm').find('label[for='+k+']').append('<span class="error">'+v+'</span>');
					}
				});
			}
			
		},'json');
		
	});
	
	
	
	// Reply form submit listener
	$('.addReplyForm').live('submit', function(e){
 		e.preventDefault();
		
		parentID = $(this).attr('id');
		parentID = parentID.substring(16);
		
		if(working) return false;
		
		working = true;
		$('#reply_submit_'+parentID).val(L_WORKING);
		$('span.error').remove();
		
		// Sending the form fileds to commento.processor.php:
		$.post(commentoPostUrl+'processor/?type=reply&id='+parentID+'',$(this).serialize(),function(msg){

			working = false;
			$('#reply_submit_'+parentID).val(L_SUBMIT);
			
			if(msg.status){
				//  If the insert was successful, add the comment below the last one (from this replies list)
				if ($('.to_'+parentID+':last').length != 0) {
					$(msg.html).hide().insertAfter('.to_'+parentID+':last').slideDown();
				} else {
					$(msg.html).hide().insertAfter('.id_'+parentID+'').slideDown();
				}
				
				
				// Set the textarea to blank
				$('#reply_body_'+parentID).val('');
				
				$('#rpl_count_'+parentID).html(maxReplyCharsAllowed);
				
				$('#replyto_'+parentID).html(L_REPLY);
				$('#replyto_'+parentID).removeClass("cancel_reply");
				$('#replyto_'+parentID).addClass("reply_btn");
				
				$('#rplcont_'+parentID).slideUp("fast", function() {
					offsett = $('.to_'+parentID+':last').offset();
					offsett = offsett.top;
					offsett = offsett - 50;
					if (offsett > 100) {
						$('html,body').animate({scrollTop: offsett},'slow');
					}
				});
				
				$(".commento_captcha_img").attr("src", commentoPostUrl+'commento_captcha/?'+Math.random()).animate({ opacity: 1 }, 500);
				
			} else {
				// If there were errors, loop through the msg.errors object and display them on the page appending spans
				$.each(msg.errors,function(k,v){
					if ((k.substring(0, 13) == "reply_content_id_") || (k == "content_id") || (k.substring(0, 13) == "reply_parent_") || (k == "parent")) {
						$('#addCommentReply_'+parentID).find('#'+k).insertAfter('<span class="error">'+v+'</span>');
					} else {
						$('#addCommentReply_'+parentID).find('label[for='+k+']').append('<span class="error">'+v+'</span>');
					}
				});
			}
			
		},'json');
		
		
	});
	
	
	
	
	/***********************************************
			COMMENT AND REPLY MAX CHAR COUNTER
	***********************************************/
	
	// first get the original color value
	C_originalColor = $('.comment_char_counter').css("color");
	// Comment form maximun character counter
	$('#body').keyup(function() {
		var len = this.value.length;
		if (len >= maxCharsAllowed) {
			this.value = this.value.substring(0, maxCharsAllowed);
			$('.comment_char_counter').css("color", "red");
		} else {
			$('.comment_char_counter').css("color", C_originalColor);
		}
		$('.comment_char_counter').text(maxCharsAllowed - len);
	});
	
	
	// first get the original color value
	R_originalColor = $('.reply_char_counter').css("color");
	// Reply form maximun character counter
	$('.reply_text_area').keyup(function() {
		
		parentID 	= $(this).attr("id");
		parentID 	= parentID.substring(11);
		counterSpan = "#rpl_count_" + parentID;
		
		var len = this.value.length;
		if (len >= maxReplyCharsAllowed) {
			this.value = this.value.substring(0, maxReplyCharsAllowed);
			$(counterSpan).css("color", "red");
		} else {
			$(counterSpan).css("color", R_originalColor);
		}
		$(counterSpan).text(maxReplyCharsAllowed - len);
	});
	
	
	
	
	
	/***********************************************
				REPLY BUTTONS INTERFACE
	***********************************************/
	
	// Reply button click listener
	$('.reply_btn').live('click', function(e) {
		
		e.preventDefault();
		
		parentID = $(this).attr("id");
		parentID = parentID.substring(8);
		
		$(this).html(L_CANCELREPLY);
		$(this).addClass("cancel_reply");
		$(this).removeClass("reply_btn");
		
		$('#rplcont_'+parentID).slideDown();
		
	});
	
	
	// Cancel Reply button click listener
	$('.cancel_reply').live('click', function(e) {
		
		e.preventDefault();
		
		parentID = $(this).attr("id");
		parentID = parentID.substring(8);
		
		$(this).html(L_REPLY);
		$(this).removeClass("cancel_reply");
		$(this).addClass("reply_btn");
		
		$('#rplcont_'+parentID).slideUp();
		
	});
	
	
	
	
	
	
	/***********************************************
				ADMIN BUTTONS INTERFACE
	***********************************************/
	
	// Remove comment button listener
	$('.remove_btn').live('click', function(e) {
		e.preventDefault();
		parentID = $(this).attr("id");
		parentID = parentID.substring(8);
		$(this).hide().html(L_YESREM).fadeIn("normal");
		$('<a class="do_not_remove" id="do_not_remove_'+parentID+'" href="#">'+L_NO+'</a>').insertAfter(this);
		$(this).removeClass("remove_btn").addClass("really_remove_btn");
	});
	
	
	// DO NOT Remove comment button listener
	$('.do_not_remove').live('click', function(e) {
		e.preventDefault();
		parentID = $(this).attr("id");
		parentID = parentID.substring(14);
		$("#rem_btn_"+parentID).addClass("remove_btn").removeClass("really_remove_btn");
		$("#rem_btn_"+parentID).hide().html(L_REMOVE).fadeIn("normal");
		$(this).remove();
	});
	
	
	// REALLY comment button listener
	$('.really_remove_btn').live('click', function(e) {
		e.preventDefault();
		parentID = $(this).attr("id");
		parentID = parentID.substring(8);
		// Sending the request to commento.processor.php:
		$.post(commentoPostUrl+'processor/?type=rem&id='+parentID+'', function(msg){
			if(msg.status){
				// Set the textarea to black
				$('.id_'+parentID).slideUp();
			} else {
				// If there were errors, alert
				alert(msg.error);
			}
		},'json');
		
	});
	
	
	// Approve comment button listener
	$('.aprove_btn').live('click', function(e) {
		e.preventDefault();
		parentID = $(this).attr("id");
		parentID = parentID.substring(8);
		$(this).hide().html(L_YESAPP).fadeIn("normal");
		$('<a class="do_not_approve" id="do_not_approve_'+parentID+'" href="#">'+L_NO+'</a>').insertAfter(this);
		$(this).removeClass("aprove_btn").addClass("really_aprove_btn");
	});
	
	
	// DO NOT Remove comment button listener
	$('.do_not_approve').live('click', function(e) {
		e.preventDefault();
		parentID = $(this).attr("id");
		parentID = parentID.substring(15);
		$("#apr_btn_"+parentID).addClass("aprove_btn").removeClass("really_aprove_btn");
		$("#apr_btn_"+parentID).hide().html(L_APPROVE).fadeIn("normal");
		$(this).remove();
	});
	
	
	// REALLY Approve comment button listener
	$('.really_aprove_btn').live('click', function(e) {
		e.preventDefault();
		parentID = $(this).attr("id");
		parentID = parentID.substring(8);
		// Sending the request to commento.processor.php:
		$.post(commentoPostUrl+'processor/?type=app&id='+parentID+'', function(msg){
			if(msg.status){
				$(".id_"+parentID).removeClass("not_accepted_comment");
				$("#apr_btn_"+parentID).hide();
				$("#do_not_approve_"+parentID).hide();
			} else {
				// If there were errors, alert
				alert(msg.error);
			}
		},'json');
	});
	
	
	
	/***********************************************
				PAGINATION INTERFACE
	***********************************************/
	
	
	// Get what page id are we showing
	ajaxPage_content_type = $("input#content_type_value").val();
	ajaxPage_content_id = $("input#content_id_value").val();
	
	// Loading info show function
	function loading_show() {
		$('#commento_container').html('<div class="loading_content">'+L_LOADING+'</div>').hide().fadeIn('fast');
	}
	
	// Main load data function
	function loadData(ajaxPage_content_type, ajaxPage_content_id, page, ipp) {
		$.ajax({
			type: "POST",
			url: commentoPostUrl+"processor/?type=ajax_paginate",
			data: "content_type=" + ajaxPage_content_type + "&content_id="+ajaxPage_content_id+"&coms_page="+page+"&ipp="+ipp,
			success: function(msg) {
				$("#commento_container").html(msg).hide().fadeIn(500,function(){
					activate_replies();
				});
				activate_forms();
			}
		});
	}
	
	// A simple timer before calling the above loadData function
	function startLoadData(ajaxPage_content_type, ajaxPage_content_id, page, ipp) {
		loading_show();
		window.setTimeout(function() {
			loadData(ajaxPage_content_type, ajaxPage_content_id, page, ipp);
		}, 1000);
		
	}
	
	// Pagination link listener
	$('.commento_paginator > a').live('click',function(e){
	
		e.preventDefault();
		
		var ajaxPage_content_type = $('#content_type_value').val();
		var ajaxPage_content_id = $('#content_id_value').val();
		
		var page = getParameterByName($(this).attr("href"), "coms_page");
		var ipp = getParameterByName($(this).attr("href"), "ipp");

		
		startLoadData(ajaxPage_content_type, ajaxPage_content_id, page, ipp);
	});
	
	// Function to extract a parameter from a given url
	function getParameterByName(url, name) {
		name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
		var regexS = "[\\?&]"+name+"=([^&#]*)";
		var regex = new RegExp( regexS );
		var results = regex.exec(url);
		if( results == null )
			return "";
		else
			return decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	
	
	
	
	/***********************************************
				CAPTCHA SYSTEM FUNCTIONS
	***********************************************/
	
	// Comment Change captcha image button listener
	$('.commento_change_image_comm').live('click',function(e){
		e.preventDefault();
		$('.commento_captcha_img_comm').animate({
			opacity: 0.25
		}, 20., function() {
			$(".commento_captcha_img").attr("src", commentoPostUrl+'commento_captcha/?'+Math.random()).animate({ opacity: 1 }, 500);
			$('#commento_anti_bot_input').focus();
		});
	});
	
	
	// Reply Change captcha image button listener
	$('.commento_change_image_repl').live('click',function(e){
		e.preventDefault();
		parentID 	= $(this).attr("id");
		parentID 	= parentID.substring(8);
		$('.cci_rpl_'+parentID).animate({
			opacity: 0.25
		}, 20., function() {
			$(".commento_captcha_img").attr("src", commentoPostUrl+'commento_captcha/?'+Math.random()).animate({ opacity: 1 }, 500);
			$('#commento_anti_bot_input_'+parentID).focus();
		});
	});
	
	
	
	
	
	/***********************************************
				KARMA SYSTEM FUNCTIONS
	***********************************************/
	
	// Main Karma Vote function
	function karmaSetVote(ID, voteUPorDOWN) {
		$.post(commentoPostUrl+'processor/?type=karma_vote&ID='+ID+'&voteUPorDOWN='+voteUPorDOWN, function(data) {
			working = false;
			if (data.status) {
				$("#karma_"+ID).hide().removeClass().addClass("karma").addClass(data.state_class).html(data.final_karma).fadeIn("slow");
				$("#karma_msg_"+ID).addClass("karma_msg_success").hide().html(data.message).fadeIn("slow").delay(2000).fadeOut("fast");
			} else {
				$("#karma_msg_"+ID).addClass("karma_msg_error").hide().html(data.message).fadeIn("slow").delay(2000).fadeOut("fast");
			}
		},'json');
	}
	
	
	// Karma vote UP button listener
	$('.vote_up').live('click',function(e){
		e.preventDefault();
		if(working) return false;
		working = true;
		ID 	= $(this).attr("id");
		ID 	= ID.substring(14);
		karmaSetVote(ID, "up");
	});
	
	
	// Karma vote DOWN button listener
	$('.vote_down').live('click',function(e){
		e.preventDefault();
		if(working) return false;
		working = true;
		ID 	= $(this).attr("id");
		ID 	= ID.substring(16);
		karmaSetVote(ID, "down");
	});
	
	
	
});