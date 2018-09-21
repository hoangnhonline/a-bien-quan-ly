<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
    header('location: ../');
    exit('Login failed');
}
$template -> set_filenames(array(
    'product'    => $dir_template . 'content.html')
);

//Create subject action Module
$act_sbj = 'content';
$table_prj = $DB_FSQL ."tblcontent";
$table_prj_sub = $DB_FSQL ."tblcat_content";
$emsg="";
$bmsg=false;
//-----------------------------------------------------------+
$template->assign_vars(array(   
 //Select group lang
 'txt_sel_en'                  =>  ($langset=='en')?'selected=""':'',
 'txt_sel_vn'                  =>  ($langset=='vn')?'selected=""':'',   
)); 
  
//----------------------------------------------------+
//       KIEM SOAT DIEU KHIEN BUTTON                  +
//----------------------------------------------------+
    $cmd = '';
    if(isset($HTTP_POST_VARS['cmd']))
       $cmd = $HTTP_POST_VARS['cmd']; 
     
//----------------------------------------------------+
//       PHAN BIET THONG TIN TRASH, CAT_ID, LANG      +
//----------------------------------------------------+
if(isset($HTTP_GET_VARS['trash']))
             {
    $TrashMenu = $HTTP_GET_VARS['trash'];
    $sql_type_trash = " and `trash`=".$TrashMenu;
    $trash_sel = '&trash='.$TrashMenu;
    }
else
    {
    $TrashMenu = 1;
    $sql_type_trash = " and `trash`=1";
    $trash_sel = '&trash='.$TrashMenu;
    }  
 //1.1. Lay thong tin CAT_ID - LANG [mac dinh]

      $cat_id  =  (!isset($_SESSION['is_group_prj']))?0:$_SESSION['is_group_prj'];
      $langset =  (!isset($_SESSION['is_langset']))?$_SESSION['lang']:$_SESSION['is_langset'];
      
 //1.2. Lay thong tin CAT_ID [theo duong link ]
  if(isset($_GET['cat_id']))
       {
         $cat_id = $_GET['cat_id']; 
         $_SESSION['is_group_prj'] = $cat_id;
  } 
 //1.3. Lay thong tin CAT_ID [theo bien co Action]      
 if(isset($HTTP_POST_VARS['cbGroup']))
     {
       $cat_id               = $HTTP_POST_VARS['cbGroup'];
       $_SESSION['is_group_prj'] = $cat_id;  
     }
	 
 //1.4. Lay thong tin LANG [theo bien co action]
 if(isset($HTTP_POST_VARS['lang']))
     {
       $langset                 = $HTTP_POST_VARS['lang'];
       $_SESSION['is_langset']  = $langset;  
     }
//phan quyen
$module="";
$_SESSION['is__xem'] =1;
$_SESSION['is__sua'] =1;
$_SESSION['is__xoa'] =1;
$_SESSION['is__them'] =1;
$module=Make_field_values1("module", $table_catcontent, $db, " where id='".$cat_id."'");
if ($_SESSION['is_'.$module.'_xem'] <> '1')
{
echo "<script> alert('Bạn không có quyền truy cập trang này!'); location.href='./';</script>";
exit();
}
		
 $deal_s0="";
 $deal_s1="";
 $deal_s2="";
 if(isset($HTTP_POST_VARS['deal']))
     {
       if ($HTTP_POST_VARS['deal']=="0") {$sqldeal=""; $deal_s0="selected";}
       if ($HTTP_POST_VARS['deal']=="1") {$sqldeal=" and hotdeal=1"; $deal_s1="selected";}
	   if ($HTTP_POST_VARS['deal']=="2") {$sqldeal=" and hotdeal=0"; $deal_s2="selected";}
     } 
//-----------------------------------------------------------+
//    KIEM TRA DIEU KIEN HIEN THI CAC BUTTON & SELECT        +
//-----------------------------------------------------------+

$template->assign_vars(array(
    'trash_act'                    => $TrashMenu, 
    'trash_icon'                   => ($TrashMenu==0)?'-trash':'',   //Phan biet icon la nomal hay trash tren thanh standar
    'txt_button_law_add'           => ($_SESSION['is_'.$module.'_them'] == '1' && $TrashMenu==1)?'block':'none',
    'txt_button_law_trash'         => ($_SESSION['is_'.$module.'_sua'] == '1' && $TrashMenu==1)?'block':'none',
    'txt_button_law_mod'           => ($_SESSION['is_'.$module.'_sua'] == '1' && $TrashMenu==1 )?'block':'none',
    'txt_button_law_pre'           => ($_SESSION['is_'.$module.'_xem'] == '1' && $TrashMenu==1 )?'block':'none',

    'txt_show_addnew'           => ($cat_id>0 and $_SESSION['is_'.$module.'_them'] == '1')?'block':'none',
    'txt_show_update'           => ($cat_id>0 and $_SESSION['is_'.$module.'_sua'] == '1')?'block':'none',
    'txt_show_pub'           => ($cat_id>0 and $_SESSION['is_'.$module.'_sua'] == '1')?'block':'none',
    'txt_show_unpub'           => ($cat_id>0 and $_SESSION['is_'.$module.'_sua'] == '1')?'block':'none',
    'txt_button_law_del'           => ($_SESSION['is_'.$module.'_xoa'] == '1')?'block':'none',
    'txt_button_law_restore'       => ($_SESSION['is_'.$module.'_sua'] <> '1' && $TrashMenu==0 )?'block':'none', 
    
     //Select group lang
     'txt_sel_en'                  =>  ($langset=='en')?'selected=""':'',
     'txt_sel_vn'                  =>  ($langset=='vn')?'selected=""':'',
	'txt_sel_d0'                  =>  $deal_s0,
	'txt_sel_d1'                  =>  $deal_s1,
	'txt_sel_d2'                  =>  $deal_s2,	 
));    

//----------------------------------------------------+
//                   THAY DOI                         +
//----------------------------------------------------+
if ($_SESSION['is_'.$module.'_sua'] == '1')
 {
        //ON-OFF trang thai
        if(isset($_GET['sel']) && isset($_GET['status']) && $_GET['status'] >=0 && $_GET['sel'] != 0)
        {
                $val_item_sel      = ($_GET['status']==0)?1:0;
                $sql_change_status = "update `".$table_prj."` set `status`=".$val_item_sel ." where id=".(int)$_GET['sel'];
                $sql_change_status = $db->sql_query($sql_change_status) or die(mysql_error());
				
				$c_module = Make_field_values1("module", $table_content, $db," where id='".$_GET['sel']."'");
				if ($c_module=="download") {
					$hidden_update = Make_field_values1("hidden_update", $table_content, $db," where id='".$_GET['sel']."'");
					$uid = Make_field_values1("uid", $table_content, $db," where id='".$_GET['sel']."'");
					$setting_xuduyetbai = Make_field_values1("xuduyetbai", $table_set, $db," where id='1'");
					if ($val_item_sel==1 and $hidden_update=='0') {
						//cong xu vao tk
						$info_update = "UPDATE `".$table_u."` SET `credit` = `credit`+".$setting_xuduyetbai." WHERE `id` = '" . $uid ."'";
						$db->sql_query($info_update) or die(mysql_error());
						//cap nhat log
						$sql_item_insert         = "insert into " . $table_addcredit_log . " (`uid`,`cid`,`credit`,`action`,`create_time`) values (".$uid.",'".$_GET['sel']."','".$setting_xuduyetbai."','Duyệt bài viết',NOW())";
						$sql_item_insert  =   $db->sql_query($sql_item_insert) or die(mysql_error());
						//cap nhat add xu
						$sql_item_insert         = "insert into " . $tbladdcredit_add . " (`uid`,`cid`,`full_credit`,`credit`,`action`,`create_time`) values (".$uid.",'".$_GET['sel']."','".$setting_xuduyetbai."','".$setting_xuduyetbai."','Duyệt bài viết',NOW())";
						$sql_item_insert  =   $db->sql_query($sql_item_insert) or die(mysql_error());
						//cap nhat hidden_update
						$info_update = "UPDATE `".$table_content."` SET `hidden_update` = '1' WHERE `id` = '" . $_GET['sel'] ."'";
						$db->sql_query($info_update) or die(mysql_error());
					}
				}
        }
        
        //1.1. ON trang thai
        if ($cmd == 'ON')
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
                $sql_info_enable = "update `".$table_prj."` set `status` = 1 where `id` IN (" . $EnID_list . ")";
                $db->sql_query($sql_info_enable) or die(mysql_error());
            }
        } 
        
        //1.2. OFF trang thai
        if ($cmd == 'OFF')
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
                $sql_info_disable = "update `".$table_prj."` set `status` = 0 where `id` IN (" . $DisID_list . ")";
                $db->sql_query($sql_info_disable) or die(mysql_error());
            }
        }  
        
        //1.3. Xoa tung ban ghi vao thung rac
        if(isset($_GET['mTrash']) && isset($_GET['trash']) && $_GET['mTrash'] >=0)
        {
                $change_local=($_GET['trash']==0)?1:0;
                $sql_change_status = "update `".$table_prj."` set `trash`=".$change_local." where id=".(int)$_GET['mTrash'];
                $sql_change_status = $db->sql_query($sql_change_status) or die(mysql_error());
        }

        //1.4. Xoa tat ca ban ghi duoc chon vao trong thuc rac menu
        if ($cmd == 'MoveTrash')
        {
              $MoveTrashID = $HTTP_POST_VARS['cid'];
            $MoveTrashID_list = '';
             if ( count($MoveTrashID) > 0 )
            {
                foreach ($MoveTrashID as $information_id )
                {
                    $MoveTrashID_list .= $information_id . ', ';

                }
                $MoveTrashID_list .= '0';
                $sql_info_moveTrash = "update `".$table_prj."` set `trash` = 0 where `id` IN (" . $MoveTrashID_list . ")";
                $db->sql_query($sql_info_moveTrash) or die(mysql_error());
            }
        }
        
        //1.5. Restore
        if ($cmd == 'restore')
        {
              $RestoreID = $HTTP_POST_VARS['cid'];
            $Restore_list = '';
             if ( count($RestoreID) > 0 )
            {
                foreach ($RestoreID as $information_id )
                {
                    $Restore_list .= $information_id . ', ';

                }
                $Restore_list .= '0';
                $sql_info_restore = "update `".$table_prj."` set `trash` = 1 where `id` IN (" . $Restore_list . ")";
                $db->sql_query($sql_info_restore) or die(mysql_error());
            }
        } 
        
        //1.6. Cap nhat toan bo thong tin dang hien thi
        if ($cmd == 'UPDATE')
        {
            $itemID            = $HTTP_POST_VARS['itemID'];
            $itemOrder         = $HTTP_POST_VARS['order'];

            if(count($itemID) > 0)
            {
                for($i=0;$i<count($itemID);$i++)
                {
                    $sql_update = "UPDATE `".$table_prj."` SET `priority_order` = '".(int)$itemOrder[$i]."' WHERE `id` = '".$itemID[$i]."'";
                    $sql_update = $db->sql_query($sql_update) or die(mysql_error());
                }
				$emsg="Update successful.";
				$bmsg=true;
            }
        }
        //1.7. Chuyen danh muc
        if ($cmd == 'MOVE')
        {
            $itemID            = $HTTP_POST_VARS['cid'];
            $mgroup         = $HTTP_POST_VARS['movecbGroup'];
            if(count($itemID) > 0)
            {
                for($i=0;$i<count($itemID);$i++)
                {
					$info_update = "UPDATE `".$table_content."` 
												SET `cat_list` = '" . insertData("-|".$mgroup."|") . "' WHERE `id` = '" . $itemID[$i] ."'";
					$db->sql_query($info_update) or die(mysql_error());
					//xoa tat ca ban ghi cu
					$sql_information_delete = "DELETE from `" . $table_content_to_cat . "` where content_id='".$itemID[$i]."'";
					$db->sql_query($sql_information_delete) or die(mysql_error());
					//product to catalog
					$sql_information_insert = "INSERT INTO `" . $table_content_to_cat . "` (`content_id`, `cat_id`) VALUES ('".$itemID[$i]."','".$mgroup."')";
					$db->sql_query($sql_information_insert) or die(mysql_error());
                }
				$emsg="Moved ".$i." content.";
				$bmsg=true;
            }
        }
		
 }

//----------------------------------------------------+
//                     XOA                            +
//----------------------------------------------------+
if ($_SESSION['is_'.$module.'_xoa'] ==  '1')
 {
      //2.1. Xoa tung item
      if(isset($_GET['del']) && $_GET['del'] != 0)
      {     
            //Delete image item
            $sql_info_id = "SELECT * FROM `".$table_prj."` where id ='".$_GET['del']."'";
            $sql_info_id = $db->sql_query($sql_info_id) or die(mysql_error());
            while($sql_info_id_row = $db->sql_fetchrow($sql_info_id))
            {
                $img_item_large = $sql_info_id_row['image'];
                 if ( !empty($img_item_large) && file_exists($dir_upload . $img_item_large)) {
                    //delete_files($img_item_large, $dir_upload);
                 }
            }
			//Delete imagelist
            $sql_item = "delete from `".$table_content_images."` where product_id='".(int)$_GET['del']."'";
            $sql_item = $db->sql_query($sql_item) or die(mysql_error());
			//Deltete cat
            $sql_item = "delete from `".$table_content_to_cat."` where content_id=".(int)$_GET['del'];
            $sql_item = $db->sql_query($sql_item) or die(mysql_error());
			//Deltete connter user
            $sql_item = "delete from `".$table_content_to_user."` where content_id=".(int)$_GET['del'];
            $sql_item = $db->sql_query($sql_item) or die(mysql_error());
			
			//Deltete quiz
            $sql_item = "delete from `".$table_contentquiz."` where content_id=".(int)$_GET['del'];
            $sql_item = $db->sql_query($sql_item) or die(mysql_error());
			//Deltete size
            $sql_item = "delete from `".$table_size."` where pro_id=".(int)$_GET['del'];
            $sql_item = $db->sql_query($sql_item) or die(mysql_error());
			//Deltete color
            $sql_item = "delete from `".$table_color."` where pro_id=".(int)$_GET['del'];
            $sql_item = $db->sql_query($sql_item) or die(mysql_error());
			//Deltete attr
            $sql_item = "delete from `".$table_proattr."` where pro_id=".(int)$_GET['del'];
            $sql_item = $db->sql_query($sql_item) or die(mysql_error());
			
            //Clear this item
            $sql_item = "delete from `".$table_content."` where id=".(int)$_GET['del'];
            $sql_item = $db->sql_query($sql_item) or die(mysql_error());
      }

     //2.2. Xoa nhieu item
      if($cmd=='DEL')
      {
            $Del_ID = $HTTP_POST_VARS['cid'];
            $Del_list = '';
             if ( count($Del_ID) > 0 )
            {
                $itemSubID = "(";
                foreach ($Del_ID as $information_id )
                {
                    //Lay items 
                    $Del_list .= $information_id . ', ';
                                         
                }
                $Del_list .= '0';
                
                //Delete image items
                $sql_info_id = "SELECT * FROM `".$table_prj."` where `id` IN (" . $Del_list . ")";
                $sql_info_id = $db->sql_query($sql_info_id) or die(mysql_error());
                while($sql_info_id_rows = $db->sql_fetchrow($sql_info_id))
                {
                    $img_item_large = $sql_info_id_rows['image'];
                    if ( !empty($img_item_large) && file_exists($dir_upload . $img_item_large)) {
                        //delete_files($img_item_large, $dir_upload);
					}
                }  
				//Delete imagelist
				$sql_item = "delete from `".$table_content_images."` where product_id IN (" . $Del_list . ")";
				$sql_item = $db->sql_query($sql_item) or die(mysql_error());
				//Deltete cat
				$sql_item = "delete from `".$table_content_to_cat."` where content_id IN (" . $Del_list . ")";
				$sql_item = $db->sql_query($sql_item) or die(mysql_error());
				//Deltete connter user
				$sql_item = "delete from `".$table_content_to_user."` where content_id IN (" . $Del_list . ")";
				$sql_item = $db->sql_query($sql_item) or die(mysql_error());
				
				//Deltete quiz
				$sql_item = "delete from `".$table_contentquiz."` where content_id IN (" . $Del_list . ")";
				$sql_item = $db->sql_query($sql_item) or die(mysql_error());
				//Deltete size
				$sql_item = "delete from `".$table_size."` where pro_id IN (" . $Del_list . ")";
				$sql_item = $db->sql_query($sql_item) or die(mysql_error());
				//Deltete color
				$sql_item = "delete from `".$table_color."` where pro_id IN (" . $Del_list . ")";
				$sql_item = $db->sql_query($sql_item) or die(mysql_error());
				//Deltete attr
				$sql_item = "delete from `".$table_proattr."` where pro_id IN (" . $Del_list . ")";
				$sql_item = $db->sql_query($sql_item) or die(mysql_error());
				
				//Clear this item
				$sql_item = "delete from `".$table_content."` where id IN (" . $Del_list . ")";
				$sql_item = $db->sql_query($sql_item) or die(mysql_error());
            }
      }
 }

   
//---------------------------------------------------+
//  HIEN THI NHOM THU MUC VA CHON NHOM               +
//---------------------------------------------------+
    $cond_end=' trash=1 and ';
	if ($cat_id>0) {
		$module=Make_field_values1("module", $table_catcontent, $db, " where id='".$cat_id."'");
		display_tree(0, $table_prj_sub, $table_prj, $template, $cat_id, "cat_id", $cond_end,"GROUP"," and module='".$module."'");
	} else {
		display_tree(0, $table_prj_sub, $table_prj, $template, $cat_id, "cat_id", $cond_end);
	}
	

//---------------------------------------------------+
//  KIEM TRA XEM TAI KHOAN CO QUYEN XEM TT kO        +
//---------------------------------------------------+
if ($_SESSION['is_'.$module.'_xem'] == '1')
{
    //Tim kiem theo tu khoa
    $sql_item_seach ="";
    $search_info = false;
    if ( $cmd == 'Tìm' || $cmd == 'Search')
    {
        $search_info = true;
    }
    if(isset($HTTP_GET_VARS['search']))
    {
        $search_info = true;   
    }    
    //          DANH SACH BAI VIET        +
        $template->assign_vars(array(            
             'txt_height_file'  =>  'height="360"',
             'txt_height_folder'=>  '', 
             'v_list_lang'      =>  'block',              
        ));
            
            //Sap xep thong tin
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
                        $order = " name_".$langset." ".$_GET['dir'];
                        $template->assign_vars(array(
                            'order_name'                    => $img_sort_title,
                            'txt_class_title_name'          => 'order_active',
                            'txt_class_title_created'       => 'order',
                            'txt_class_title_updated'       => 'order',
                            'txt_class_title_status'        => 'order',
                            'txt_class_title_order'         => 'order',
                            'txt_class_title_id'            => 'order',
                        ));
                        break;
                    case 'created':
                        $order  =   'create_time '. $_GET['dir'];
                        $template->assign_vars(array(
                            'order_create'                    => $img_sort_title,
                            'txt_class_title_name'          => 'order',
                            'txt_class_title_created'       => 'order_active',
                            'txt_class_title_updated'       => 'order',
                            'txt_class_title_status'        => 'order',
                            'txt_class_title_order'         => 'order',
                            'txt_class_title_id'            => 'order',
                        ));                        
                        break;
                    case 'updated':
                        $order  =   'update_time '. $_GET['dir'];
                        $template->assign_vars(array(
                            'order_update'                    => $img_sort_title,
                            'txt_class_title_name'          => 'order',
                            'txt_class_title_created'       => 'order',
                            'txt_class_title_updated'       => 'order_active',
                            'txt_class_title_status'        => 'order',
                            'txt_class_title_order'         => 'order',
                            'txt_class_title_id'            => 'order',
                        ));  
                        break;
                    case 'status':
                        $order  =   'status '. $_GET['dir'];
                        $template->assign_vars(array(
                            'order_status'                    => $img_sort_title,
                            'txt_class_title_name'          => 'order',
                            'txt_class_title_created'       => 'order',
                            'txt_class_title_updated'       => 'order',
                            'txt_class_title_status'        => 'order_active',
                            'txt_class_title_order'         => 'order',
                            'txt_class_title_id'            => 'order',
                        ));                         
                        break;                        
                    case 'pri_order':
                        $order = " priority_order ".$_GET['dir'];
                        $template->assign_vars(array(
                            'order_pri_order'                    => $img_sort_title,
                            'txt_class_title_name'          => 'order',
                            'txt_class_title_created'       => 'order',
                            'txt_class_title_updated'       => 'order',
                            'txt_class_title_status'        => 'order',
                            'txt_class_title_order'         => 'order_active',
                            'txt_class_title_id'            => 'order',
                        ));
                        break;
                    case 'id':
                        $order = " id ".$_GET['dir'];
                        $template->assign_vars(array(
                            'order_id'                    => $img_sort_title,
                            'txt_class_title_name'          => 'order',
                            'txt_class_title_created'       => 'order',
                            'txt_class_title_updated'       => 'order',
                            'txt_class_title_status'        => 'order',
                            'txt_class_title_order'         => 'order',
                            'txt_class_title_id'            => 'order_active',
                        ));
                        break;
                }
                $link_order = "&order=".$_GET['order'];
            }
            else
            {
                  $order = " id DESC";
                  $template->assign_vars(array(
                            'txt_class_title_name'          => 'order',
                            'txt_class_title_created'       => 'order',
                            'txt_class_title_updated'       => 'order',
                            'txt_class_title_status'        => 'order',
                            'txt_class_title_order'         => 'order',
                            'txt_class_title_id'            => 'order',
                  ));
            }
            
            //Tim kiem
            $sql_item_seach ="";
            $link_search   =   "";
            $sql_item_seach_key="";
            if ( $cmd == 'Tìm' || $cmd == 'Search')
                        {
                 $sql_item_seach_key = $HTTP_POST_VARS['txtInfo_Search'];
                 $sql_item_seach = " and (`title` like '%". $sql_item_seach_key . "%' or `sub` like '%". $sql_item_seach_key . "%' or `des` like '%". $sql_item_seach_key . "%' or 
                                           `Serial` like '%" . $sql_item_seach_key. "%') " ;
                if($_POST['search_status']!="") {
					$sql_item_seach = $sql_item_seach . " and status='".$_POST['search_status']."' ";
				}
				$template->assign_vars(array(
                      'txt_enter_key_search'     => $sql_item_seach_key,
                ));
                $link_search   =   "&search=".$sql_item_seach_key; 
            }
            
            if(isset($HTTP_GET_VARS['search']))
            {
                 $sql_item_seach_key    =  $HTTP_GET_VARS['search'];
                 $sql_item_seach = " and (`title` like '%". $sql_item_seach_key . "%' or `sub` like '%". $sql_item_seach_key . "%' or `des` like '%". $sql_item_seach_key . "%' or 
                                           `Serial` like '%" . $sql_item_seach_key. "%') " ;
                $template->assign_vars(array(
                      'txt_enter_key_search'     => $sql_item_seach_key,
                ));
                $link_search   =   "&search=".$sql_item_seach_key; 
            }
			//hidden view
            $sql_hidden_view ="";
            $link_hidden_view  =   "";
			if (isset($_GET["hiddenview"]) and $_GET["hiddenview"]!="") {
            $sql_hidden_view =" and status='".$_GET["hiddenview"]."' ";
            $link_hidden_view  =   "&hiddenview=".$_GET["hiddenview"];
			
			}
			//$sql_query_group = ($cat_id==0)? "id>=0 ": " id IN (SELECT content_id from ".$table_content_to_cat." where cat_id IN ".get_cat_sub($cat_id).") "; 
			$sql_query_group="(";
			get_cat_list($cat_id);
			$sql_query_group=($cat_id==0)?" id>0 ":$sql_query_group." cat_list='xxx')";
			//exit($sql_query_group);
            //Phan trang
            $sql_info_total = "SELECT COUNT(*) FROM `".$table_prj."` where ".$sql_query_group.$sql_hidden_view.$sql_item_seach.$sql_type_trash;
			$sql_info_total = $db->sql_query($sql_info_total) or die(mysql_error());
            $nRows = $db->sql_fetchfield(0);

            $p = !empty($HTTP_GET_VARS['p']) ? $HTTP_GET_VARS['p'] : 0;
            // Set lai $p neu $p >= $nRows
            $p = ( ($p >= $nRows) || !is_numeric($p) || ($p < 0)) ? 0 : $p;
            // So trang dang hien thi
            $link_current_page = ($p > 0) ? '&p=' . $p : '';
            $link_current_page =  $link_current_page.$trash_sel;
            $nNewsSize = 20;
             
            $sql_info="Select * from `".$table_prj."` where ".$sql_query_group.$sql_hidden_view.$sql_item_seach. $sql_type_trash.
             "  ORDER BY ". $order . " LIMIT " . $p . "," . $nNewsSize;
            $sql_info = $db->sql_query($sql_info) or die(mysql_error());
            $couter=0;
            $order_group = ($cat_id==0||$search_info==true)?'':'&cat_id='.$cat_id ;
            //Result search key
            if ($search_info==true)
            {
                if(strlen($sql_item_seach_key) > 24)
                   $sql_item_seach_key_new = substr($sql_item_seach_key,0,24)."...";
                else
                    $sql_item_seach_key_new = $sql_item_seach_key;
                                        
                $template -> assign_vars(array(
                    'txt_resul_search'  => ($sql_item_seach_key=="" and $_POST['search_status']=="")?"":"<p class='result_search' style='color:#E4661C;'>Found ".$nRows." results with keyword <span>".$sql_item_seach_key_new."</span> and status ".$_POST['search_status']."</p>",   
                    'search_1_checked'  => ( $_POST['search_status']=="1")?" checked":"",   
                    'search_0_checked'  => ( $_POST['search_status']=="0")?" checked":"",   
                ));   
            }
            
            while($sql_info_rows = $db->sql_fetchrow($sql_info))
            {
                $couter++;
                $imges_item = $sql_info_rows['image'];
                $image_prev_large = $dir_upload . $imges_item; 
                $image_prev_small = $dir_upload . $imges_item;
                
                $name_img           =   ($sql_info_rows['status']==1)?'publish_g.png':'publish_r.png';  
                
                
                $onclick_img        = 'onclick="return hs.expand(this, {'." captionId: 'caption".$couter."' } )".'"';
                $thiscat_id=Make_field_values1("cat_id", $table_content_to_cat, $db, " where content_id 	='".$sql_info_rows['id']."'");
				$thismodule = Make_field_values1("module", $table_catcontent, $db, " where id='".$thiscat_id."'");
				$group_prj          = '&cat_id='.$thiscat_id;
                $template->assign_block_vars('INFOLIST',array(
                    'stt'               =>  $couter-1,
                    
                    //Hien thi mau cac duong khac  nhau
                    'background'        =>  ($couter%2!=0)?'step1':'step2',
                    'hits'              =>  displayData_Textbox($sql_info_rows['hits']),                
                    'order'             =>  $couter,
                                       
                    'images'           =>  ($imges_item<>"")?"<a id='thumb".$couter.
                    "' class='highslide' ".$onclick_img." href='".$image_prev_large."'><img  width='80' src='".$image_prev_small."'/></a>":'none',
                                        
                    'lang'              =>  $langset,
                    'code'              =>  displayData_Textbox($sql_info_rows['code']),
                    'name'              =>  $sql_info_rows['title'],
                    'catname'              =>  Make_field_values1("title", $table_catcontent, $db, " where id='".$thiscat_id."'"),
                    'price_vn'             =>  displayData_Textbox($sql_info_rows['price_vn']),
                    'priceOld_vn'          =>  displayData_Textbox($sql_info_rows['priceOld_vn']),
                    'price_en'             =>  displayData_Textbox($sql_info_rows['price_en']),
                    'priceOld_en'          =>  displayData_Textbox($sql_info_rows['priceOld_en']),
                    'price_cn'             =>  displayData_Textbox($sql_info_rows['price_cn']),
                    'priceOld_cn'          =>  displayData_Textbox($sql_info_rows['priceOld_cn']),
                    'price_jp'             =>  displayData_Textbox($sql_info_rows['price_jp']),
                    'priceOld_jp'          =>  displayData_Textbox($sql_info_rows['priceOld_jp']),

					'selled'           =>  displayData_Textbox($sql_info_rows['selled']),
                    
                    'created'           =>  transform_date_back_only($sql_info_rows['create_time']),
					
                    'qty'           =>  $sql_info_rows['quantity'],
					
                    'updated'           =>  transform_date_back_only($sql_info_rows['update_time']),
                    
                    'pri_order'         =>  $sql_info_rows['priority_order'],

                    //Hien thi neu sua thi co icon ben canh nguoc lai hien thi id cua item
                    'img'               =>  displayData_Textbox($sql_info_rows['image']), 
                    'id_item'           =>  $sql_info_rows['id'],
                    
                    //Thiet dat cac links thay doi
                    'linkStatus'        =>  ($_SESSION['is_'.$thismodule.'_sua'] == '1' && $TrashMenu==1)?'onclick="window.location.href=\'./?act='.$act_sbj.$group_prj.'&sel='.$sql_info_rows['id']
                    .'&status='.$sql_info_rows['status'].$link_order.$links_dir.$link_current_page.'&p=' . $p.'\'"':'onclick="alert(\'Bạn không có quyền này.\')";',                    
                    'linkEdit'          =>  ($_SESSION['is_'.$thismodule.'_sua'] == '1')?'href="./?act=content_modify'.$group_prj.
                    $link_order.$links_dir.$link_current_page.'&p='. $p.'&addnew='.$sql_info_rows['id'].'#view"':'onclick="alert(\'Bạn không có quyền này.\')";',
                    'linkDel'           =>  ($_SESSION['is_'.$thismodule.'_xoa'] == '1')?'href="./?act='.$act_sbj.$group_prj.'&del='.$sql_info_rows['id']
                    .$link_order.$links_dir.$link_current_page.'&p='. $p.'"':'onclick="alert(\'Bạn không có quyền này.\')";',
                    'linkTrash'         =>  ($_SESSION['is_'.$module.'_sua'] == '1')?'href="./?act='.$act_sbj.$group_prj.'&mTrash='.$sql_info_rows['id']
                    .$link_order.$links_dir.$link_current_page.'&p=' . $p.'"':'',

                    //Thong bao loi neu ban khong co quyen
                    'checkDel'          =>  ($_SESSION['is_'.$module.'_xoa'] == '1')?"return Question_del();":"return Error_law('del')",
                    'checkMod'          =>  ($_SESSION['is_'.$module.'_sua'] == '1')?"":"return Error_law('mod')",
					'publish'         =>  ($sql_info_rows['status']==1)?'checked':'',
					'diable'         =>  ($_SESSION['is_'.$module.'_sua'] == true)?"":'disabled="disabled"',
                    //Hien thi icon theo quy?n
                    'imgStatus'         =>  ($_SESSION['is_'.$module.'_sua'] == '1')?$dir_icon_16.$name_img:$dir_icon_16.'un'.$name_img,
                    'imgEdit'           =>  ($_SESSION['is_'.$module.'_sua'] == '1')?$dir_icon_16.'icon-16-edit.png':$dir_icon_16.'icon-16-unedit.png',
                    'imgDel'            =>  ($_SESSION['is_'.$module.'_xoa'] == '1')?$dir_icon_16.'icon-16-del.png':$dir_icon_16.'icon-16-undel.png',
                    'imgTrash'          =>  ($_SESSION['is_'.$module.'_xoa'] == '1')?$dir_icon_16.'icon-16-trash'.$TrashMenu.'.png':$dir_icon_16.'icon-16-untrash'.$TrashMenu.'.png',
                    'id'                =>  $sql_info_rows['id'],                     
                 ));

               }

                // Hien thi phan trang bai viet
            $url = './?act='.$act_sbj.$link_order.$links_dir.$order_group.$link_hidden_view;
            $page = generate_pagination($url.$trash_sel.$link_search, $nRows, $nNewsSize, $p);
            $template -> assign_vars(array(
                'link_page_info'                 => $page,   
                'txt_sophantu'              => ($couter>0)?$couter:0,
                'txt_other_links'           => '&cat_id='.$cat_id.$link_order.$links_dir.$link_current_page,
                'txt_other_links_title'     => '&cat_id='.$cat_id.$link_current_page,
                'txt_oder_fun'              => '&cat_id='.$cat_id.$link_order.$links_dir,
                'txt_go_link'              => './?act='.$act_sbj.$link_order.$links_dir,
            ));

            $_SESSION['is_links_prj']  =   $order_group.$link_order.$links_dir.$link_current_page;
}     
  
//Hien thi thong tin chung
    $template -> assign_vars(array(
        'sbj_act'    => $act_sbj,
        'ques_del_All'           =>  ($_SESSION['is_'.$module.'_xoa'] == '1')?" Question_del()":" Error_law('del')",
		'txt_msg_error'             => $emsg,
		'txt_show_error'            => (!isset($emsg) or $emsg=='')?'none':'block',
		'txt_mess_result'           => ($bmsg==true)?'success':'danger',       
    ));
$template -> pparse('product');
?>