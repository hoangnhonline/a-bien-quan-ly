<?
include('includes/config.inc.php');
include($dir_inc.'template.php');
include($dir_inc.'functions.php');
include($dir_inc.'function.php');
$id = '1';
$_SESSION['help_lang'] = 'en';
if(isset($_GET['id'])) $id = $_GET['id'];
if(isset($_GET['mod'])) $id = Make_field_values1("id", $DB_FSQL."tblhelp", $db, " where source='".$_GET['mod']."'");

if(isset($_GET['l']))  $_SESSION['help_lang'] = $_GET['l'];

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi-vn" lang="vi-vn" >
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="title" content="TIUN THE BEST DESIGN" />
	<meta name="description" content="We have several years of local and overseas technical experience, in the field of website design and advertising. Hotline:+84 909 233 501 Email: support@tiun.us" />
	<meta name="keywords" content="Tiun, 7iun, design, website, software, work-art, thiet ke web, phan mem, hosting, domain, do hoa, nghe thuat" />
	<link rel="stylesheet" href="css/help.css">
</head>
<body>
<div class="content">
	<div class="left_menu">
<?
      $sql_define_cat="Select * from ".$DB_FSQL."tblhelp  ORDER BY priority_order ASC";
      $sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
      while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
      {
		$class =($sql_define_cat_rows["id"]==$id)?"active":"un-active";
		echo '<a class="'.$class.'" href="help.php?l='.$_SESSION['help_lang'].'&id='.$sql_define_cat_rows["id"].'">'.$sql_define_cat_rows["title_".$_SESSION['help_lang']].'</a>';
	  }

?>
		
		
	</div>
	<div class="right_content">
<?
      $sql_define_cat="Select * from ".$DB_FSQL."tblhelp  where id='".$id."'";
      $sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
      while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
      {
	  echo '<h1>'.$sql_define_cat_rows["title_".$_SESSION['help_lang']].'</h1>';
	  echo '<div style="margin-top:20px;">'.displayData_DB($sql_define_cat_rows["content_".$_SESSION['help_lang']]).'</div>';
	  }

?>

	</div>
</div>
</body>
</html>


