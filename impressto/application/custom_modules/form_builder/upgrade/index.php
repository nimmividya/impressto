<?php
include("../config.php");
mysql_query("CREATE TABLE IF NOT EXISTS `flexible_file_settings`  (
		`flexible_id` INT( 20 ) NOT NULL ,
		`flexible_file_ext` VARCHAR( 200 ) NOT NULL ,
		`flexible_file_size` INT( 255 ) NOT NULL
		) ENGINE = MYISAM 
		DEFAULT CHARACTER SET utf8
		DEFAULT COLLATE utf8_general_ci;
		;") or die(mysql_error());	
mysql_query("CREATE TABLE IF NOT EXISTS `flexible_slider_settings`  (
		`flexible_id` INT( 20 ) NOT NULL ,
		`slider_min` INT( 200 ) NOT NULL ,
		`slider_max` INT( 200 ) NOT NULL,
		`slider_value` INT( 200 ) NOT NULL ,
		`slider_step` INT( 200 ) NOT NULL,
		`slider_display` INT( 1 ) NOT NULL ,
		`slider_prefix` VARCHAR( 3 ) NOT NULL,
		`slider_range` INT( 1 ) NOT NULL ,
		`slider_value_min` INT( 200 ) NOT NULL,
		`slider_value_max` INT( 200 ) NOT NULL
		) ENGINE = MYISAM 
		DEFAULT CHARACTER SET utf8
		DEFAULT COLLATE utf8_general_ci;
		;") or die(mysql_error());	
?>