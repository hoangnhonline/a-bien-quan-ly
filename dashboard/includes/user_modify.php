<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ./login.php');
	exit('Login failed');
}
$table_ad =  $DB_FSQL . "tbladmin";
$template -> set_filenames(array(
	'user_modify'	=> $dir_template . 'user_modify.html')
);

// ******************************************** 1. INFORMATION DERFAULT ***********************************************
               $template->assign_vars(array(
                    'txt_show_error'         => 'none', //Hiển thị lỗi mặc định
            	));

                $id = '0';
                $emsg ='';   //Biến lưu trữ thông báo
                $bmsg = true; //Style lỗi
                $bEdited = false; //Kiểm tra có phải là sửa hay không
                $bAll = true;    //Hiện tất cả các cửa sổ
                $str_add            =   ($_SESSION['lang']=='vn')?'Thêm mới':'Add New';
                $str_mod            =   ($_SESSION['lang']=='vn')?'Sửa':'edit';

                if(isset($HTTP_GET_VARS['edit']))
                	$id = $HTTP_GET_VARS['edit'];

                $cmd = '';
                if(isset($HTTP_POST_VARS['cmd']))
                   $cmd = $HTTP_POST_VARS['cmd'];
                if(isset($HTTP_POST_VARS['cmdl']))
                   $cmd = $HTTP_POST_VARS['cmdl'];
// ******************************************** 2. UPDATE INFORMATION ***********************************************
if ($cmd=='add')
{
	$strUserHname 	= $HTTP_POST_VARS['txtUserHname'];
	$strUsername 	= $HTTP_POST_VARS['txtUsername'];
	$strUseremail	= $HTTP_POST_VARS['txtUseremail'];
	$strUserphone 	= $HTTP_POST_VARS['txtUserphone'];
	$err=0;
	$nfRows      = Check_sub_info($table_ad,$db," WHERE `admin_user` ='".$strUsername."'");
	if ($nfRows>0) {
			$template -> assign_vars(array(
                'txtUserHname_inf'         => $strUserHname,
                'txtUsername_inf'         => $strUsername,
                'txtUseremail_inf'        => $strUseremail,
                'txtUserphone_inf'        => $strUserphone,
			));
    $emsg="Nhân viên với tên này đã tồn tại, vui lòng kiểm tra lại.";
    $bmsg=false;
	$err=1;
	}
	$nfRows      = Check_sub_info($table_ad,$db," WHERE `admin_email` ='".$strUseremail."'");
	if ($nfRows>0) {
			$template -> assign_vars(array(
                'txtUserHname_inf'         => $strUserHname,
				'txtUsername_inf'         => $strUsername,
                'txtUseremail_inf'        => $strUseremail,
                'txtUserphone_inf'        => $strUserphone,
			));
    $emsg="Nhân viên với địa chỉ email này đã tồn tại, vui lòng kiểm tra lại.";
    $bmsg=false;
	$err=1;
	}
	
	$strPwd 		= !empty($HTTP_POST_VARS['txtPwd'])? md5($HTTP_POST_VARS['txtPwd']):'';
	$bStatus 		= (int)$HTTP_POST_VARS['cbstatus'];
	$group 			= (int)$HTTP_POST_VARS['txtGroup'];
	$nfRows      = Check_sub_info($table_ad,$db," WHERE `admin_phone` ='".$strUserphone."'");
	if ($nfRows>0) {
			$template -> assign_vars(array(
                'txtUserHname_inf'         => $strUserHname,
				'txtUsername_inf'         => $strUsername,
                'txtUseremail_inf'        => $strUseremail,
                'txtUserphone_inf'        => $strUserphone,
			));
    $emsg="Nhân viên với số điện thoại này đã tồn tại, vui lòng kiểm tra lại.";
    $bmsg=false;
	$err=1;
	}
	if ($err==0) {
		//Insert authority to user by query string insert
		$sql_user_insert = "INSERT INTO ".$DB_FSQL."tbladmin (`admin_user`,`admin_name`,`admin_email`,`admin_phone`, `admin_password`, `group`, `admin_status`)
							VALUES('"
							.$strUsername . "', '"
							.$strUserHname . "', '"
							.$strUseremail . "', '"
							.$strUserphone . "', '"
							.$strPwd . "', '"
							.$group . "', '"
							.$bStatus . "')";
		$sql_user_insert = $db->sql_query($sql_user_insert) or die(mysql_error());

		//Messge box successful
		$emsg="Đã tạo thành công tài khoản: ".$strUsername;
		$bmsg=true;
	}
}
if ($cmd=='edit' & $id!=0)
{
	$strUserHname 	= $HTTP_POST_VARS['txtUserHname'];
	$strUsername 	= $HTTP_POST_VARS['txtUsername'];
	$strUseremail	= $HTTP_POST_VARS['txtUseremail'];
	$strUserphone 	= $HTTP_POST_VARS['txtUserphone'];
	$strPwd 		= !empty($HTTP_POST_VARS['txtPwd'])? md5($HTTP_POST_VARS['txtPwd']):'';
	$bStatus 		= (int)$HTTP_POST_VARS['cbstatus'];
	$group 			= (int)$HTTP_POST_VARS['txtGroup'];
	$err=0;
	$nfRows      = Check_sub_info($table_ad,$db," WHERE `admin_user` ='".$strUsername."' and admin_id<>'".$id."'");
	if ($nfRows>0) {
			$template -> assign_vars(array(
                'txtUserHname_inf'         => $strUserHname,
				'txtUsername_inf'         => $strUsername,
                'txtUseremail_inf'        => $strUseremail,
                'txtUserphone_inf'        => $strUserphone,
			));
    $emsg="Nhân viên với tên này đã tồn tại, vui lòng kiểm tra lại.";
    $bmsg=false;
	$err=1;
	}
	$nfRows      = Check_sub_info($table_ad,$db," WHERE `admin_email` ='".$strUseremail."' and admin_id<>'".$id."'");
	if ($nfRows>0) {
			$template -> assign_vars(array(
                'txtUserHname_inf'         => $strUserHname,
				'txtUsername_inf'         => $strUsername,
                'txtUseremail_inf'        => $strUseremail,
                'txtUserphone_inf'        => $strUserphone,
			));
    $emsg="Nhân viên với địa chỉ email này đã tồn tại, vui lòng kiểm tra lại.";
    $bmsg=false;
	$err=1;
	}
	$nfRows      = Check_sub_info($table_ad,$db," WHERE `admin_phone` ='".$strUserphone."' and admin_id<>'".$id."'");
	if ($nfRows>0) {
			$template -> assign_vars(array(
                'txtUserHname_inf'         => $strUserHname,
				'txtUsername_inf'         => $strUsername,
                'txtUseremail_inf'        => $strUseremail,
                'txtUserphone_inf'        => $strUserphone,
			));
    $emsg="Nhân viên với số điện thoại này đã tồn tại, vui lòng kiểm tra lại.";
    $bmsg=false;
	$err=1;
	}
    $strPwd_query = ($strPwd!='')? "', `admin_password`='" .$strPwd:"";
	//Update authority to user by query string Update
	if ($err==0) {
	$sql_user_insert = "update ".$DB_FSQL."tbladmin set
                                   `admin_email`='".$strUseremail. "',`admin_name`='".$strUserHname. "',`admin_phone`='".$strUserphone."',
								   `admin_user`='" .$strUsername
                                   .$strPwd_query
								   . "', `group`='"            .$group
                                   . "', `admin_status`='"   .$bStatus . "' where `admin_id`='".$id."'";
	$sql_user_insert = $db->sql_query($sql_user_insert) or die(mysql_error());
	if ($_SESSION['is_admin'] AND $bStatus==0) {
		//chuyen du an ve wait_user
		$sql_query  = "update `".$table_content."` SET  `wait_user`='1' where admin_id='".insertData($id)."'";
		$sql_query = $db -> sql_query($sql_query) or die(mysql_error());
		addLog("Dừng hoạt động thành viên ".Make_field_values1("admin_user", $table_ad, $db," where admin_id='".$id."'"), 0, 0,"unpublic");
	}
	
    //Messge box successful
    $emsg="Đã cập nhật thành công tài khoản: ".$strUsername;
    $bmsg=true;
	}
    //Show edit pw
    $template -> assign_vars(array(
                'txtPwd_inf'        => ($strPwd!='')?displayData_Textbox($HTTP_POST_VARS['txtPwd']):'',
    ));
}

// ******************************************** 3. SHOW INFORMATION ***********************************************
//Bước 1: Nếu tồn tại biến ID
if ( !empty($id) && is_numeric($id))	//Nếu thấy có thông tin user truyền vào
{
    //Bước 1.1: Kiểm tra xem id này có tồn tại hay không (Sai thì báo lỗi links, đúng thì kiểm tra tiếp)
	$sql_user_edit = "SELECT * FROM ".$DB_FSQL."tbladmin WHERE admin_id = '" . $id . "'";
	$sql_user_edit = $db->sql_query($sql_user_edit) or die(mysql_error());
    $bEdited = (mysql_num_rows($sql_user_edit) == 1)?true:false;

    //Result: True (tồn tại id)
	if ($bEdited)
	{
		while ( $user_rows = $db->sql_fetchrow($sql_user_edit))
		{
			$template -> assign_vars(array(
                'txtUserHname_inf'        => displayData_Textbox($user_rows['admin_name']),
                'txtUsername_inf'        => displayData_Textbox($user_rows['admin_user']),
                'txtUseremail_inf'        => displayData_Textbox($user_rows['admin_email']),
                'txtUserphone_inf'        => displayData_Textbox($user_rows['admin_phone']),
			));

            //Bước 1.2: là Admin
			if($_SESSION['is_admin'])
			{
                        //Hiển thị trạng thái của user này
              			$template -> assign_vars(array(
              			'ActivitySelected'	     => ($user_rows['admin_status'] == 1) ? ' selected="selected"' : '',
                        'WaitingSelected'	     => ($user_rows['admin_status'] == 0) ? ' selected="selected"' : '',
              			));
                        $bEdited=true;
						//Hiển thị nhóm
						$sql_define_cat="Select * from `" . $DB_FSQL . "tblcat_admin` where id<=50";
						$sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
						while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
						{
						$template->assign_block_vars('LISTGROUP',array(
							'id'  		    =>  $sql_define_cat_rows['id'],
							'selected'  	=>  ($sql_define_cat_rows['id']==$user_rows['group'])?'selected':'',
							'name' 		    =>  $sql_define_cat_rows['name'],

						));
						}

			}
            else
            { 
                //Nếu đúng thì báo sửa
                if($id==$_SESSION['login_id'])
                {
                  $bEdited=true;
                }
                else
                //Nếu sai hiện thông báo lỗi
                {
                  $bEdited = false;
                  $bmsg=false;        //Hiển thị thông báo màu đỏ lỗi
                  $bAll=false;        //Ẩn tất cả các cửa sổ
                  $emsg=($_SESSION['lang'] == 'vn')?"Đường dẫn không chính xác!": "URL not correct!";
                }
            }
		}
	}
	else
	{   //Result: False (thông báo link không chính xác)
        $bEdited = false;
        $bmsg=false;        //Hiển thị thông báo màu đỏ lỗi
        $bAll=false;        //Ẩn tất cả các cửa sổ
        $emsg=($_SESSION['lang'] == 'vn')?"Đường dẫn không chính xác!": "URL not correct!";
    }
}
else //tao moi user
{
  $bEdited = false;
	$template -> assign_vars(array(
		'txt_show_keeppass'	     => "visibility:hidden;",
		'txthide_placeholder'        => "hide",
		'txtrequired'        => 'required="required"',
	));
}

//Bước 2: Nếu không phải là sửa thông tin (Add new) và là Admin thì hiển thị thông tin
if ($bEdited==false && ($_SESSION['is_admin']))
{
    //Hiển thị thông tin để thêm mới
          $sql_authority = "SELECT * FROM ".$DB_FSQL."tblauthority";
          $sql_authority = $db->sql_query($sql_authority);
          while($authority_row = $db->sql_fetchrow($sql_authority))
          {
          	$template->assign_block_vars('LAW',array(
          		'id' => displayData_DB($authority_row['id']),
          		'name' => displayData_DB($authority_row['name_en']),
          	));
          }
        //Hiển thị trạng thái của user này
    	$template -> assign_vars(array(
    	'ActivitySelected'	 => ' selected="selected"',
        'WaitingSelected'	 => ''
        ));
//Hiển thị nhóm
$sql_define_cat="Select * from `" . $DB_FSQL . "tblcat_admin` where id<=50";
$sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
{
$template->assign_block_vars('LISTGROUP',array(
	'id'  		    =>  $sql_define_cat_rows['id'],
	'selected'  	=>  ($sql_define_cat_rows['id']==$group_id)?'selected':'',
	'name' 		    =>  $sql_define_cat_rows['name'],
));
}

}




//Bước 2.1: Nếu thêm mới nhưng không phải admin thông báo bạn không có quyền
if ($bEdited==false && $_SESSION['is_admin']<>'1')
{
   $emsg=($_SESSION['lang'] == 'vn')?"Bạn không phải là thành viên Ban quản trị nên không được phép thay đổi thông tin trên Module này!": "You not member ADMIN, so you can't preview and change information on page!";
   $bmsg=false;        //Hiển thị thông báo màu đỏ lỗi
   $bAll=false;        //Ẩn tất cả các cửa sổ

}
$page_tile = "Thêm mới quản lý";
if (isset($_GEt['edit']) and $_GEt['edit']>0 and $_GEt['edit'] <> $_SESSION['login_id']) $page_tile = "Chỉnh sửa quản lý";
if (isset($_GEt['edit']) and $_GEt['edit']>0 and $_GEt['edit'] == $_SESSION['login_id']) $page_tile = "Thông tin tài khoản";

// ******************************************* 4.TOTAL INFORMATION SHOW IN MODULE ********************************
$template -> assign_vars(array(
    'txt_msg_error'             => $emsg,
    'txt_show_error'            => (!isset($emsg) or $emsg=='')?'none':'block',
    'txt_mess_result'           => ($bmsg==true)?'success':'danger',
    //Thông báo sửa/nhập mới thông tin với người sử dụng
    'txt_type_update'           => ($bEdited==false)?$str_add:$str_mod,
    //Nếu sửa thông tin của mình thì chỉ để sửa UI & PASS
    'show_edit_sample_active'   => ($_SESSION['is_admin'] AND $id<>$_SESSION['login_id'])?'block':'none',
    //Ẩn tất cả các cửa sổ
    'show_all'                  => ($bAll==false)?'none':'block',
    'link_cancel'               => ($_SESSION['is_admin'])?'act=user_list':'',
    //Type button
    'txt_type_button'           => ($bEdited)?'edit':'add',
));

$template -> pparse('user_modify');

?>