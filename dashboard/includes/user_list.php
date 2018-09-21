<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ./login.php');
	exit('Login failed');
}
if (!$_SESSION['is_admin'])
{
echo "<script> alert('Bạn không có quyền truy cập trang này!'); location.href='index.php';</script>";
exit();
}
$template -> set_filenames(array(
	'user_list'	=> $dir_template . 'user_list.html')
);
$act_sbj="user_list";

// ******************************************** INFORMATION DERFAULT ***********************************************
               $template->assign_vars(array(
                    'txt_show_error'         => 'none', //Hiển thị lỗi

                    'txt_button_law_add'           => ($_SESSION['is_admin'])?'block':'none',
                    'txt_button_law_mod'           => ($_SESSION['is_admin'])?'block':'none',
                    'txt_button_law_del'           => ($_SESSION['is_admin'])?'block':'none',
                    'txt_button_law_pre'           => ($_SESSION['is_admin'])?'block':'none',
            	));
                $id = '0';
                $emsg ='';   //Biến lưu trữ thông báo
                $mess_result_check_item = true; //Style lỗi

                if(isset($HTTP_GET_VARS['id']))
                	$id = $HTTP_GET_VARS['id'];

                $cmd = '';
                if(isset($HTTP_POST_VARS['cmd']))
                   $cmd = $HTTP_POST_VARS['cmd'];


if($_SESSION['is_admin'])
 {
//------------------------------------------- 1. UPDATE INFORMATION FORM -----------------------------------------
         //1.1 Clear item when user lick edit item
        if (isset($_GET['del']) && isset($_GET['del'])!=0 && $_SESSION['is_admin'])
        {
               if($_SESSION['login_id']==$_GET['del'])
               {
                 $emsg=($_SESSION['lang']=='vn')?"Tài khoản [".$_SESSION['username']."] đang được sử dụng nên bạn không được phép xóa!":"Cannot delete Account [".$_SESSION['username']."], so that the account is not currently in use!";
                 $mess_result_check_item = false; //create style error
               }
               else
               {
                $sql_info_delete = "DELETE FROM ".$DB_FSQL."tbladmin  WHERE `admin_id`='" . $_GET['del'] . "'";
        		$db->sql_query($sql_info_delete) or die(mysql_error());
               }
        }

        //1.2 Clear items When user click Submit
        if ( ($cmd == 'Xóa' || $cmd == 'Delete') && $_SESSION['is_admin'])
        {
          //echo 'Bạn muốn xóa u?';
          	$delID = $HTTP_POST_VARS['cid'];
        	$delID_list = '';
         	if ( count($delID) > 0 )
        	{
        		foreach ($delID as $information_id )
        		{
        		   if($information_id==$_SESSION['login_id'] && $mess_result_check_item == true)
                   {
                      $emsg=($_SESSION['lang']=='vn')?"Tài khoản [".$_SESSION['username']."] đang được sử dụng nên bạn không được phép xóa!":"Cannot delete Account [".$_SESSION['username']."], so that the account is not currently in use!";
                      $mess_result_check_item = false; //create style error
                   }
                   else
                   {$delID_list .= $information_id . ', ';}
        		}
        		$delID_list .= '0';
        		$sql_info_delete = "DELETE FROM ".$DB_FSQL."tbladmin WHERE `admin_id` IN (" . $delID_list . ")";
        		$db->sql_query($sql_info_delete) or die(mysql_error());
        	}
        }

        //1.3 ON items on Submit
        if ( ($cmd == 'Bật' || $cmd == 'Publish') && $_SESSION['is_admin'] )
        {
          	$EnID = $HTTP_POST_VARS['cid'];
        	$EnID_list = '';
         	if ( count($EnID) > 0 )
        	{
        		foreach ($EnID as $information_id )
        		{
        			$EnID_list .= $information_id . ', ';

        		}
        		$EnID_list .= '0';
        		$sql_info_enable = "update ".$DB_FSQL."tbladmin set `admin_status` = 1 where `admin_id` IN (" . $EnID_list . ")";
        		$db->sql_query($sql_info_enable) or die(mysql_error());
        	}
        }

        //1.4 OFF items on Submit
        if ( ($cmd == 'Tắt' || $cmd == 'Unpublish') && $_SESSION['is_admin'])
        {
          	$DisID = $HTTP_POST_VARS['cid'];
        	$DisID_list = '';
         	if ( count($DisID) > 0 )
        	{
        		foreach ($DisID as $information_id )
        		{
        			$DisID_list .= $information_id . ', ';

        		}
        		$DisID_list .= '0';
        		$sql_info_disable = "update ".$DB_FSQL."tbladmin set `admin_status` = 0 where `admin_id` IN (" . $DisID_list . ")";
                //echo $sql_info_disable.'<br>';
        		$db->sql_query($sql_info_disable) or die(mysql_error());
        	}
        }

        //1.5 Update all items in Form when user lick Submit
        $bOK = true;
        if ( (($cmd == 'Cập nhật' || $cmd == 'Update') || $cmd == 'Update') && $_SESSION['is_admin'])
        {
        	$itemID		    = $HTTP_POST_VARS['itemID'];
        	$itemUI	        = $HTTP_POST_VARS['strName'];
            $itemPASS 		= $HTTP_POST_VARS['strPassword'];
        	if(count($itemID) > 0)
        	{
                $b_OK_ITEM = true;
        		for($i=0;$i<count($itemID) && $b_OK_ITEM==true;$i++)
        		{
                    //Mã hóa mật khẩu nếu tồn tại mật khẩu này
                    $strPass = (!empty($itemPASS[$i]))? md5($itemPASS[$i]):'';
                    //Kiểm tra user đã đăng ký chưa
        			$sql_user_check_existing = "SELECT * FROM ".$DB_FSQL."tbladmin
        										WHERE admin_user = '" . $itemUI[$i] . "'
        										AND admin_id != '" . $itemID[$i] . "'";
        			$sql_user_check_existing = $db->sql_query($sql_user_check_existing) or die(mysql_error());
        			if ( mysql_num_rows($sql_user_check_existing) == 0)
        				$bOK = true;
        			else
        			{
        				$bOK = false;
        				$emsg = ($_SESSION['lang']=='vn')?'Tên đăng ['.$itemUI[$i].'] của [id='.$itemID[$i].'] đã được sử dụng!':'Username ['.$itemUI[$i].'] of [id='.$itemID[$i].'] already in use!';
        			}

                    if($bOK)
                    {
                        //Kiểm tra mật khẩu có đủ 6 ký tự trở lên hay không
                        if(strlen($itemPASS[$i])<=0 && !empty($strPass))
                        {
                          $bOK=false;
                          $emsg = ($_SESSION['lang']=='vn')?'Mật khẩu của tài khoản ['.$itemUI[$i].'] && [id='.$itemID[$i].'] chưa đủ 6 ký tự trở lên nên chưa được cập nhật!':'Password for Acount ['.$itemUI[$i].'] with [id='.$itemID[$i].'] not enough 6 word then item do not update!';
                          $mess_result_check_item = false;
                          $b_OK_ITEM = false;
                        }
                        if($bOK)
                        {
                          $sql_update_pass = (!empty($strPass))?",`admin_password`='". $strPass."' ":"";
                          $sql_update_user = "update ".$DB_FSQL."tbladmin set `admin_user`='".$itemUI[$i]."'".$sql_update_pass.
                                             " where admin_id=".(int)$itemID[$i];
							//exit($sql_update_user);
                          $sql_update_user = $db->sql_query($sql_update_user) or die(mysql_error());
                          //Thông báo cập nhật thành công
                          $emsg = ($_SESSION['lang']=='vn')?"Cập nhật thành công!":"Update successful!";
                          $mess_result_check_item = true;
                        }
                    }

        		}
        	}
        }

      //1.6 Option ON/OFF status item
      if(isset($_GET['status']) && isset($_GET['id']) && $_GET['id'] != 0 && $_GET['id'] !=$_SESSION['login_id'] && $_SESSION['is_admin'])
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
      $sql_define_cat="Select * from ".$DB_FSQL."tbladmin  where `admin_id`>0 ".$sql_item_seach."  ORDER BY ". $order . " LIMIT " . $p . "," . $nNewsSize;
     
	  $sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
      $couter=0;
      while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
      {
      	$couter++;
          $name_img           =   ($sql_define_cat_rows['admin_status']==1)?'publish_g.png':'publish_r.png';
          $type_status        =   ($sql_define_cat_rows['admin_status']==1)?0:1;


      	$template->assign_block_vars('USERLIST',array(
      		'id'  		        =>  $sql_define_cat_rows['admin_id'],
      		'username' 		    =>  displayData_Textbox($sql_define_cat_rows['admin_user']),
      		'email' 		    =>  displayData_Textbox($sql_define_cat_rows['admin_email']),
      		'pass' 		        =>  displayData_Textbox($sql_define_cat_rows['admin_password']),
      		'order'		        =>  $couter,
			'group' 		    =>  Make_field_values1('name', $table_adg, $db, " where id='".$sql_define_cat_rows['group']."'"),

			  //STT của user để cho phép checkall or UnCheckall
			  'stt'               =>  $couter-1,

			  //Hien thi mau cac duong khac  nhau
			  'background'        =>  ($couter%2!=0)?'step1':'step2',

			//Thiet dat cac links thay doi
			'linkStatus'        =>  ($_SESSION['is_admin'] == '1' and $sql_define_cat_rows['admin_id']!=$_SESSION['login_id'])?'onclick="window.location.href=\'./?act='.$act_sbj.'&id='.$sql_define_cat_rows['admin_id'].'&status='. (1-(int)$sql_define_cat_rows['admin_status'])
			.$link_order.$links_dir.$link_current_page.'&p=' . $p.'\'"':'',                    
			'linkEdit'          =>  ($_SESSION['is_admin'])?'href="./?act=user_modify'.
			$link_order.$links_dir.$link_current_page.'&p='. $p.'&edit='.$sql_define_cat_rows['admin_id'].'"':'',
			'linkDel'           =>  ($_SESSION['is_admin'])?'href="./?act='.$act_sbj.'&del='.$sql_define_cat_rows['admin_id']
			.$link_order.$links_dir.$link_current_page.'&p='. $p.'"':'',
			//Thong bao loi neu ban khong co quyen
			'checkDel'          =>  ($_SESSION['is_admin'])?"return Question_del();":"return Error_law('del')",
			'checkMod'          =>  ($_SESSION['is_admin'])?"":"return Error_law('mod')",
			'publish'         =>  ($sql_define_cat_rows['admin_status']==1)?'checked':'',
			'diable'         =>  ($_SESSION['is_admin'] == true)?"":'disabled="disabled"',
			//Hien thi icon theo quy?n
			'imgStatus'         =>  ($_SESSION['is_admin'])?$dir_icon_16.$name_img:$dir_icon_16.'un'.$name_img,
			'imgEdit'           =>  ($_SESSION['is_admin'])?$dir_icon_16.'icon-16-edit.png':$dir_icon_16.'icon-16-unedit.png',
			'imgDel'            =>  ($_SESSION['is_admin'])?$dir_icon_16.'icon-16-del.png':$dir_icon_16.'icon-16-undel.png',
			  ));

          //Check authority of user
          $sql_code_array = array();

      }

      $template->assign_vars(array(
            'txt_sophantu'        => ($couter>0)?$couter:0,
            'txt_other_links'     => $link_current_page,
      ));

     //----------------------------------------- 4. Hiển thị phân trang ----------------------------------------------
    // Hien thi phan trang
    $url = './?act=user_list'.$link_order.$links_dir;
    $page = generate_pagination($url, $nRows, $nNewsSize, $p);
    $template -> assign_vars(array(
    	'link_page'	=> $page,
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


$template -> pparse('user_list');
?>