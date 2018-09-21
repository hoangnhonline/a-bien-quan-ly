<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ../');
	exit('Login failed');
}
$template -> set_filenames(array(
	'page'	=> $dir_template . 'users.html')
);
$emsg ='';   //Bien luu tru thong tin
$mess_result_check_item = true; //Keu loi
	if (isset($_POST["cmd"]) and $_POST["cmd"]=="update") {
		$user_id = $_POST["user_id"];
		$user_pre = $_POST["user_pre"];
		$user_name = $_POST["user_name"];
		$user_mobile1 = $_POST["user_mobile1"];
		$user_mobile2 = $_POST["user_mobile2"];
		$user_phone = $_POST["user_phone"];
		$user_address = $_POST["user_address"];
		if(count($user_id) > 0)
		{
			for($i=0;$i<count($user_id);$i++)
			{
				$admin_id=Make_field_values1("admin_id", $table_u, $db," where id='".$user_id[$i]."'");
				if ($admin_id==$_SESSION['login_id'] OR $_SESSION['is_admin']) {
					$sql_update = "UPDATE `".$table_u."` SET `pre` = '".$user_pre[$i]."',
															`name` = '".insertData($user_name[$i])."',
															`mobile1` = '".insertData($user_mobile1[$i])."',
															`mobile2` = '".insertData($user_mobile2[$i])."',
															`phone` = '".insertData($user_phone[$i])."',
															`address` = '".insertData($user_address[$i])."' WHERE `id` = '".$user_id[$i]."'";
					$sql_update = $db->sql_query($sql_update) or die(mysql_error());
				}
			}
			$emsg="Cập nhật khách hàng thành công.";
			$bmsg=true;
		}
	}
	if (isset($_GET["del"]) and $_GET["del"]>0) {
		$user_id = $_GET["del"];
		$admin_id=Make_field_values1("admin_id", $table_u, $db," where id='".$user_id."'");
		if ($admin_id==$_SESSION['login_id'] OR $_SESSION['is_admin']) {
			$kh_name = Make_field_values1("name", $table_u, $db," where id='".$user_id."'");
			$check_content = Check_sub_info($table_content, $db, " where trash=1 and user_id='".$user_id."'");
			if ($check_content > 0) {
				$emsg ='Bạn chưa thể xóa vì khách hàng này đang còn dự án. [<a href="./?kh_id='.$user_id.'" style="color: #06f622;text-decoration: underline;" target="_blank">Xem danh sách dự án</a>]';   //Bien luu tru thong tin
				$mess_result_check_item = false; //Keu loi	
			} else {
				$sql_query  = "delete from `".$table_u."` where id='".$_GET["del"]."'";
				$sql_query = $db -> sql_query($sql_query) or die(mysql_error());	
				addLog("Đã xóa khách hàng: ".$kh_name, 0, 0);
				$emsg ='Đã xóa khách hàng thành công';   //Bien luu tru thong tin
				$mess_result_check_item = true; //Keu loi			
			}
		} else {
				$emsg ='Bạn không được cấp quyền xóa khu vực này.';   //Bien luu tru thong tin
				$mess_result_check_item = false; //Keu loi	
		}
	}
	//danh sach khach hang
	$sql_info_total = "SELECT COUNT(*) FROM `".$table_u."` where admin_id='".$_SESSION['login_id']."' ORDER by name ASC";
	$sql_info_total = $db->sql_query($sql_info_total) or die(mysql_error());
	$nRows = $db->sql_fetchfield(0);
	$p = !empty($HTTP_GET_VARS['p']) ? $HTTP_GET_VARS['p'] : 0;
	// Set lai $p neu $p >= $nRows
	$p = ( ($p >= $nRows) || !is_numeric($p) || ($p < 0)) ? 0 : $p;
	// So trang dang hien thi
	$link_current_page = ($p > 0) ? '&p=' . $p : '';
	$nNewsSize = 10;
	$sql_query="Select * from `".$table_u."` where admin_id='".$_SESSION['login_id']."' ORDER BY name ASC LIMIT " . $p . "," . $nNewsSize;
	$sql_query = mysql_query($sql_query);
	$stt=0;
	while($sql_query_rows = mysql_fetch_array($sql_query))
	{
		$stt++;
		$pre_arr = array("","Anh","Chị","Ông","Bà");
		$template->assign_block_vars('MENULIST',array(
			'tt'     		=>  $p + $stt,
			'id'     		=>  $sql_query_rows['id'],
			'name'			=>  $sql_query_rows['name'],
			'pre'			=>  $pre_arr[$sql_query_rows['pre']],
			'mobile1'			=>  $sql_query_rows['mobile1'],
			'mobile2'			=>  $sql_query_rows['mobile2'],
			'phone'			=>  $sql_query_rows['phone'],
			'pre'.$sql_query_rows['pre'].'_selected'			=>  "selected",
			'address'			=>  $sql_query_rows['address'],
			'create_time'			=>  transform_date_back($sql_query_rows['create_time']),
		));
	}
	
	$url = './?sort=name';
	$page = generate_pagination($url, $nRows, $nNewsSize, $p);
	$template -> assign_vars(array(
		'link_page_info'                 => $page,   
	));

$template -> assign_vars(array(
	'txt_msg_error'          => $emsg,
	'txt_show_error'         => ($emsg=='')?'none':'block',
	'txt_mess_result'        => ($mess_result_check_item==true)?'success':'error',
));
$template -> pparse('page');
?>