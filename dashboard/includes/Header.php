<?php
/************************* COPPING RIGHT 3G @2009 ****************************
  Create by: Pham Vu Luyen
  Director: 3G-Star
  Phone number: 0972 041 135
  Email: pv.hoangluyenfan@gmail.com ho?c hoangluyenfan@yahoo.com
  The Website:   3g.com.vn
************************** THE STAR OF 3G **********************************/
date_default_timezone_set("Asia/Saigon");
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ./login.php');
	exit('Login failed');
}
if (isset($_GET['showtip']) AND $_GET['showtip']=="1") {
	$template->assign_block_vars('SHOWTIP',array(
		'show'     		=>  "",
	));
}

$langset = (isset($_SESSION['lang']))?$_SESSION['lang']:Make_field_values1('id', $table_lang, $db, " order by priority_order asc limit 1");
if (isset($_GET['lang'])) {
	$langset = $_GET['lang'];
	$_SESSION['lang']=$langset;
}

$group_id = Make_field_values1('group', $table_a, $db, " where admin_id='".$_SESSION['login_id']."'");
$_SESSION['is_admin'] = false;

if ($group_id=="1") $_SESSION['is_admin'] = true;
$is_admin = str_split(Make_field_values1('admin', $table_adg, $db, " where id='".$group_id."'"));
$is_info = str_split(Make_field_values1('info', $table_adg, $db, " where id='".$group_id."'"));
$is_pro = str_split(Make_field_values1('pro', $table_adg, $db, " where id='".$group_id."'"));
$is_hv = str_split(Make_field_values1('hv', $table_adg, $db, " where id='".$group_id."'"));
$is_lh = str_split(Make_field_values1('lhe', $table_adg, $db, " where id='".$group_id."'"));
$is_tk = str_split(Make_field_values1('tke', $table_adg, $db, " where id='".$group_id."'"));
$is_th = str_split(Make_field_values1('thv', $table_adg, $db, " where id='".$group_id."'"));
$is_dg = str_split(Make_field_values1('dgia', $table_adg, $db, " where id='".$group_id."'"));
$is_nk = str_split(Make_field_values1('nky', $table_adg, $db, " where id='".$group_id."'"));

$template -> assign_vars(array(
	'txt_info_module_name'	        => "Quản lý blog",
	'txt_pro_module_name'	        => "Quản lý sản phẩm",
	'txt_hv_module_name'	        => "Quản lý trang",
	'txt_lh_module_name'	        => "Quản lý liên hệ",
	'txt_tk_module_name'	        => "Quản lý khách hàng, đơn hàng, đánh giá",
	'txt_th_module_name'	        => "Quản lý bộ sưu tập",
	'txt_dg_module_name'	        => "Quản lý hỗ trợ, block",
	'txt_nk_module_name'	        => "Quản lý menu, hình ảnh",
));

$template->assign_vars(array(
	'txt_lang_vn'			=> Make_field_values1('symbol', $table_lang, $db, " where pre='vn'"),
	'txt_lang_en'			=> Make_field_values1('symbol', $table_lang, $db, " where pre='en'"),
	'txt_lang_cn'			=> Make_field_values1('symbol', $table_lang, $db, " where pre='cn'"),
	'txt_lang_jp'			=> Make_field_values1('symbol', $table_lang, $db, " where pre='jp'"),
	'txt_show_lang_vn'			=> "ok",
	'txt_show_lang_en'			=> "ok",
	'txt_show_lang_cn'			=> "ok",
	'txt_show_lang_jp'			=> "ok",
	'txt_hide_lang_vn'			=> (Make_field_values1('status', $table_lang, $db, " where pre='vn'")=='1')?"":" style='display:none;'",
	'txt_hide_lang_en'			=> (Make_field_values1('status', $table_lang, $db, " where pre='en'")=='1')?"":" style='display:none;'",
	'txt_hide_lang_cn'			=> (Make_field_values1('status', $table_lang, $db, " where pre='cn'")=='1')?"":" style='display:none;'",
	'txt_hide_lang_jp'			=> (Make_field_values1('status', $table_lang, $db, " where pre='jp'")=='1')?"":" style='display:none;'",
	'txt_group_name'			=> Make_field_values1('name', $table_adg, $db, " where id='".$group_id."'"),
));
$template -> set_filenames(array(
	'Header'	=> $dir_template . 'Header.html')
);


$template -> assign_vars(array(
	'username'	        => $_SESSION['username'],
	'admin_name'	    => Make_field_values1('admin_user', $table_ad, $db, " where admin_id='".$_SESSION['login_id']."'"),
	'id'                => $_SESSION['login_id'],
    'gms_admin'         => ($_SESSION['is_admin'])?'block':'none',
    'gms_modify'        => ($_SESSION['is_admin'])?'block':'none'    
));


/********************************* BEGIN GET DEFINE PAGE HOME LOGIN THE WEBSITE ***********************************************/
    $sql_check_define =0;
    $sql_cat_define_start = "'1','2'";
    $sql_cat_define = "select * from ".$DB_FSQL."tblcat_define where id in(".$sql_cat_define_start.") and status='1'";
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
    	 $sql_define = "select * from ".$DB_FSQL."tbldefine where cat_id in(".$txt_id_cat_define.") and trash='1'"; //voi dieu kien khong nam trong thung rac trong thùng rác
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
                  $result_define  =displayData_Textbox(Make_field_values1("value", $table_definevalue, $db, " where lang_id='".$langset."' and define_id='".$arr_define[$i]['id']."'"));
                  $template->assign_vars(array(
                       $des_define  => $result_define,
                  ));
              }
         }
         else
         {
           //echo 'Không có định nghĩa nào trong module này!';
         }
    }

//******************************** Action Manager **********************************************
$txt_url_name_module_vn="";
$txt_url_name_module_en="";
switch ($act)
{
    // Module 2
    case 'module2':
        $txt_url_name_module_vn ="<p></p><a href='./?act=module2' title='Quản lý đặt món' class='path_name_links'>Quản lý đặt món</a><p></p>";
        $txt_url_name_module_en ="<p></p><a href='./?act=module2' title='Quản lý đặt món' class='path_name_links'>Quản lý đặt món</a><p></p>";
        break;
    // Dinh nghia noi dung website
    case 'define':
        $txt_url_name_module_vn ="<p></p><a href='./?act=define_cat' title='Nhóm định nghĩa' class='path_name_links'>Nhóm định nghĩa</a><p></p><a href='./?act=define' title='Định nghĩa' class='path_name_links'>Định nghĩa</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=define_cat' title='Definition Group' class='path_name_links'>Definition Group</a><p></p><a href='./?act=define' title='Definition' class='path_name_links'>Definition</a>";
        break;
    case 'define_cat':
        $txt_url_name_module_vn ="<p></p><a href='./?act=define_cat' title='Nhóm định nghĩa' class='path_name_links'>Nhóm định nghĩa</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=define_cat' title='Definition Group' class='path_name_links'>Definition Group</a>";
        break;
    case 'help':
    case 'help_list':
	case 'help_modify':
        $txt_url_name_module_vn ="<p></p><a href='./?act=help' title='Trợ giúp' class='path_name_links'>Trợ giúp</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=help' title='Help' class='path_name_links'>Help</a>";
        break;

    //Quan ly người dùng
    case 'user_list':
        $txt_url_name_module_vn ="<p></p><a href='' title='Quản lý nhân viên' class='path_name_links'>Quản lý nhân viên</a>";
        $txt_url_name_module_en ="<p></p><a href='' title='Admin Setting' class='path_name_links'>Admin Setting</a><p></p><a href='./?act=user_list' title='Admin List' class='path_name_links'>Admin List</a>";
        break;
    case 'user_modify':
        $txt_url_name_module_vn ="<p></p><a href='./?act=user_list' title='Quản lý nhân viên' class='path_name_links'>Quản lý nhân viên</a><p></p><a href='' class='path_name_links'>Thêm mới</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=user_list' title='Account setting' class='path_name_links'>Admin account</a><p></p><a href='' class='path_name_links'>Add account</a>";
        if (isset($_GET['edit']) and $_GET['edit']>0 and $_GET['edit'] <> $_SESSION['login_id']) {
        $txt_url_name_module_vn ="<p></p><a href='./?act=user_list' title='Cài đặt tài khoản' class='path_name_links'>Tài khoản admin</a><p></p><a href='' class='path_name_links'>Chỉnh sửa</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=user_list' title='Account setting' class='path_name_links'>Admin account</a><p></p><a href='' class='path_name_links'>Edit account</a>";		}
		if (isset($_GET['edit']) and $_GET['edit']>0 and $_GET['edit'] == $_SESSION['login_id']) {
        $txt_url_name_module_vn ="<p></p><a href='./?act=user_list' title='Cài đặt tài khoản' class='path_name_links'>Tài khoản admin</a><p></p><a href='' class='path_name_links'>Chỉnh sửa</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=user_list' title='Account setting' class='path_name_links'>Admin account</a><p></p><a href='' class='path_name_links'>Edit account</a>";		}
		
		break;
    case 'cat_admin':
        $txt_url_name_module_vn ="<p></p><a href='' title='Cài đặt quản trị' class='path_name_links'>Cài đặt quản trị</a><p></p><a href='./?act=cat_admin' title='Phân quyền quản lý' class='path_name_links'>Phân quyền nhóm quản lý</a>";
        $txt_url_name_module_en ="<p></p><a href='' title='Admin Setting' class='path_name_links'>Admin Setting</a><p></p><a href='./?act=cat_admin' title='Admin Role' class='path_name_links'>Admin Role</a>";
        break;
    case 'cat_bds':
        $txt_url_name_module_vn ="<p></p><a href='' title='Quản lý khu vực' class='path_name_links'>Quản lý khu vực</a>";
        $txt_url_name_module_en ="<p></p><a href='' title='Admin Setting' class='path_name_links'>Admin Setting</a><p></p><a href='./?act=cat_admin' title='Admin Role' class='path_name_links'>Admin Role</a>";
        break;

    //Cau hinh he thong
    case 'setting':
        $txt_url_name_module_vn ="<p></p><a href='./?act=setting' title='Cài đặt chung' class='path_name_links'>Cài đặt chung</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=setting' title='Setting' class='path_name_links'>Setting</a>";
        break;
    case 'pre_setting':
        $txt_url_name_module_vn ="<p></p><a href='./?act=pre_setting' title='Cài đặt riêng' class='path_name_links'>Cài đặt riêng</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=pre_setting' title='Privacy etting' class='path_name_links'>Privacy Setting</a>";
        break;
   case 'reviews':
	  $txt_url_name_module_vn ="<p></p><a href='./?act=reviews' title='Đánh giá' class='path_name_links'>Đánh giá</a>";
	  $txt_url_name_module_en ="<p></p><a href='./?act=reviews' title='Reviews' class='path_name_links'>Reviews</a>";
      break;
		
    case 'users':
        $txt_url_name_module_vn ="<p></p><a href='./?act=users' title='Quản lý thành viên' class='path_name_links'>Quản lý khách hàng</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=users' title='Custumers manager' class='path_name_links'>Custumers manager</a>";
        break;
    case 'thu-hoc-vien':
        $txt_url_name_module_vn ="<p></p><a href='./?act=thu-hoc-vien' title='Quản lý thư học viên' class='path_name_links'>Quản lý thư học viên</a>";
        break;
    case 'cat_album':
        $txt_url_name_module_vn ="<p></p><a href='./?act=cat_album' title='Quản lý Album' class='path_name_links'>Quản lý Album</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=cat_album' title='Album list' class='path_name_links'>Album list</a>";
        break;
    case 'cat_dichgia':
        $txt_url_name_module_vn ="<p></p><a href='./?act=cat_dichgia' title='Quản lý diễn giả' class='path_name_links'>Quản lý diễn giả</a>";
        break;
    case 'download':
        $txt_url_name_module_vn ="<p></p><a href='./?act=download' title='Quản lý file download' class='path_name_links'>Quản lý file download</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=download' title='File download manager' class='path_name_links'>File download manager</a>";
        break;
    case 'download_modify':
        $txt_url_name_module_vn ="<p></p><a href='./?act=download' title='Quản lý file download' class='path_name_links'>Quản lý file download</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=download' title='File download manager' class='path_name_links'>File download manager</a>";
        break;
    case 'action_list':
        $txt_url_name_module_vn ="<p></p><a href='./?act=action_list' title='Quản lý file thể loại' class='path_name_links'>Quản lý hoạt động</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=action_list' title='Cctionmanager' class='path_name_links'>Action manager</a>";
        break;
	    case 'admin_role':
        $txt_url_name_module_vn ="<p></p><a href='' class='path_name_links'>Cài đặt tài khoản</a><p></p><a href='./?act=admin_role' title='Phân quyền quản lý' class='path_name_links'>Phân quyền quản lý</a>";
        $txt_url_name_module_en ="<p></p><a href='' class='path_name_links'>Account settings</a><p></p><a href='./?act=admin_role' title='Admin role' class='path_name_links'>Admin role</a>";
        break;
		
    case 'action_modify':
        $txt_url_name_module_vn ="<p></p><a href='./?act=action_list' title='Quản lý file thể loại' class='path_name_links'>Quản lý hoạt động</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=action_list' title='Cctionmanager' class='path_name_links'>Action manager</a>";
        break;
    case 'place_list':
        $txt_url_name_module_vn ="<p></p><a href='./?act=action_list' title='Quản lý file thể loại' class='path_name_links'>Quản lý địa danh</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=place_list' title='Cctionmanager' class='path_name_links'>Place manager</a>";
		break;
    case 'cat_lang':
        $txt_url_name_module_vn ="<p></p><a href='./?act=cat_lang' title='Quản lý ngôn ngữ' class='path_name_links'>Quản lý ngôn ngữ</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=cat_lang' title='Language manager' class='path_name_links'>Language manager</a>";
		break;
   case 'album':
        $txt_url_name_module_vn ="<p></p><a href='./?act=cat_album' title='Album' class='path_name_links'>Album</a><p></p><a>".Make_field_values1("name_vn", $table_catalbum, $db, " where id='".$_GET['cat_id']."'")."</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=cat_album' title='Album' class='path_name_links'>Album</a><p></p><a>".Make_field_values1("name_vn", $table_catalbum, $db, " where id='".$_GET['cat_id']."'")."</a>";
        break;
   case 'addfund':
        $txt_url_name_module_vn ="<p></p><a href='./?act=addfund' title='Add credit' class='path_name_links'>Add credit</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=addfund' title='Add credit' class='path_name_links'>Add credit</a>";
        break;
   case 'attr':
        $txt_url_name_module_vn ="<p></p><a href='./?act=attr' title='Quản lý thông số kỹ thuật' class='path_name_links'>Quản lý thông số kỹ thuật</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=attr' title='Pro Attr' class='path_name_links'>Pro Attr</a>";
        break;
   case 'create_msg':
        $txt_url_name_module_vn ="<p></p><a href='./?act=create_msg' title='Send message' class='path_name_links'>Send message</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=create_msg' title='Send message' class='path_name_links'>Send message</a>";
        break;
    case 'album_modify':
        $txt_url_name_module_vn ="<p></p><a href='./?act=cat_album' title='Album' class='path_name_links'>Album</a><p></p><a href=\"./?act=album&cat_id=".$_GET['cat_id']."\">".Make_field_values1("name_vn", $table_catalbum, $db, " where id='".$_GET['cat_id']."'")."</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=cat_album' title='Album' class='path_name_links'>Album</a><p></p><a href=\"./?act=album&cat_id=".$_GET['cat_id']."\">".Make_field_values1("name_vn", $table_catalbum, $db, " where id='".$_GET['cat_id']."'")."</a>";
        break;
    case 'place_modify':
        $txt_url_name_module_vn ="<p></p><a href='./?act=action_list' title='Quản lý file thể loại' class='path_name_links'>Quản lý địa danh</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=action_list' title='Cctionmanager' class='path_name_links'>Place manager</a>";
        break;
    case 'cat_slide':
        $txt_url_name_module_vn ="<p></p><a href='./?act=cat_slide' title='Banner trang web' class='path_name_links'>Banner trang web</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=cat_slide' title='Web banner' class='path_name_links'>Web banner</a>";
        break;
		//Thong tin lien he khach hang
    case 'contact':
        $txt_url_name_module_vn ="<p></p><a href='./?act=contact' title='Liên hệ' class='path_name_links'>Liên hệ</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=contact' title='Contact' class='path_name_links'>Contact</a>";
        break;        
        
    //Danh sach thu gui di
    case 'sended':
        $txt_url_name_module_vn ="<p></p><a href='./?act=sended' title='Thư đã gửi' class='path_name_links'>Thư đã gửi</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=sended' title='Sent Mail' class='path_name_links'>Sent Mail</a>";
        break;   
    case 'cat_poll':
        $txt_url_name_module_vn ="<p></p><a href='./?act=cat_poll' title='Thăm dò ý kiến' class='path_name_links'>Thăm dò ý kiến</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=cat_poll' title='Community Poll' class='path_name_links'>Community Poll</a>";
        break;
    //Tao thu gui di
    case 'create_email':
        $txt_url_name_module_vn ="<p></p><a href='./?act=contact' title='Thư liên hệ' class='path_name_links'>Thư liên hệ</a><p></p><a href='./?act=create_email' title='Gửi thư' class='path_name_links'>Gửi thư</a>";
        $txt_url_name_module_en ="<p></p><a href='./?act=create_email' title='Send' class='path_name_links'>Send</a>";
        break;                
        
    //Cau hinh he thong
    case 'menu':
                  //Lay nhom menu
                  if(isset($HTTP_POST_VARS['cbtrash']))
                    $_SESSION['type'] = $HTTP_POST_VARS['cbtrash'];

                  if(isset($HTTP_GET_VARS['trash']))
                      {
                      $TrashMenu = $HTTP_GET_VARS['trash'];
                      $trash_sel = '&trash='.$TrashMenu;
                      }
                  else
                      {
                      $TrashMenu = 1;
                      $trash_sel = '&trash='.$TrashMenu;
                      }

                  //Order by information
                  $links_dir ="";
                  if(isset($_GET['dir']))
                  {
                         if($_GET['dir'] == 'asc')
                         {
                              $links_dir = '&dir=asc';
                         }
                         else
                         {
                              $links_dir = '&dir=desc';
                         }
                  }
                  else
                  {
                              $links_dir = '&dir=asc';
                  }


                  $link_order="";
                  if(isset($_GET['order']))
                  {
                      $link_order = "&order=".$_GET['order'];
                  }
                  else
                  {
                      $link_order = "&order=id";
                  }

                  if(isset($HTTP_GET_VARS['type']) && isset($_SESSION['type']))
                  {
                      $type = (int)$_GET['type'];
                  }
                  else
                  {
                      if(isset($_SESSION['type']))
                      {
                        $type = $_SESSION['type'];
                      }
                      else
                      {
                        $type = 1;
                      }
                  }

                $links_other_menu =$link_order.$links_dir.$trash_sel;
               	$menu = ($_SESSION['lang']=='vn')?'Quản lý liên kết':'Link manager';
                  $links_menu ="&type=" . $type;

                  //Thiet lap  main    menu
                  $txt_url_name_module_vn ="<p></p><a href='./?act=menu".$links_menu.$links_other_menu."' title='".$menu."' class='path_name_links'>".$menu."</a>";
                  $txt_url_name_module_vn ="<p></p><a href='./?act=menu".$links_menu.$links_other_menu."' title='".$menu."' class='path_name_links'>".$menu."</a>";
                  $txt_url_name_module_en ="<p></p><a href='./?act=menu".$links_menu.$links_other_menu."'' title='".$menu."' class='path_name_links'>".$menu."</a>";


                   // Lay id menu
                    if(!isset($_GET['id']))
                    	$id_menu = 0;
                    else
                    	$id_menu = $_GET['id'];

                  $url_link_menu = get_array_link_menu($id_menu, $table_menu, 'menu'.$links_other_menu);

                  $sql_current = "SELECT * FROM ".$DB_FSQL."tblmenu WHERE id = '".$id_menu."'";
                  $sql_current = $db->sql_query($sql_current) or die(mysql_error());
                  while($current_value = $db->sql_fetchrow($sql_current))
                  {
                       $id=$current_value['id'];
					   $txt_url_name_module_vn = $txt_url_name_module_vn.$url_link_menu."<p></p><a href='./?act=menu&id=".$id.$links_menu.$links_other_menu."' title='".displayData_DB(makeMenuInfo($current_value['id'],"name"))."' class='path_name_links'>".displayData_DB(makeMenuInfo($current_value['id'],"name"))."</a>";
                       $txt_url_name_module_en = $txt_url_name_module_en.$url_link_menu."<p></p><a href='./?act=menu&id=".$id.$links_menu.$links_other_menu."' title='".displayData_DB(makeMenuInfo($current_value['id'],"name"))."' class='path_name_links'>".displayData_DB(makeMenuInfo($current_value['id'],"name"))."</a>";
                  }
                  break;
    
    //Quan ly nhom tin              
    case 'cat_quiz':
                  if(isset($HTTP_GET_VARS['trash']))
                      {
                      $TrashCat_info = $HTTP_GET_VARS['trash'];
                      $trash_sel = '&trash='.$TrashCat_info;
                      }
                  else                 
                      {
                      $TrashCat_info = 1;
                      $trash_sel = '&trash='.$TrashCat_info;
                      }

                  //Order by information
                  $links_dir ="";
                  if(isset($_GET['dir']))
                  {
                         if($_GET['dir'] == 'asc')
                         {
                              $links_dir = '&dir=asc';
                         }
                         else
                         {
                              $links_dir = '&dir=desc';
                         }
                  }
                  else
                  {
                              $links_dir = '&dir=asc';
                  }


                  $link_order="";
                  if(isset($_GET['order']))
                  {
                      $link_order = "&order=".$_GET['order'];
                  }
                  else
                  {
                  	$link_order = "&order=id";
                  }

                $links_other_info =$link_order.$links_dir.$trash_sel;

                  //Thiet lap  main    menu
                  $txt_url_name_module_vn ="<p></p><a href='./?act=cat_quiz".$links_other_info."' title='Quiz bank categories' class='path_name_links'>Quiz bank categories</a>";
                  $txt_url_name_module_en ="<p></p><a href='./?act=cat_quiz".$links_other_info."'' title='Quiz bank categories' class='path_name_links'>Quiz bank categories</a>";


                   // Lay id menu
                    if(!isset($_GET['id']))
                    	$id_info = 0;
                    else
                    	$id_info = $_GET['id'];

                  $url_link_info = get_array_link_menu($id_info, '`'.$DB_FSQL.'tblcat_quiz`', 'cat_info'.$links_other_info);

                  $sql_current = "SELECT * FROM `".$DB_FSQL."tblcat_quiz` WHERE id = '".$id_info."'";
                  $sql_current = $db->sql_query($sql_current) or die(mysql_error());
                  while($current_value = $db->sql_fetchrow($sql_current))
                  {
                       $txt_url_name_module_vn = $txt_url_name_module_vn.$url_link_info."<p></p><a href='./?act=cat_info&id=".$id.$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                       $txt_url_name_module_en = $txt_url_name_module_en.$url_link_info."<p></p><a href='./?act=cat_info&id=".$id.$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                  }
       break;
    //Quan ly dao tao           
    case 'cat_daotao':
                  if(isset($HTTP_GET_VARS['trash']))
                      {
                      $Trashcat_daotao = $HTTP_GET_VARS['trash'];
                      $trash_sel = '&trash='.$Trashcat_daotao;
                      }
                  else                 
                      {
                      $Trashcat_daotao = 1;
                      $trash_sel = '&trash='.$Trashcat_daotao;
                      }

                  //Order by information
                  $links_dir ="";
                  if(isset($_GET['dir']))
                  {
                         if($_GET['dir'] == 'asc')
                         {
                              $links_dir = '&dir=asc';
                         }
                         else
                         {
                              $links_dir = '&dir=desc';
                         }
                  }
                  else
                  {
                              $links_dir = '&dir=asc';
                  }


                  $link_order="";
                  if(isset($_GET['order']))
                  {
                      $link_order = "&order=".$_GET['order'];
                  }
                  else
                  {
                  	$link_order = "&order=id";
                  }

                $links_other_info =$link_order.$links_dir.$trash_sel;

                  //Thiet lap  main    menu
                  $txt_url_name_module_vn ="<p></p><a href='./?act=cat_daotao".$links_other_info."' title='Quản lý nhóm tin' class='path_name_links'>Quản lý chương trình</a>";
                  $txt_url_name_module_en ="<p></p><a href='./?act=cat_daotao".$links_other_info."'' title='Content manager' class='path_name_links'>Quản lý chương trình</a>";


                   // Lay id menu
                    if(!isset($_GET['id']))
                    	$id_info = 0;
                    else
                    	$id_info = $_GET['id'];

                  $url_link_info = get_array_link_menu($id_info, '`'.$DB_FSQL.'tblcat_daotao`', 'cat_daotao'.$links_other_info);

                  $sql_current = "SELECT * FROM `".$DB_FSQL."tblcat_daotao` WHERE id = '".$id_info."'";
                  $sql_current = $db->sql_query($sql_current) or die(mysql_error());
                  while($current_value = $db->sql_fetchrow($sql_current))
                  {
                       $txt_url_name_module_vn = $txt_url_name_module_vn.$url_link_info."<p></p><a href='./?act=cat_daotao&id=".$id.$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                       $txt_url_name_module_en = $txt_url_name_module_en.$url_link_info."<p></p><a href='./?act=cat_daotao&id=".$id.$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                  }
       break;
    //Quan ly bai viet
    case 'quiz_modify':
    case 'quiz':
                  $act_curent = "quiz";
                  if(isset($HTTP_GET_VARS['trash']))
                      {
                      $TrashCat_info = $HTTP_GET_VARS['trash'];
                      $trash_sel = '&trash='.$TrashCat_info;
                      }
                  else                 
                      {
                      $TrashCat_info = 1;
                      $trash_sel = '&trash='.$TrashCat_info;
                      }

                  //Order by information
                  $links_dir ="";
                      if(isset($_GET['dir']))
                      {
                             if($_GET['dir'] == 'asc')
                                  $links_dir = '&dir=asc';
                             else
                                  $links_dir = '&dir=desc';
                      }
                      else
                      {
                                  $links_dir = '&dir=asc';
                      }


                      $link_order="";
                      if(isset($_GET['order']))
                      {
                          $link_order = "&order=".$_GET['order'];
                      }
                      else
                      {
                          $link_order = "&order=id";
                      }

                      $links_other_info =$link_order.$links_dir.$trash_sel;

                      //Thiet lap  
                      $txt_url_name_module_vn ="<p></p><a href='./?act=".$act_curent."&cat_id=0".$links_other_info."' title='Quiz bank manager' class='path_name_links'>Quiz bank manager</a>";
                      $txt_url_name_module_en ="<p></p><a href='./?act=".$act_curent."&cat_id=0".$links_other_info."' title='Quiz bank manager' class='path_name_links'>Quiz bank manager</a>";


                     //1.1. Lay thong tin CAT_ID - LANG [mac dinh]

                     $id_info  =  ($_SESSION['is_group']==NULL)?0:$_SESSION['is_group'];

                     //1.2. Lay thong tin CAT_ID [theo duong link ]
                      if(isset($_GET['cat_id']))
                      {
                        $id_info = $_GET['cat_id']; 
                      } 
                     //1.3. Lay thong tin CAT_ID [theo bien co Action]      
                     if(isset($HTTP_POST_VARS['cbGroup']))
                     {
                        $id_info               = $HTTP_POST_VARS['cbGroup']; 
                     }                   

                  $sql_current = "SELECT * FROM `".$DB_FSQL."tblcat_quiz` WHERE id = '".$id_info."'";
                  $sql_current = $db->sql_query($sql_current) or die(mysql_error());
                  while($current_value = $db->sql_fetchrow($sql_current))
                  {
                       $txt_url_name_module_vn = $txt_url_name_module_vn."<p></p><a href='./?act=".$act_curent."&cat_id=".displayData_DB($current_value['id']).$links_other_info."' title='".displayData_DB($current_value['name_vn'])."' class='path_name_links'>".displayData_DB($current_value['name_vn'])."</a>";
                       $txt_url_name_module_en = $txt_url_name_module_en."<p></p><a href='./?act=".$act_curent."&cat_id=".displayData_DB($current_value['id']).$links_other_info."' title='".displayData_DB($current_value['name_vn'])."' class='path_name_links'>".displayData_DB($current_value['name_vn'])."</a>";
                  }
       break;
                  
    //Quan ly du an              
    case 'cat_project':
            $act_curent = "cat_project";
                  if(isset($HTTP_GET_VARS['trash']))
                      {
                      $TrashCat_info = $HTTP_GET_VARS['trash'];
                      $trash_sel = '&trash='.$TrashCat_info;
                      }
                  else                 
                      {
                      $TrashCat_info = 1;
                      $trash_sel = '&trash='.$TrashCat_info;
                      }

                  //Order by information
                  $links_dir ="";
                  if(isset($_GET['dir']))
                  {
                         if($_GET['dir'] == 'asc')
                         {
                              $links_dir = '&dir=asc';
                         }
                         else
                         {
                              $links_dir = '&dir=desc';
                         }
                  }
                  else
                  {
                              $links_dir = '&dir=asc';
                  }


                  $link_order="";
                  if(isset($_GET['order']))
                  {
                      $link_order = "&order=".$_GET['order'];
                  }
                  else
                  {
                      $link_order = "&order=id";
                  }

                $links_other_info =$link_order.$links_dir.$trash_sel;

                  //Thiet lap main Project
                  $txt_url_name_module_vn ="<p></p><a href='./?act=".$act.$links_other_info."' title='Quản lý Sản phẩm' class='path_name_links'>Quản lý Sản phẩm</a>";
                  $txt_url_name_module_en ="<p></p><a href='./?act=".$act.$links_other_info."' title='Projects Manager' class='path_name_links'>Projects Manager</a>";


                   // Lay id Project
                    if(!isset($_GET['id']))
                        $id_prj = 0;
                    else
                        $id_prj = $_GET['id'];

                  $url_link_info = get_array_link_menu($id_prj, $DB_FSQL.'tblcat_project', $act.$links_other_info);

                  $sql_current = "SELECT * FROM `".$DB_FSQL."tbl".$act."` WHERE id = '".$id_prj."'";
                  $sql_current = $db->sql_query($sql_current) or die(mysql_error());
                  while($current_value = $db->sql_fetchrow($sql_current))
                  {
                       $txt_url_name_module_vn = $txt_url_name_module_vn.$url_link_info."<p></p><a href='./?act=".$act."&id=".$id.$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                       $txt_url_name_module_en = $txt_url_name_module_en.$url_link_info."<p></p><a href='./?act=".$act."&id=".$id.$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                  }
        break;
    
    //Quan ly anh du an
    case 'project_modify':
    case 'project':
                  $act_curent = "project";
                  if(isset($HTTP_GET_VARS['trash']))
                      {
                      $TrashCat_info = $HTTP_GET_VARS['trash'];
                      $trash_sel = '&trash='.$TrashCat_info;
                      }
                  else                 
                      {
                      $TrashCat_info = 1;
                      $trash_sel = '&trash='.$TrashCat_info;
                      }

                  //Order by information
                  $links_dir ="";
                      if(isset($_GET['dir']))
                      {
                             if($_GET['dir'] == 'asc')
                                  $links_dir = '&dir=asc';
                             else
                                  $links_dir = '&dir=desc';
                      }
                      else
                      {
                                  $links_dir = '&dir=asc';
                      }


                      $link_order="";
                      if(isset($_GET['order']))
                      {
                          $link_order = "&order=".$_GET['order'];
                      }
                      else
                      {
                          $link_order = "&order=id";
                      }

                      $links_other_info =$link_order.$links_dir.$trash_sel;

                      //Thiet lap  
                      $txt_url_name_module_vn ="<p></p><a href='./?act=".$act_curent."&cat_id=0".$links_other_info."' title='Quản lý ảnh theo Sản phẩm' class='path_name_links'>Quản lý ảnh theo Sản phẩm</a>";
                      $txt_url_name_module_en ="<p></p><a href='./?act=".$act_curent."&cat_id=0".$links_other_info."' title='Images Management Project' class='path_name_links'>Images Management Project</a>";


                     //1.1. Lay thong tin CAT_ID - LANG [mac dinh]

                     $id_info  =  ($_SESSION['is_group_prj']==NULL)?0:$_SESSION['is_group_prj'];

                     //1.2. Lay thong tin CAT_ID [theo duong link ]
                      if(isset($_GET['cat_id']))
                      {
                        $id_info = $_GET['cat_id']; 
                      } 
                     //1.3. Lay thong tin CAT_ID [theo bien co Action]      
                     if(isset($HTTP_POST_VARS['cbGroup']))
                     {
                        $id_info               = $HTTP_POST_VARS['cbGroup']; 
                     }                   

                  $url_link_info = get_array_link_info($id_info, '`'.$DB_FSQL.'tblcat_project`', $act_curent.$links_other_info);

                  $sql_current = "SELECT * FROM `".$DB_FSQL."tblcat_project` WHERE id = '".$id_info."'";
                  $sql_current = $db->sql_query($sql_current) or die(mysql_error());
                  while($current_value = $db->sql_fetchrow($sql_current))
                  {
                       $txt_url_name_module_vn = $txt_url_name_module_vn.$url_link_info."<p></p><a href='./?act=".$act_curent."&cat_id=".displayData_DB($current_value['id']).$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                       $txt_url_name_module_en = $txt_url_name_module_en.$url_link_info."<p></p><a href='./?act=".$act_curent."&cat_id=".displayData_DB($current_value['id']).$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                  }
        break;
    
    //Quan ly san pham
    case 'cat_product':
                  if(isset($HTTP_GET_VARS['trash']))
                      {
                      $TrashCat_info = $HTTP_GET_VARS['trash'];
                      $trash_sel = '&trash='.$TrashCat_info;
                      }
                  else                 
                      {
                      $TrashCat_info = 1;
                      $trash_sel = '&trash='.$TrashCat_info;
                      }

                  //Order by information
                  $links_dir ="";
                  if(isset($_GET['dir']))
                  {
                         if($_GET['dir'] == 'asc')
                         {
                              $links_dir = '&dir=asc';
                         }
                         else
                         {
                              $links_dir = '&dir=desc';
                         }
                  }
                  else
                  {
                              $links_dir = '&dir=asc';
                  }


                  $link_order="";
                  if(isset($_GET['order']))
                  {
                      $link_order = "&order=".$_GET['order'];
                  }
                  else
                  {
                      $link_order = "&order=id";
                  }

                $links_other_info =$link_order.$links_dir.$trash_sel;

                  //Thiet lap main Product
                  $txt_url_name_module_vn ="<p></p><a href='./?act=product' title='Sản phẩm' class='path_name_links'>Sản phẩm</a><p></p><a href='./?act=".$act.$links_other_info."' title='Phân loại sản phẩm' class='path_name_links'>Phân loại sản phẩm</a>";
                  $txt_url_name_module_en ="<p></p><a href='./?act=".$act.$links_other_info."' title='Management product group' class='path_name_links'>Management product group</a>";


                   // Lay id Project
                    if(!isset($_GET['id']))
                        $id_prj = 0;
                    else
                        $id_prj = $_GET['id'];

                  $url_link_info = get_array_link_menu($id_prj, $DB_FSQL.'tblcat_product', $act.$links_other_info);

                  $sql_current = "SELECT * FROM `".$DB_FSQL."tbl".$act."` WHERE id = '".$id_prj."'";
                  $sql_current = $db->sql_query($sql_current) or die(mysql_error());
                  while($current_value = $db->sql_fetchrow($sql_current))
                  {
                       $txt_url_name_module_vn = $txt_url_name_module_vn.$url_link_info."<p></p><a href='./?act=".$act."&id=".$id_prj.$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                       $txt_url_name_module_en = $txt_url_name_module_en.$url_link_info."<p></p><a href='./?act=".$act."&id=".$id_prj.$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                  }
        break;    
    case 'cat_content':
                  if(isset($HTTP_GET_VARS['trash']))
                      {
                      $TrashCat_info = $HTTP_GET_VARS['trash'];
                      $trash_sel = '&trash='.$TrashCat_info;
                      }
                  else                 
                      {
                      $TrashCat_info = 1;
                      $trash_sel = '&trash='.$TrashCat_info;
                      }

                  //Order by information
                  $links_dir ="";
                  if(isset($_GET['dir']))
                  {
                         if($_GET['dir'] == 'asc')
                         {
                              $links_dir = '&dir=asc';
                         }
                         else
                         {
                              $links_dir = '&dir=desc';
                         }
                  }
                  else
                  {
                              $links_dir = '&dir=asc';
                  }


                  $link_order="";
                  if(isset($_GET['order']))
                  {
                      $link_order = "&order=".$_GET['order'];
                  }
                  else
                  {
                      $link_order = "&order=id";
                  }

                $links_other_info =$link_order.$links_dir.$trash_sel;

                  //Thiet lap main Product
                  $txt_url_name_module_vn ="<p></p><a href='./?act=content' title='Quản lý nội dung' class='path_name_links'>Quản lý nội dung</a><p></p><a href='./?act=".$act.$links_other_info."' title='Cat content' class='path_name_links'>Danh mục</a>";
                  $txt_url_name_module_en ="<p></p><a href='./?act=content' title='Content' class='path_name_links'>Content</a><p></p><a href='./?act=".$act.$links_other_info."' title='Cat content' class='path_name_links'>Cat content</a>";


                   // Lay id Project
                    if(!isset($_GET['id']))
                        $id_prj = 0;
                    else
                        $id_prj = $_GET['id'];

                  $url_link_info = get_array_link_menu($id_prj, $DB_FSQL.'tblcat_content', $act.$links_other_info);

                  $sql_current = "SELECT * FROM `".$DB_FSQL."tbl".$act."` WHERE id = '".$id_prj."'";
                  $sql_current = $db->sql_query($sql_current) or die(mysql_error());
                  while($current_value = $db->sql_fetchrow($sql_current))
                  {
                       $catname=$current_value['title'];
					   $txt_url_name_module_vn = $txt_url_name_module_vn.$url_link_info."<p></p><a href='./?act=".$act."&id=".$id_prj.$links_other_info."' title='".$catname."' class='path_name_links'>".$catname."</a>";
                       $txt_url_name_module_en = $txt_url_name_module_en.$url_link_info."<p></p><a href='./?act=".$act."&id=".$id_prj.$links_other_info."' title='".$catname."' class='path_name_links'>".$catname."</a>";
                  }
        break;    
    case 'product_modify':
    case 'product':
                  $act_curent = "product";
                  if(isset($HTTP_GET_VARS['trash']))
                      {
                      $TrashCat_info = $HTTP_GET_VARS['trash'];
                      $trash_sel = '&trash='.$TrashCat_info;
                      }
                  else                 
                      {
                      $TrashCat_info = 1;
                      $trash_sel = '&trash='.$TrashCat_info;
                      }

                  //Order by information
                  $links_dir ="";
                      if(isset($_GET['dir']))
                      {
                             if($_GET['dir'] == 'asc')
                                  $links_dir = '&dir=asc';
                             else
                                  $links_dir = '&dir=desc';
                      }
                      else
                      {
                                  $links_dir = '&dir=asc';
                      }


                      $link_order="";
                      if(isset($_GET['order']))
                      {
                          $link_order = "&order=".$_GET['order'];
                      }
                      else
                      {
                          $link_order = "&order=id";
                      }

                      $links_other_info =$link_order.$links_dir.$trash_sel;

                      //Thiet lap  
                      $txt_url_name_module_vn ="<p></p><a href='./?act=product' title='Sản phẩm' class='path_name_links'>Sản phẩm</a><p></p><a href='./?act=".$act_curent."&cat_id=0".$links_other_info."' title='Danh sách Sản phẩm' class='path_name_links'>Danh sách Sản phẩm</a>";
                      $txt_url_name_module_en ="<p></p><a href='./?act=".$act_curent."&cat_id=0".$links_other_info."' title='Products manage' class='path_name_links'>Products manage</a>";


                     //1.1. Lay thong tin CAT_ID - LANG [mac dinh]

                     $id_info  =  ($_SESSION['is_group_prj']==NULL)?0:$_SESSION['is_group_prj'];

                     //1.2. Lay thong tin CAT_ID [theo duong link ]
                      if(isset($_GET['cat_id']))
                      {
                        $id_info = $_GET['cat_id']; 
                      } 
                     //1.3. Lay thong tin CAT_ID [theo bien co Action]      
                     if(isset($HTTP_POST_VARS['cbGroup']))
                     {
                        $id_info               = $HTTP_POST_VARS['cbGroup']; 
                     }                   

                  $url_link_info = get_array_link_info($id_info, '`'.$DB_FSQL.'tblcat_product`', $act_curent.$links_other_info);

                  $sql_current = "SELECT * FROM `".$DB_FSQL."tblcat_product` WHERE id = '".$id_info."'";
                  $sql_current = $db->sql_query($sql_current) or die(mysql_error());
                  while($current_value = $db->sql_fetchrow($sql_current))
                  {
                       $txt_url_name_module_vn = $txt_url_name_module_vn.$url_link_info."<p></p><a href='./?act=".$act_curent."&cat_id=".displayData_DB($current_value['id']).$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                       $txt_url_name_module_en = $txt_url_name_module_en.$url_link_info."<p></p><a href='./?act=".$act_curent."&cat_id=".displayData_DB($current_value['id']).$links_other_info."' title='".displayData_DB($current_value['name_'.$_SESSION['lang']])."' class='path_name_links'>".displayData_DB($current_value['name_'.$_SESSION['lang']])."</a>";
                  }
                  break;
    case 'content_modify':
    case 'content':
                  $act_curent = "content";
                  if(isset($HTTP_GET_VARS['trash']))
                      {
                      $TrashCat_info = $HTTP_GET_VARS['trash'];
                      $trash_sel = '&trash='.$TrashCat_info;
                      }
                  else                 
                      {
                      $TrashCat_info = 1;
                      $trash_sel = '&trash='.$TrashCat_info;
                      }

                  //Order by information
                  $links_dir ="";
                      if(isset($_GET['dir']))
                      {
                             if($_GET['dir'] == 'asc')
                                  $links_dir = '&dir=asc';
                             else
                                  $links_dir = '&dir=desc';
                      }
                      else
                      {
                                  $links_dir = '&dir=asc';
                      }


                      $link_order="";
                      if(isset($_GET['order']))
                      {
                          $link_order = "&order=".$_GET['order'];
                      }
                      else
                      {
                          $link_order = "&order=id";
                      }

                      $links_other_info =$link_order.$links_dir.$trash_sel;

                      //Thiet lap  
                      $txt_url_name_module_vn ="<p></p><a href='./?act=".$act_curent."&cat_id=0".$links_other_info."' title='Quản lý nội dung' class='path_name_links'>Quản lý nội dung</a>";
                      $txt_url_name_module_en ="<p></p><a href='./?act=".$act_curent."&cat_id=0".$links_other_info."' title='Content' class='path_name_links'>Content</a>";


                     //1.1. Lay thong tin CAT_ID - LANG [mac dinh]

                     $id_info  =  (!isset($_SESSION['is_group_prj']))?0:$_SESSION['is_group_prj'];

                     //1.2. Lay thong tin CAT_ID [theo duong link ]
                      if(isset($_GET['cat_id']))
                      {
                        $id_info = $_GET['cat_id']; 
                      } 
                     //1.3. Lay thong tin CAT_ID [theo bien co Action]      
                     if(isset($HTTP_POST_VARS['cbGroup']))
                     {
                        $id_info               = $HTTP_POST_VARS['cbGroup']; 
                     }                   

                  $url_link_info = get_array_link_info($id_info, '`'.$DB_FSQL.'tblcat_content`', $act_curent.$links_other_info);

                  $sql_current = "SELECT * FROM `".$DB_FSQL."tblcat_content` WHERE id = '".$id_info."'";
                  $sql_current = $db->sql_query($sql_current) or die(mysql_error());
                  while($current_value = $db->sql_fetchrow($sql_current))
                  {
                       $cat_name=$current_value['title'];
					   $txt_url_name_module_vn = $txt_url_name_module_vn.$url_link_info."<p></p><a href='./?act=".$act_curent."&cat_id=".displayData_DB($current_value['id']).$links_other_info."' title='".displayData_DB($cat_name)."' class='path_name_links'>".displayData_DB($cat_name)."</a>";
                       $txt_url_name_module_en = $txt_url_name_module_en.$url_link_info."<p></p><a href='./?act=".$act_curent."&cat_id=".displayData_DB($current_value['id']).$links_other_info."' title='".displayData_DB($cat_name)."' class='path_name_links'>".displayData_DB($cat_name)."</a>";
                  }
                  break;
    case 'info_user':
    case 'cart':
                  $act_curent = "cart";
                  if(isset($HTTP_GET_VARS['trash']))
                      {
                      $TrashCat_info = $HTTP_GET_VARS['trash'];
                      $trash_sel = '&trash='.$TrashCat_info;
                      }
                  else                 
                      {
                      $TrashCat_info = 1;
                      $trash_sel = '&trash='.$TrashCat_info;
                      }

                  //Order by information
                  $links_dir ="";
                      if(isset($_GET['dir']))
                      {
                             if($_GET['dir'] == 'asc')
                                  $links_dir = '&dir=asc';
                             else
                                  $links_dir = '&dir=desc';
                      }
                      else
                      {
                                  $links_dir = '&dir=asc';
                      }


                      $link_order="";
                      if(isset($_GET['order']))
                      {
                          $link_order = "&order=".$_GET['order'];
                      }
                      else
                      {
                          $link_order = "&order=id";
                      }

                      $links_other_info =$link_order.$links_dir.$trash_sel;

                      //Thiet lap  
                      $txt_url_name_module_vn ="<p></p><a href='./?act=".$act_curent.$links_other_info."' title='Orders' class='path_name_links'>Orders</a>";
                      $txt_url_name_module_en ="<p></p><a href='./?act=".$act_curent.$links_other_info."' title='Orders' class='path_name_links'>Orders</a>";


                     //1.1. Lay thong tin CAT_ID [theo duong link ]
                      if(isset($_GET['cart_id']))
                      {
                        $id_info = $_GET['cart_id']; 
                      } 

       break;                                      
	default:
        $txt_url_name_module ='';

 }
$txt_url_name_module=($_SESSION['lang']=='vn')?$txt_url_name_module_vn:$txt_url_name_module_vn;
$template -> assign_vars(array(
    'txt_url_function_module'   => $txt_url_name_module,
    'txt_lang'                  => $_SESSION['lang'],
    'txt_menu_define_onoff'     => 'block',
));

$template->assign_vars(array('time' => gettime()));

$template -> pparse('Header');
?>