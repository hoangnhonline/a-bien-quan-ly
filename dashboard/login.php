<?php
include('./includes/config.inc.php');
include('./includes/template.php');
include('./includes/functions.php');
include('../mailer/func_mail.php');
$template = new Template();

//Tro file
$template -> set_filenames(array(
	'login'	=> $dir_template . 'login.html',
	'error'	=> $dir_template . 'error_page.html')
);
/**************************** SHOW DEFAULT **************************/


$error_logon = 'none';
//Lấy mặc định ngôn ngữ
$_SESSION['lang']='en';

/********************************* BEGIN GET DEFINE PAGE HOME LOGIN THE WEBSITE ***********************************************/
    $sql_check_define =0;
    $sql_cat_define_start = "'1','2'";
    $sql_cat_define = "select * from " . $DB_FSQL . "tblcat_define where id in(".$sql_cat_define_start.") and status='1'";
	$sql_cat_define = $db->sql_query($sql_cat_define) or die(mysql_error());
    $sql_check_define = $db->sql_numrows($sql_cat_define);
    if ($sql_check_define>0)
    {
		//Lay id_cat_define
		$txt_id_cat_define ="'0'";
		while($sql_cat_define_rows = $db->sql_fetchrow($sql_cat_define))
		{
			$txt_id_cat_define=$txt_id_cat_define.",'".$sql_cat_define_rows['id']."'";
		}

       //Lấy tất cả các định nghĩa trong bảng
       $sql_define = "select * from `" . $DB_FSQL . "tbldefine` where cat_id in(".$txt_id_cat_define.") and trash='1'"; //voi dieu kien khong nam trong thung rac trong thùng rác
       $sql_define = $db->sql_query($sql_define);

         //Khởi tạo và xóa mảng
         unset($arr_define);
         $number_define=0;
         //Nhập các bản ghi vào từng phần tử mảng
         while($sql_define_rows = $db->sql_fetchrow($sql_define))
         {
              $arr_define[] = $sql_define_rows;
              $number_define++;
         }
         if ($number_define>0)
         {
              for($i=0; $i<=$number_define-1; $i++)
              {
                  $des_define =  $arr_define[$i]['subject'];
                  $result_define  =$arr_define[$i]['name_'.$_SESSION['lang']];

                  $template->assign_vars(array(
                       $des_define  => $result_define,
                  ));
              }
         }
         else
         {
           //echo 'Không tìm thấy nội dung định nghĩa!';
         }
    }
/********************************* BEGIN GET DEFINE PAGE HOME LOGIN THE WEBSITE ***********************************************/


// Kiểm tra đăng nhập
$cmd 				= "";
$strUsername 		= "";
$strPwd 			= "";

if(isset($HTTP_POST_VARS['cmd']))
	$cmd 				= $HTTP_POST_VARS['cmd'];
if(isset($HTTP_POST_VARS['username']))
	$strUsername 		= strtolower ($HTTP_POST_VARS['username']);
if(isset($HTTP_POST_VARS['password']))
	$strPwd 			= md5($HTTP_POST_VARS['password']);
if(isset($HTTP_POST_VARS['lang']))
	$strLang 		    = $HTTP_POST_VARS['lang'];
if(isset($HTTP_POST_VARS['adminemail']))
	$strEmail 		    = $HTTP_POST_VARS['adminemail'];
if ($cmd == 'Login')
{
	$query_line = __LINE__;
	 $sql_check_login = "SELECT * FROM " . $DB_FSQL . "tbladmin
								WHERE ((LOWER(admin_email) = '" . $strUsername . "'
								AND admin_password = '" .$strPwd. "') OR (LOWER(admin_user) = '" . $strUsername . "'
								AND admin_password = '" .$strPwd. "')) AND (admin_status = 1)";
	$sql_check_login = $db->sql_query($sql_check_login);

    	// Kiem tra xem cau truc sql co dung khong
    	if ( !$sql_check_login)
    	{
    		$template -> assign_vars(array(
    			'err_filename'	=> '1. Lỗi file: '. __FILE__,
    			'err_line'		=>'Lỗi - ' .$query_line,
    			'err_name'		=> '2. Kiểu lỗi: '.mysql_error())
    		);

    		$template -> pparse('error');
    		exit();
    	}
		if ( $db->sql_numrows($sql_check_login) == 1)
		{
			while($db->sql_fetchrow($sql_check_login))
			{
				$_SESSION['login_id'] = $db->row[$sql_check_login]['admin_id'];
				$_SESSION['login_pass'] = $strPwd;
				$_SESSION['email']   = $db->row[$sql_check_login]['admin_email'];
                $_SESSION['lang']     =  "1";
				$_SESSION['username']   = $strUsername;
				$_SESSION['login']      = 'luyenpv';
				if (isset($_POST['remember']))
				{
					setcookie('admin_login_id', $_SESSION['login_id'], time()+60*60*24*30); 
					setcookie('admin_login_pass', $strPwd, time()+60*60*24*30); 
				}
			}

			header('location: ./?showtip=1');

		}
		else
		{
			$template -> assign_vars(array(
			'login_msg_alert'		=> "<SCRIPT>alert('Email và mật khẩu không tồn tại, xin vui lòng thử lại.');</SCRIPT>",
			));
		}
}

if ($cmd == 'Reset')
{
	 $query_line = __LINE__;
	 $sql_check_login = "SELECT * FROM " . $DB_FSQL . "tbladmin WHERE (admin_email = '" .$strEmail. "' and admin_status = 1) OR (admin_phone = '" .$strEmail. "' and admin_status = 1)";
	 $sql_check_login = $db->sql_query($sql_check_login);

    	// Kiem tra xem cau truc sql co dung khong
    	if ( !$sql_check_login)
    	{
    		$template -> assign_vars(array(
    			'err_filename'	=> '1. Lỗi file: '. __FILE__,
    			'err_line'		=>'Lỗi - ' .$query_line,
    			'err_name'		=> '2. Kiểu lỗi: '.mysql_error())
    		);

    		$template -> pparse('error');
    		exit();
    	}
		if ( $db->sql_numrows($sql_check_login) == 1)
		{
			while($db->sql_fetchrow($sql_check_login))
			{
					$admin_id = $db->row[$sql_check_login]['admin_id'];
					$admin_user = $db->row[$sql_check_login]['admin_user'];
					$admin_phone = $db->row[$sql_check_login]['admin_phone'];
					$admin_email = $db->row[$sql_check_login]['admin_email'];
					
					$npass = randomString(8);
					$sql_user_insert = "update ".$DB_FSQL."tbladmin set `admin_password`='" .md5($npass). "' where `admin_id`='".$admin_id."'";
					$sql_user_insert = $db->sql_query($sql_user_insert) or die(mysql_error());
					send_smtp_mail("Reset password","Hi ".$admin_user."!<br>New password for web administration:<br>Admin user: ".$admin_user."<br>Admin email: ".$admin_email."<br>Admin phone: ".$admin_phone."<br>Password: ".$npass."",$admin_email);
					$template -> assign_vars(array(
					'login_msg_alert'		=> "<SCRIPT>alert('Mật khẩu mới vừa được gửi về email của bạn.');</SCRIPT>",
					));
			}
		}
		else
		{
					$template -> assign_vars(array(
					'login_msg_alert'		=> "<SCRIPT>alert('Email entered does not exist, please try again.');</SCRIPT>",
					));
		}
}
$template -> pparse('login');
?>