<?php
/*** 
Company: ECOPRO Co., Ltd
CMS: ECOPRO CONTENT MANAGEMENT SYSTEM (eCMS)
Author: Vu Thanh Toan
Email: vttoan@gmail.com
Phone: 84913319908
Commen Day: 12/7/2006 9:38 AM
***/
// Kiem tra xem da dang nhap chua
$table_llog = $DB_FSQL . "tbllearnlog";
$table_u    = $DB_FSQL . "tblusers";
$table_pro  = $DB_FSQL . "tblproduct";
$table_cb  = $DB_FSQL . "tblcapbac";
$table_ketso = $DB_FSQL . "tblketso";
$table_nk = $DB_FSQL . "tblnhatky";
$table_sts = $DB_FSQL . "tblstatus";
$table_catpro   =   $DB_FSQL ."tblcat_product";
$table_set   =   $DB_FSQL ."tblsetting";
$table_dh = $DB_FSQL."tbldathen";
$table_log = $DB_FSQL."tbllog";
$table_bgia = $DB_FSQL."tblcat_banggia";
$table_info = $DB_FSQL."tblinfo";
$table_con = $DB_FSQL."tblcontact";
$table_catalbum   =   $DB_FSQL."tblcat_album";
$table_catvideo   =   $DB_FSQL."tblcat_video";
$table_album   	  =   $DB_FSQL."tblalbum";
$table_y   	  =   $DB_FSQL."tblykien";
$table_nv  = $DB_FSQL . "tblcat_nhanvien";
$table_agt = $DB_FSQL . "tblcat_anhgt";
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ./login.php');
	exit('Login failed');
}

$template -> set_filenames(array(
	'Left'	=> $dir_template . 'Left.html')
);


$template -> assign_block_vars('CAT_INFO',array());

$template -> pparse('Left');
?>