<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ./login.php');
	exit('Login failed');
}

$template -> set_filenames(array(
	'Footer'	=> $dir_template . 'Footer.html')
);

$template->assign_vars(array(
  'txt_law_admin'         => ($_SESSION['is_admin'] == true)?'':'un',
  'txt_law_add'           => ($_SESSION['is_admin'] == true)?'':'un',
  'txt_law_mod'           => ($_SESSION['is_admin'] == true)?'':'un',
  'txt_law_del'           => ($_SESSION['is_admin'] == true)?'':'un',
  'txt_law_pre'           => ($_SESSION['is_admin'] == true)?'':'un',
  'txt_type_key'          => $_SESSION['lang']
));
$sql_setting1   =   "Select * from demo1_tbllang where status=1 order by priority_order asc";
$sql_setting1   =   mysql_query($sql_setting1);
$count=0;
while($sql_setting1_rows = mysql_fetch_array($sql_setting1))
{
		$count++;
		$template->assign_block_vars('LANGLIST',array(
				   'id'                             =>    $sql_setting1_rows['id'],
				   'gach'                             =>    ($count>1)?"-":"",
				   'name'                           =>    $sql_setting1_rows['name'],
				   'style'                       =>    ($sql_setting1_rows['id']==$langset)?"text-decoration:underline;":"",
	   ));
}
$template -> pparse('Footer');
?>