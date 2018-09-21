<?php
include('./includes/config.inc.php');
include($dir_inc.'template.php');
include($dir_inc.'functions.php');
include($dir_inc.'function.php');
$template = new Template();
$ip=get_client_ip();
$sql_item_insert         = "insert into " . $table_log . " (`admin_id`,`ip`,`log`,`query`,`cat_id`,`content_id`,`create_time`) values ('0','".$ip."','CHECK','','','0',NOW())";
$sql_item_insert  =   $db->sql_query($sql_item_insert) or die(mysql_error());
?>