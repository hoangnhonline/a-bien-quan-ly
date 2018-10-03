<?php
include('./includes/config.inc.php');
include($dir_inc.'template.php');
include($dir_inc.'functions.php');
include($dir_inc.'function.php');
$template = new Template();
$disabled_enter_script = "<script type=\"text/javascript\">
		$(document).ready(function(){
			$('#addproForm1').on('keyup keypress', function(e) {
			  var keyCode = e.keyCode || e.which;
			  if (keyCode === 13) { 
			    e.preventDefault();
			    return false;
			  }
			});
		});
	</script>";
/*
if ($_GET["act"]=="getLog") {
        $sql_define_cat="Select * from `demo1_tbllog` ORDER BY id desc";
        $sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
        $couter=0;
        //echo strlen('Tôi muốn nhờ Công ty giúp đỡ ');
        while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
        {
        	$couter++;
			$admin = Make_field_values1("admin_user", "demo1_tbladmin", $db," where admin_id='".$sql_define_cat_rows['admin_id']."'");
echo "[".$sql_define_cat_rows['create_time']."] ".$sql_define_cat_rows['ip']." ".$admin." ".$sql_define_cat_rows['log']."<br>";

        }
}
*/
if (!isset($_SESSION['login_id']) and isset($_COOKIE['admin_login_id']) and $_COOKIE['admin_login_id']>0  and isset($_COOKIE['admin_login_pass']))
{
	$sql_check_login = "SELECT * FROM " . $DB_FSQL . "tbladmin WHERE admin_id='".$_COOKIE['admin_login_id']."' and admin_password='".$_COOKIE['admin_login_pass']."' AND admin_status = 1";
	$sql_check_login = $db->sql_query($sql_check_login);
	// Kiem tra xem cau truc sql co dung khong
	if ( $db->sql_numrows($sql_check_login) >= 1)
	{
		while($db->sql_fetchrow($sql_check_login))
		{
			$_SESSION['login_id'] = $db->row[$sql_check_login]['admin_id'];
			$_SESSION['login_pass'] = $db->row[$sql_check_login]['admin_password'];
			$_SESSION['email']   = $db->row[$sql_check_login]['admin_email'];
			$_SESSION['username'] = $db->row[$sql_check_login]['admin_user'];
			$_SESSION['lang']     =  "1";
			$_SESSION['login']      = 'luyenpv';
			setcookie('admin_login_id', $_SESSION['login_id'], time()+60*60*24*30); 
			setcookie('admin_login_pass', $_SESSION['login_pass'], time()+60*60*24*30); 
		}
	}
}
if (!isset($_SESSION['login_id']) OR !isset($_SESSION['login_pass']) OR $_SESSION['login_id']<1) {
	exit("Không thể nhận dạng Admin, vui lòng đăng nhập lại!");
} else {
	$check_login = Check_sub_info($table_ad,$db," WHERE `admin_id` ='".$_SESSION['login_id']."' and `admin_password` ='".$_SESSION['login_pass']."' and admin_status='1'");
	if ($check_login<1) {
		exit("Không thể nhận dạng Admin, vui lòng đăng nhập lại!");
	}
}
$group_id = Make_field_values1('group', $table_a, $db, " where admin_id='".$_SESSION['login_id']."'");
$_SESSION['is_admin'] = false;
if ($group_id=="1") $_SESSION['is_admin'] = true;
$act="";
if (isset($_GET['act'])) $act=$_GET['act'];
if ($act=="addPro" OR $act=="editPro"){
	$user_pre = 	$_POST["user_pre"];
	$user_name = 	$_POST["user_name"];
	$user_mobile1 = $_POST["user_mobile1"];
	$user_mobile2 = $_POST["user_mobile2"];
	$user_phone =   $_POST["user_phone"];
	$user_address = $_POST["user_address"];
	$pro_code =     $_POST["pro_code"];
	$pro_cat1 = 	$_POST["pro_cat1"];
	$pro_cat2 = 	$_POST["pro_cat2"];
	$pro_expired = 	$_POST["pro_expired"];
	$pro_status = 	$_POST["pro_status"];
	$pro_dt = 		$_POST["pro_dt"];
	$pro_dt_d = 	$_POST["pro_dt_d"];
	$pro_dt_r = 	$_POST["pro_dt_r"];
	$pro_price = 	$_POST["pro_price"];
	$pro_price_dvt =$_POST["pro_price_dvt"];
	$pro_ren = 		$_POST["pro_ren"];
	$pro_ren_dvt = 	$_POST["pro_ren_dvt"];
	$pro_soPN = 	$_POST["pro_soPN"];
	$pro_soWC = 	$_POST["pro_soWC"];
	$pro_huong = 	$_POST["pro_huong"];
	$pro_note = 	$_POST["pro_note"];
	$pro_flag = 	(isset($_POST["flag"]))?$_POST["flag"]:"";
	if ($act=="addPro") {
		if (strlen($_POST["user_name"])<1) exit("Vui lòng nhập tên khách hàng");
		if (strlen($_POST["user_mobile1"])<6) exit("Vui lòng nhập số di động");
		if (trim($_POST["pro_code"])=="") exit("Vui lòng nhập ký hiệu BĐS");
		if ((int)$_POST["pro_cat1"]==0 OR (int)$_POST["pro_cat2"]==0) exit("Vui lòng chọn khu vực dự án");
		if ((int)$_POST["pro_huong"]==0) exit("Vui lòng chọn hướng của dự án");
		$check_code = (int)Make_field_values1("id", $table_content, $db," where trash=1 and code='".$pro_code."' and cat2_id='".$pro_cat2."'");
		if ($check_code>0) exit("Ký hiệu (Mã) BĐS này đã có, vui lòng chọn mã khác.");
		//them user
		//$user_id = (int)Make_field_values1("id", $table_u, $db," where admin_id='".$_SESSION['login_id']."' and pre='".$user_pre."' and name='".$user_name."' and mobile1='".$user_mobile1."' and mobile2='".$user_mobile2."' and phone='".$user_phone."'");
		//moi du an la 1 user
		$user_id = 0;
		if ($user_id==0) {
			$sql_query  = "insert into `".$table_u."` (`admin_id`,`pre`,`name`,`mobile1`,`mobile2`,`phone`,`address`,`create_time`) values('".insertData($_SESSION['login_id'])."','".insertData($user_pre)."','".insertData($user_name)."','".insertData($user_mobile1)."','".insertData($user_mobile2)."','".insertData($user_phone)."','".insertData($user_address)."',NOW())";
			$sql_query = $db -> sql_query($sql_query) or die(mysql_error());
			$user_id = (int)Make_field_values1("id", $table_u, $db," ORDER by id DESC limit 1");
		}
		if ($user_id<1) exit("Lỗi tạo khách hàng, vui lòng thử lại.");
		//wait user neu la admin
		$wait_user=0;
		if ($_SESSION['is_admin']) {$wait_user=1;}
		$sql_query  = "insert into `".$table_content."` (`admin_id`,
														`cat1_id`,
														`cat2_id`,
														`title`,
														`user_id`,
														`code`,
														`expired`,
														`status`,
														`dt`,
														`dt_r`,
														`dt_d`,
														`price`,
														`price_dvt`,
														`ren`,
														`ren_dvt`,
														`soPN`,
														`SoWC`,
														`huong`,
														`flag`,
														`wait_user`,
														`create_time`,`update_time`,`admin_update_time`) values('".insertData($_SESSION['login_id'])."',
														'".insertData($pro_cat1)."',
														'".insertData($pro_cat2)."',
														'".insertData("")."',
														'".insertData($user_id)."',
														'".insertData($pro_code)."',
														'".insertData($pro_expired)."',
														'".insertData($pro_status)."',
														'".insertData($pro_dt)."',
														'".insertData($pro_dt_r)."',
														'".insertData($pro_dt_d)."',
														'".insertData($pro_price)."',
														'".insertData($pro_price_dvt)."',
														'".insertData($pro_ren)."',
														'".insertData($pro_ren_dvt)."',
														'".insertData($pro_soPN)."',
														'".insertData($pro_soWC)."',
														'".insertData($pro_huong)."',
														'".insertData($pro_flag)."','".insertData($wait_user)."',NOW(),NOW(),NOW())";
		$sql_query = $db -> sql_query($sql_query) or die(mysql_error());
		$last_id = (int)Make_field_values1("id", $table_content, $db," where admin_id='".$_SESSION['login_id']."' ORDER by id DESC limit 1");
		addLog("Tạo mới BĐS", 0, $last_id,"addnew");
		if(trim($pro_note)<>"") {addNote($pro_note, $last_id);}
		exit("--RUN:
		<script>
		alert('Tạo mới BĐS thành công.');
		document.getElementById('addproForm').reset();
		loadBDS();
		</script>");
	} else if ($act=="editPro") {
		$pro_id = $_POST["pro_id"];
		$check_code = (int)Make_field_values1("id", $table_content, $db," where trash=1 and code='".$pro_code."' and id<>'".$pro_id."' and cat2_id='".$pro_cat2."'");
		if ($check_code>0) exit("Ký hiệu (Mã) BĐS này đã có, vui lòng chọn mã khác.");
		$pro_admin = Make_field_values1("admin_id", $table_content, $db," where id='".$pro_id."'");
		$pro_update_time = Make_field_values1("update_time", $table_content, $db," where id='".$pro_id."'");
		$cur_status = Make_field_values1("status", $table_content, $db," where id='".$pro_id."'");
		$wait_user = (int)Make_field_values1("wait_user", $table_content, $db," where id='".$pro_id."'");
		
		if($pro_admin == $_SESSION['login_id'] || $_SESSION['is_admin'] || checkExpired($pro_update_time, 1)){ // kiem tra xem co phai chủ tin hoặc admin hoặc tin đã hết hạn hay ko ?

			if ($_SESSION['is_admin'] OR $pro_admin == $_SESSION['login_id'] OR $wait_user==1) {
				//cap nhat che do full			
				if (strlen($_POST["user_name"])<1) exit("Vui lòng nhập tên khách hàng");
				if (strlen($_POST["user_mobile1"])<6) exit("Vui lòng nhập số di động");
				if (trim($_POST["pro_code"])=="") exit("Vui lòng nhập ký hiệu BĐS");
				if ((int)$_POST["pro_huong"]==0) exit("Vui lòng chọn hướng của dự án");
				$user_id = (int)Make_field_values1("user_id", $table_content, $db," where id='".$pro_id."'");
				//cap nhat lai thong tin user			
				$sql_query  = "UPDATE `".$table_u."` SET `pre`='".insertData($user_pre)."',`name`='".insertData($user_name)."',`mobile1`='".insertData($user_mobile1)."',`mobile2`='".insertData($user_mobile2)."',`phone`='".insertData($user_phone)."',`address`='".insertData($user_address)."' where id='".$user_id."'";
				$sql_query = $db -> sql_query($sql_query) or die(mysql_error());
				//cap nhat du an
				$sql_query  = "update `".$table_content."` SET  `cat1_id`='".insertData($pro_cat1)."',
																`cat2_id`='".insertData($pro_cat2)."',
																`title`='".insertData("")."',
																`code`='".insertData($pro_code)."',
																`expired`='".insertData($pro_expired)."',
																`status`='".insertData($pro_status)."',
																`dt`='".insertData($pro_dt)."',
																`dt_r`='".insertData($pro_dt_r)."',
																`dt_d`='".insertData($pro_dt_d)."',
																`price`='".insertData($pro_price)."',
																`price_dvt`='".insertData($pro_price_dvt)."',
																`ren`='".insertData($pro_ren)."',
																`ren_dvt`='".insertData($pro_ren_dvt)."',
																`soPN`='".insertData($pro_soPN)."',
																`SoWC`='".insertData($pro_soWC)."',
																`huong`='".insertData($pro_huong)."',
																`flag`='".insertData($pro_flag)."',`update_time`=NOW() where id='".insertData($pro_id)."'";
			} else {
				//cap nhat che do han che
				$sql_query  = "update `".$table_content."` SET  
				`admin_id`=".$_SESSION['login_id'].",
				`expired`='".insertData($pro_expired)."',
																`status`='".insertData($pro_status)."',
																`dt`='".insertData($pro_dt)."',
																`dt_r`='".insertData($pro_dt_r)."',
																`dt_d`='".insertData($pro_dt_d)."',
																`price`='".insertData($pro_price)."',
																`price_dvt`='".insertData($pro_price_dvt)."',
																`ren`='".insertData($pro_ren)."',
																`ren_dvt`='".insertData($pro_ren_dvt)."',
																`soPN`='".insertData($pro_soPN)."',
																`SoWC`='".insertData($pro_soWC)."',
																`huong`='".insertData($pro_huong)."',
																`flag`='".insertData($pro_flag)."',`update_time`=NOW() where id='".insertData($pro_id)."'";
			}
			$query = $sql_query;
			$sql_query = $db -> sql_query($sql_query) or die(mysql_error());

			//cap nhat ngay edit gan nhat neu là du an cua nhan vien
			if ($pro_admin == $_SESSION['login_id']) {
				$sql_query  = "update `".$table_content."` SET  `admin_update_time`=NOW() where id='".insertData($pro_id)."'";
				$sql_query = $db -> sql_query($sql_query) or die(mysql_error());
			}

			//chuyen nhan vien neu ko phai la admin
			if ($wait_user==1 AND !$_SESSION['is_admin']) {
				//update wait_user
				$sql_query  = "update `".$table_content."` SET  `wait_user`='0',`admin_id`='".$_SESSION['login_id']."',`admin_update_time`=NOW() where id='".insertData($pro_id)."'";
				$sql_query = $db -> sql_query($sql_query) or die(mysql_error());
				//chuyen user
				$sql_query  = "update `".$table_u."` SET  `admin_id`='".$_SESSION['login_id']."' where id='".insertData($user_id)."'";
				$sql_query = $db -> sql_query($sql_query) or die(mysql_error());
				//add log
				addLog("Chuyển dự án cho ".Make_field_values1("admin_user", $table_ad, $db," where admin_id='".$_SESSION['login_id']."'"), 0, $pro_id,"change_use");
			}

		} // kiem tra xem co phai chủ tin hoặc admin hoặc tin đã hết hạn hay ko ?

		addLog("Cập nhật thông tin", 0, $pro_id,$query);
		if ($cur_status<>$pro_status) {
			addLog("Đổi trạng thái thành ".Make_field_values1("title", $table_content_status, $db," where id='".$pro_status."'"), 0, $pro_id,"change_status");
		}
		$pro_note = trim($pro_note)<>"" ? $pro_note : "Không có nội dung cập nhật";
		if(trim($pro_note)<>"") {addNote($pro_note, $pro_id);}
		exit("--RUN:
		<script>
		alert('Đã cập nhật BĐS thành công.');
		editBds('".$pro_id."');
		loadBDS();
		</script>");
	}
} else if ($act=="getCat2"){
	$template -> set_filenames(array(
		'page'	    => $dir_template . 'loadCat2.html'
	));
	if (!isset($_GET["cat1Id"]) OR $_GET["cat1Id"]=="0") exit('<option value="0">Vui lòng chọn</option>');
	$sql_query1 = "SELECT * FROM `" . $table_catcontent . "` where parent_id='".$_GET["cat1Id"]."' order by title ASC";
	$sql_query1 = mysql_query($sql_query1);
	while($sql_query_rows1 = mysql_fetch_array($sql_query1))
	{
		$count++;
		$template->assign_block_vars('CAT2',array(
			'id'     		=>  $sql_query_rows1['id'],
			'title'			=>  $sql_query_rows1['title'],
		));
	}
	$template -> pparse('page');
	exit();
}
 else if ($act=="dupBDS" OR $act=="editBds"){
	if ($act=="dupBDS") {
		$template -> set_filenames(array(
			'page'	    => $dir_template . 'dupBDS.html'
		));
	}
	if ($act=="editBds") {
			$template -> set_filenames(array(
				'page'	    => $dir_template . 'editBds.html'
			));	
		
	}
	$pro_admin_id = Make_field_values1("admin_id", $table_content, $db," where id='".$_GET["id"]."'");
	$sql_query="Select * from `".$table_content."` where id='".$_GET["id"]."'";
	$sql_query = $db->sql_query($sql_query) or die(mysql_error());
	while($sql_query_rows = mysql_fetch_array($sql_query))
	{
		$user_id = $sql_query_rows['user_id'];
		$user_pre = Make_field_values1("pre", $table_u, $db," where id='".$user_id."'");
		if ($_SESSION['is_admin']) {
			//neu la admin hien tat ca user
			$sql_query1 = "SELECT * FROM `" . $table_u . "` order by name ASC";
		} else {
			if ($pro_admin_id == $_SESSION['login_id'] OR $act=="dupBDS") {
				$sql_query1 = "SELECT * FROM `" . $table_u . "` where admin_id='".$_SESSION['login_id']."' order by name ASC";
			} else {
				$sql_query1 = "SELECT * FROM `" . $table_u . "` where id='".$user_id."' order by name ASC";
			}
		}

		//khu vuc
		$cat1_id = $sql_query_rows['cat1_id'];
		$cat2_id = $sql_query_rows['cat2_id'];
		$sql_query1 = "SELECT * FROM `" . $table_catcontent . "` where parent_id='0' order by title ASC";
		$sql_query1 = mysql_query($sql_query1);
		while($sql_query_rows1 = mysql_fetch_array($sql_query1))
		{
			$template->assign_block_vars('CAT1',array(
				'id'     		=>  $sql_query_rows1['id'],
				'title'			=>  $sql_query_rows1['title'],
				'selected'			=>  ($sql_query_rows1['id']==$cat1_id)?"selected":"",
			));
		}
		$sql_query1 = "SELECT * FROM `" . $table_catcontent . "` where parent_id='".$cat1_id."' order by title ASC";
		$sql_query1 = mysql_query($sql_query1);
		while($sql_query_rows1 = mysql_fetch_array($sql_query1))
		{
			$template->assign_block_vars('CAT2',array(
				'id'     		=>  $sql_query_rows1['id'],
				'title'			=>  $sql_query_rows1['title'],
				'selected'			=>  ($sql_query_rows1['id']==$cat2_id)?"selected":"",
			));
		}
		//trang thai
		$status = $sql_query_rows['status'];		
		$sql_query1 = "SELECT * FROM `" . $table_content_status . "` order by id ASC";
		$sql_query1 = mysql_query($sql_query1);
		while($sql_query_rows1 = mysql_fetch_array($sql_query1))
		{
			$template->assign_block_vars('CSTATUS',array(
				'id'     		=>  $sql_query_rows1['id'],
				'title'			=>  $sql_query_rows1['title'],
				'color'			=>  $sql_query_rows1['color'],
				'selected'			=>  ($sql_query_rows1['id']==$status)?"selected":"",
			));
		}
		$template->assign_vars(array(
			'txt_user_pre'.(int)Make_field_values1("pre", $table_u, $db," where id='".$user_id."'").'_selected'		=>  "selected",
			'txt_pro_huong'.(int)$sql_query_rows['huong'].'_selected'		=>  "selected",
			'txt_user_name'		=>  Make_field_values1("name", $table_u, $db," where id='".$user_id."'"),
			'txt_user_mobile1'	=>  ($pro_admin_id==$_SESSION['login_id'] OR $_SESSION['is_admin'] OR (int)$sql_query_rows['wait_user']==1 OR checkExpired($sql_query_rows['update_time']) OR $sql_query_rows['status']!=1 ) ? Make_field_values1("mobile1", $table_u, $db," where id='".$user_id."'"):"",
			'txt_user_mobile2'	=>  ($pro_admin_id == $_SESSION['login_id'] OR $_SESSION['is_admin'] OR (int)$sql_query_rows['wait_user'] == 1 OR checkExpired($sql_query_rows['update_time']) OR $sql_query_rows['status']!=1)  ? Make_field_values1("mobile2", $table_u, $db," where id='".$user_id."'"):"",
			'txt_user_phone'	=>  ($pro_admin_id==$_SESSION['login_id'] OR $_SESSION['is_admin'] OR (int)$sql_query_rows['wait_user']==1)?Make_field_values1("phone", $table_u, $db," where id='".$user_id."'"):"",
			'txt_pro_cat1'		=>  Make_field_values1("title", $table_catcontent, $db," where id='".$sql_query_rows['cat1_id']."'"),
			'txt_pro_cat2'		=>  Make_field_values1("title", $table_catcontent, $db," where id='".$sql_query_rows['cat2_id']."'"),
			'txt_pro_status'		=>  Make_field_values1("title", $table_content_status, $db," where id='".$sql_query_rows['status']."'"),
			'txt_pro_status_color'	=>  Make_field_values1("color", $table_content_status, $db," where id='".$sql_query_rows['status']."'"),
			'txt_pro_id'		=>  $sql_query_rows['id'],
			'txt_pro_titme'		=>  $sql_query_rows['create_time'],
			'txt_pro_admin'		=>  Make_field_values1("admin_user", $table_ad, $db," where admin_id='".$sql_query_rows['admin_id']."'"),
			'txt_pro_code'		=>  $sql_query_rows['code'],
			'txt_pro_expired'		=>  $sql_query_rows['expired'],
			'txt_pro_dt'			=>  ((int)$sql_query_rows['dt'] == $sql_query_rows['dt'])?(int)$sql_query_rows['dt']:$sql_query_rows['dt'],
			'txt_pro_dt_d'			=>  ((int)$sql_query_rows['dt_d'] == $sql_query_rows['dt_d'])?(int)$sql_query_rows['dt_d']:$sql_query_rows['dt_d'],
			'txt_pro_dt_r'			=>  ((int)$sql_query_rows['dt_r'] == $sql_query_rows['dt_r'])?(int)$sql_query_rows['dt_r']:$sql_query_rows['dt_r'],
			'txt_pro_price'			=>  ((int)$sql_query_rows['price'] == $sql_query_rows['price'])?(int)$sql_query_rows['price']:$sql_query_rows['price'],
			'price_dvt2_selected'	=>  ($sql_query_rows['price_dvt']=="Triệu")?"selected":"",
			'txt_pro_ren'			=>  ((int)$sql_query_rows['ren'] == $sql_query_rows['ren'])?(int)$sql_query_rows['ren']:$sql_query_rows['ren'],
			'ren_dvt2_selected'	=>  ($sql_query_rows['ren_dvt']=="Triệu")?"selected":"",
			'pro_hot_checked'	=>  ($sql_query_rows['flag']=="hot")?"checked":"",
			'txt_pro_soPN'			=>  $sql_query_rows['soPN'],
			'txt_pro_SoWC'			=>  $sql_query_rows['SoWC'],
			'txt_pro_huong'			=>  $sql_query_rows['huong'],
			'txt_show_edit'	=>  ($_SESSION['login_id']==$sql_query_rows['admin_id'] OR $_SESSION['is_admin'] OR $act=="dupBDS")?"":"display:none;",
			'txt_show_view'	=>  ($_SESSION['login_id']==$sql_query_rows['admin_id'] OR $_SESSION['is_admin'] OR $act=="dupBDS")?"display:none;":"",
			'txt_readonly'	=>  ($_SESSION['login_id']==$sql_query_rows['admin_id'] OR $_SESSION['is_admin'] OR $act=="dupBDS" OR (int)$sql_query_rows['wait_user']==1)?"":"readonly",
			'txt_disabled'	=>  ($sql_query_rows['wait_user'] OR $_SESSION['login_id']==$sql_query_rows['admin_id'] OR $_SESSION['is_admin'] OR $act=="dupBDS")?"":"disabled",
			'show_addnew'	=>  ($_SESSION['login_id']==$sql_query_rows['admin_id'] OR $_SESSION['is_admin'])?"display:none;":"",
			'addnew_checked'	=>  ($_SESSION['login_id']==$sql_query_rows['admin_id'] OR $_SESSION['is_admin'] OR $act=="editBds")?"":"checked",
			'choise_checked'	=>  ($_SESSION['login_id']==$sql_query_rows['admin_id'] OR $_SESSION['is_admin'] OR $act=="editBds")?"checked":"",
			//'available_update' => (checkExpired($sql_query_rows['update_time']) OR $sql_query_rows['status'] > 1 OR $_SESSION['login_id']== $sql_query_rows['admin_id'] OR $_SESSION['is_admin'] ) ? '' : 'display:none',
			//'disabled_enter_script' => (checkExpired($sql_query_rows['update_time']) OR $sql_query_rows['status'] > 1 OR $_SESSION['login_id']== $sql_query_rows['admin_id'] OR $_SESSION['is_admin'] ) ? '' : $disabled_enter_script,
			'available_update' => '',
			'disabled_enter_script' => '',
		));
		//ghi chu
		$sql_query1 = "SELECT * FROM `" . $table_content_note . "` where content_id='".$_GET["id"]."' order by id DESC";
		$sql_query1 = mysql_query($sql_query1);
		while($sql_query_rows1 = mysql_fetch_array($sql_query1))
		{
			$template->assign_block_vars('NOTE',array(
				'time'			=>  $sql_query_rows1['create_time'],
				'note'			=>  $sql_query_rows1['note'],
				'admin'			=>  Make_field_values1("admin_user", $table_ad, $db," where admin_id='".$sql_query_rows1['admin_id']."'"),
			));
		}
		//log
		$sql_query1 = "SELECT * FROM `" . $table_log . "` where (query='change_status' OR query='addnew' OR query='change_use') and content_id='".$_GET["id"]."' order by id DESC";
		$sql_query1 = mysql_query($sql_query1);
		while($sql_query_rows1 = mysql_fetch_array($sql_query1))
		{
			$template->assign_block_vars('LOG',array(
				'time'			=>  $sql_query_rows1['create_time'],
				'log'			=>  $sql_query_rows1['log'],
				'admin'			=>  Make_field_values1("admin_user", $table_ad, $db," where admin_id='".$sql_query_rows1['admin_id']."'"),
			));
		}
	}
	$template -> pparse('page');
	exit();
} else if ($act=="loadBDS") {
	$template -> set_filenames(array(
		'page'	    => $dir_template . 'loadBDS.html'
	));
	$sql_seach="";
	if ($_POST["catbds_id"]>0) {
		$sql_seach.=" AND (cat1_id='".$_POST["catbds_id"]."' OR cat2_id='".$_POST["catbds_id"]."')";
	}
	if (isset($_POST["my_kh"])) {
		$sql_seach.=" AND user_id IN (SELECT id FROM `".$table_u."` WHERE `admin_id`='".$_SESSION['login_id']."')";
	}
	$sql_query="Select * from `".$table_content."` where trash=1 ". $sql_seach."  ORDER BY  status ASC,update_time ASC";
	//exit($sql_query);
	makeBdsList($sql_query,"MENULIST");
	$template -> pparse('page');
}

?>