<?php
    header("content-type: text/html");
    header("Cache-Control: no-cache"); 
    require( "../config/config.inc.php" );
    require_once( "../".DIR_INC.PHP_FNS );
 
    if(isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["email"])){
        $id = $_POST["id"];
        $name = echappement(utf8_urldecode($_POST["name"]));
        $email = echappement(utf8_urldecode($_POST["email"]));
        $startdate = $_POST["startdate"];
        $salary = $_POST["salary"];
        $active = $_POST["active"];      
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        $rowId = $_POST["rowId"]; // rowId param is appended to all insert calls
        if($active == 'true') $active = 1;
        else $active = 0;
         
        connect_db();
        $query = "INSERT INTO ".TBL_DEMO_EMPLOYEE." ".
                    " VALUES('0','$name','$email','$startdate','$salary',null, null,". 
                    "'$ip', null, null, NOW(), null, null, $active, 0)";        
        mysql_query($query);
         
        //last inserted record id
        $id = mysql_insert_id();
        echo "<script>";
        echo "var tr = document.getElementById('".$rowId ."');";
        echo "if(tr){ tr.setAttribute('id', 'tr".$id."'); }"; 
        echo "</script>";
        echo "[New row ".$id."] <b>".$name."</b>'s data successfully inserted!";
         
        close_db();
    } else {
        echo "Data could not be saved! Expected params not found!";
    }
?>       