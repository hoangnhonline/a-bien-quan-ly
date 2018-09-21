<?php
include('./includes/config.inc.php');
include($dir_inc.'template.php');
include($dir_inc.'functions.php');
include($dir_inc.'function.php');
$template = new Template();
date_default_timezone_set("Asia/Saigon");
$check_date = date("Y-m-d H:i:s", strtotime("-30 day"));
//echo($check_date);
$sql_query  = "update `".$table_content."` SET  `wait_user`='1' where admin_update_time<'".$check_date."'";
$sql_query = $db -> sql_query($sql_query) or die(mysql_error());

?>