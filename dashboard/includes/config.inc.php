<?php
session_start();
?>
<?php
error_reporting(E_ALL);
error_reporting(0);
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'kiohome';
$DB_FSQL = 'demo1_';
include('mysql.php');
$db = new sql_db($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Duong dan den thu muc chua file giao dien
$dir_website    = 'http://localhost/kiohome';
$dir_root   	= '/';
$dir_template   = './templates/';
$tem		   	= '/';
$dir_real_temp	= $dir_root."templates/".$tem;
$dir_inc        = './includes/';
$dir_set        = './includes/setting/';
$dir_mdl        = './includes/modules/';
$dir_under      = './under/';
// Thư mục chứa ảnh add thêm vào ảnh gốc và tạo tiền tố ảnh nhỏ
$file_small_other   =   'bacvietluat-';
$dir_upload_file	=	'../images_upload/';
//Event
$dir_event      =   './images/';

$HTTP_POST_VARS     = $_POST;
$HTTP_GET_VARS      = $_GET;
$HTTP_SERVER_VARS   = $_SERVER;
$HTTP_COOKIE_VARS   = $_COOKIE;
$HTTP_POST_FILES    = $_FILES;

// Thu muc chua file anh cua san pham
$dir_upload = '../images_upload/';

// Thuc muc icon-16px
$dir_icon_16 = './images/icon-16/';
if (isset($_GET['l']) and $_GET['l']=='en') $_SESSION['lang']='en';
if (isset($_GET['l']) and $_GET['l']=='vn') $_SESSION['lang']='vn';
?>