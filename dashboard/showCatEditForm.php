<?php
include('./includes/config.inc.php');
include('./includes/template.php');
include('./includes/functions.php');
include('../mailer/func_mail.php');
$template = new Template();
//Tro file
$template -> set_filenames(array(
	'page'	=> $dir_template . 'showCatEditForm.html',
));
$cat_id=$_GET["cid"];
$parent_id = Make_field_values1("parent_id", $table_catcontent, $db," where id='".$cat_id."'");
$template -> assign_vars(array(
	'txt_cat_id'    => $cat_id,    
	'txt_cat_name'    => Make_field_values1("title", $table_catcontent, $db," where id='".$cat_id."'"),    
	'txt_cat_des'    => Make_field_values1("sub", $table_catcontent, $db," where id='".$cat_id."'"),    
));
//danh sach
$sql_query = "SELECT * FROM `" . $table_catcontent . "` where parent_id='0' order by title ASC";
$sql_query = mysql_query($sql_query);
$count=0;
while($sql_query_rows = mysql_fetch_array($sql_query))
{
	$count++;
	$template->assign_block_vars('MENULIST',array(
		'id'     		=>  $sql_query_rows['id'],
		'title1'			=>  $sql_query_rows['title'],
		'selected'			=>  ($parent_id==$sql_query_rows['id'])?"selected":"",
	));
	$sql_query1 = "SELECT * FROM `" . $table_catcontent . "` where parent_id='".$sql_query_rows['id']."' order by title ASC";
	$sql_query1 = mysql_query($sql_query1);
	while($sql_query_rows1 = mysql_fetch_array($sql_query1))
	{
		$count++;
		$template->assign_block_vars('MENULIST',array(
			'id'     		=>  $sql_query_rows1['id'],
			'title1'			=> "---- ".$sql_query_rows1['title'],
			'selected'			=>  ($parent_id==$sql_query_rows1['id'])?"selected":"",
		));
		$sql_query2 = "SELECT * FROM `" . $table_catcontent . "` where parent_id='".$sql_query_rows1['id']."' order by title ASC";
		$sql_query2 = mysql_query($sql_query2);
		while($sql_query_rows2 = mysql_fetch_array($sql_query2))
		{
			$count++;
			$template->assign_block_vars('MENULIST',array(
				'id'     		=>  $sql_query_rows2['id'],
				'title1'			=>  "-------- ".$sql_query_rows2['title'],
				'selected'			=>  ($parent_id==$sql_query_rows2['id'])?"selected":"",
			));
			
		}			
	}		
}
$template -> pparse('page');
?>