<?php
include('includes/config.inc.php');
include($dir_inc.'template.php');
include($dir_inc.'functions.php');
include($dir_inc.'function.php');
ini_set ("SMTP","mail.anhquansenter.com");
ini_set ("sendmail_from","support@anhquancenter.com");
if (!isset($_SESSION['login']) and isset($_COOKIE['admin_login_id']) and $_COOKIE['admin_login_id']>0 and isset($_COOKIE['admin_login_pass']))
{
	$sql_check_login = "SELECT * FROM " . $DB_FSQL . "tbladmin WHERE admin_id='".$_COOKIE['admin_login_id']."' and admin_password='".$_COOKIE['admin_login_pass']."' AND admin_status = 1";
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
$act = 'home';
if(isset($_GET['act']))
	$act = $_GET['act'];

if ($act == 'logout')
{
	setcookie('admin_login_id', "", time()-3600);
	unset($_SESSION['login']);
	unset($_SESSION['lang']);
	session_destroy();
	header('location: ./');
	exit();
}
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ./login.php');
	//exit('Login failed');
} else {
	$check_login = Check_sub_info($table_ad,$db," WHERE `admin_id` ='".$_SESSION['login_id']."' and `admin_password` ='".$_SESSION['login_pass']."' and admin_status='1'");
	//exit($_SESSION['login_pass']);
	if ($check_login<1) {
		setcookie('admin_login_id', "", time()-3600);
		unset($_SESSION['login']);
		unset($_SESSION['lang']);
		session_destroy();
		header('location: ./');
		exit();
	}
}

$template = new Template();

include($dir_inc.'Header.php');
switch ($act)
{
    //Quan ly Nguoi su dung
	case 'user_list':
		include($dir_inc.'user_list.php');
        break;
	case 'admin_role':
		include($dir_inc.'admin_role.php');
        break;
	case 'user_modify':
		include($dir_inc.'user_modify.php');
	    break;
	case 'cat_poll':
		include($dir_inc.'cat_poll.php');
	    break;

    //Setting
	case 'setting':
		private_unset();
		include($dir_inc.'setting.php');
		break;
	case 'pre_setting':
		private_unset();
		include($dir_inc.'pre_setting.php');
		break;
	case 'define':
		private_unset();
		include($dir_inc.'define.php');
		break;
	case 'flash':
		private_unset();
		include($dir_inc.'flash.php');
		break;
	case 'analysis':
		private_unset();
		include($dir_inc.'analysis.php');
		break;
		
	case 'cat_home':
		private_unset();
		include($dir_inc.'cat_home.php');
		break;
	case 'cat_video':
		private_unset();
		include($dir_inc.'cat_video.php');
		break;
	case 'cat_khachhang':
		private_unset();
		include($dir_inc.'cat_khachhang.php');
		break;
	case 'cat_info':
		private_unset();
		include($dir_inc.'cat_info.php');
		break;
	case 'info':
		private_unset();
		include($dir_inc.'info.php');
		break;

	case 'info_modify':
		private_unset();
		include($dir_inc.'info_modify.php');
		break;
            
    case 'infosearch':
        private_unset();
        include($dir_inc.'infosearch.php');
        break;    
    case 'cat_slide':
        private_unset();
        include($dir_inc.'cat_slide.php');
        break;    
 
     case 'cat_nhanvien':
        private_unset();
        include($dir_inc.'cat_nhanvien.php');
        break;
     case 'cat_album':
        private_unset();
        include($dir_inc.'cat_album.php');
        break;
     case 'album':
        private_unset();
        include($dir_inc.'album.php');
        break;
     case 'album_midify':
        private_unset();
        include($dir_inc.'album_midify.php');
        break;
    case 'contact':
        private_unset();
        include($dir_inc.'contact.php');
        break;  
        
    case 'sended':
        private_unset();
        include($dir_inc.'sended.php');
        break; 
        
    case 'create_email':
        private_unset();
        include($dir_inc.'create_email.php');
        break;    
        
    //Products manager 
    case 'cat_album':
        include($dir_inc.'cat_album.php');
        break;  
    case 'album':
        include($dir_inc.'album.php');
        break; 
    case 'album_modify':
        include($dir_inc.'album_modify.php');
        break; 
    case 'action_list':
        include($dir_inc.'action_list.php');
        break;  
    case 'action_modify':
        include($dir_inc.'action_modify.php');
        break; 
    case 'place_list':
        include($dir_inc.'place_list.php');
        break;  
    case 'place_modify':
        include($dir_inc.'place_modify.php');
        break;  
		case 'cat_product':
        private_unset();
        include($dir_inc.'cat_product.php');
        break;  
    case 'product':
        private_unset();
        include($dir_inc.'product.php');
        break;
    case 'product':
        include($dir_inc.'product.php');
        break;

    case 'product_modify':
        include($dir_inc.'product_modify.php');
        break; 
        
    case 'cart':
        include($dir_inc.'cart.php');
        break; 
    case 'statistic':
        include($dir_inc.'statistic.php');
        break;
    case 'help':
        include($dir_inc.'help.php');
        break; 
    case 'help_modify':
        include($dir_inc.'help_modify.php');
        break;
    case 'help_list':
        include($dir_inc.'help_list.php');
        break;
	default:
		private_unset();
		include($dir_inc.$act.'.php');
}
include($dir_inc.'Footer.php');
?>