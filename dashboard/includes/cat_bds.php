<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ../');
	exit('Login failed');
}
$template -> set_filenames(array(
	'page'	=> $dir_template . 'cat_bds.html')
);
$emsg ='';   //Bien luu tru thong tin
$mess_result_check_item = true; //Keu loi
	if (isset($_POST["cmd"]) and $_POST["cmd"]=="addnew") {
		$bds_name = $_POST["bds_name"];
		$bds_parent = $_POST["bds_parent"];
		$bds_des = $_POST["bds_des"];
		$sql_query  = "insert into `".$table_catcontent."` (`admin_id`,`parent_id`,`title`,`sub`,`create_time`) values('".insertData($_SESSION['login_id'])."','".insertData($bds_parent)."','".insertData($bds_name)."','".insertData($bds_des)."',NOW())";
		$sql_query = $db -> sql_query($sql_query) or die(mysql_error());
		$emsg ='Đã thêm mới khu vực thành công';   //Bien luu tru thong tin
		$mess_result_check_item = true; //Keu loi
	}
	if (isset($_POST["cmd"]) and $_POST["cmd"]=="update") {
		$bds_id = $_POST["cid"];
		$bds_name = $_POST["bds_name"];
		$bds_parent = $_POST["bds_parent"];
		$bds_des = $_POST["bds_des"];
		$admin_id=Make_field_values1("admin_id", $table_catcontent, $db," where id='".$bds_id."'");
		if ($admin_id==$_SESSION['login_id'] OR $_SESSION['is_admin']) {
				$sql_query  = "update `".$table_catcontent."` SET parent_id='".insertData($bds_parent)."',title='".insertData($bds_name)."',sub='".insertData($bds_des)."' WHERE id='".insertData($bds_id)."'";
				$sql_query = $db -> sql_query($sql_query) or die(mysql_error());
				addLog("Cập nhật nội dung", $bds_id, 0);
				$emsg ='Đã cập nhật khu vực thành công';   //Bien luu tru thong tin
				$mess_result_check_item = true; //Keu loi			
		} else {
				$emsg ='Bạn không thể thay đổi khu vực này.';   //Bien luu tru thong tin
				$mess_result_check_item = false; //Keu loi	
		}

	}
	
	if (isset($_GET["del"]) and $_GET["del"]>0) {
		$bds_id = $_GET["del"];
		$admin_id=Make_field_values1("admin_id", $table_catcontent, $db," where id='".$bds_id."'");
		if ($_SESSION['is_admin']) {
			$check_content = Check_sub_info($table_content, $db, " where trash=1 and (cat1_id='".$bds_id."' OR cat2_id='".$bds_id."')");
			$check_subcat = Check_sub_info($table_catcontent, $db, " where parent_id='".$bds_id."'");
			if ($check_content > 0 OR $check_subcat > 0) {
				$emsg ='Bạn chưa thể xóa khu vực đã chọn còn khu vực con hoặc dự án.';   //Bien luu tru thong tin
				$mess_result_check_item = false; //Keu loi	
			} else {
				$sql_query  = "delete from `".$table_catcontent."` where id='".$_GET["del"]."'";
				$sql_query = $db -> sql_query($sql_query) or die(mysql_error());				
				addLog("Đã xóa khu vực", $bds_id, 0);
				$emsg ='Đã xóa khu vực thành công';   //Bien luu tru thong tin
				$mess_result_check_item = true; //Keu loi			

			}
		} else {
				$emsg ='Bạn không được phép xóa khu vực.';   //Bien luu tru thong tin
				$mess_result_check_item = false; //Keu loi	
		}
	}
	//danh sach
	$sql_query = "SELECT * FROM `" . $table_catcontent . "` where parent_id='0' order by title ASC";
	$sql_query = mysql_query($sql_query);
	$count=0;
	while($sql_query_rows = mysql_fetch_array($sql_query))
	{
		$count++;
		$template->assign_block_vars('MENULIST',array(
			'tt'     		=>  $count,
			'id'     		=>  $sql_query_rows['id'],
			'title'			=>  $sql_query_rows['title'],
			'title1'			=>  $sql_query_rows['title'],
			'admin_name'	=>  Make_field_values1("admin_user", $table_ad, $db," where admin_id='".$sql_query_rows['admin_id']."'"),
			'show_action'	=>  ($_SESSION['is_admin'])?"":"display:none;",
		));
		$sql_query1 = "SELECT * FROM `" . $table_catcontent . "` where parent_id='".$sql_query_rows['id']."' order by title ASC";
		$sql_query1 = mysql_query($sql_query1);
		while($sql_query_rows1 = mysql_fetch_array($sql_query1))
		{
			$count++;
			$template->assign_block_vars('MENULIST',array(
				'tt'     		=>  $count,
				'id'     		=>  $sql_query_rows1['id'],
				'title'			=>  $sql_query_rows1['title'],
				'title1'			=> "---- ".$sql_query_rows1['title'],
				'admin_name'	=>  Make_field_values1("admin_user", $table_ad, $db," where admin_id='".$sql_query_rows1['admin_id']."'"),
				'show_action'	=>  ($_SESSION['is_admin'])?"":"display:none;",
			));
			$sql_query2 = "SELECT * FROM `" . $table_catcontent . "` where parent_id='".$sql_query_rows1['id']."' order by title ASC";
			$sql_query2 = mysql_query($sql_query2);
			while($sql_query_rows2 = mysql_fetch_array($sql_query2))
			{
				$count++;
				$template->assign_block_vars('MENULIST',array(
					'tt'     		=>  $count,
					'id'     		=>  $sql_query_rows2['id'],
					'title'			=>  $sql_query_rows2['title'],
					'title1'			=>  "-------- ".$sql_query_rows2['title'],
					'admin_name'	=>  Make_field_values1("admin_user", $table_ad, $db," where admin_id='".$sql_query_rows2['admin_id']."'"),
					'show_action'	=>  ($_SESSION['is_admin'])?"":"display:none;",
				));
				
			}			
		}		
	}

$template -> assign_vars(array(
	'txt_msg_error'          => $emsg,
	'txt_show_error'         => ($emsg=='')?'none':'block',
	'txt_mess_result'        => ($mess_result_check_item==true)?'success':'error',
));
$template -> pparse('page');
?>