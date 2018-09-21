<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ./login.php');
	exit('Login failed');
}
$template -> set_filenames(array(
	'setting'	=> $dir_template . 'setting.html',

	)
);
      $tab = (isset($_GET['tab']))?$_GET['tab']:0;
      $cmd = '';
      $emsg ='';   //Bien luu tru thong bao
      $bmsg = true; //Style l?i
      if(isset($HTTP_POST_VARS['cmd']))
         $cmd = $HTTP_POST_VARS['cmd'];

      //Hien thi Tab vua chon
      for($i=0;$i<=2;$i++)
      {
            $template -> assign_vars(array(
            	'txt_tab_curent_'.$i => ($i==$tab)?'id="current"':'',
            	'txt_show_tab_'.$i   => ($i==$tab)?'block':'none',
            ));
      }

      //Hien thi kieu button update in form
          $txt_button_type  ="submitForm_NN()";
		   switch ($tab)
		  {
			case 0:
					  $txt_button_type  ="submitbutton('update')";
					  break;
			case 1:

					  break;
			case 2:

					  break;
		  }
          $template -> assign_vars(array(
          	'txtButton_type'   => $txt_button_type,
			'txt_lang_vn_display'	=> '',
			'txt_lang_en_display'	=> 'display:none;',
          ));


     //Cap nhat thong tin
     if ($cmd=='update')
     {
		 if($_SESSION['is_admin_sua'] == '1')
		 {
					   switch ($tab)
					  {
						case 0:
							  $tabID                = (int)$HTTP_POST_VARS['tab0_setting_id'];
                              $valunderC            = (int)$HTTP_POST_VARS['offline'];
							  $valEvents             = (int)$HTTP_POST_VARS['events'];
							  $valShowOffline       = (int)$HTTP_POST_VARS['OfflineLang'];
							  $nameSite_vn          = $HTTP_POST_VARS['txt_site_name_vn'];
							  $nameSite_en          = $HTTP_POST_VARS['txt_site_name_en'];
							  $messOffline_vn       = $HTTP_POST_VARS['mes_offline_vn'];
							  $messOffline_en       = $HTTP_POST_VARS['mes_offline_en'];
							  $cur_post          = $HTTP_POST_VARS['currency'];
							  $cur_ex_post          = $HTTP_POST_VARS['cur_ex'];
							  $site_logo          = $HTTP_POST_VARS['fileSmallImage'];
							  $f_link          = $HTTP_POST_VARS['txt_f_link'];
							  $t_link          = $HTTP_POST_VARS['txt_t_link'];
							  $g_link          = $HTTP_POST_VARS['txt_g_link'];
							  $hidden_tag            = $HTTP_POST_VARS['hidden_tag'];
							  $meta_page            = $HTTP_POST_VARS['metaPage'];
							  $meta_key             = $HTTP_POST_VARS['metaKey'];
                              $meta_robot           = $HTTP_POST_VARS['txt_site_robots'];
                              $meta_author          = $HTTP_POST_VARS['txt_site_author'];
                              $meta_author          = $HTTP_POST_VARS['txt_site_author'];
                              $xuduyetbai          = $HTTP_POST_VARS['xuduyetbai'];
                              $phantramdl_admin          = $HTTP_POST_VARS['phantramdl_admin'];
                              $xu1000view          = $HTTP_POST_VARS['xu1000view'];
                              $user_fee          = $HTTP_POST_VARS['user_fee'];
							  $copyright          = $HTTP_POST_VARS['txt_copyright'];
							  $pro_w          = $HTTP_POST_VARS['pro_w'];
							  $pro_h          = $HTTP_POST_VARS['pro_h'];
							  $prothumb_w          = $HTTP_POST_VARS['prothumb_w'];
							  $prothumb_h          = $HTTP_POST_VARS['prothumb_h'];
							  $prodetail_w          = $HTTP_POST_VARS['prodetail_w'];
							  $prodetail_h          = $HTTP_POST_VARS['prodetail_h'];
							  $probig_w          = $HTTP_POST_VARS['probig_w'];
							  $probig_h          = $HTTP_POST_VARS['probig_h'];
							  $order_code          = $HTTP_POST_VARS['order_code'];
							  $sale_email         = $HTTP_POST_VARS['sale_email'];
							  $addcode          = $HTTP_POST_VARS['addcode'];
							  $str_addcode = "";
							  foreach ($addcode as $item)
								{
									if ($item!="") {
										$str_addcode = $str_addcode. $item."|*|";
									} else {
										$str_addcode = $str_addcode. " "."|*|";
									}
								}
							  $sql_updat_tab1= "update `".$DB_FSQL."tblsetting` set
                                          `underC`      =". $valunderC . ",
										  `event`       =". $valEvents . ",
										  `pro_w`       =". $pro_w . ",
										  `pro_h`       =". $pro_h . ",
										  `prothumb_w`       =". $prothumb_w . ",
										  `prothumb_h`       =". $prothumb_h . ",
										  `prodetail_w`       =". $prodetail_w . ",
										  `prodetail_h`       =". $prodetail_h . ",
										  `probig_w`       =". $probig_w . ",
										  `probig_h`       =". $probig_h . ",
										  `order_code`       ='". $order_code . "',
										  `sale_email`       ='". $sale_email . "',
										  `addcode`      ='". insertData($str_addcode) . "',
										  `xu1000view`      ='". insertData($xu1000view) . "',
										  `user_fee`      ='". insertData($user_fee) . "',
										  `xuduyetbai`      ='". insertData($xuduyetbai) . "',
										  `phantramdl_admin`      ='". insertData($phantramdl_admin) . "',
										  `msg_vn`      ='". insertData($messOffline_vn) . "',
										  `msg_en`      ='". insertData($messOffline_en) . "',
										  `msg_show`    ='". insertData($valShowOffline) . "',
										  `cur` ='". insertData($cur_post) . "',
										  `cur_ex` ='". insertData($cur_ex_post) . "',
										  `site_logo` ='". $site_logo . "',
										  `f_link` ='". $f_link . "',
										  `t_link` ='". $t_link . "',
										  `g_link` ='". $g_link . "',
										  `copyright` ='". $copyright . "',
										  `hidden_tag`     ='". insertData($hidden_tag) ."',
										  `DesMeta`     ='". insertData($meta_page) ."',
                                          `robots`      ='". insertData($meta_robot) ."',
                                          `author`      ='". insertData($meta_author) ."',
                                          `KeyMeta`      ='". insertData($meta_key) ."',
										  `siteName_vn` ='". insertData($nameSite_vn) . "',
										  `siteName_en` ='". insertData($nameSite_en) . "' where `id`=". $tabID;
							  $db->sql_query($sql_updat_tab1) or die(mysql_error());

							  //Messge box successful
							  $emsg=($_SESSION['lang'] == 'vn')?"Ðã cập nhật thành công!": "Update successfully!";
							  $bmsg=true;
							  break;
						case 1:
							  $tabID                    = (int)$HTTP_POST_VARS['tab1_setting_id'];
							  $contact_vn_file			= $HTTP_POST_VARS['txtContent_Vn'];
							  $contact_en_file			= $HTTP_POST_VARS['txtContent_En'];

							  $sql_update_tab2= "update ".$DB_FSQL."tblsetting set `contact_vn` ='". insertData($contact_vn_file) . "',
										   `contact_en`     ='". insertData($contact_en_file) . "' where `id`=". $tabID;
							  $db->sql_query($sql_update_tab2) or die(mysql_error());

							  //Messge box successful
							  $emsg=($_SESSION['lang'] == 'vn')?"Ðã cập nhật thành công!": "Update successfully!";
							  $bmsg=true;
							  break;
						case 2:
							  $tabID                       = (int)$HTTP_POST_VARS['tab2_setting_id'];
							  $contact_footer_vn      = $HTTP_POST_VARS['footer_vn'];
							  $contact_footer_en           = $HTTP_POST_VARS['footer_en'];

							  $sql_updat_tab3= "update `".$DB_FSQL."tblsetting` set
										  `footer_vn`     ='". insertData($contact_footer_vn) . "',
										  `footer_en`     ='". insertData($contact_footer_en) . "' where `id`=". $tabID;
							  $db->sql_query($sql_updat_tab3) or die(mysql_error());

							  //Messge box successful
							  $emsg=($_SESSION['lang'] == 'vn')?"Ðã cập nhật thành công!": "Update successfully!";
							  $bmsg=true;
							  break;
					  }
		 }
		 else
		 {
							  //Messge box successful
							  $emsg=($_SESSION['lang'] == 'vn')?"Bạn chưa được cấp phép thay đổi thông tin trên Module này!": "Can not change inforamion on Modules!";
							  $bmsg=false;
		 }
     }

   //Hien thi du lieu
		   switch ($tab)
		  {
			case 0:
					 $sql_setting0   =   "Select * from ".$DB_FSQL."tblsetting where id=1";
					 $sql_setting0   =   $db->sql_query($sql_setting0) or die(mysql_error());
					  while($sql_setting0_rows = $db->sql_fetchrow($sql_setting0))
					  {
								$template->assign_block_vars('Tab0',array(
										   'id'                             =>    $sql_setting0_rows['id'],
										   'txt_ofline0'                    =>   ($sql_setting0_rows['underC']=='1')?'':'checked="checked"',
										   'txt_ofline1'                    =>   ($sql_setting0_rows['underC']=='1')?'checked="checked"':'',
										   'txtSite_nameVN'                 =>   displayData_Textbox($sql_setting0_rows['siteName_vn']),
										   'txtSite_nameEN'                 =>   displayData_Textbox($sql_setting0_rows['siteName_en']),
										   'txt_mesoffline_vn'              =>   displayData_Textbox($sql_setting0_rows['msg_vn']),
										   'txt_mesoffline_en'              =>   displayData_Textbox($sql_setting0_rows['msg_en']),
                                           'txtSite_robot'                  =>   displayData_Textbox($sql_setting0_rows['robots']),   
                                           'txtSite_author'                 =>   displayData_Textbox($sql_setting0_rows['author']),   
										   'hidden_tag'             		=>   displayData_Textbox($sql_setting0_rows['hidden_tag']),
										   'txt_data_meta_page'             =>   displayData_Textbox($sql_setting0_rows['DesMeta']),
										   'txt_data_meta_key'              =>   displayData_Textbox($sql_setting0_rows['KeyMeta']),
										   'vnd_cur_selected'				=>   ($sql_setting0_rows['cur']=='1')?"checked":"",
										   'dolla_cur_selected'				=>   ($sql_setting0_rows['cur']=='2')?"checked":"",
										   'dolla_cur_ex'					=>   (int)$sql_setting0_rows['cur_ex'],
										   'txt_site_logo'					=>    displayData_Textbox($sql_setting0_rows['site_logo']),
										   'txtf_link'						=>    displayData_Textbox($sql_setting0_rows['f_link']),
										   'txtt_link'						=>    displayData_Textbox($sql_setting0_rows['t_link']),
										   'txtg_link'						=>    displayData_Textbox($sql_setting0_rows['g_link']),
										   'txtcopyright'					=>    displayData_Textbox($sql_setting0_rows['copyright']),
										   'phantramdl_admin'					=>    displayData_Textbox($sql_setting0_rows['phantramdl_admin']),
										   'xuduyetbai'					=>    displayData_Textbox($sql_setting0_rows['xuduyetbai']),
										   'xu1000view'					=>    displayData_Textbox($sql_setting0_rows['xu1000view']),
										   'user_fee'					=>    displayData_Textbox($sql_setting0_rows['user_fee']),
										   'pro_w'					=>    displayData_Textbox($sql_setting0_rows['pro_w']),
										   'pro_h'					=>    displayData_Textbox($sql_setting0_rows['pro_h']),
										   'prothumb_w'					=>    displayData_Textbox($sql_setting0_rows['prothumb_w']),
										   'prothumb_h'					=>    displayData_Textbox($sql_setting0_rows['prothumb_h']),
										   'prodetail_w'					=>    displayData_Textbox($sql_setting0_rows['prodetail_w']),
										   'prodetail_h'					=>    displayData_Textbox($sql_setting0_rows['prodetail_h']),
										   'probig_w'					=>    displayData_Textbox($sql_setting0_rows['probig_w']),
										   'probig_h'					=>    displayData_Textbox($sql_setting0_rows['probig_h']),
										   'order_code'					=>    displayData_Textbox($sql_setting0_rows['order_code']),
										   'sale_email'					=>    displayData_Textbox($sql_setting0_rows['sale_email']),
                                           
							   ));
							   $addcode_str = displayData_Textbox($sql_setting0_rows['addcode']);
							   $explosub = explode("|*|",$addcode_str);
							   $i=0;
							   foreach ($explosub as $item)
								{
									$i++;
                                    $template -> assign_vars(array(
                                        "Tab0_addcode_".$i    =>   $item,
                                    ));
								}
                               //Events
                               for($i=0;$i<=2;$i++)
                               {
                                   $des_events = (int)$sql_setting0_rows['event'];  
                                   $from_events = "txt_event_".$i;  
                                   $template -> assign_vars(array(
                                        $from_events    =>   ($des_events==$i)?'selected="selected"':''
                                   ));
                               }
							   //lang
								$sql_define = "Select * from " . $table_lang . " ORDER BY priority_order ASC";
								$sql_define = $db->sql_query($sql_define) or die(mysql_error());
								while($sql_define_rows = $db->sql_fetchrow($sql_define))
								{
									 $template->assign_block_vars('Tab0.LANG_LIST',array(
										'name'			=>   $sql_define_rows['name'],
										'id'		=>   $sql_define_rows['id'],
										'selected'		=>   ($sql_setting0_rows['msg_show']==$sql_define_rows['id'])?' selected':'',
									 ));
								}
					  }
					 break;
			case 1:
					 $sql_setting1   =   "Select * from ".$DB_FSQL."tblsetting where id=1";
					 $sql_setting1   =   $db->sql_query($sql_setting1) or die(mysql_error());
					  while($sql_setting1_rows = $db->sql_fetchrow($sql_setting1))
					  {
								$template->assign_block_vars('Tab1',array(
								   'id'                =>    $sql_setting1_rows['id'],
								   'Contact_vn'        =>   displayData_Textbox($sql_setting1_rows['contact_vn']),
								   'Contact_en'        =>   displayData_Textbox($sql_setting1_rows['contact_en']),
							   ));
					  }
					  break;
			case 2:
					 $sql_setting2   =   "Select * from ".$DB_FSQL."tblsetting where id=1";
					 $sql_setting2   =   $db->sql_query($sql_setting2) or die(mysql_error());
					  while($sql_setting_rows = $db->sql_fetchrow($sql_setting2))
					  {
								$template->assign_block_vars('Tab2',array(
								   'id'                  =>    $sql_setting_rows['id'],
								   'txtContact_footer_vn'        =>   displayData_Textbox($sql_setting_rows['footer_vn']),
								   'txtContact_footer_en'        =>   displayData_Textbox($sql_setting_rows['footer_en']),
							   ));
					  }

					break;
		  }


// ******************************************* 4.TOTAL INFORMATION SHOW IN MODULE ********************************
$template -> assign_vars(array(
    'txt_msg_error'             => $emsg,
    'txt_show_error'            => ($emsg=='')?'none':'block',
    'txt_mess_result'           => ($bmsg==true)?'success':'danger',
));



$template -> pparse('setting');
?>