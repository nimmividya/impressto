<?php
    header("content-type: text/html");
    header("Cache-Control: no-cache");
    require( "../config/config.inc.php" );
    require_once( "../".DIR_INC.PHP_FNS );
 
    if(isset($_POST["rowId"]) && isset($_POST["name"]) && isset($_POST["email"])){
        $id = $_POST["id"];
        $rowId = $_POST["rowId"];
        if($id == ""){ //if id empty then id is retrieved from rowId
            $id = str_replace("tr", "", $rowId);
        }
        $name = echappement(utf8_urldecode($_POST["name"]));
        $email = echappement(utf8_urldecode($_POST["email"]));
        $startdate = $_POST["startdate"];
        $salary = $_POST["salary"];
        $active = $_POST["active"];     
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        if($active == 'true') $active = 1;
        else $active = 0;
        connect_db();
        $query = "UPDATE ".TBL_DEMO_EMPLOYEE." SET ".
                    "NAME='$name',EMAIL='$email',STARTDATE='$startdate',SALARY='$salary'".
                    ",MODIP='$ip',MODDATE=NOW(),ACTIVE=$active ".
                    "WHERE ID='$id'";
        mysql_query($query);
        echo "[RowId ".$id."] <b>".$name."</b>'s data successfully updated!";
        close_db();
    } else {
        echo "Data could not be saved! Expected params not found!";
    }
?>