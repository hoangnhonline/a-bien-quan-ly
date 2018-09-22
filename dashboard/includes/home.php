<?php

// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ./login.php');
	exit('Login failed');
}

$template -> set_filenames(array(
	'Home'	    => $dir_template . 'home.html'
));
$emsg ='';   //Bien luu tru thong tin
$mess_result_check_item = true; //Keu loi
if (isset($_GET["del"]) and $_GET["del"]>0) {
	$pro_id = $_GET["del"];
	$admin_id=Make_field_values1("admin_id", $table_content, $db," where id='".$pro_id."'");
	//if ($admin_id==$_SESSION['login_id'] OR $_SESSION['is_admin']) {
	if ($_SESSION['is_admin']) {
		$check_pro=(int)Make_field_values1("trash", $table_content, $db," where id='".$pro_id."'");
		if ($check_pro==1) {
		$pro_code = Make_field_values1("code", $table_content, $db," where id='".$pro_id."'");
		//$sql_query  = "update `".$table_content."` set trash='0' where id='".$pro_id."'";
		$sql_query  = "delete from `".$table_content."` where id='".$pro_id."'";
		$sql_query = $db -> sql_query($sql_query) or die(mysql_error());	
		addLog("Đã xóa dự án BĐS ký hiệu: ".$pro_code, 0, $pro_id);
		$emsg ='Đã xóa dự án BĐS ký hiệu: '.$pro_code;   //Bien luu tru thong tin
		$mess_result_check_item = true; //Keu loi
		}
	} else {
			$emsg ='Bạn không được cấp quyền xóa dự án.';   //Bien luu tru thong tin
			$mess_result_check_item = false; //Keu loi	
	}
}
	
	
//danh sach
$sql_query = "SELECT * FROM `" . $table_catcontent . "` where parent_id='0' and trash=1 order by title ASC";
$sql_query = mysql_query($sql_query);
$count=0;
while($sql_query_rows = mysql_fetch_array($sql_query))
{
	$count++;
	$template->assign_block_vars('CAT1',array(
		'id'     		=>  $sql_query_rows['id'],
		'title'			=>  $sql_query_rows['title'],
		'selected'			=>  (isset($_GET["cat_id"]) AND $_GET["cat_id"]==$sql_query_rows['id'])?'{ "opened" : true, "selected" : true }':'{ "opened" : true}',
		'checked'			=>  (isset($_GET["cat_id"]) AND $_GET["cat_id"]==$sql_query_rows['id'])?'selected':'',
	));
	$sql_query1 = "SELECT * FROM `" . $table_catcontent . "` where parent_id='".$sql_query_rows['id']."' and trash=1  order by title ASC";
	$sql_query1 = mysql_query($sql_query1);
	while($sql_query_rows1 = mysql_fetch_array($sql_query1))
	{
		$count++;
		$template->assign_block_vars('CAT1.CAT2',array(
			'id'     		=>  $sql_query_rows1['id'],
			'title'			=>  $sql_query_rows1['title'],
			'selected'			=>  (isset($_GET["cat_id"]) AND $_GET["cat_id"]==$sql_query_rows1['id'])?'{"selected" : true }':'',
			'checked'			=>  (isset($_GET["cat_id"]) AND $_GET["cat_id"]==$sql_query_rows1['id'])?'selected':'',
		));
		$sql_query2 = "SELECT * FROM `" . $table_catcontent . "` where parent_id='".$sql_query_rows1['id']."' and trash=1  order by title ASC";
		$sql_query2 = mysql_query($sql_query2);
		while($sql_query_rows2 = mysql_fetch_array($sql_query2))
		{
			$count++;
			$template->assign_block_vars('CAT1.CAT2.CAT3',array(
				'id'     		=>  $sql_query_rows2['id'],
				'title'			=>  $sql_query_rows2['title'],
				'selected'			=>  (isset($_GET["cat_id"]) AND $_GET["cat_id"]==$sql_query_rows2['id'])?'{"selected" : true }':'',
				'checked'			=>  (isset($_GET["cat_id"]) AND $_GET["cat_id"]==$sql_query_rows2['id'])?'selected':'',
			));
			
		}			
	}		
}
//trang thai
$sql_query = "SELECT * FROM `" . $table_content_status . "` order by id ASC";
$sql_query = mysql_query($sql_query);
while($sql_query_rows = mysql_fetch_array($sql_query))
{
	$count++;
	$template->assign_block_vars('CSTATUS',array(
		'id'     		=>  $sql_query_rows['id'],
		'title'			=>  $sql_query_rows['title'],
		'color'			=>  $sql_query_rows['color'],
	));
}
//khach hang cua toi
$sql_query = "SELECT * FROM `" . $table_u . "` where admin_id='".$_SESSION['login_id']."' order by name ASC";
$sql_query = mysql_query($sql_query);
while($sql_query_rows = mysql_fetch_array($sql_query))
{
	$pre_arr= array("","Anh","Chị","Ông","Bà");
	$template->assign_block_vars('MY_USER',array(
		'id'     		=>  $sql_query_rows['id'],
		'pre'			=>  $pre_arr[$sql_query_rows['pre']],
		'name'			=>  $sql_query_rows['name'],
		'mobile1'			=>  $sql_query_rows['mobile1'],
	));
}

//nhan vien
$sql_query = "SELECT * FROM `" . $table_a . "` where admin_status='1' order by admin_user ASC";
$sql_query = mysql_query($sql_query);
while($sql_query_rows = mysql_fetch_array($sql_query))
{
	$count++;
	$template->assign_block_vars('NHAVIEN',array(
		'id'     		=>  $sql_query_rows['admin_id'],
		'name'			=>  $sql_query_rows['admin_user'],
	));
}

//DS BĐS
$sql_order=" status ASC,update_time ASC, id DESC";
$qr_order = "?order=id&sort=desc";
$sql_seach="";
$qr_seach = "";
if (isset($_GET["cat_id"]) AND $_GET["cat_id"]>0) {
	//$sql_seach.=" AND ".makeProInCat($_GET["cat_id"]);
	$sql_seach.=" AND (cat1_id='".$_GET["cat_id"]."' OR cat2_id='".$_GET["cat_id"]."')";
	$qr_seach = "&cat_id=".$_GET["cat_id"];
	
}
if (isset($_GET["kh_name"]) AND $_GET["kh_name"]<>"") {
	$sql_seach.=" AND user_id IN (SELECT id FROM `".$table_u."` WHERE `name` LIKE '%".$_GET["kh_name"]."%')";
	$qr_seach = "&kh_name=".$_GET["kh_name"];
	$template->assign_vars(array('txt_kh_name' =>  $_GET["kh_name"]));
}
if (isset($_GET["kh_id"]) AND $_GET["kh_id"]>0) {
	$sql_seach.=" AND user_id = '".$_GET["kh_id"]."'";
	$qr_seach = "&kh_id=".$_GET["kh_id"];
}

if (isset($_GET["pro_code"]) AND $_GET["pro_code"]<>"") {
	$sql_seach.=" AND code LIKE '%".$_GET["pro_code"]."%'";
	$qr_seach = "&pro_code=".$_GET["pro_code"];
	$template->assign_vars(array('txt_pro_code' =>  $_GET["pro_code"]));
}
if (isset($_GET["dt_min"]) AND $_GET["dt_min"]>0) {
	$sql_seach.=" AND dt >= '".$_GET["dt_min"]."'";
	$qr_seach = "&dt_min=".$_GET["dt_min"];
	$template->assign_vars(array('txt_dt_min' =>  $_GET["dt_min"]));
}
if (isset($_GET["dt_max"]) AND $_GET["dt_max"]>0) {
	$sql_seach.=" AND dt <= '".$_GET["dt_max"]."'";
	$qr_seach = "&dt_max=".$_GET["dt_max"];
	$template->assign_vars(array('txt_dt_max' =>  $_GET["dt_max"]));
}
if (isset($_GET["price_dvt"]) AND $_GET["price_dvt"]<>"") {
	$sql_seach.=" AND price_dvt='".$_GET["price_dvt"]."'";
	$qr_seach = "&price_dvt=".$_GET["price_dvt"];
	$template->assign_vars(array(
	'txt_price_dvt1_selected' =>  ($_GET["price_dvt"]=="Tỷ")?"selected":"",
	'txt_price_dvt2_selected' =>  ($_GET["price_dvt"]=="Triệu")?"selected":"",
	));
}
if (isset($_GET["price_min"]) AND $_GET["price_min"]>0) {
	$sql_seach.=" AND price >= '".$_GET["price_min"]."'";
	$qr_seach = "&price_min=".$_GET["price_min"];
	$template->assign_vars(array('txt_price_min' =>  $_GET["price_min"]));
}
if (isset($_GET["price_max"]) AND $_GET["price_max"]>0) {
	$sql_seach.=" AND price <= '".$_GET["price_max"]."'";
	$qr_seach = "&price_max=".$_GET["price_max"];
	$template->assign_vars(array('txt_price_max' =>  $_GET["price_max"]));
}

if (isset($_GET["ren_dvt"]) AND $_GET["ren_dvt"]<>"") {
	$sql_seach.=" AND ren_dvt='".$_GET["ren_dvt"]."'";
	$qr_seach = "&ren_dvt=".$_GET["ren_dvt"];
	$template->assign_vars(array(
	'txt_ren_dvt1_selected' =>  ($_GET["ren_dvt"]=="Tỷ")?"selected":"",
	'txt_ren_dvt2_selected' =>  ($_GET["ren_dvt"]=="Triệu")?"selected":"",
	));
}
if (isset($_GET["ren_min"]) AND $_GET["ren_min"]>0) {
	$sql_seach.=" AND ren >= '".$_GET["ren_min"]."'";
	$qr_seach = "&ren_min=".$_GET["ren_min"];
	$template->assign_vars(array('txt_ren_min' =>  $_GET["ren_min"]));
}
if (isset($_GET["ren_max"]) AND $_GET["ren_max"]>0) {
	$sql_seach.=" AND ren <= '".$_GET["ren_max"]."'";
	$qr_seach = "&ren_max=".$_GET["ren_max"];
	$template->assign_vars(array('txt_ren_max' =>  $_GET["ren_max"]));
}
if (isset($_GET["admin_name"]) AND $_GET["admin_name"]<>"") {
	$sql_seach.=" AND admin_id IN (SELECT admin_id FROM `".$table_a."` WHERE `admin_user` LIKE '%".$_GET["admin_name"]."%')";
	$qr_seach = "&admin_name=".$_GET["admin_name"];
	$template->assign_vars(array('txt_admin_name' =>  $_GET["admin_name"]));
}
if (isset($_GET["expired_begin"]) AND $_GET["expired_begin"]<>"") {
	$sql_seach.=" AND expired >= '".$_GET["expired_begin"]."'";
	$qr_seach = "&expired_begin=".$_GET["expired_begin"];
	$template->assign_vars(array('txt_expired_begin' =>  $_GET["expired_begin"]));
}
if (isset($_GET["expired_end"]) AND $_GET["expired_end"]<>"") {
	$sql_seach.=" AND expired <= '".$_GET["expired_end"]."'";
	$qr_seach = "&expired_end=".$_GET["expired_end"];
	$template->assign_vars(array('txt_expired_end' =>  $_GET["expired_end"]));
}
//exit($sql_seach);
//Phan trang
$sql_info_total = "SELECT COUNT(*) FROM `".$table_content."` where id>0 ".$sql_seach;
$sql_info_total = $db->sql_query($sql_info_total) or die(mysql_error());
$nRows = $db->sql_fetchfield(0);
$p = !empty($HTTP_GET_VARS['p']) ? $HTTP_GET_VARS['p'] : 0;
// Set lai $p neu $p >= $nRows
$p = ( ($p >= $nRows) || !is_numeric($p) || ($p < 0)) ? 0 : $p;
// So trang dang hien thi
$link_current_page = ($p > 0) ? '&p=' . $p : '';
$nNewsSize = 2000;
//for ($i=1;$i<=2;$i++) {
$sql_query="Select * from `".$table_content."` where trash=1 ". $sql_seach."  ORDER BY ". $sql_order . " LIMIT " . $p . "," . $nNewsSize;
makeBdsList($sql_query,"MENULIST");
//}

$url = './'.$qr_order.$sql_seach;
$page = generate_pagination($url, $nRows, $nNewsSize, $p);
$template -> assign_vars(array(
	'link_page_info'                 => $page,   
	'txt_showleft'                 => "showleft",   
));
$template -> assign_vars(array(
	'txt_msg_error'          => $emsg,
	'txt_show_error'         => ($emsg=='')?'none':'block',
	'txt_mess_result'        => ($mess_result_check_item==true)?'success':'error',
));
$template -> pparse('Home');
?>