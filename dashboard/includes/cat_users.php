<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ../');
	exit('Login failed');
}
$template -> set_filenames(array(
	'cat_dichgia'	=> $dir_template . 'cat_users.html')
);
         $act_sbj =  'cat_users';
         $table_prj_sub =  $DB_FSQL . "tblcat_dichgia";
         $table_prj =  $DB_FSQL . "tblcat_dichgia";
// ******************************************** Order INFORMATION ***********************************************


        $id = '0';
        $emsg ='';   //Bien luu tru thong tin
        $mess_result_check_item = true; //Keu loi

        if(isset($HTTP_GET_VARS['id']))
            $id = $HTTP_GET_VARS['id'];

        //Kiem tra hien thi du lieu trong Trash Menu or Menu
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

        //Bien preview
        $cmd = '';
        if(isset($HTTP_POST_VARS['cmd']))
           $cmd = $HTTP_POST_VARS['cmd'];
        //Bien Modif
        $cmdf = '';
        if(isset($HTTP_POST_VARS['cmdf']))
           $cmdf = $HTTP_POST_VARS['cmdf'];

        if(isset($HTTP_POST_VARS['cmdfF']))
           $cmdf = $HTTP_POST_VARS['cmdfF'];

        $Chedo = 1;   //Che do cap nhat du lieu
        $type_update =0;
        $str_add            =   ($_SESSION['lang']=='vn')?'Thêm mới':'Add New';
        $str_mod            =   ($_SESSION['lang']=='vn')?'Sửa':'edit';
        $change_id = 0;
        $parent_id = $id;
        $menu_id = '';
        $image_old = '';
        //Lay Max order Foder=$id
        $Current_oder = Max_pre_order('priority_order',$id,'parent_id',$DB_FSQL.'tblcat_dichgia',$db);

        $template -> assign_vars(array('back2list' => $_SESSION['catinfolist']));
        
        if(isset($HTTP_GET_VARS['addnew']))     
        {
            $Chedo = 0;  //Chế độ thêm mới
            $change_id = (int)$HTTP_GET_VARS['addnew'];

            $sql_info_content ="Select * from " . $DB_FSQL . "tblcat_dichgia where id=". $change_id ;
            $sql_info_content = $db->sql_query($sql_info_content) or die(mysql_error());
            if ( $db->sql_numrows($sql_info_content) == 1)   //Edit
            {            
                while($cat_dichgia_rows = $db->sql_fetchrow($sql_info_content))
                {
                   $type_update =1;
                   $status_val = $cat_dichgia_rows['status'];
                   $parent_id = $cat_dichgia_rows['parent_id'];
                   $Current_oder = $cat_dichgia_rows['priority_order'];
                   
                   $template->assign_vars(array(
                   'type_name_vn'           =>    displayData_Textbox($cat_dichgia_rows['name_vn']),
                   'type_name_en'           =>    displayData_Textbox($cat_dichgia_rows['name_en']),
                   'txt_image_name'         =>    displayData_Textbox($cat_dichgia_rows['image']), 
                   'type_des'               =>    displayData_Textbox($cat_dichgia_rows['des']),
                   'type_des_en'            =>    displayData_Textbox($cat_dichgia_rows['des_en']),
                   'txt_ID'                 =>    displayData_Textbox($cat_dichgia_rows['id']),
			       'ActivitySelected'		=>    ($status_val == 1) ? ' selected' : '',
			       'WaitingSelected'		=>    ($status_val == 0) ? ' selected' : '',
                   ));
                    $image = $cat_dichgia_rows['image'];
      			    if($image != '')
      				    $template -> assign_block_vars('SMALLIMAGE_PREVIEW', array(
      					    'small_image'	=> $dir_upload . $image,
      			        ));
                        
                    $menu_id =  (int)$cat_dichgia_rows['menu_id'];
                    if ($menu_id == 0){
                        $template -> assign_vars(array(
                            'menuid'            => $menu_id,
                            '0_selected'        => ' selected',
                        ));
                    }else{             
                        $get_menu_id = "SELECT * FROM " . $DB_FSQL . "tblmenu WHERE id = '".$menu_id."'";
                        $get_menu_id = $db->sql_query($get_menu_id) or die(mysql_error());
                        while ($menu_rows = $db->sql_fetchrow($get_menu_id))
                        {
                            $template -> assign_vars(array(
                                'menuid'            => $menu_id,
                                '0_selected'        => ($menu_rows['type'] == 0) ? ' selected' : '',
                                '1_selected'        => ($menu_rows['type'] == 1) ? ' selected' : '',
                                '2_selected'        => ($menu_rows['type'] == 2) ? ' selected' : '',
                                '3_selected'        => ($menu_rows['type'] == 3) ? ' selected' : '',
                                '4_selected'        => ($menu_rows['type'] == 4) ? ' selected' : '',
                            ));
                        }
                    }                        
                }
                 //Order select
                $template->assign_vars(array(
                    'priority_order' =>    displayData_Textbox($Current_oder),
                ));  
                              
            }
            else    //them moi thong tin
            {
                
                 //Order select
               $menu_id=(int)$_SESSION['is_menu_id'];
                
                $template->assign_vars(array(
                    'priority_order' =>    displayData_Textbox($Current_oder),
                ));
                
                //Hien thi menu
                if ($menu_id == 0)
                {
                    $template -> assign_vars(array(
                        'menuid'            => $menu_id,
                        '0_selected'        => ' selected',
                    ));
                }
                else
                {             
                    $get_menu_id = "SELECT * FROM " . $DB_FSQL . "tblmenu WHERE id = '".$menu_id."'";
                    $get_menu_id = $db->sql_query($get_menu_id) or die(mysql_error());
                    while ($menu_rows = $db->sql_fetchrow($get_menu_id))
                    {
                        //echo '<br> Chon menu';
                        $template -> assign_vars(array(
                            'menuid'            => $menu_id,
                            '0_selected'        => ($menu_rows['type'] == 0) ? ' selected' : '',
                            '1_selected'        => ($menu_rows['type'] == 1) ? ' selected' : '',
                            '2_selected'        => ($menu_rows['type'] == 2) ? ' selected' : '',
                            '3_selected'        => ($menu_rows['type'] == 3) ? ' selected' : '',
                            '4_selected'        => ($menu_rows['type'] == 4) ? ' selected' : '',
                        ));
                    }
                } 
                                                                  
            }    
        }


       $template->assign_vars(array(
            'txt_show_error'               => 'none', //Hien thi loi
            'trash_icon'                   => ($TrashMenu==0)?'-trash':'',
            'trash_act'                    => $TrashMenu,
            'txt_type_update'              => ($type_update==0)?$str_add:$str_mod,
            'txt_type_button'              => ($type_update==0)?$str_add:$str_mod,
            'txt_chedo0'                   => ($Chedo==0)?'block':'none',
            'txt_chedo1'                   => ($Chedo==0)?'none':'block',
            'sbj_act'                      => $act_sbj,
            'txt_button_law_add'           => ($_SESSION['is_add'] == '1' && $TrashMenu==1)?'block':'none',
            'txt_button_law_trash'         => ($_SESSION['is_modify'] == '1' && $TrashMenu==1)?'block':'none',
            'txt_button_law_mod'           => ($_SESSION['is_modify'] == '1' && $TrashMenu==1 )?'block':'none',
            'txt_button_law_pre'           => ($_SESSION['is_admin'] == '1' && $TrashMenu==1 )?'block':'none',

            'txt_button_law_del'           => ($_SESSION['is_delete'] == '1')?'block':'none',
            'txt_button_law_restore'       => ($_SESSION['is_modify'] == '1' && $TrashMenu==0 )?'block':'none',

        ));



//************************************** Fom Cap nhat du lieu *******************************************
    //1. Them moi thong tin
    if ($cmdf == $str_mod || $cmdf == $str_add)
    {
    	// Small Image Info
    	$smallImageName 		= $HTTP_POST_FILES['fileSmallImage']['name'];
    	$smallImageType 		= $HTTP_POST_FILES['fileSmallImage']['type'];
    	$smallImageTemp 		= $HTTP_POST_FILES['fileSmallImage']['tmp_name'];

    	$strName_Vn 			= $HTTP_POST_VARS['txtType_Vn'];
    	$strName_En 			= $HTTP_POST_VARS['txtType_En'];

        $strParent_Id			= (int)$HTTP_POST_VARS['cbGroup'];
        $menu_type              = $HTTP_POST_VARS['cbMenuType'];  
                
        $menu_id                = (int)$_POST['cbMenu'];
        $_SESSION['is_menu_id'] = $menu_id;      //Dung Session luu lai vi tri cua menu
        
    	$des					= $HTTP_POST_VARS['txtType_Des'];
    	$des_en					= $HTTP_POST_VARS['txtType_Des_En'];
    	$priority_order			= (int)$HTTP_POST_VARS['txtPriority_Order'];

        //Get level of category
        $level 					= 1;  //Default
    	$get_level_of_parent 	= "SELECT level FROM `" . $DB_FSQL . "tblcat_dichgia` WHERE id = '".$strParent_Id."'";
    	$get_level_of_parent 	= $db->sql_query($get_level_of_parent) or die(mysql_error());
    	while($level_of_parent  = $db->sql_fetchrow($get_level_of_parent))
    	{
    		$level				= $level_of_parent['level'] + 1;
    	}

	    $bRemoveImage 			= 0;
	    if(isset($HTTP_POST_VARS['cbRemoveImage']))
		$bRemoveImage 			= (int)$HTTP_POST_VARS['cbRemoveImage']; 
        
        if(isset($HTTP_POST_VARS['txt_img_name']))
        $image_old             = $HTTP_POST_VARS['txt_img_name'];
        
        //1. Add new record
        if ($cmdf == $str_add && $_SESSION['is_add'] == '1')
        {
            	// Upload Small Image
            	$small_image = '';
            	if ( !empty($smallImageName))
            	{
            		$result = upload_files($smallImageName, $smallImageType, $smallImageTemp, $dir_upload);
            		if(!$result)
            		{
            			$emsg = ($_SESSION['lang']=='vn')?'Không thể đưa ảnh lên Website!':'Can not upload image to Website!';
                        $mess_result_check_item = false;
            		}
            		else
                    {
                        $small_image = $smallImageName . $smallImageType;
                        //imagejpeg ( resize ( $dir_upload . $small_image, 280,240,$dir_upload."add_img.png","b"), $dir_upload. $small_image );
                        imagejpeg ( resize ( $dir_upload . $small_image, 303,207,$dir_add."add_img_L.png","b"), $dir_upload. $small_image );                        
                    }

            	}

            	$sql_information_insert = "INSERT INTO `" . $DB_FSQL . "tblcat_dichgia` (`name_vn`, `name_en`, `des`, `des_en`, `image`, `parent_id`, `level`,
                `priority_order`, `menu_id`)
            	VALUES('" . insertData($strName_Vn) . "', '" . insertData($strName_En)
                ."', '". insertData($des). "', '". insertData($des_en). "', '". $small_image
                . "', '". $strParent_Id . "', '". $level ."', '".$priority_order."','".$menu_id."')";
        		$db->sql_query($sql_information_insert) or die(mysql_error());
                
                /******************************************************/
                /*             CAP NHAT MENU VUA DUOC CHON            */
                /******************************************************/
                $sql_id_max = "SELECT id FROM ".$DB_FSQL."tblcat_dichgia ORDER BY id DESC LIMIT 0,1";
                $sql_id_max = $db->sql_query($sql_id_max) or die(mysql_error());
                while ($id_max_row = $db->sql_fetchrow($sql_id_max)){
                    $id_max = (int)$id_max_row['id'];
                }
            	$emsg = $emsg. '<br>'.($_SESSION['lang']=='vn')?'Cập nhật thành công!':'Update successful!';
                $mess_result_check_item = true;
        }

        //2. Modify row
        if ($cmdf == $str_mod && $_SESSION['is_modify'] == '1')
        {
            $id_item_row 	= (int)$HTTP_POST_VARS['id_item'];

			// Upload anh khac
			if ( !empty($smallImageName))
			{
				// Xoa file anh cu
				if ( !empty($image_old) && file_exists($dir_upload . $image_old))
					delete_files($image_old, $dir_upload);
				// Upload file anh moi
				$result = upload_files($smallImageName, $smallImageType, $smallImageTemp, $dir_upload);
				if(!$result)
				{
					$template -> assign_block_vars('NEWINFORMATION_MSG', array(
						'newinformation_msg'	=> ($_SESSION['lang']=='vn')?'Tải ảnh thất bại!':'Upload a picture failed!')
					);
				}
				else
				{
					$image = $smallImageName . $smallImageType; 
                    imagejpeg ( resize ($dir_upload . $image, 303,207,$dir_add."add_img_L.png","b"), $dir_upload. $image );
					$where_image = " image = '" . $image . "', ";
				}
			}
			elseif (empty($smallImageName) && ($bRemoveImage == 1))	// Xoa file anh cu
			{
				if ( !empty($image_old) && file_exists($dir_upload . $image_old))
					delete_files($image_old, $dir_upload);
				$where_image = " image  = '', ";
				$image = '';
			}

			$sql_information_update = "UPDATE `" . $DB_FSQL . "tblcat_dichgia` 
										SET `name_vn` = '" . insertData($strName_Vn) . "',
											`name_en` = '" . insertData($strName_En) . "',
                                            `des` = '".insertData($des)."',
                                            `des_en` = '".insertData($des_en)."',
                                             " . $where_image . "                                           
											`parent_id` = '".$strParent_Id."',
											`level` = '".$level."',											
											`priority_order` = '".$priority_order."',
											`menu_id` = '".$menu_id."' 
										WHERE `id` = '" . $id_item_row . "'";
            /******************************************************/
            /*             CAP NHAT MENU VUA DUOC CHON            */
            /******************************************************/
 			$db->sql_query($sql_information_update) or die(mysql_error());   //Cap nhat thu muc

        	$emsg = $emsg. '<br>'.($_SESSION['lang']=='vn')?'Cập nhật thành công!':'Update successful!';
            $mess_result_check_item = true;
        }
    }



//************************************** Form Hien thi du lieu duoi dang luoi ***************************************************
    //1. Thay doi trang thai
    if ($_SESSION['is_modify'] == '1')
    {
        //1.3. Xoa tung ban ghi vao thung rac
        if(isset($_GET['mTrash']) && isset($_GET['trash']) && $_GET['mTrash'] >=0)
        {
                $change_local=($_GET['trash']==0)?1:0;
        		$sql_change_status = "update `" . $DB_FSQL . "tblcat_dichgia` set `trash`=".$change_local." where id=".(int)$_GET['mTrash'];
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
        		$sql_info_moveTrash = "update `" . $DB_FSQL . "tblcat_dichgia` set `trash` = 0 where `id` IN (" . $MoveTrashID_list . ")";
        		$db->sql_query($sql_info_moveTrash) or die(mysql_error());
        	}
        }

        //1.5. Cap nhat toan bo thong tin dang hien thi
        if ($cmd == 'update')
        {
        	$itemID		    = $HTTP_POST_VARS['itemID'];
        	$itemName_vn	= $HTTP_POST_VARS['strName_vn'];
        	$itemName_en	= $HTTP_POST_VARS['strName_en'];
        	$itemlinks  	= $HTTP_POST_VARS['strLinks'];
            $itemOrder  	= $HTTP_POST_VARS['order'];

        	if(count($itemID) > 0)
        	{
        		for($i=0;$i<count($itemID);$i++)
        		{
        			$sql_update = "UPDATE `" . $DB_FSQL . "tblcat_dichgia` SET
                                                     `name_vn` = '".$itemName_vn[$i]."',
                                                     `name_en`= '".$itemName_en[$i]."',
                                                     `priority_order`= '".(int)$itemOrder[$i]."' WHERE `id` = '".$itemID[$i]."'";
                    $sql_update = $db->sql_query($sql_update) or die(mysql_error());
        		}
        	}
        }

        //1.6 Restore
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
        		$sql_info_restore = "update `" . $DB_FSQL . "tblcat_dichgia` set `trash` = 1 where `id` IN (" . $Restore_list . ")";
        		$db->sql_query($sql_info_restore) or die(mysql_error());
        	}
        }
    }


    //2. Xoa item
    if($_SESSION['is_delete'] == '1')
    {
      //2.1. Xoa tung item
      if(isset($_GET['del']) && $_GET['del'] != 0)
      {
            $sql_item = "delete from `".$table_prj."` where id=".(int)$_GET['del'];
            $sql_item = $db->sql_query($sql_item) or die(mysql_error());
      }

     //2.2. Xoa nhieu item
      if($cmd=='xoa')
      {
          	$Del_ID = $HTTP_POST_VARS['cid'];
        	$Del_list = '';
         	if ( count($Del_ID) > 0 )
        	{
                $itemSubID = "(";  
        		foreach ($Del_ID as $information_id )
        		{
        			$Del_list .= $information_id . ', ';
        		}
        		$Del_list .= '0';
                $sql_item = "delete from `".$table_prj."` where id IN (" . $Del_list . ")"; 
                $sql_item = $db->sql_query($sql_item) or die(mysql_error());                     
        	}
      }
    }



    //Show information if user login have law Preview
    if ($_SESSION['is_admin'] == '1')
    {
         // show parent id
          if(!isset($_GET['id']))
          	$id = 0;
          else
          	$id = $_GET['id'];


        //Order by information
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
            		    $order = " name_".$_SESSION['lang']." ".$_GET['dir'];
                    	$template->assign_vars(array(
                    		'order_name'                 => $img_sort_title,
                            'txt_class_title_name'       => 'order_active',
                            'txt_class_title_order'      => 'order',
                            'txt_class_title_status'     => 'order',
                            'txt_class_title_id'         => 'order',
                    	));
            			break;
            		case 'pri_order':
            		    $order = " priority_order ".$_GET['dir'];
                    	$template->assign_vars(array(
                    		'order_pri_order'            => $img_sort_title,
                            'txt_class_title_name'       => 'order',
                            'txt_class_title_order'      => 'order_active',
                            'txt_class_title_status'     => 'order',
                            'txt_class_title_id'         => 'order',
                    	));
            			break;
                	case 'id':
            			$order = " id ".$_GET['dir'];
                    	$template->assign_vars(array(
                    		'order_id'                   => $img_sort_title,
                            'txt_class_title_name'       => 'order',
                            'txt_class_title_order'      => 'order',
                            'txt_class_title_status'     => 'order',
                            'txt_class_title_id'         => 'order_active',
                    	));
            			break;
            	}
                $link_order = "&order=".$_GET['order'];
            }
            else
            {
            	$order = " id DESC";
              	$template->assign_vars(array(
                            'txt_class_title_name'       => 'order',
                            'txt_class_title_order'      => 'order',
                            'txt_class_title_status'     => 'order',
                            'txt_class_title_id'         => 'order',
              	));
            }

      //Search all inf in table Menu
        $sql_item_seach ="";
        $link_search   =   "";
        $search_info    =   false;
        
        if ( $cmd == 'Tìm' || $cmd == 'Search')
        {
             $sql_item_seach_key = $HTTP_POST_VARS['txtInfo_Search'];
             $sql_item_seach = " and (`name_vn` like '%" . $sql_item_seach_key . "%' or
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
             $sql_item_seach = " and (`name_vn` like '%" . $sql_item_seach_key . "%' or
                                       `name_en` like '%" . $sql_item_seach_key. "%') " ;
            $template->assign_vars(array(
                  'txt_enter_key_search'     => $sql_item_seach_key,
            ));
            $link_search   =   "&search=".$sql_item_seach_key;
            $search_info    =   true;  
        }
        
        $type_view = ($TrashMenu==1)?"parent_id =".$id." and ":" ";
        
        $sql_define_total = "SELECT COUNT(*) FROM `" . $DB_FSQL . "tblcat_dichgia` where ".$type_view." parent_id>=0 " . $sql_item_seach.$sql_type_trash;
        $sql_define_total = $db->sql_query($sql_define_total) or die(mysql_error());
        $nRows = $db->sql_fetchfield(0);

        $p = !empty($HTTP_GET_VARS['p']) ? $HTTP_GET_VARS['p'] : 0;
        // Set lai $p neu $p >= $nRows
        $p = ( ($p >= $nRows) || !is_numeric($p) || ($p < 0)) ? 0 : $p;
        // So trang dang hien thi
        $link_current_page = ($p > 0) ? '&p=' . $p : '';
        $link_current_page =  $link_current_page.$trash_sel;
        $nNewsSize = 20;

        //Result search key
        if ($search_info==true)
        {
            if(strlen($sql_item_seach_key) > 24)
               $sql_item_seach_key_new = substr($sql_item_seach_key,0,24)."...";
            else
                $sql_item_seach_key_new = $sql_item_seach_key;
                                    
            $template -> assign_vars(array(
                'txt_resul_search'  => ($_SESSION['lang']==vn)?"<p class='result_search'>[ Tìm được ".$nRows." nhóm tin với từ khóa <span title='".$sql_item_seach_key."'>".$sql_item_seach_key_new."</span> ]</p>":
                "<p class='result_search'>[ Found ".$nRows." contents with keywords <span title='".$sql_item_seach_key."'>".$sql_item_seach_key_new."</span> ]</p>",   
            ));   
        }

        $sql_define_cat="Select * from `" . $DB_FSQL . "tblcat_dichgia` where ".$type_view." parent_id>=0 " . $sql_item_seach. $sql_type_trash ."  ORDER BY ". $order . " LIMIT " . $p . "," . $nNewsSize;
        $sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
        $couter=0;
        $order_group = ($id==0)?'':'&id='.$id ;
        while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
        {
        	$couter++;
            $name_img    =   ($sql_define_cat_rows['status']==1)?'publish_g.png':'publish_r.png';

        	$sql_group = "SELECT * FROM `" . $DB_FSQL . "tblcat_dichgia` WHERE parent_id = ".$sql_define_cat_rows['id'].$sql_type_trash;
        	$sql_group = $db->sql_query($sql_group) or die(mysql_error());
        	$cat_dichgia_rows1 = $db->sql_fetchrow($sql_group);

            $imges_item = $sql_define_cat_rows['image'];   //Make images item
            $onclick_eve = ($info_exits_nums == 0)?'':$strjs_info;
            
            $image_item_view = $dir_upload . $imges_item;
            $onclick_img        = 'onclick="return hs.expand(this, {'." captionId: 'caption".$couter."' } )".'"';
            
            $type_icon_files     = ($info_exits_nums == 0)?'icon-16-item.png':'icon-16-items.png'; 
            $type_icon_f = (!empty($cat_dichgia_rows1['id']) && $TrashMenu==1)?'icon-16-folders.png':$type_icon_files;
            
        	$template->assign_block_vars('MENULIST',array(
        		'id'  		        =>  $sql_define_cat_rows['id'],
                'type_F'            =>  ($TrashMenu==1)?'<a href="./?act='.$act_sbj.'&id='.$sql_define_cat_rows['id'].$link_order
                .$links_dir.$link_current_page.'&p='.$p.'" '.$onclick_eve.
                '><img src="'.$dir_icon_16.$type_icon_f.'" border="0"/></a>':'<img src="'.$dir_icon_16.$type_icon_f.'" border="0"/>',
                
        		'name_vn' 		    =>  displayData_Textbox($sql_define_cat_rows['name_vn']),
        		'name_en' 		    =>  displayData_Textbox($sql_define_cat_rows['name_en']), 
                
                //'images'            =>  (!empty($imges_item) && file_exists($dir_upload . $imges_item)&& $TrashMenu==1)?'<a href="./?act='.$act_sbj.
                //'&id='.$sql_define_cat_rows['id'].$link_order.$links_dir.$link_current_page.'&p=' . $p.'" '.$onclick_eve.'><img src="'  
                //.$dir_upload . $imges_item.'"  height="46" width="61" border="0"/></a>':'none',

                'images'            =>  (!empty($imges_item) && file_exists($dir_upload . $imges_item)&& $TrashMenu==1)?"<a id='thumb".$couter."' class='highslide' ".$onclick_img." href='".$image_item_view."'> <img height='46' width='61' border='0' src='".$image_item_view."'/></a>":'none',
                                                             
                //'preview'           =>  "<a id='thumb".$couter."' class='highslide' ".$onclick_img." href='".$image_item_view."'> <img src='./images/view_cam.png'/></a>",        		
                'order'		        =>  $couter,
                'onclick_eve'       =>  $onclick_eve,
                'pri_order'         =>  displayData_Textbox($sql_define_cat_rows['priority_order']),


                //Hien thi neu sua thi co icon ben canh nguoc lai hien thi id cua item
        		'id_item'           =>  ($sql_define_cat_rows['id']==$id_choose_edit)?$sql_define_cat_rows['id'].
                '<img border="0" src="./images/item_select.gif" />':$sql_define_cat_rows['id'],
                'stt'               =>  $couter-1,

                //Hien thi mau cac duong khac  nhau
                'background'        =>  ($couter%2!=0)?'step1':'step2',

                //Thiet dat cac links thay doi
                'linkEdit'          =>  ($_SESSION['is_modify'] == '1')?'href="./?act='.$act_sbj.'&id='.$id.
                $link_order.$links_dir.$link_current_page.'&addnew='.$sql_define_cat_rows['id'].'"':'',
                'linkDel'           =>  ($_SESSION['is_delete'] == '1')?'href="./?act='.$act_sbj.'&id='.$id.'&del='.$sql_define_cat_rows['id']
                .$links_adnew.$link_order.$links_dir.$link_current_page.'&p=' . $p.'"':'',
                'linkTrash'         =>  ($_SESSION['is_modify'] == '1')?'href="./?act='.$act_sbj.'&mTrash='.$sql_define_cat_rows['id']
                .$links_adnew.$link_order.$links_dir.$link_current_page.'&p=' . $p.'"':'',

                //Thong bao loi neu ban khong co quyen
                'checkDel'          =>  ($_SESSION['is_delete'] == '1')?"return Question_del();":"return Error_law('del')",
                'checkMod'          =>  ($_SESSION['is_delete'] == '1')?"":"return Error_law('mod')",

                //Hien thi icon theo quy?n
                'imgStatus'         =>  ($_SESSION['is_modify'] == '1')?$dir_icon_16.$name_img:$dir_icon_16.'un'.$name_img,
                'imgEdit'           =>  ($_SESSION['is_modify'] == '1')?$dir_icon_16.'icon-16-edit.png':$dir_icon_16.'icon-16-unedit.png',
                'imgDel'            =>   ($_SESSION['is_delete'] == '1')?$dir_icon_16.'icon-16-del.png':$dir_icon_16.'icon-16-undel.png',
                'imgTrash'          =>   ($_SESSION['is_modify'] == '1')?$dir_icon_16.'icon-16-trash'.$TrashMenu.'.png':$dir_icon_16.'icon-16-untrash'.$TrashMenu.'.png',
        	));

           }

            // Hien thi phan trang

        $url = './?act='.$act_sbj.$links_adnew.$link_edit.$link_order.$links_dir.$order_group;
        $page = generate_pagination($url.$trash_sel.$link_search, $nRows, $nNewsSize, $p);
        $template -> assign_vars(array(
        	'link_page'	                => $page,   
            'txt_sophantu'              => ($couter>0)?$couter:0,
            'txt_other_links'           => $link_order.$links_dir.$link_current_page.'&p=' . $p,
            'txt_other_links_title'     => '&id='.$id.$link_current_page,
            'txt_oder_fun'              => $link_order.$links_dir,
        ));

    }
	echo ("aaa");
    $template -> assign_vars(array(
    	'link_page'	=> $page,
        'checkDel_anyfile'       =>  ($_SESSION['is_delete'] == '1')?"Question_del()":"Error_law('del')",
        
        'txt_msg_error'          => $emsg,
        'txt_show_error'         => ($emsg=='')?'none':'block',
        'txt_mess_result'        => ($mess_result_check_item==true)?'finish':'error',

    ));

$template -> pparse('cat_dichgia');
?>