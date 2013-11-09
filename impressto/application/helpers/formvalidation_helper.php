<?php //Functions to validate forms
function formError($seshValue,$message) {
	if (isset($_SESSION["error"])) {
		$_SESSION["error"] .= "<li style=\"color:#f00\"><strong>".$message."</strong></li>\n";
	} else {
		$_SESSION["error"] = "<li style=\"color:#f00\"><strong>".$message."</strong></li>\n";
	}
	if (isset($_SESSION["badForm"])) {
		$_SESSION["badForm"] .="*".$seshValue."*";
	}else{
		$_SESSION["badForm"] ="*".$seshValue."*";
	}	
}
function formIsUniqueUrl($seshValue,$properName,$bool,$returnURL) { //Checks for empty form        
    if (isset($_SESSION[$seshValue])) {
        if ($_SESSION[$seshValue]!=="" && $bool == false) {
            formError($seshValue,efr("Friendly Url is not unique.","Friendly Url is not unique"));
            $GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
        }
    }
}

function formIsBlank($seshValue,$properName,$returnURL) { //Checks for empty form		
	if (!isset($_SESSION[$seshValue])) {
			formError($seshValue,efr("Please enter a value for the field titled <em>".$properName."</em>.","Please enter a value for the field titled <em>".$properName."</em>."));
			$GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
	} else if (isset($_SESSION[$seshValue])) {
		if ($_SESSION[$seshValue]=="") {
			formError($seshValue,efr("Please enter a value for the field titled <em>".$properName."</em>.","Please enter a value for the field titled <em>".$properName."</em>."));
			$GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
		}
	}
}
function formIsLong($seshValue,$properName,$maxLength,$returnURL) { //Checks for long entry
	if (isset($_SESSION[$seshValue])) {
		if (strlen(html_entity_decode($_SESSION[$seshValue]))>$maxLength) {
			formError($seshValue,efr("Your entry for <em>".$properName."</em> can only contain a maximum of ".$maxLength." characters.","Your entry for <em>".$properName."</em> can only contain a maximum of ".$maxLength." characters."));
			$GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
		}
	}
}
function formIsEmail($seshValue,$properName,$returnURL) {  //Checks for a valid email
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $_SESSION[$seshValue])) { 
		formError($seshValue,efr("Your entry for <em>".$properName."</em> is not a valid e-mail address.","Your entry for <em>".$properName."</em> is not a valid e-mail address."));
		$GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
	}
}
function formIsSelected($seshValue,$properName,$selectName,$returnURL) { //Checks to see if the first value of a dropdown is selected
	if (isset($_SESSION[$seshValue])) {
		if ($_SESSION[$seshValue]==$selectName) {
			formError($seshValue,efr("Please select a value for the field titled <em>".$properName."</em>.","Please select a value for the field titled <em>".$properName."</em>."));
			$GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
		}
	}
}
function formIsBadSelect($seshValue,$properName,$selectName,$returnURL) {
	if (isset($_SESSION[$seshValue])) {
		if ($_SESSION[$seshValue]==$selectName) {
			formError($seshValue,efr("Please select another value for the field titled <em>".$properName."</em>.","Please select another value for the field titled <em>".$properName."</em>."));
			$GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
		}
	}
}
function formIsRange($seshValue,$properName,$low,$high,$returnURL) { //Checks to see if value is within valid range
	if (isset($_SESSION[$seshValue])) {
		if ($_SESSION[$seshValue]<$low || $_SESSION[$seshValue]>$high) { 
			formError($seshValue,efr("Please select a value between ".$low." and ".$high." for the field marked <em>".$properName."</em>.","Please select a value between ".$low." and ".$high." for the field marked <em>".$properName."</em>."));
			$GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
		} 		
	}
}
function formIsNumeric($seshValue,$properName,$returnURL) { //Checks to see if entry is numeric
	if (isset($_SESSION[$seshValue])) {
		if (!is_numeric($_SESSION[$seshValue])) {
			formError($seshValue,efr("Your entry for <em>".$properName."</em> must be a number.","Your entry for <em>".$properName."</em> must be a number."));
			$GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
		}
	}	
}
function formIsPostal($seshValue,$properName,$returnURL) { //Checks if it's a postal code
	if(!eregi("^(^[0-9]{5}(\-* *[0-9]{4})?$)|([a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1} *[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1})$", $_SESSION[$seshValue])) { 
		formError($seshValue,efr("Your entry for <em>".$properName."</em> is not a valid postal code or zip code.","Your entry for <em>".$properName."</em> is not a valid postal code or zip code."));	
		$GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
	} else {
		$_SESSION[$seshValue]=str_replace("--", "-",str_replace("  ", " ", $_SESSION[$seshValue]));
		$_SESSION[$seshValue]=strtoupper($_SESSION[$seshValue]);
		if (strlen($_SESSION[$seshValue])==6) {
			$_SESSION[$seshValue]=substr_replace($_SESSION[$seshValue], ' ', 3, 0);
		} else if (strlen($_SESSION[$seshValue])==9) {
			$_SESSION[$seshValue]=substr_replace($_SESSION[$seshValue], '-', 5, 0);
		} else if (strlen($_SESSION[$seshValue])==10) {
			$_SESSION[$seshValue]=str_replace(' ', '-', $_SESSION[$seshValue]);
		}
	}
}
function formIsPhone($seshValue,$properName,$returnURL) { //Checks if it's a phone number
	if(!eregi("^(\(*)[0-9]{3}(\)*)(\-* *)[0-9]{3}(\-* *)[0-9]{4}$", $_SESSION[$seshValue])) { 
		formError($seshValue,efr("Your entry for <em>".$properName."</em> is not a valid phone number. Please use the format: 555-555-5555.","Your entry for <em>".$properName."</em> is not a valid phone number. Please use the format: 555-555-5555."));	
		$GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
	} else {
		$_SESSION[$seshValue]=str_replace("((", "(",str_replace("))", ")",str_replace("--", "-",str_replace("  ", " ", $_SESSION[$seshValue]))));
		$deleteCharacters = array("(", ")");	
		$_SESSION[$seshValue] = str_replace(" ", "-", str_replace($deleteCharacters, "", $_SESSION[$seshValue]));
		if (strlen($_SESSION[$seshValue])==10) {
			$_SESSION[$seshValue]=substr_replace($_SESSION[$seshValue], '-', 6, 0);
			$_SESSION[$seshValue]=substr_replace($_SESSION[$seshValue], '-', 3, 0);
		}
	}
}
function formIsDate($seshValue,$month,$day,$year,$properName,$returnURL) { //Checks if it's a valid date
	if (isset($_SESSION[$month]) && isset($_SESSION[$day]) && isset($_SESSION[$year])) {
		if (!checkdate($_SESSION[$month],$_SESSION[$day],$_SESSION[$year])) {
			formError($seshValue,efr("Your entry for <em>".$properName."</em> is not a valid date.","Your entry for <em>".$properName."</em> is not a valid date."));
			$GLOBALS['formIsError']=true;$GLOBALS['formRedirect']=$returnURL;
		}
	}
}
function formIsErrors() { //Checks if there are any errors and redirects if there are
	if ($GLOBALS['formIsError']==true) {		
		redirect($GLOBALS['formRedirect']);
	}
}
function f_variableIsEmail($variable) {  //Checks for a valid email
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $variable)) { 
		return true;
	} else {
		return false;
	}
}
function f_variableBoundLength($variable, $minlength, $maxlength) {  //Checks variable for valid length
	$returnbool = true;
	if($minlength!="") {
		if(strlen($variable) < $minlength) { 
			$returnbool = false;
		}
	}
	if($maxlength!="") {
		if(strlen($variable) > $maxlength) { 
			$returnbool = false;
		}
	} 
	return $returnbool;
}
function f_san($variable) {
	return htmlspecialchars($variable, ENT_QUOTES);
}
function f_is_sane($variable) {
	if ($variable == htmlspecialchars($variable, ENT_QUOTES) ) {
		return true;
	} else {
		return false;
	}
}

