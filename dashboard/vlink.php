<?php
include('./includes/config.inc.php');
include($dir_inc.'functions.php');
include($dir_inc.'function.php');
$title=$_POST['value'];
$field=$_POST['field'];
$catid=$_POST['catid'];
$module=$_POST['module'];
$table_catpro   =   $DB_FSQL ."tblcat_content";
$table_catin   =   $DB_FSQL ."tblcat_info";
$table_pro   =   $DB_FSQL ."tblcontent";
$table_info   =   $DB_FSQL ."tblinfo";
if ($module=="catpro"){
	echo makeVlink($table_catpro,$field,$catid,$title);
	exit();
} elseif ($module=="pro"){
	echo makeVlink($table_pro,$field,$catid,$title);
	exit();
} elseif ($module=="catinfo"){
	echo makeVlink($table_catin,$field,$catid,$title);
	exit();
} elseif ($module=="info"){
	echo makeVlink($table_info,$field,$catid,$title);
	exit();
}
?>