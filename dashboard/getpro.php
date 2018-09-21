<?php
include('./includes/config.inc.php');
include($dir_inc.'functions.php');
include($dir_inc.'function.php');
$langset=$_SESSION['lang'];
if (isset($_GET['cat_id'])){
	$sql_info="Select * from `" . $table_content . "` where  id IN (SELECT content_id from ".$table_content_to_cat." where cat_id IN ".get_cat_sub($_GET['cat_id']).") ORDER BY id ASC";
	$sql_info = $db->sql_query($sql_info) or die(mysql_error());
	while($sql_info_rows = $db->sql_fetchrow($sql_info))
	{
		echo('<option value="'.$sql_info_rows['id'].'">'.makeContentInfo($sql_info_rows['id'],"name").'</option>');
	}

}

?>