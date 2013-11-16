
// ps form class validation
// dependancy is jquery
// this should come from a lang file

var captcha_incorrect = "CAPTCHA is incorrect.";
var has_not_been_filled = "has not been filled in.";
var has_not_been_selected = "has not been selected.";
var didnt_enter_username = "You didn't enter a username.";
var username_wrong_length = "The username is the wrong length.";
var username_illegal = "The username contains illegal characters.";
var wrong_length = "is the wrong length.";
var contains_illegal = "contains illegal characters.";
var enter_valid_email = "is not a valid e-mail address.";
var illegal_email = " contains illegal characters.";
var didnt_enter_phone = "You didn't enter a phone number.";
var phone_illegal = "The phone number contains illegal characters.";
var phone_wrong_length = "The phone number is the wrong length. Make sure you included an area code.";
var not_number = "The value is not a number.";



if(ps_base.lang == "fr"){

	captcha_incorrect = "CAPTCHA is incorrect.";
	has_not_been_filled = "n'a pas été rempli.";
	has_not_been_selected = "n'a pas été sélectionn" + "&egrave;"; //piece of crap IE6 won't allow an accent on the end of a string. 
	didnt_enter_username = "Vous n'avez pas entrer un nom d'utilisateur.";

	username_wrong_length = "Le nom d'utilisateur n'est pas la bonne longueur.";
	username_illegal = "Le nom d'utilisateur contient des caractères.";
	wrong_length = "n'est pas la bonne longueur.";
	contains_illegal = "contient des caractères non autorisés.";
	enter_valid_email = "n'a pas été rempli.";
	illegal_email = " contient des caractères.";
	didnt_enter_phone = "Vous n'avez pas entrer un numéro de téléphone.";
	phone_illegal = "Le numéro de téléphone contient des caractères.";
	phone_wrong_length = "Le numéro de téléphone n'est pas la bonne longueur. Assurez-vous que vous avez inclus un code régional.";
	not_number = "The value is not a number.";
	

}

//if(!qform_validate_highlight_color) var qform_validate_highlight_color  = '#FFE25F';


function validateEmpty(fld,flabel) {
    
	var error = "";
	 
    if (fld.value.length == 0) {
        fld.style.backgroundColor = ps_form.validate_color; 
        error = flabel + " " + has_not_been_filled + "\n"
    } else {
        fld.style.backgroundColor = '';
    }
    return error;  
}


function validate_date(fld,flabel) {
	return ps_form.validate_text(fld,flabel);
}


function validate_hidden(fld,flabel) {
	return ps_form.validate_hidden(fld,flabel);
}



function validate_captcha(fld,flabel) {
	return ps_form.validate_captcha(fld,flabel);
}


////////////////////////
// legacy stuff

function validate_text(fld,flabel) {
	return ps_form.validate_text(fld,flabel);
}

function validate_file(fld,flabel) {
	return ps_form.validate_text(fld,flabel);
}

function validate_textarea(fld,flabel) {
	return ps_form.validate_textarea(fld,flabel);
}

function validate_checkbox(fld,flabel) {
	return ps_form.validate_checkbox(fld,flabel);
}

function validate_select(fld,flabel) {
	return ps_form.validate_select(fld,flabel);
}

function validate_province(fld,flabel) {
	return validate_select(fld,flabel);
}

function validate_radio(fld,flabel){
	return ps_form.validate_radio(fld,flabel);
}

function validate_multiselect(fld,flabel) {
	return ps_form.validate_multiselect(fld,flabel);
}


function validate_numeric(fld,flabel) {
	return ps_form.validate_numeric(fld,flabel);
}


function validate_multicheckbox(fld,flabel){
	return ps_form.validate_multicheckbox(fld,flabel);
}

function validateUsername(fld,flabel) {
	return ps_form.validateUsername(fld,flabel);
}

function validate_password(fld,flabel) {
	return ps_form.validate_password(fld,flabel);
} 

function validate_email(fld,flabel) {
	return ps_form.validate_email(fld,flabel);
}

function validate_phone(fld,flabel) {
	return ps_form.validate_phone(fld,flabel);
}

// end legacy stuff
///////////////////////////////



var psform = appbase.extend({

validate_color: '#FFE24F',
highlight_color: '#FFFFFF',

validate_color_rgb: '',
highlight_color_rgb: '',

valid_captcha: 'true',
validation_errors: '',

captchasuccess: '',
captchafail: '',

hascaptcha: 'false',

form_name: '',

trimstring: function (s){

  return s.replace(/^\s+|\s+$/, '');
},



divhighlight: function (opfldname){

	return;
	
	if(this.highlight_color == '') this.highlight_color = '#FFFFD1';

	var fieldrequired = '';
	var opfvalid = '';
		
	
	$('div').find('.ps_formelement').each( function(){
	
		if($(this).css('backgroundColor') != ps_form.validate_color_rgb){

			$(this).css('backgroundColor','');
				
		}
			
	});
				
			
	$("#" + opfldname + "_div").css('background-color',this.highlight_color);
	

},

setvalidstate: function (tfld_container,flabel,state,message){

	var error = '';
	
	if(tfld_container){
		if(tfld_container.style.display == 'none') return "";
	}
		
    if (state == 0) {
	
		if(tfld_container){
			$("#" + tfld_container.id).css('backgroundColor',this.validate_color);
			// this gets us the rgb value for use later ...
			this.validate_color_rgb = $("#" + tfld_container.id).css('backgroundColor');
			tfld_container.setAttribute("opfvalid", false);
		}
		
		
		if(message != ""){
			error = flabel + " " + message + "\n"
		}else{
			error = flabel + " " + has_not_been_filled + "\n"
		}
    
	} else {
	
		if(tfld_container){
			tfld_container.style.backgroundColor = '';
			tfld_container.setAttribute("opfvalid", true);		
		}
	}
	
	return error;

},


	setreadonlyonce: function(container_id,state){
	
		if(state == true || state == 1) state = "true";
		if(state == false || state == 0 || state == "") state = "false";
				
		// little fix for sloppy coders ... like me :)
		container_id = container_id.replace("_div", "");
	
		if(state == "true"){
				
			$("#" + container_id + "_div").removeClass('ps_formelement');
			$("#" + container_id + "_div").addClass('ps_formelement_disabled');
			
			if( 
				$("#" + container_id + "_div").attr('opftype') == "multicheckbox"
			){
				$("#" + container_id + "_div :input").attr('readonly', true);	

				$("#" + container_id + "_div").find('.opfieldlabel').each( function(){
					$(this).removeClass('opfieldlabel');
					$(this).addClass('opfieldlabel_disabled');		
				});
				
		
			}else{
				$('#' + container_id).attr('readonly', true);
			}
				
		}else{
		
		
			$("#" + container_id + "_div").removeClass('ps_formelement_disabled');
			$("#" + container_id + "_div").addClass('ps_formelement');
			
			if( 
				$("#" + container_id + "_div").attr('opftype') == "multicheckbox"
			){
				$("#" + container_id + "_div :input").attr('readonly', false);	

				$("#" + container_id + "_div").find('.opfieldlabel_disabled').each( function(){
					$(this).removeClass('opfieldlabel_disabled');
					$(this).addClass('opfieldlabel');		
				});
				
		


			
			
			}else{
				$('#' + container_id).attr('readonly', false);
			}
				
		}
		
			
	},
	

	setdisabilityonce: function(container_id,state){
	
		if(state == true || state == 1) state = "true";
		if(state == false || state == 0 || state == "") state = "false";
				
		// little fix for sloppy coders ... like me :)
		container_id = container_id.replace("_div", "");
	
		if(state == "true"){
		
			$("#" + container_id + "_div").removeClass('ps_formelement');
			$("#" + container_id + "_div").addClass('ps_formelement_disabled');
			
			if( 
				$("#" + container_id + "_div").attr('opftype') == "multicheckbox"
			){
				$("#" + container_id + "_div :input").attr('disabled', true);	

				$("#" + container_id + "_div").find('.opfieldlabel').each( function(){
					$(this).removeClass('opfieldlabel');
					$(this).addClass('opfieldlabel_disabled');		
				});
				
		
			}else{
				$('#' + container_id).attr('disabled', true);
			}
				
		}else{
		
		
			$("#" + container_id + "_div").removeClass('ps_formelement_disabled');
			$("#" + container_id + "_div").addClass('ps_formelement');
			
			if( 
				$("#" + container_id + "_div").attr('opftype') == "multicheckbox"
			){
				$("#" + container_id + "_div :input").attr('disabled', false);	

				$("#" + container_id + "_div").find('.opfieldlabel_disabled').each( function(){
					$(this).removeClass('opfieldlabel_disabled');
					$(this).addClass('opfieldlabel');		
				});
				
		


			
			
			}else{
				$('#' + container_id).attr('disabled', false);
			}
				
		}
		
			
	},

	setenabled: function(container_id){
	
		this.setdisabilityonce(container_id,false);
					
	},


	// this is sort of odd but necessary for now 
	setcheckabled: function(check_id,state){
		
		if(state == true || state == 1) state = "true";
		if(state == false || state == 0 || state == "") state = "false";
		
		if(state == "true"){
		
			$('#' + check_id).attr('disabled', false);
			$("#" + check_id + "_label").removeClass('opfieldlabel_disabled');
			$("#" + check_id + "_label").addClass('opfieldlabel');
			
		}else{
			$('#' + check_id).attr('disabled', true);
			$("#" + check_id + "_label").removeClass('opfieldlabel');
			$("#" + check_id + "_label").addClass('opfieldlabel_disabled');			
		}
		
					
	},
	
	

	setreadonly: function(container_id){
		
		this.setreadonlyonce(container_id,true);
		this.setrequiredonce(container_id,false);
		
			
	},
	
	setdisabled: function(container_id){
		
		this.setdisabilityonce(container_id,true);
		this.setrequiredonce(container_id,false);
		
			
	},
	

	setrequiredonce: function(container_id,state){
	
		if(state == true || state == 1) state = "true";
		if(state == false || state == 0 || state == "") state = "false";
		
		
		// little fix for sloppy coders ... like me :)
		container_id = container_id.replace("_div", "");
		
		$("#" + container_id + "_div").attr('opfrequired',state);
		
			
	
			
	},

	
	setrequired: function(container_id,state){
	
		if(state == true || state == 1) state = "true";
		if(state == false || state == 0 || state == "") state = "false";
		
		this.setrequiredonce(container_id,state);
				
		if(state == "true"){
		
			this.setdisabilityonce(container_id,false);
		}		
				
	
			
	},
	
	
	checkdovalidate: function(obj_id){
	
	
		var myobj = $("#" + obj_id);
		var fielddivid = $(myobj).attr("id");
		var fieldid = fielddivid.replace("_div", "");
		var fieldtype = $(this).attr("opftype");	
			
			
		if(fieldtype == 'undefined') return false;
		if(! $(myobj).attr("opfrequired")) return false;		
		if(! $(myobj).is(':visible')) return false;
		if($(myobj).attr('opfignorvalid') == "true") return false;	
		
		if($("#" + fielddivid + "_div").attr('class') == "ps_formelement_disabled") return false;
		
		return true;
	
	},

	////////////////////////////////////////////////
	// work in progress
	autovalidate: function(container_id) {

		// here we will loop through all field elements of the form_id and get their field type, label and whether they are tagged as required 
		// we will them run validation tests on each required field that is found
		// it a required field is set to non visible, it is ignored
		
		// get all divs with the attribute opvalid in them ...
		
		var fielddivid = '';
		var fieldid = '';
		var fieldtype = '';
		var fieldrequired = false;
		var fielddisabled = false;
		var fieldlabel = '';
		var opvalidflag = '';
		var opisvisible = false;
		
		var dovalidate = true;
				
		opform.validation_errors = '';
		
		// loop through and find all elements with a div contained having the class "field_required".
				
			
		$('#' + container_id).find('.ps_formelement').each( function(){
		
		

			fielddivid = $(this).attr("id");
			fieldid = fielddivid.replace("_div", "");
			fieldtype = $(this).attr("opftype");			
			fieldlabel = $(this).attr("opflabel");	
			
	
				
				
			dovalidate = true;
			
			if(fieldtype == 'undefined') dovalidate = false;
			
				
			if(dovalidate){
				if(! $(this).attr("opfrequired")) dovalidate = false;
			}
			
			if(dovalidate){
				if($(this).attr("opfrequired") == "false") dovalidate = false;
			}
			
			if(dovalidate){	
				if(! $(this).is(':visible')) dovalidate = false;
			}
			
		
			if(dovalidate){	
				if($(this).attr('opfignorvalid') == "true") dovalidate = false;
			
			}
			
			
			if(dovalidate){	
				if($("#" + fielddivid + "_div").attr('class') == "ps_formelement_disabled") dovalidate = false;					
			}
			
			if(dovalidate){
			
			
				//alert(fieldid);
			
				
			
				switch(fieldtype){
		
					case 'text':
						opform.validation_errors += opform.validate_text(fieldid,fieldlabel);
						break;
						
					case 'textarea':
						opform.validation_errors += opform.validate_textarea(fieldid,fieldlabel);
						break;				
				
					case 'captcha':
						opform.validation_errors += opform.validate_captcha(fieldid,fieldlabel);
						break;
				
					case 'checkbox':
						opform.validation_errors += opform.validate_checkbox(fieldid,fieldlabel);
						break;

					case 'date':
						opform.validation_errors += opform.validate_date(fieldid,fieldlabel);
						break;
						
					case 'email':
						opform.validation_errors += opform.validate_email(fieldid,fieldlabel);
						break;

					case 'file':
						opform.validation_errors += opform.validate_file(fieldid,fieldlabel);
						break;

					case 'hidden':
						opform.validation_errors += opform.validate_hidden(fieldid,fieldlabel);
						break;

					case 'multicheckbox':
						opform.validation_errors += opform.validate_multicheckbox(fieldid,fieldlabel);
						break;						
						
					case 'multiselect':
						opform.validation_errors += opform.validate_multiselect(fieldid,fieldlabel);
						break;	
						
					case 'numeric':
						opform.validation_errors += opform.validate_numeric(fieldid,fieldlabel);
						break;	

					case 'password':
						opform.validation_errors += opform.validate_password(fieldid,fieldlabel);
						break;	

					case 'phone':
						opform.validation_errors += opform.validate_phone(fieldid,fieldlabel);
						break;	

					case 'province':
						opform.validation_errors += opform.validate_province(fieldid,fieldlabel);
						break;	

					case 'radio':
						opform.validation_errors += opform.validate_radio(fieldid,fieldlabel);
						break;	

					case 'select':
						opform.validation_errors += opform.validate_select(fieldid,fieldlabel);
						break;	

					case 'text':
						opform.validation_errors += opform.validate_text(fieldid,fieldlabel);
						break;	

					case 'textarea':
						opform.validation_errors += opform.validate_textarea(fieldid,fieldlabel);
						break;							
						
									
				}
				

			
			}
		
		});
		
		
		return ps_form.validation_errors;
			
			

			
	},
	

imposeMaxLength: function (event, obj, maxlen, divid){


	charsleft = (maxlen - obj.value.length) + 1;
	
	$('#' + divid + '_maxchars_div').html(charsleft + ' characters left');

	return (obj.value.length <= maxlen)||(event.keyCode == 8 ||event.keyCode==46||(event.keyCode>=35&&event.keyCode<=40))
	
},

	
	
	
validate_textarea: function (fld,flabel){


	var tfld = document.getElementById(fld);
	if(!tfld) return "";
	
	var tfld_container = document.getElementById(fld + '_div');	
		
	if(tfld_container.style.display == 'none') return "";
	
	

	
	tfld.value = this.trimstring(tfld.value);   
	   
	var validstate = 1;
	
    if (tfld.value.length == 0) validstate = 0;
	
	return this.setvalidstate(tfld_container,flabel,validstate,has_not_been_filled);



		
	},
	
validate_multiselect: function (fld,flabel) {

	var tfld = document.getElementById(fld);
	if(!tfld) return "";
	
	var tfld_container = document.getElementById(fld + '_div');	
		

	var error = "";

	chosen = ""
	var validstate = 1;
	
	len = tfld.length

	for (i = 0; i <len; i++) {
		if (tfld[i].selected) {
			chosen = tfld[i].value
		}
	}

	if (chosen == "") validstate = 0;

	return this.setvalidstate(tfld_container,flabel,validstate,has_not_been_selected);

},
	
validate_date: function (fld,flabel){

	return this.validate_text(fld,flabel);


},

	
validate_text: function (fld,flabel){


	var tfld = document.getElementById(fld);
	if(!tfld)	return "";
	
	var tfld_container = document.getElementById(fld + '_div');	
	
	if(!tfld_container) return "";
	
	if(tfld_container.style.display == 'none') return "";
	
	
	tfld.value = this.trimstring(tfld.value);   
		
	var validstate = 1;
	
    if (tfld.value.length == 0) validstate = 0;
	
	return this.setvalidstate(tfld_container,flabel,validstate,has_not_been_filled);

		
	},
	
validate_email: function (fld,flabel) {

	var tfld = document.getElementById(fld);
	if(!tfld) return "";
	
	var tfld_container = document.getElementById(fld + '_div');	
			
	var error = "";
	var validstate = 1;
	
	var trimmedfld = this.trimstring(tfld.value);     

	var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
	var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
	
	//alert('checking');
		

	if (tfld.value == "") {
		validstate = 0;
		error = has_not_been_filled;
	} else if (!this.checkemail(trimmedfld)) {
		validstate = 0;
		error = enter_valid_email;
	} else if (tfld.value.match(illegalChars)) {
		validstate = 0;
		error = illegal_email;
	}	
	
    return this.setvalidstate(tfld_container,flabel,validstate,error);

},


checkemail: function (str){

	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (filter.test(str)){
		testresults=true
	}else{
		testresults=false
	}

	return (testresults)
},




validate_numeric: function (fld,flabel) {

	var tfld = document.getElementById(fld);
	if(!tfld) return "";
	
	var tfld_container = document.getElementById(fld + '_div');	
	
    var error = "";
	var validstate = 1;
	
	tfld.value = this.trimstring(tfld.value);   
	
    var stripped = tfld.value.replace(/[\(\)\.\-\ ]/g, '');    

   if (tfld.value == "") {
        error = has_not_been_filled;
        validstate = 0;
    } else if (isNaN(parseInt(stripped))) {
        error = not_number;
        validstate = 0;
	}
	
    return this.setvalidstate(tfld_container,flabel,validstate,error);
},


validate_phone: function (fld,flabel) {

	var tfld = document.getElementById(fld);
	if(!tfld) return "";
	
	var tfld_container = document.getElementById(fld + '_div');	
	
    var error = "";
	var validstate = 1;
	
	tfld.value = this.trimstring(tfld.value);   
	
    var stripped = tfld.value.replace(/[\(\)\.\-\ ]/g, '');    

   if (tfld.value == "") {
        error = didnt_enter_phone;
        validstate = 0;
    } else if (isNaN(parseInt(stripped))) {
        error = phone_illegal;
        validstate = 0;
    } else if (!(stripped.length == 10)) {
        error = phone_wrong_length;
        validstate = 0;
    }
	
    return this.setvalidstate(tfld_container,flabel,validstate,error);
},
	
validate_hidden: function (fld,flabel) {

	var tfld = document.getElementById(fld);
	if(!tfld)	return "";
	
	var validstate = 1;
	
    if (tfld.value.length == 0) return flabel + " incomplete.\n";

    return ""; //flabel + " incomplete"; 
	
},



validate_captcha: function (fld,flabel) {

	var validerror = opform.validate_text(fld,flabel);
	
	this.hascaptcha = 'true';

	var tfld_container = document.getElementById(fld + '_div');	
	
	this.valid_captcha = 'false';
			
	var validstate = 0;
		
	if(validerror == ""){
	
		var validstate = 1;
			
		this.setvalidstate(tfld_container,flabel,validstate,has_not_been_selected);
	
		var tfld = document.getElementById(fld);
		
		var ajaxparams= "cma=pages:form:remote&func=jsValidateCaptcha&args[keystring]=" + tfld.value + "&args[valholder]=validerror&args[fieldname]=" + tfld.id;
	
		$.ajax({
	 
				async: true,
				type: "GET",
				url: "index.php",
				data: ajaxparams,
				success: function(error){
							
					if(error == ''){
					
					
						if(opform.captchasuccess != ""){
						
							eval(opform.captchasuccess)
						
						}else{
						
							///////////////////////////////////////
							// this stuff is pretty much obsolete now
						
							precaptchavalid = 'fullyprocessed';
							validstate = 1;
						
							// this does its own thing even after the function
							// calling this one is all done and packed up...
							
							opform.valid_captcha = 'true';
												
							var postform = document.getElementById(opform.form_name + '_form');
					
							if(postform) {
							
								if(opform.validation_errors == ''){
							
									postform.submit();
								
								}
								
							}else{
							
								return "";
							
							}
							

						
							//
							/////////////////////////////////////
						}
				
								
					}else{
					

						var validstate = 0;
						
						opform.setvalidstate(tfld_container,flabel,validstate,has_not_been_selected);
						
						
						var captchaimg = document.getElementById(tfld.id + "_captcha_img")
										
						if(captchaimg){
						
							eval("captchaimg.src = captchaimg.src + " + "'&newdate=" + (new Date()).getTime() + "'");
							tfld.value = "";
							
						}

						opform.validation_errors += "\nCaptcha incorrect";
						
					
				
						if(opform.captchafail != ""){
													
							eval(opform.captchafail);
							
						}
						
						
					}
					
				}
		});
		
		return "";
		
		
	}else{
	
		var validstate = 0;
		
		if(opform.captchafail != ""){
		
			this.setvalidstate(tfld_container,flabel,validstate,has_not_been_selected);
			
			opform.validation_errors += "\nCaptcha not entered";
			
	
															
			eval(opform.captchafail);
							
		}else{
		
			return this.setvalidstate(tfld_container,flabel,validstate,has_not_been_selected);
		}
	}
	

},



validate_checkbox: function (fld,flabel) {

	var tfld = document.getElementById(fld);
	if(!tfld) return "";
	
	var tfld_container = document.getElementById(fld + '_div');	
	
    var error = "";
	var validstate = 1;
	
	if(!tfld.checked) validstate = 0;
	
    return this.setvalidstate(tfld_container,flabel,validstate,has_not_been_selected);
	
},


validate_multicheckbox: function (fld,flabel){

	var error = "";
	var tfld_container = document.getElementById(fld + '_div');	
	if(!tfld_container) return "";

	chosen = ""
	var validstate = 1;
		
	
	var i = 1;
	var checkfield = true;
	
	while(checkfield){
		
		checkfield = document.getElementById(fld + '_' + i);
		
		if(checkfield && checkfield.checked){
			
			chosen = true;
			break;
		
		}
		
		i++;
	}


	if (chosen == "") validstate = 0;


    return this.setvalidstate(tfld_container,flabel,validstate,has_not_been_selected);


},

validate_radio: function (fld,flabel){

	// this function may be obsolete ???
	var error = "";
	
	var tfld = document.getElementById(fld);
	var tfld_container = document.getElementById(fld + '_div');	

	if(!tfld_container) return '';
	
	chosen = ""
	var validstate = 1;
	
	var i = 1;
	var checkfield = true;
	
	while(checkfield){
	
		checkfield = document.getElementById(fld + '_' + i);
		
		if(checkfield && checkfield.checked){
		
			chosen = true;
			break;
		
		}
		
		i++;
		
		if(i > 20) break; // prevent endless loop
	}


	if (chosen == "") validstate = 0;


    return this.setvalidstate(tfld_container,flabel,validstate,has_not_been_selected);



},

validate_select: function (fld,flabel){


	var tfld = document.getElementById(fld);
	if(!tfld) return "";
	
	var tfld_container = document.getElementById(fld + '_div');	
		

	// need to check that there are actually options to pick from. If not, return true
			
	var validstate = 1;
	
	if (tfld.value.length == 0) var validstate = 0;
   
	return this.setvalidstate(tfld_container,flabel,validstate,has_not_been_selected);

		
	},
	
validateUsername: function (fld,flabel) {

	var tfld = document.getElementById(fld);
	if(!tfld) return "";
	
	var tfld_container = document.getElementById(fld + '_div');	
		

	
	tfld.value = this.trimstring(tfld.value);   
	
    var error = "";
	var validstate = 1;
    var illegalChars = /\W/; // allow letters, numbers, and underscores
 
    if (tfld.value == "") {
        validstate = 0; 
        error = didnt_enter_username;
    } else if ((tfld.value.length < 5) || (tfld.value.length > 15)) {
        validstate = 0; 
        error = username_wrong_length;
    } else if (illegalChars.test(tfld.value)) {
        validstate = 0; 
        error = username_illegal;
    }
	
	return this.setvalidstate(tfld_container,flabel,validstate,error);
},

validate_password: function (fld,flabel) {

	var tfld = document.getElementById(fld);
	if(!tfld) return "";
	
	var tfld_container = document.getElementById(fld + '_div');	
		

	
	tfld.value = this.trimstring(tfld.value);   
		
	
    var error = "";
	var validstate = 1;
    var illegalChars = /[\W_]/; // allow only letters and numbers 
 
    if (tfld.value == "") {
        validstate = 0; 
		error = flabel + " " + has_not_been_filled;
	} else if ((tfld.value.length < 3) || (tfld.value.length > 15)) {
        error = flabel + " " + wrong_length + "\n";
        validstate = 0; 
    } else if (illegalChars.test(tfld.value)) {
        error = flabel + " " + contains_illegal;
        validstate = 0; 
    }
	
	return this.setvalidstate(tfld_container,flabel,validstate,error);
} 

	
	

	
});

var ps_form = new psform();
