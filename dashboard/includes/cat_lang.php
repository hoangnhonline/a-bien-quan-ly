<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ../');
	exit('Login failed');
}
$template -> set_filenames(array(
	'cat_lang'	=> $dir_template . 'cat_lang.html')
);
if ($_SESSION['is_admin_xem'] <> '1')
{
echo "<script> alert('You can not access this page!'); location.href='./';</script>";
exit();
}

$template->assign_vars(array(
	'txt_show_error'               => 'none', //Hien thi loi
	'txt_action'           		   => $_GET['act'],
	'txt_button_law_add'           => ($_SESSION['is_admin_them'] == true)?'block':'none',
	'txt_button_law_trash'         => ($_SESSION['is_admin_sua'] == true)?'block':'none',
	'txt_button_law_mod'           => ($_SESSION['is_admin_sua'] == true)?'block':'none',
	'txt_button_law_pre'           => ($_SESSION['is_admin_xem'] == true)?'block':'none',
	'txt_button_law_del'           => ($_SESSION['is_admin_xoa'] == true)?'block':'none',
	'txt_button_law_restore'       => ($_SESSION['is_admin_sua'] == true)?'block':'none',
	'txt_hide_list'       			=> (isset($_GET['edit']) and (int)$_GET['edit']>=0)?'none':'block',
	'txt_hide_edit'       			=> (isset($_GET['edit']) and (int)$_GET['edit']>=0)?'block':'none',

));
if (isset($_GET['del']) and (int)$_GET['del']>0){
	$image_flag=Make_field_values1('flag', $table_lang, $db, " where id='".$_GET['del']."'");
	if ( $image_flag<>"" and file_exists($dir_upload . $image_flag))
			delete_files($image_flag, $dir_upload);
	$sql_item = "delete from `".$table_lang."` where id = ".(int)$_GET['del'];
	$sql_item = $db->sql_query($sql_item) or die(mysql_error());  
	//xoa tat ca value cua define
	$sql_item_delete          = "delete from " . $table_definevalue . " where lang_id='".(int)$_GET['del']."'";
	$sql_item_delete  =   $db->sql_query($sql_item_delete) or die(mysql_error());
}
if (isset($_POST['cmd']) and $_POST['cmd']=='edit'){
	$lid=$_GET['edit'];
	$name=$_POST['name'];
	$location=$_POST['location'];
	$pre=$_POST['pre'];
	$priority_order=$_POST['order'];
	$flag=$_POST['flag'];
	$symbol=$_POST['symbol'];
	$status=$_POST['status'];
	$err=0;
	if (Check_sub_info($table_lang, $db, " where name='".$name."' and id<>'".$lid."'")>0){
		$err++;
		$template->assign_block_vars('ERROR',array(
			'info'  		        =>  "This language (name) already exists, please choose another language (name)!",
		));
	}
	if (Check_sub_info($table_lang, $db, " where pre='".$pre."' and id<>'".$lid."'")>0){
		$err++;
		$template->assign_block_vars('ERROR',array(
			'info'  		        =>  "This prefix already exists, please choose another prefix!",
		));
	}
	if (Check_sub_info($table_lang, $db, " where symbol='".$symbol."' and id<>'".$lid."'")>0){
		$err++;
		$template->assign_block_vars('ERROR',array(
			'info'  		        =>  "This symbol already exists, please choose another symbol!",
		));
	}
	if ($err==0){
		$sql_information_update = "UPDATE `" . $table_lang . "` 
									SET `name` = '" . insertData($name) . "',
										`location` = '" . insertData($location) . "',
										`pre` = '".insertData($pre)."',
										`priority_order` = '".insertData($priority_order)."',
										`flag` = '".insertData($flag)."',
										`symbol` = '".$symbol."',
										`status` = '".$status."' 
									WHERE `id` = '" . $lid . "'";
												
		$db->sql_query($sql_information_update) or die(mysql_error());
		exit ("<script>window.location.href='./?act=".$_GET['act']."';</script>");
	}
	

}
if (isset($_POST['cmd']) and $_POST['cmd']=='add'){
	$lid=$_GET['edit'];
	$name=$_POST['name'];
	$location=$_POST['location'];
	$pre=$_POST['pre'];
	$priority_order=$_POST['order'];
	$flag=$_POST['flag'];
	$symbol=$_POST['symbol'];
	$cbCopy=$_POST['cbCopy'];
	$status=$_POST['status'];
	$err=0;
	if (Check_sub_info($table_lang, $db, " where name='".$name."'")>0){
		$err++;
		$template->assign_block_vars('ERROR',array(
			'info'  		        =>  "This language (name) already exists, please choose another language (name)!",
		));
	}
	if (Check_sub_info($table_lang, $db, " where pre='".$pre."'")>0){
		$err++;
		$template->assign_block_vars('ERROR',array(
			'info'  		        =>  "This prefix already exists, please choose another prefix!",
		));
	}
	if (Check_sub_info($table_lang, $db, " where symbol='".$symbol."'")>0){
		$err++;
		$template->assign_block_vars('ERROR',array(
			'info'  		        =>  "This symbol already exists, please choose another symbol!",
		));
	}
	if ($err>0){
		$template->assign_vars(array(
			'txt_lang_name'  		        =>  $name,
			'txt_lang_location'  		    =>  $location,
			'txt_lang_pre'  		        =>  $pre,
			'txt_lang_order'  		        =>  $priority_order,
			'txt_lang_flag'  		        =>  $flag,
			'txt_lang_symbol'  		        =>  $symbol,
			'txt_lang_status'  		        =>  ($status=='0')?"checked":"",
		));
	} else {
		$sql_information_insert = "INSERT INTO `" . $table_lang . "` (`name`, `location`, `pre`, `priority_order`, `flag`, `symbol`, `status`)
		VALUES('" . insertData($name) . "', '" . insertData($location)
		."', '". insertData($pre). "', '". insertData($priority_order). "', '". insertData($flag). "', '". $symbol
		. "', '". (int)$status . "')";
		$db->sql_query($sql_information_insert) or die(mysql_error());
		$last_id = Make_field_values1("id", $table_lang, $db, " ORDER by id DESC limit 1");
		//copy du lieu
		$sql_define = "Select * from " . $table_definevalue . " where lang_id='".$cbCopy."' ORDER BY ID DESC";
		$sql_define = $db->sql_query($sql_define) or die(mysql_error());
		while($sql_define_rows = $db->sql_fetchrow($sql_define))
		{
			$sql_item_insert         = "insert into " . $table_definevalue . " (`define_id`,`value`,`lang_id`) values (".$sql_define_rows['define_id'].",'".$sql_define_rows['value']."',".$last_id.")";
			$sql_item_insert  =   $db->sql_query($sql_item_insert) or die(mysql_error());
		}
		exit ("<script>window.location.href='./?act=".$_GET['act']."';</script>");
	}
	

}

if (isset($_GET['edit']) and (int)$_GET['edit']>0){
	$sql_define_cat="Select * from `" . $table_lang . "` where id='".$_GET['edit']."'";
	$sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
	while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
	{
		$template->assign_vars(array(
			'txt_doaction'  		        	=>  "Edit",
			'txt_cmdaction'  		        	=>  "edit",
			'txt_lang_id'  		        	=>  $sql_define_cat_rows['id'],
			'txt_lang_name'  		        =>  $sql_define_cat_rows['name'],
			'txt_lang_location'  		    =>  $sql_define_cat_rows['location'],
			'txt_lang_pre'  		        =>  $sql_define_cat_rows['pre'],
			'txt_lang_order'  		        =>  $sql_define_cat_rows['priority_order'],
			'txt_lang_flag'  		        =>  $sql_define_cat_rows['flag'],
			'txt_lang_symbol'  		        =>  $sql_define_cat_rows['symbol'],
			'txt_lang_status'  		        =>  ($sql_define_cat_rows['status']=='0')?"checked":"",
		));
	}
}
if (isset($_GET['edit']) and (int)$_GET['edit']==0){
		$template->assign_vars(array(
			'txt_doaction'  		        	=>  "Add New",
			'txt_cmdaction'  		        	=>  "add",
			'txt_show_copy'  		        	=>  "block",
		));
}

$sql_define_cat="Select * from `" . $table_lang . "` ORDER BY id asc";
$sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
$couter=0;
while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
{
	$couter++;
	$template->assign_block_vars('MENULIST',array(
		'id'  		        =>  $sql_define_cat_rows['id'],
		'name'  		        =>  $sql_define_cat_rows['name'],
		'location'  		        =>  $sql_define_cat_rows['location'],
		'pre'  		        =>  $sql_define_cat_rows['pre'],
		'priority_order'  		        =>  $sql_define_cat_rows['priority_order'],
		'flag'  		        =>  $dir_upload.$sql_define_cat_rows['flag'],
		'symbol'  		        =>  $sql_define_cat_rows['symbol'],
		'status'  		        =>  ($sql_define_cat_rows['status']=='1')?"checked":"",
	));
}
$template -> pparse('cat_lang');
?>