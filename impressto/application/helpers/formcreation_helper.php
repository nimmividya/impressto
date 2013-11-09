<?php //Functions to create forms
function formLabel($name,$properName,$class) {
	echo "<label for=\"".$name."\" class=\"".$class."\">";
	if (isset($_SESSION["badForm"])) { 
	$pos = strpos($_SESSION["badForm"], "*".$name."*");
		if ($pos === false) {
			echo $properName;			
		} else {echo "<span style=\"color:#f00;\">".$properName."</span>";}
	} else { echo $properName; }
	echo "</label>\n";
}

function formNumericDropdown($name,$start,$end,$class) { //Creates a numeric dropdown
	echo "<select id=\"".$name."\" name=\"".$name."\" class=\"".$class."\">\n";
	if ($start<$end) {
		for ( $counter = $start; $counter <= $end; $counter ++) {		
			echo "<option ";
			if (isset($_SESSION[$name])) {
				if ($_SESSION[$name]==$counter) {
					echo "selected=\"selected\" ";
				}
			}
			echo "value=\"".$counter."\">".$counter."</option>\n"	;
		}
		echo "</select>";
	} else {
		for ( $counter = $start; $counter >= $end; $counter --) {	
			echo "<option ";	
			if (isset($_SESSION[$name])) {
				if ($_SESSION[$name]==$counter) {
					echo "selected=\"selected\" ";
				}
			}
			echo "value=\"".$counter."\">".$counter."</option>\n"	;
		}
		echo "</select>";
	}
}
function formTextField($name,$size,$length,$class) { //Prints a text field
	echo "<input type=\"text\" id=\"".$name."\" name=\"".$name."\" size=\"".$size."\" maxlength=\"".$length."\" class=\"".$class."\"";
	if (isset($_SESSION[$name])) {echo " value=\"".$_SESSION[$name]."\"";}
	echo " />\n";
}


function formRadioButton($name,$value,$class) {
	echo "<input type=\"radio\" id=\"".$name."\" name=\"".$name."\" value=\"".$value."\" class=\"".$class."\"";
	if (isset($_SESSION[$name])) {
		if ($_SESSION[$name]==$value) {
			echo " checked=\"checked\"";
		}
	}
	echo " />\n";
}
function formTextFieldPassword($name,$size,$length,$class) { //Prints a text field
	echo "<input type=\"password\" id=\"".$name."\" name=\"".$name."\" size=\"".$size."\" maxlength=\"".$length."\" class=\"".$class."\"";
	if (isset($_SESSION[$name])) {echo " value=\"".$_SESSION[$name]."\"";}
	echo " />\n";
}
function formCheckBox($name,$value,$class) {
	echo "<input type=\"checkbox\" id=\"".$name."\" name=\"".$name."\" value=\"".$value."\" class=\"".$class."\"";
	if (isset($_SESSION[$name])) {
		if ($_SESSION[$name]==$value) {
			echo " checked=\"checked\"";
		}
	}
	echo " />\n";
}
function formIsCheckbox($name,$badValue) {
	if (!isset($_SESSION[$name])) {
		$_SESSION[$name]=$badValue;
	}
}
function formTextArea($name,$width,$height,$class) {//Print a text area
	echo "<textarea id=\"".$name."\" name=\"".$name."\" cols=\"".$width."\" rows=\"".$height."\" class=\"".$class."\">";
	if (isset($_SESSION[$name])) {echo $_SESSION[$name];}
	echo "</textarea>\n";
}
function formSubmitButton($name,$value,$class) {
	echo "<input type=\"submit\" name=\"".$name."\" class=\"".$class."\" value=\"".$value."\" />\n";
}
function formProvStateDropdown($name,$type,$class) { //Creates a province/state dropdown > type=1 (can), type=2 (us), type=3 (both)
	echo "<select name=\"".$name."\" class=\"".$class."\">\n";
	if ($type==1 || $type==3) {
		$sql = "SELECT PR_ID,PR_NameE,PR_NameF,PR_Abbr,PR_Country FROM ps_provstate WHERE PR_Country=1 ORDER BY PR_Name".strtoupper($GLOBALS['language']);
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			echo "<option ";
			if (isset($_SESSION[$name])) {
				if ($_SESSION[$name]==$row['PR_ID']) {echo "selected=\"selected\" ";}
			} else {
				if ($row['PR_ID']=="9") {echo "selected=\"selected\" ";}
			}
			echo "value=\"".$row['PR_ID']."\">".$row['PR_Name'.strtoupper($GLOBALS['language'])]."</option>\n";
		}
	}
	if ($type==2 || $type==3) {
		$sql = "SELECT PR_ID,PR_NameE,PR_NameF,PR_Abbr,PR_Country FROM ps_provstate WHERE PR_Country=2 ORDER BY PR_Name".strtoupper($GLOBALS['language']);
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			echo "<option ";
			if (isset($_SESSION[$name])) {if ($_SESSION[$name]==$row['PR_ID']) {echo "selected=\"selected\" ";}}
			echo "value=\"".$row['PR_ID']."\">".$row['PR_Name'.strtoupper($GLOBALS['language'])]."</option>\n";
		}
	}
	$sql = "SELECT PR_ID,PR_NameE,PR_NameF,PR_Abbr,PR_Country FROM ps_provstate WHERE PR_Country=3 ORDER BY PR_Name".strtoupper($GLOBALS['language']);
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	echo "<option ";
	if (isset($_SESSION[$name])) {if ($_SESSION[$name]==$row['PR_ID']) {echo "selected=\"selected\" ";}}
	echo "value=\"".$row['PR_ID']."\">".$row['PR_Name'.strtoupper($GLOBALS['language'])]."</option>\n";
	echo "</select>";
}

function formCountryDropdown($name,$class) { //Creates a country dropdown
	echo "<select name=\"".$name."\" class=\"".$class."\">\n";
	$sql = "SELECT * FROM ps_countries ORDER BY CN_Name".strtoupper($GLOBALS['language']);
	$result = mysql_query($sql);	
	while($row = mysql_fetch_array($result)) {
		echo "<option ";
		if (isset($_SESSION[$name])) {
			if ($_SESSION[$name]==$row['CN_ID']) {echo "selected=\"selected\" ";}
		} else {
			if ($row['CN_ID']=="142") {echo "selected=\"selected\" ";}
		}
		echo "value=\"".$row['CN_ID']."\">".$row['CN_Name'.strtoupper($GLOBALS['language'])]."</option>\n";
	}
	echo "</select>";
}
function formFCK($name,$toolbar,$width,$height) {//toolbar: Basic or system
	$oFCKeditor = new FCKeditor('fck'.$name) ;
	$oFCKeditor->BasePath = '/' . PROJECTNAME . '/includes/fckeditor/' ;
	if (isset($_SESSION[$name])) {
		$oFCKeditor->Value = $_SESSION[$name];
	} else {
		$oFCKeditor->Value = '<p>&nbsp;</p>';
	}
	$oFCKeditor->ToolbarSet = $toolbar;
	$oFCKeditor->Width = $width;
	$oFCKeditor->Height = $height;
	$oFCKeditor->Create();
}

