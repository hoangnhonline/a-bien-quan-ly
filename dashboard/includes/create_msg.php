<?php

// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ../');
	exit('Login failed');
}
$template -> set_filenames(array(
	'create_msg'	=> $dir_template . 'create_msg.html')
);
$act_sbj =  'create_msg';

$cmdf = '';
if(isset($HTTP_POST_VARS['cmd']))
   $cmdf = $HTTP_POST_VARS['cmd'];
$id = '0';
$url = "./?".$_SERVER['QUERY_STRING'];

$sql_define_cat="Select * from `" . $table_a . "` ORDER BY `group` ASC, `admin_user` ASC";
$sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
$couter=0;
while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
{
	$couter++;
	
	$template->assign_block_vars('MENULIST',array(
		'id'                  =>  $sql_define_cat_rows['admin_id'],
		'order'                =>  $couter,
		'stt'               =>  $couter-1,                
		'name'              =>  $sql_define_cat_rows['admin_user'],
		'group'             =>  ($sql_define_cat_rows['group']=="1")?"Admin tối cao":"Nhân viên",                        
	));

}
$template -> assign_vars(array(  
	'txt_sophantu'              => ($couter>0)?$couter:0,
));                    

//Send email
if($cmdf=='add')
{
	$strSubject             = $HTTP_POST_VARS['txtSubject'];
	$strContent             = $HTTP_POST_VARS['txtContent'];
	$sql_information_insert = "INSERT INTO `".$table_msg."` (`title`, `content`, `time`)
	VALUES('". insertData($strSubject) . "', '" . insertData($strContent). "', NOW())";
	$db->sql_query($sql_information_insert) or die(mysql_error());
	$last_id = Make_field_values1("id", $table_msg, $db," order by id desc limit 1 ");
	$listU_ID = $HTTP_POST_VARS['cid'];
	$count=0;
	if ( count($listU_ID) > 0 )
	{
		 foreach ($listU_ID as $u_id )
		{
			$count+=1;
			$sql_information_insert = "INSERT INTO `".$table_msg_to_user."` (`msg_id`, `user_id`, `viewed`) VALUES('". insertData($last_id) . "', '" . insertData($u_id). "', '0')";
			$db->sql_query($sql_information_insert) or die(mysql_error());
		}                
	}
	$mess_result_check_item=true;
	$emsg="Đã gửi tin nhắn tới ".$count." tài khoản";
}

    $template -> assign_vars(array(
        'txt_msg_error'          => (isset($emsg))?$emsg:"",
        'txt_show_error'         => (!isset($emsg) or $emsg=='')?'none':'block',
        'txt_mess_result'        => (isset($mess_result_check_item) and $mess_result_check_item==true)?'success':'danger',       
    ));

$template -> pparse('create_msg');
?>