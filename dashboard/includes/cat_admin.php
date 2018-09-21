<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ../');
	exit('Login failed');
}
$template -> set_filenames(array(
	'cat_admin'	=> $dir_template . 'cat_admin.html')
);
if ($_SESSION['is_admin_sua'] <> '1')
{
echo "<script> alert('Bạn không có quyền truy cập trang này!'); location.href='index.php';</script>";
exit();
}
         $act_sbj =  'cat_admin';
         $table_prj_sub =  $DB_FSQL . "tblalbum";
         $table_prj =  $DB_FSQL . "tblcat_admin";
// ******************************************** Order INFORMATION ***********************************************
			$template->assign_vars(array(
				'txt_msg_error'  		    =>  "",
				'txt_show_error'            =>  'none',
				'txt_mess_result'           => 'finish',
			));
if (isset($_POST['cmdf']))
{
$p_name = $_POST['admin_name'];
$p_admin = (int)$_POST['admin_xem'].(int)$_POST['admin_sua'].(int)$_POST['admin_xoa'].(int)$_POST['admin_them'];
$p_info = (int)$_POST['info_xem'].(int)$_POST['info_sua'].(int)$_POST['info_xoa'].(int)$_POST['info_them'];
$p_pro = (int)$_POST['pro_xem'].(int)$_POST['pro_sua'].(int)$_POST['pro_xoa'].(int)$_POST['pro_them'];
$p_hv = (int)$_POST['hv_xem'].(int)$_POST['hv_sua'].(int)$_POST['hv_xoa'].(int)$_POST['hv_them'];
$p_tk = (int)$_POST['tk_xem'].(int)$_POST['tk_sua'].(int)$_POST['tk_xoa'].(int)$_POST['tk_them'];
$p_lh = (int)$_POST['lh_xem'].(int)$_POST['lh_sua'].(int)$_POST['lh_xoa'].(int)$_POST['lh_them'];
$p_th = (int)$_POST['th_xem'].(int)$_POST['th_sua'].(int)$_POST['th_xoa'].(int)$_POST['th_them'];
$p_dg = (int)$_POST['dg_xem'].(int)$_POST['dg_sua'].(int)$_POST['dg_xoa'].(int)$_POST['dg_them'];
$p_nk = (int)$_POST['nk_xem'].(int)$_POST['nk_sua'].(int)$_POST['nk_xoa'].(int)$_POST['nk_them'];

			$sql_information_update = "UPDATE `" . $DB_FSQL . "tblcat_admin` 
										SET `admin` = '" . $p_admin . "',
										`name` = '" . $p_name . "',
										`info` = '" . $p_info . "',
										`pro` = '" . $p_pro . "',
										`hv` = '" . $p_hv . "',
										`lhe` = '" . $p_lh . "',
										`tke` = '" . $p_tk . "',
										`dgia` = '" . $p_dg . "',
										`thv` = '" . $p_th . "',
                                        `nky` = '".$p_nk."'   
										WHERE `id` = '" . $_GET['id'] . "'";
			$db->sql_query($sql_information_update) or die(mysql_error()); 
			$template->assign_vars(array(
				'txt_msg_error'  		    =>  "Cập nhật thành công!",
				'txt_show_error'            =>  'block',
				'txt_mess_result'           => 'finish',
			));
}


    //Show information if user login have law Preview
    if ($_SESSION['is_admin_sua'] == '1')
    {
		$sql_define_cat="Select * from `" . $DB_FSQL . "tblcat_admin`";
		$sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
		while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
			{
			$template->assign_block_vars('LISTGROUP',array(
				'id'  		    =>  $sql_define_cat_rows['id'],
				'selected'  	=>  (isset($_GET['id']) and $sql_define_cat_rows['id']==$_GET['id'])?'selected':'',
				'name' 		    =>  $sql_define_cat_rows['name'],

			));
			}
		if (isset($_GET['id']) and  $_GET['id']>0)
		{
			$sql_define_cat="Select * from `" . $DB_FSQL . "tblcat_admin` where id='".$_GET['id']."'Order by order_g";
			$sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
			while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
				{
				$is_admin = str_split($sql_define_cat_rows['admin']);
				$is_info = str_split($sql_define_cat_rows['info']);
				$is_pro = str_split($sql_define_cat_rows['pro']);
				$is_hv= str_split($sql_define_cat_rows['hv']);
				$is_lh = str_split($sql_define_cat_rows['lhe']);
				$is_tk = str_split($sql_define_cat_rows['tke']);
				$is_th = str_split($sql_define_cat_rows['thv']);
				$is_dg = str_split($sql_define_cat_rows['dgia']);
				$is_nk = str_split($sql_define_cat_rows['nky']);
				$template->assign_vars(array(
					'txt_admin_name'  		        =>  $sql_define_cat_rows['name'],
					'txt_admin_xem'  		        =>  str_replace('1','checked',$is_admin[0]),
					'txt_admin_sua'  		        =>  str_replace('1','checked',$is_admin[1]),
					'txt_admin_xoa'  		        =>  str_replace('1','checked',$is_admin[2]),
					'txt_admin_them'  		        =>  str_replace('1','checked',$is_admin[3]),
					
					'txt_info_xem'  		        =>  str_replace('1','checked',$is_info[0]),
					'txt_info_sua'  		        =>  str_replace('1','checked',$is_info[1]),
					'txt_info_xoa'  		        =>  str_replace('1','checked',$is_info[2]),
					'txt_info_them'  		        =>  str_replace('1','checked',$is_info[3]),
					
					'txt_pro_xem'  		        =>  str_replace('1','checked',$is_pro[0]),
					'txt_pro_sua'  		        =>  str_replace('1','checked',$is_pro[1]),
					'txt_pro_xoa'  		        =>  str_replace('1','checked',$is_pro[2]),
					'txt_pro_them'  		    =>  str_replace('1','checked',$is_pro[3]),

					'txt_hv_xem'  		        =>  str_replace('1','checked',$is_hv[0]),
					'txt_hv_sua'  		        =>  str_replace('1','checked',$is_hv[1]),
					'txt_hv_xoa'  		        =>  str_replace('1','checked',$is_hv[2]),
					'txt_hv_them'  		    	=>  str_replace('1','checked',$is_hv[3]),
					
					'txt_lh_xem'  		        =>  str_replace('1','checked',$is_lh[0]),
					'txt_lh_sua'  		        =>  str_replace('1','checked',$is_lh[1]),
					'txt_lh_xoa'  		        =>  str_replace('1','checked',$is_lh[2]),
					'txt_lh_them'  		    	=>  str_replace('1','checked',$is_lh[3]),
					
					'txt_tk_xem'  		        =>  str_replace('1','checked',$is_tk[0]),
					'txt_tk_sua'  		        =>  str_replace('1','checked',$is_tk[1]),
					'txt_tk_xoa'  		        =>  str_replace('1','checked',$is_tk[2]),
					'txt_tk_them'  		    	=>  str_replace('1','checked',$is_tk[3]),
					
					'txt_th_xem'  		        =>  str_replace('1','checked',$is_th[0]),
					'txt_th_sua'  		        =>  str_replace('1','checked',$is_th[1]),
					'txt_th_xoa'  		        =>  str_replace('1','checked',$is_th[2]),
					'txt_th_them'  		    	=>  str_replace('1','checked',$is_th[3]),
					
					'txt_dg_xem'  		        =>  str_replace('1','checked',$is_dg[0]),
					'txt_dg_sua'  		        =>  str_replace('1','checked',$is_dg[1]),
					'txt_dg_xoa'  		        =>  str_replace('1','checked',$is_dg[2]),
					'txt_dg_them'  		    	=>  str_replace('1','checked',$is_dg[3]),
					
					'txt_nk_xem'  		        =>  str_replace('1','checked',$is_nk[0]),
					'txt_nk_sua'  		        =>  str_replace('1','checked',$is_nk[1]),
					'txt_nk_xoa'  		        =>  str_replace('1','checked',$is_nk[2]),
					'txt_nk_them'  		    	=>  str_replace('1','checked',$is_nk[3]),
				));
				$template->assign_vars(array(
					'txt_msg_error'             => (isset($emsg))?$emsg:"",
					'txt_show_error'            => (!isset($emsg) or $emsg=='')?'none':'block',
					'txt_mess_result'           => (isset($bmsg) and $bmsg==true)?'success':'danger',
					'txt_show_quyen'           => 'block',
				));
			   }
		}

    }
$template -> pparse('cat_admin');
?>