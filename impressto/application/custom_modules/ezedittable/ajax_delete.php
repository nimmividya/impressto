<?php
    header("content-type: application/x-javascript");
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];    
        connect_db();
        $query = "UPDATE ".TBL_DEMO_EMPLOYEE." SET ".
                    "DELIP='$ip',DELDATE=NOW(),DELETED=1 ".
                    "WHERE ID='$id'";
        mysql_query($query);
        close_db();
    }
?>