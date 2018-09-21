<?php

// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ./login.php');
	exit('Login failed');
}

$template -> set_filenames(array(
	'define'	=> $dir_template . 'define.html')
);
if ($_SESSION['is_admin_xem'] <> '1')
{
echo "<script> alert('Bạn không có quyền truy cập trang này!'); location.href='index.php';</script>";
exit();
}
//------------------------------------------- 1. SHOW AND UPDATE DATA BODY RIGHT -----------------------------------------
//1.1 Mặc định
               $template->assign_vars(array(
            		'phantram_left'          => '100%',
                    'show_update'            => 'none',
                    'show_form'              => 'none',
                    'show_edit'              => 'none',
                    'txt_button_add'         => 'none',
                    'txt_button_edit'        => 'none',

                    'txt_button_law_add'           => ($_SESSION['is_admin_them'] == true)?'block':'none',
                    'txt_button_law_mod'           => ($_SESSION['is_admin_sua'] == true)?'block':'none',
                    'txt_button_law_del'           => ($_SESSION['is_admin_xoa'] == true)?'block':'none',
                    'txt_button_law_pre'           => ($_SESSION['is_admin_xem'] == true)?'block':'none',
					'txt_cmd_submit'              => 'Update',
					'txt_form1_submit'              => 'adminForm',
					'txt_form2_submit'              => 'updateForm',
            	));
                $emsg =''; //String mess
                $id = '0';
                if(isset($HTTP_GET_VARS['id']))
                	$id = $HTTP_GET_VARS['id'];

                $cmd = '';
                if(isset($HTTP_POST_VARS['cmd']))
                   $cmd = $HTTP_POST_VARS['cmd'];

                if(isset($HTTP_GET_VARS['cat_id']))
					$_SESSION['is_group_define'] = $HTTP_GET_VARS['cat_id'];
					
				$template->assign_vars(array(
					'txt_name_subject'          => 'txt_lang_',
				));

if($_SESSION['is_admin_xem'])
 {
        //1.2 Thêm mới item
        $links_adnew ="";
        if(isset($_GET['addnew']) && $_GET['addnew']==1 && $_SESSION['is_admin_them'])
        {
                	$template->assign_vars(array(
                		'phantram_left'          => '64%',
                        'show_update'            => 'block',
                        'show_form'              => 'block',
                        'txt_button_add'         => 'block',
						'show_form0'              => 'none',
						'txt_button_group'              => 'none',
						'txt_button_publish'              => 'none',
						'txt_button_unpublish'              => 'none',
						'txt_button_change'              => 'none',
						'txt_button_delete'              => 'none',
						'txt_button_addnew'              => 'none',
						'txt_cmd_submit'              => 'Save',
						'txt_form1_submit'              => 'updateForm',
						'txt_form2_submit'              => 'adminForm',
						'txt_doaction'              => 'Add new',
                	));
					//Lay value
					$sql_define = "Select * from " . $table_lang . " ORDER BY priority_order ASC";
					$sql_define = $db->sql_query($sql_define) or die(mysql_error());
					while($sql_define_rows = $db->sql_fetchrow($sql_define))
					{
						 $template->assign_block_vars('VALUE',array(
							'name'          =>   "",
							'lang'		=>   $sql_define_rows['name'],
							'lang_id'		=>   $sql_define_rows['id'],
						 ));
					}

                    $links_adnew = "&addnew=1";


                    if ( $cmd == 'Lưu' || $cmd == 'Save')
                    {
                        $txt_name_subject	=   $HTTP_POST_VARS['txtSubject'];
                        $txt_title			=   $HTTP_POST_VARS['txtTitle'];
                        $txt_group_id		=   (int)$HTTP_POST_VARS['cbGroup'];
                        $txt_trash_av  		=   (int)$HTTP_POST_VARS['cbtrash'];


                        $sql_insert_db      =   "Insert INTO " . $DB_FSQL . "tbldefine(`cat_id`,`subject`,`trash`) values('"
                                                .$txt_group_id."','"
                                                .$txt_name_subject."','"
                                                .$txt_trash_av."')";

                        $sql_insert_db      =   $db->sql_query($sql_insert_db) or die(mysql_error());
						$last_id = Make_field_values1("id", $table_define, $db, " ORDER by id DESC limit 1");
						//chen value
						foreach ($txt_title as $key => $value) {
							$sql_item_insert         = "insert into " . $table_definevalue . " (`define_id`,`value`,`lang_id`) values (".$last_id.",'".$value."',".$key.")";
							$sql_item_insert  =   $db->sql_query($sql_item_insert) or die(mysql_error());
						}
						exit("<script>location.href='?act=define';</script>");
                        $_SESSION['is_group_define']=  $txt_group_id;

                    }

                    //Hien thi nhom
                    $sql_define = "Select * from " . $DB_FSQL . "tblcat_define ORDER BY ID DESC";
                    $sql_define = $db->sql_query($sql_define) or die(mysql_error());
                    while($sql_define_rows = $db->sql_fetchrow($sql_define))
                    {
                         $template->assign_block_vars('GROUP_V',array(
                            'id'            =>   $sql_define_rows['id'],
                            'name'          =>   displayData_Textbox($sql_define_rows['name_en']),
                            '_selected'     =>   ($sql_define_rows['id']==$_SESSION['is_group_define'])?' selected':' ',
                         ));
                    }

        }

        //1.3 Clear item when user lick edit item
        if (isset($_GET['del']) && isset($_GET['del'])!=0 && $_SESSION['is_admin_xoa'])
        {
                $sql_info_delete = "DELETE FROM " . $DB_FSQL . "tbldefine  WHERE `id`='" . $_GET['del'] . "'";
        		$db->sql_query($sql_info_delete) or die(mysql_error());
        }

        //1.4 Xóa items on Submit
        if ($cmd == 'Delete' && $_SESSION['is_admin_xoa'])
        {
          //echo 'Bạn muốn xóa u?';
          	$delID = $HTTP_POST_VARS['cid'];
        	$delID_list = '';
         	if ( count($delID) > 0 )
        	{
        		foreach ($delID as $information_id )
        		{
        		   if($information_id!='1' && $information_id!='2' && $information_id!='3' && $information_id!='4')
                   	$delID_list .= $information_id . ', ';
        		}
        		$delID_list .= '0';
        		$sql_info_delete = "DELETE FROM " . $DB_FSQL . "tbldefine WHERE `id` IN (" . $delID_list . ")";
        		$db->sql_query($sql_info_delete) or die(mysql_error());
        	}
        }

        //1.5 On items on Submit
        if ($cmd == 'Publish' && $_SESSION['is_admin_sua'])
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
        		$sql_info_enable = "update " . $DB_FSQL . "tbldefine set `trash` = 1 where `id` IN (" . $EnID_list . ")";
				$db->sql_query($sql_info_enable) or die(mysql_error());
        	}
        }

        //1.6 Tắt items on Submit
        if ($cmd == 'Unpublish' && $_SESSION['is_admin_sua'])
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
        		$sql_info_disable = "update " . $DB_FSQL . "tbldefine set `trash` = 0 where `id` IN (" . $DisID_list . ")";
                //echo $sql_info_disable.'<br>';
        		$db->sql_query($sql_info_disable) or die(mysql_error());
        	}
        }

        //1.7 Cập nhật items on Submit
        if ($cmd == 'Update' && $_SESSION['is_admin_sua'])
        {

			$itemID		    = $HTTP_POST_VARS['itemID'];
        	$itemSubject    = $HTTP_POST_VARS['strSubject'];
        	$itemName_vn	= $HTTP_POST_VARS['strName_vn'];
        	$itemName_en	= $HTTP_POST_VARS['strName_en'];
        	$itemName_cn	= $HTTP_POST_VARS['strName_cn'];
        	$itemName_jp	= $HTTP_POST_VARS['strName_jp'];
        	$itemGroup  	= $HTTP_POST_VARS['cbGroup'];

        	if(count($itemID) > 0)
        	{
        		for($i=0;$i<count($itemID);$i++)
        		{
        			$sql_update = "UPDATE " . $DB_FSQL . "tbldefine SET
                                                     `cat_id` = '".(int)$itemGroup[$i]."',
                                                     `subject`= '".$itemSubject[$i]."',
                                                     `name_vn`= '".$itemName_vn[$i]."',
                                                     `name_en`= '".$itemName_en[$i]."',
                                                     `name_cn`= '".$itemName_cn[$i]."',
                                                     `name_jp`= '".$itemName_jp[$i]."' WHERE `id` = '".$itemID[$i]."'";
                    //echo $sql_update .'<br>';
                    $sql_update = $db->sql_query($sql_update) or die(mysql_error());
        		}
        	}

        }

        //1.8 Edit item on Submit and click item edit
        //1.8.1 Hiển thị thông tin item muốn sửa
        $link_edit="";        //Biến này để lưu trữ links hiện tại đang dùng
        $id_choose_edit = ''; //Lưu item sửa

        if (( $cmd == 'Change' || (isset($_GET['edit']) && $_GET['edit']!=0)) && $_SESSION['is_admin_sua'])
        {
        $trash_active=0;      //Biến này để bắt thông tin sửa khi được chọn
            if(isset($_GET['edit']) && $_GET['edit']!=0)
            {
                    $id_choose_edit = $_GET['edit'];
                  	$template->assign_vars(array(
							'phantram_left'          => '64%',
							'show_edit'              => 'block',
							'show_update'            => 'none',
							'show_form'              => 'block',
							'txt_button_group'              => 'none',
							'txt_button_publish'              => 'none',
							'txt_button_unpublish'              => 'none',
							'txt_button_change'              => 'none',
							'txt_button_delete'              => 'none',
							'txt_button_addnew'              => 'none',
							'txt_doaction'              => 'Edit',
                  	));
                    $link_edit = "&edit=".$_GET['edit'];
            }

            if($cmd == 'Thay đổi' || $cmd == 'Change')
            {

                  	$template->assign_vars(array(
                  	        'phantram_left'          => '64%',
                            'show_edit'              => 'block',
                            'show_form'              => 'block',
                            'show_update'            => 'none',
                            'show_form'              => 'none',
                            'txt_button_add'         => 'none',
                  	));
                $CkID       = $HTTP_POST_VARS['cid'];
                $id_choose_edit='';
             	if ( count($CkID) > 0 )
            	{
            		foreach ($CkID as $information_id )
            		{
                        //Lấy phần tử đầu tiên muốn sửa
                        $id_choose_edit = $information_id;
                        break;
            		}
                }
                //echo 'Bạn muốn thay đổi '.$id_choose_edit.' ư?';
            }

            //Truy vấn lấy thông tin đầu tiên này
            $sql_item_define_edit  =   "Select * from " . $DB_FSQL . "tbldefine where id=".$id_choose_edit. " limit 1";
            $sql_item_define_edit  =   $db->sql_query($sql_item_define_edit) or die(mysql_error());
            while($sql_item_define_edit_rows = $db->sql_fetchrow($sql_item_define_edit))
            {
                    //Hiển thị thông tin cần sửa đổi
                    $trash_active =  $sql_item_define_edit_rows['cat_id'];
                	$template->assign_vars(array(
                		'phantram_left'          => '64%',
                        'show_edit'              => 'block',
                        'show_form'              => 'block',
                        'txt_button_edit'        => 'block',
						'show_form0'              => 'none',
                        'txt_id_item'            => displayData_Textbox($sql_item_define_edit_rows['id']),
                        'txt_name_subject'       => displayData_Textbox($sql_item_define_edit_rows['subject']),
                        'txt_title_vn'           => displayData_Textbox($sql_item_define_edit_rows['name_vn']),
                        'txt_title_en'           => displayData_Textbox($sql_item_define_edit_rows['name_en']),
                        'txt_title_cn'           => displayData_Textbox($sql_item_define_edit_rows['name_cn']),
                        'txt_title_jp'           => displayData_Textbox($sql_item_define_edit_rows['name_jp']),
                        'ActivitySelected'	     => ($sql_item_define_edit_rows['trash'] == 1) ? ' selected' : '',
                        'WaitingSelected'	     => ($sql_item_define_edit_rows['trash'] == 0) ? ' selected' : '',
                        'txt_cmd_submit'	     => "Edit",
						'txt_form1_submit'              => 'updateForm',
						'txt_form2_submit'              => 'adminForm',
						
                	));
				
                    //Hiển thị nhóm muốn sửa
                    $sql_define_group = "Select * from " . $DB_FSQL . "tblcat_define ORDER BY ID DESC";
                    $sql_define_group = $db->sql_query($sql_define_group) or die(mysql_error());
                    while($sql_define_group_rows = $db->sql_fetchrow($sql_define_group))
                    {
                         $template->assign_block_vars('GROUP_V',array(
                            'id'            =>   $sql_define_group_rows['id'],
                            'name'          =>   displayData_Textbox($sql_define_group_rows['name_en']),
                            '_selected'     =>   ($sql_item_define_edit_rows['cat_id']==$sql_define_group_rows['id'])?' selected':' ',
                         ));
                    }
					//Lay value
					$sql_define = "Select * from " . $table_lang . " ORDER BY priority_order ASC";
					$sql_define = $db->sql_query($sql_define) or die(mysql_error());
					while($sql_define_rows = $db->sql_fetchrow($sql_define))
					{
						 $template->assign_block_vars('VALUE',array(
							'name'          =>   displayData_Textbox(Make_field_values1("value", $table_definevalue, $db, " where lang_id='".$sql_define_rows['id']."' and define_id='".$sql_item_define_edit_rows['id']."'")),
							'lang'		=>   $sql_define_rows['name'],
							'lang_id'		=>   $sql_define_rows['id'],
						 ));
					}
            }


         }

        //1.8.2 Cập nhật thông tin muốn sửa trong mục 1.8.1
        if ( ($cmd == 'Sửa' or $cmd == 'Edit') && $_SESSION['is_admin_sua'])
        {
			$itemID_edit		    = $HTTP_POST_VARS['id_itemFile'];
        	$itemSubject_edit  		= $HTTP_POST_VARS['txtSubject'];
        	$itemName_edit  		= $HTTP_POST_VARS['txtTitle'];
        	$cbGroup_edit			= (int)$HTTP_POST_VARS['cbGroup'];
        	$cbtrash_edit			= (int)$HTTP_POST_VARS['cbtrash'];

            $sql_item_edit          = "update " . $DB_FSQL . "tbldefine set `cat_id`='".$cbGroup_edit."',
                                                                `subject`='".$itemSubject_edit."',
                                                                `trash`='".$cbtrash_edit."' where `id`=".$itemID_edit;
            $sql_item_edit  =   $db->sql_query($sql_item_edit) or die(mysql_error());
			//xoa tat ca value cua define
			$sql_item_delete          = "delete from " . $table_definevalue . " where define_id='".$itemID_edit."'";
			$sql_item_delete  =   $db->sql_query($sql_item_delete) or die(mysql_error());
			//chen value moi
			foreach ($itemName_edit as $key => $value) {
				$sql_item_insert         = "insert into " . $table_definevalue . " (`define_id`,`value`,`lang_id`) values (".$itemID_edit.",'".$value."',".$key.")";
				$sql_item_insert  =   $db->sql_query($sql_item_insert) or die(mysql_error());
			}
			exit("<script>location.href='?act=define';</script>");
            $sql_item_edit  =   '';
            
            $_SESSION['is_group_define']=  $cbGroup_edit;

                    //Hien thi nhom
                    $sql_define = "Select * from " . $DB_FSQL . "tblcat_define ORDER BY ID DESC";
                    $sql_define = $db->sql_query($sql_define) or die(mysql_error());
                    while($sql_define_rows = $db->sql_fetchrow($sql_define))
                    {
                         $template->assign_block_vars('GROUP_V',array(
                            'id'            =>   $sql_define_rows['id'],
                            'name'          =>   displayData_Textbox($sql_define_rows['name_'.$_SESSION['lang']]),
                            '_selected'     =>   ($sql_define_rows['id']==$_SESSION['is_group_define'])?' selected':' ',
                         ));
                    }

        }

        //------------------------------------------- 2. UPDATE DATA BODY LEFT -----------------------------------------
        //2.1 Đưa vào thùng rác
          if(isset($_GET['trash']) && isset($_GET['id']) && $_GET['id'] != 0 && $_SESSION['is_admin_sua'])
          {
                  $val_new_trash     =   $_GET['trash'];
              	  $sql_change_trash = "update " . $DB_FSQL . "tbldefine set `trash`=".$val_new_trash ." where id=".(int)$_GET['id'];
                  $sql_change_trash = $db->sql_query($sql_change_trash) or die(mysql_error());
          }

        //2.2 Xắp xếp thông tin theo order by & phan trang
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
                    case 'subject':
            			$order = " subject ".$_GET['dir'];
                    	$template->assign_vars(array(
                    		'order_subject'                  => $img_sort_title,
                            'txt_class_title_subject'        => 'order_active',
                            'txt_class_title_name'           => 'order',
                            'txt_class_title_status'         => 'order',
                            'txt_class_title_id'             => 'order',
                            'txt_class_title_group'          => 'order',

                    	));
            			break;
            		case 'name':
            		    $order = " name_".$_SESSION['lang']." ".$_GET['dir'];
                    	$template->assign_vars(array(
                    		'order_name'                     => $img_sort_title,
                            'txt_class_title_subject'        => 'order',
                            'txt_class_title_name'           => 'order_active',
                            'txt_class_title_status'         => 'order',
                            'txt_class_title_id'             => 'order',
                            'txt_class_title_group'          => 'order',
                    	));
            			break;
            		case 'group':
            		    $order = " cat_id ".$_GET['dir'];
                    	$template->assign_vars(array(
                    		'order_group'                    => $img_sort_title,
                            'txt_class_title_subject'        => 'order',
                            'txt_class_title_name'           => 'order',
                            'txt_class_title_status'         => 'order',
                            'txt_class_title_id'             => 'order',
                            'txt_class_title_group'          => 'order_active',
                    	));
            			break;
                    case 'trash':
                        $order = ' trash '.$_GET['dir'];
                    	$template->assign_vars(array(
                    		'order_status'              => $img_sort_title,
                            'txt_class_title_subject'        => 'order',
                            'txt_class_title_name'           => 'order',
                            'txt_class_title_status'         => 'order_active',
                            'txt_class_title_id'             => 'order',
                            'txt_class_title_group'          => 'order',
                    	));
                        break;
                	case 'id':
            			$order = " id ".$_GET['dir'];
                    	$template->assign_vars(array(
                    		'order_id'                  => $img_sort_title,
                            'txt_class_title_subject'        => 'order',
                            'txt_class_title_name'           => 'order',
                            'txt_class_title_status'         => 'order',
                            'txt_class_title_id'             => 'order_active',
                            'txt_class_title_group'          => 'order',
                    	));
            			break;
            	}
                $link_order = "&order=".$_GET['order'];
            }
            else
            {
            	$order = " id DESC";
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
        $link_search   =   "";
        $search_info    =   false;
        
        if ( $cmd == 'Tìm' || $cmd == 'Search')
        {
             //$_SESSION['is_group_define'] ='';
             $sql_item_seach_key = $HTTP_POST_VARS['txtInfo_Search'];
             $sql_item_seach = " and (`subject` like '%". $sql_item_seach_key . "%' or
                                       `name_vn` like '%" . $sql_item_seach_key . "%' or
                                       `name_en` like '%" . $sql_item_seach_key. "%') " ;
            $template->assign_vars(array(
                  'txt_enter_key_search'     => $sql_item_seach_key,
            ));
            $link_search   =   "&search=".$sql_item_seach_key;
            $search_info    =   true;
        }
        
        if(isset($HTTP_GET_VARS['search']))
        {
             $sql_item_seach_key    =  $HTTP_GET_VARS['search'];
             $sql_item_seach = " and (`subject` like '%". $sql_item_seach_key . "%' or
                                       `name_vn` like '%" . $sql_item_seach_key . "%' or
                                       `name_en` like '%" . $sql_item_seach_key. "%') " ;
            $template->assign_vars(array(
                  'txt_enter_key_search'     => $sql_item_seach_key,
            ));
            $link_search   =   "&search=".$sql_item_seach_key; 
            $search_info    =   true; 
        }
        //****************************** 3. Hiển thị thông tin theo nhóm ****************************************************
        //Phát biểu truy vấn theo nhóm
        $cbGp ='';
		$sql_group_only="";
        if (isset($_SESSION['is_group_define']) and $_SESSION['is_group_define']!='' && $_SESSION['is_group_define']!='0')
        {      $cbGp = $_SESSION['is_group_define'];
               $sql_group_only = " and `cat_id` ='".$cbGp."' ";
        }
        //Hiển thị nhóm
        $sql_define_group = "Select * from " . $DB_FSQL . "tblcat_define ORDER BY ID DESC";
        $sql_define_group = $db->sql_query($sql_define_group) or die(mysql_error());
        while($sql_define_group_rows = $db->sql_fetchrow($sql_define_group))
        {
             $template->assign_block_vars('C_GROUP',array(
                'id'            =>   $sql_define_group_rows['id'],
                'name'          =>   displayData_Textbox($sql_define_group_rows['name_en']),
                '_selected'     =>   ($cbGp==$sql_define_group_rows['id'])?' selected':' ',
             ));
        }

        // ----------------------------------------- 4. SHOW DATA TO GRID BODY LEFT ------------------------------------
        //3.1 Phân trang
        $sql_define_total = "SELECT COUNT(*) FROM " . $DB_FSQL . "tbldefine where id>0".$sql_group_only. $sql_item_seach;
        $sql_define_total = $db->sql_query($sql_define_total) or die(mysql_error());
        $nRows = $db->sql_fetchfield(0);

        $p = !empty($HTTP_GET_VARS['p']) ? $HTTP_GET_VARS['p'] : 0;
        // Set lai $p neu $p >= $nRows
        $p = ( ($p >= $nRows) || !is_numeric($p) || ($p < 0)) ? 0 : $p;
        // So trang dang hien thi
        $link_current_page = ($p > 0) ? '&p=' . $p : '';
        $nNewsSize = 30;
        
        //Result search key
        if ($search_info==true)
        {
            if(strlen($sql_item_seach_key) > 24)
               $sql_item_seach_key_new = substr($sql_item_seach_key,0,24)."...";
            else
                $sql_item_seach_key_new = $sql_item_seach_key;
                                    
            $template -> assign_vars(array(
                'txt_resul_search'  => ($_SESSION['lang']=='1')?"<p class='result_search'>[ Tìm được ".$nRows." định nghĩa với từ khóa <span title='".$sql_item_seach_key."'>".$sql_item_seach_key_new."</span> ]</p>":
                "<p class='result_search'>[ Found ".$nRows." defines with keywords <span title='".$sql_item_seach_key."'>".$sql_item_seach_key_new."</span> ]</p>",   
            ));   
        }

        //3.2 hien thi danh sach cac dinh nghia
        $sql_define_cat="Select * from " . $DB_FSQL . "tbldefine  where id>0 ".$sql_group_only.$sql_item_seach."  ORDER BY ". $order . " LIMIT " . $p . "," . $nNewsSize;
        $sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
        $couter=0;
        while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
        {
        	$couter++;
            $type_status        =   ($sql_define_cat_rows['trash']==1)?0:1;


        	$template->assign_block_vars('DEFINE',array(
        		'id'  		        =>  $sql_define_cat_rows['id'],
                'subject'           =>  $sql_define_cat_rows['subject'],
        		'name_vn' 		    =>  displayData_Textbox($sql_define_cat_rows['name_vn']),
        		'name_en' 		    =>  displayData_Textbox($sql_define_cat_rows['name_en']),
        		'name_cn' 		    =>  displayData_Textbox($sql_define_cat_rows['name_cn']),
        		'name_jp' 		    =>  displayData_Textbox($sql_define_cat_rows['name_jp']),
        		'order'		        =>  $couter,

                //Hien thi neu sua thi co icon ben canh nguoc lai hien thi id cua item
        		'id_item'           =>  ($sql_define_cat_rows['id']==$id_choose_edit)?$sql_define_cat_rows['id'].
                '<img border="0" src="./images/item_select.gif" />':$sql_define_cat_rows['id'],
                'stt'               =>  $couter-1,

                //Hien thi mau cac duong khac  nhau
                'background'        =>  ($couter%2!=0)?'step1':'step2',

                //Thiet dat cac links thay doi
                'linkStatus'        =>  ($_SESSION['is_admin_sua'] == true)?'href="./?act=define&id='.$sql_define_cat_rows['id'].'&trash='.$type_status
                .$links_adnew.$link_edit.$link_order.$links_dir.$link_current_page.'"':'',
                'linkEdit'          =>  ($_SESSION['is_admin_sua'] == true)?'href="./?act=define&edit='.$sql_define_cat_rows['id']
                .$link_order.$links_dir.$link_current_page.'"':'',
                'linkDel'           =>  ($_SESSION['is_admin_xoa'] == true)?'href="./?act=define&del='.$sql_define_cat_rows['id']
                .$links_adnew.$link_order.$links_dir.$link_current_page.'"':'',

                //Thong bao loi neu ban khong co quyen
                'checkDel'          =>  ($_SESSION['is_admin_xoa'] == true)?"return Question_del();":"return Error_law('del')",
                'checkMod'          =>  ($_SESSION['is_admin_xoa'] == true)?"window.location.href='./?act=define&id=".$sql_define_cat_rows['id']."&trash=".$type_status.$links_adnew.$link_edit.$link_order.$links_dir.$link_current_page."';":"return Error_law('mod')",

                //Hien thi icon theo quy?n
                'publish'         =>  ($sql_define_cat_rows['trash']==1)?'checked':'',
                'diable'         =>  ($_SESSION['is_admin_sua'] == true)?"":'disabled="disabled"',
                'imgEdit'           =>  ($_SESSION['is_admin_sua'] == true)?$dir_icon_16.'icon-16-edit.png':$dir_icon_16.'icon-16-unedit.png',
                'imgDel'            =>   ($_SESSION['is_admin_xoa'] == true)?$dir_icon_16.'icon-16-del.png':$dir_icon_16.'icon-16-undel.png',
        	));
            //Lay value
            $sql_define = "Select * from " . $table_lang . " ORDER BY priority_order ASC";
            $sql_define = $db->sql_query($sql_define) or die(mysql_error());
            while($sql_define_rows = $db->sql_fetchrow($sql_define))
            {
                 $template->assign_block_vars('DEFINE.VALUE',array(
                    'name'          =>   displayData_Textbox(Make_field_values1("value", $table_definevalue, $db, " where lang_id='".$sql_define_rows['id']."' and define_id='".$sql_define_cat_rows['id']."'")),
					'symbol'		=>   $sql_define_rows['symbol'],
				 ));
            }
            //Lay Group
            $sql_define = "Select * from " . $DB_FSQL . "tblcat_define ORDER BY ID DESC";
            $sql_define = $db->sql_query($sql_define) or die(mysql_error());
            while($sql_define_rows = $db->sql_fetchrow($sql_define))
            {
                 $template->assign_block_vars('DEFINE.GROUP',array(
                    'id'            =>   $sql_define_rows['id'],
                    'name'          =>   displayData_Textbox($sql_define_rows['name_en']),
                    '_selected'     =>   ($sql_define_cat_rows['cat_id']==$sql_define_rows['id'])?' selected':' ',
                 ));
            }
        }

        $template->assign_vars(array(
              'txt_sophantu'        => ($couter>0)?$couter:0,
              'txt_other_links'     => $links_adnew.$link_edit.$link_current_page,
        ));


        //----------------------------------------- 5. Hi?n th? phân trang ----------------------------------------------
        // Hien thi phan trang
        $url = './?act=define'.$links_adnew.$link_edit.$link_order.$links_dir;
        $page = generate_pagination($url.$link_search, $nRows, $nNewsSize, $p);
        $template -> assign_vars(array(
        	'link_page'	=> $page
        ));


}
else
{
   $emsg=($_SESSION['lang'] == 'vn')?"Bạn không phải là thành viên Ban quản trị nên không được phép thay đổi thông tin trên Module này!": "You not member ADMIN, so you can't preview and change information on page!";
}
    $template -> assign_vars(array(
        'txt_show_error'         => ($emsg=='')?'none':'block',
        'txt_msg_error'          => $emsg,

    ));
$template -> pparse('define');
?>