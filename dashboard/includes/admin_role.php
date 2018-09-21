<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ./login.php');
	exit('Login failed');
}

$template -> set_filenames(array(
	'admin_role'	=> $dir_template . 'admin_role.html')
);


// ******************************************** INFORMATION DERFAULT ***********************************************
               $template->assign_vars(array(
                    'txt_show_error'         => 'none', //Hiển thị lỗi

                    'txt_button_law_add'           => ($_SESSION['is_admin_them'] == '1')?'block':'none',
                    'txt_button_law_mod'           => ($_SESSION['is_admin_sua'] == '1')?'block':'none',
                    'txt_button_law_del'           => ($_SESSION['is_admin_xoa'] == '1')?'block':'none',
                    'txt_button_law_pre'           => ($_SESSION['is_admin_xem'] == '1')?'block':'none',
            	));
                $id = '0';
                $emsg ='';   //Biến lưu trữ thông báo
                $mess_result_check_item = true; //Style lỗi

                if(isset($HTTP_GET_VARS['id']))
                	$id = $HTTP_GET_VARS['id'];

                $cmd = '';
                if(isset($HTTP_POST_VARS['cmd']))
                   $cmd = $HTTP_POST_VARS['cmd'];


if($_SESSION['is_admin_xem']=='1')
 {
        //1.5 Update all items in Form when user lick Submit
        $bOK = true;
        if ( $cmd == 'edit')
        {
        	$itemID		    = $HTTP_POST_VARS['itemID'];
        	$itemGroup	        = $HTTP_POST_VARS['txtGroup'];
        	if(count($itemID) > 0)
        	{
        		for($i=0;$i<count($itemID);$i++)
        		{
						  $sql_update_user = "update ".$DB_FSQL."tbladmin set `group`='".$itemGroup[$i]."' where admin_id='".(int)$itemID[$i]."'";
                          $sql_update_user = $db->sql_query($sql_update_user) or die(mysql_error());
                          //Thông báo cập nhật thành công
                          $emsg = ($_SESSION['lang']=='vn')?"Cập nhật phân quyền thành công!":"Update successful!";
                          $mess_result_check_item = true;
        		}
        	}
        }

      //1.6 Option ON/OFF status item
      if(isset($_GET['status']) && isset($_GET['id']) && $_GET['id'] != 0 && $_SESSION['is_modify'])
      {
              $val_new_trash     =   $_GET['status'];
      		  $sql_change_trash  = "update ".$DB_FSQL."tbladmin set `admin_status`=".$val_new_trash ." where `admin_id`=".(int)$_GET['id'];
              $sql_change_trash  = $db->sql_query($sql_change_trash) or die(mysql_error());
      }


      //------------------------------------------- 2. SHOW DATA  -----------------------------------------
      //2.2 Choose type order user
          $links_dir ="";
          if(isset($_GET['dir']))
          {
                 if($_GET['dir'] == 'asc')
                 {
                  	$template->assign_vars(array(
                  		'dir'           => '&dir=desc',
                  	));
                      $links_dir = '&dir=asc';
                      $img_sort_title  = '<img border="0" src="./images/sort_asc.gif" />';
                 }
                 else
                 {
                  	$template->assign_vars(array(
                  		'dir'           => '&dir=asc',
                  	));
                      $links_dir = '&dir=desc';
                      $img_sort_title  = '<img border="0" src="./images/sort_desc.gif" />';
                 }
          }
          else
          {
                  	$template->assign_vars(array(
                  		'dir'           => '&dir=asc',
                  	));
                      $links_dir = '&dir=asc';
                      $img_sort_title  = '';
          }


          $link_order="";
          if(isset($_GET['order']))
          {
          	switch ($_GET['order'])
          	{
          		case 'name':
          		    $order = " admin_user ".$_GET['dir'];
                  	$template->assign_vars(array(
                  		'order_name'                     => $img_sort_title,
                          'txt_class_title_name'           => 'order_active',
                          'txt_class_title_status'         => 'order',
                          'txt_class_title_id'             => 'order',
                  	));
          			break;
                  case 'status':
                      $order = ' admin_status '.$_GET['dir'];
                  	$template->assign_vars(array(
                  		'order_status'              => $img_sort_title,
                          'txt_class_title_name'           => 'order',
                          'txt_class_title_status'         => 'order_active',
                          'txt_class_title_id'             => 'order',
                  	));
                      break;
              	case 'id':
          			$order = " admin_id ".$_GET['dir'];
                  	$template->assign_vars(array(
                  		'order_id'                  => $img_sort_title,
                          'txt_class_title_name'           => 'order',
                          'txt_class_title_status'         => 'order',
                          'txt_class_title_id'             => 'order_active',
                  	));
          			break;
          	}
              $link_order = "&order=".$_GET['order'];
          }
          else
          {
          	$order = " `admin_id` DESC";
            	$template->assign_vars(array(
                          'txt_class_title_subject'        => 'order',
                          'txt_class_title_name'           => 'order',
                          'txt_class_title_status'         => 'order',
                          'txt_class_title_id'             => 'order',
                          'txt_class_title_group'          => 'order',
            	));
          }
      //Lấy thông tin Tìm kiếm
      $sql_item_seach ="";
      if ( $cmd == 'Tìm')
      {
           $sql_item_seach_key = $HTTP_POST_VARS['txtInfo_Search'];
           $sql_item_seach = " and (`admin_user` like '%". $sql_item_seach_key . "%') " ;
          $template->assign_vars(array(
                'txt_enter_key_search'     => $sql_item_seach_key,
          ));
      }

      // ----------------------------------------- 3. SHOW DATA TO GRID BODY LEFT ------------------------------------
      //3.1 Phân trang
      $sql_define_total = "SELECT COUNT(*) FROM ".$DB_FSQL."tbladmin where `admin_id`>0". $sql_item_seach;
      $sql_define_total = $db->sql_query($sql_define_total) or die(mysql_error());
      $nRows = $db->sql_fetchfield(0);

      $p = !empty($HTTP_GET_VARS['p']) ? $HTTP_GET_VARS['p'] : 0;
      // Set lai $p neu $p >= $nRows
      $p = ( ($p >= $nRows) || !is_numeric($p) || ($p < 0)) ? 0 : $p;
      // So trang dang hien thi
      $link_current_page = ($p > 0) ? '&p=' . $p : '';
      $nNewsSize = 20;

      //3.2 hien thi danh sach cac User
      $sql_define_cat="Select * from ".$DB_FSQL."tbladmin  where `admin_id`>0 ".$sql_item_seach."  ORDER BY `group` ASC LIMIT " . $p . "," . $nNewsSize;
      $sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
      $couter=0;
      while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
      {
		$couter++;
		$group=$sql_define_cat_rows['group'];
		if ($group==1 ) { $group_img= 'admin_group.png'; $role_des = "Có quyền quản lý tối cao, có thể quản lý tất cả các khu vực trên website, bao gồm cả quản lý tài khoản khác.";}
		if ($group==2 ) { $group_img= 'pro_group.png'; $role_des = "Có quyền quản lý các khu vực sản phẩm, bao gồm: Phân loại sản phẩm, Danh sách sản phẩm, Chỉnh sửa sản phẩm, Đánh giá sản phẩm, Giỏ hàng.";}
		if ($group==3 ) { $group_img= 'info_group.png';$role_des = "Có quyền quản lý các nội dung khu vực bài viết, như bài viết giới thiệu, bài viết dịch vụ...";}
      	$template->assign_block_vars('USERLIST',array(
      		'id'  		        =>  $sql_define_cat_rows['admin_id'],
      		'username' 		    =>  displayData_Textbox($sql_define_cat_rows['admin_user']),
      		'phone' 		    =>  displayData_Textbox($sql_define_cat_rows['admin_phone']),
      		'email' 		    =>  displayData_Textbox($sql_define_cat_rows['admin_email']),
      		'pass' 		        =>  displayData_Textbox($sql_define_cat_rows['admin_password']),
      		'order'		        =>  $couter,
			'group' 		    =>  Make_field_values1('name', $table_adg, $db, " where id='".$sql_define_cat_rows['group']."'"),
            'stt'               =>  $couter-1,
            'image'       		=>  $group_img,
            'role_des'       		=>  $role_des,
            'background'        =>  ($couter%2!=0)?'step1':'step2',
            'disabled'        =>  ($sql_define_cat_rows['admin_id']==$_SESSION['login_id'])?'disabled':'',
            'input'        =>  ($sql_define_cat_rows['admin_id']==$_SESSION['login_id'])?'<input type="hidden" name="txtGroup[]" value="'.$sql_define_cat_rows['group'].'">':'',
      	));
		$sql_group_cat="Select * from `" . $DB_FSQL . "tblcat_admin` where id<=3";
		$sql_group_cat = $db->sql_query($sql_group_cat) or die(mysql_error());
		while($sql_group_cat_rows = $db->sql_fetchrow($sql_group_cat))
		{
		$template->assign_block_vars('USERLIST.LISTGROUP',array(
			'id'  		    =>  $sql_group_cat_rows['id'],
			'selected'  	=>  ($sql_group_cat_rows['id']==$sql_define_cat_rows['group'])?'selected':'',
			'name' 		    =>  $sql_group_cat_rows['name'],
		));
		}
      }

      $template->assign_vars(array(
            'txt_sophantu'        => ($couter>0)?$couter:0,
      ));
 }
 else
 {
   $emsg=($_SESSION['lang'] == 'vn')?"Bạn không phải là thành viên Ban quản trị nên không được phép thay đổi thông tin trên Module này!": "You not member ADMIN, so you can't preview and change information on page!";
   $mess_result_check_item=false;
 }
    $template -> assign_vars(array(
        'txt_msg_error'          => $emsg,
        'txt_show_error'         => ($emsg=='')?'none':'block',
        'txt_mess_result'        => ($mess_result_check_item==true)?'finish':'error',

    ));


$template -> pparse('admin_role');
?>