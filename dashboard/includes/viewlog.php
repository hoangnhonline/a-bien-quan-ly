<?php
// Kiem tra xem da dang nhap chua
if (!isset($_SESSION['login']) ||(isset($_SESSION['login']) && ($_SESSION['login'] != 'luyenpv')))
{
	header('location: ../');
	exit('Login failed');
}
$template -> set_filenames(array(
	'viewlog'	=> $dir_template . 'viewlog.html')
);
if ($_SESSION['is_admin_xem'] <> '1')
{
echo "<script> alert('Bạn không có quyền truy cập trang này!'); location.href='index.php';</script>";
exit();
}
        $act_sbj =  'viewlog';
        $table_prj =  $DB_FSQL . "tbllog";
		
        $sql_define_total = "SELECT COUNT(*) FROM `".$table_prj."`";
        $sql_define_total = $db->sql_query($sql_define_total) or die(mysql_error());
        $nRows = $db->sql_fetchfield(0);

        $p = !empty($HTTP_GET_VARS['p']) ? $HTTP_GET_VARS['p'] : 0;
        // Set lai $p neu $p >= $nRows
        $p = ( ($p >= $nRows) || !is_numeric($p) || ($p < 0)) ? 0 : $p;
        // So trang dang hien thi
        $link_current_page = ($p > 0) ? '&p=' . $p : '';
        $link_current_page =  $link_current_page;
        $nNewsSize = 100;
		
        $sql_define_cat="Select * from `".$table_prj."` ORDER BY id desc  LIMIT " . $p . "," . $nNewsSize;
        $sql_define_cat = $db->sql_query($sql_define_cat) or die(mysql_error());
        $couter=0;
        //echo strlen('Tôi muốn nhờ Công ty giúp đỡ ');
        while($sql_define_cat_rows = $db->sql_fetchrow($sql_define_cat))
        {
        	$couter++;
            if (strpos($sql_define_cat_rows['action'],"bot") <= 0) {
        	$template->assign_block_vars('MENULIST',array(
        		'id'  		        =>  $sql_define_cat_rows['id'],
        		'order'		        =>  $couter,
                'stt'               =>  $couter-1,                
                'background'        =>  ($couter%2!=0)?'step1':'step2', //Hien thi mau cac duong khac  nhau
                'ip'              =>  $sql_define_cat_rows['ip'],
                'date'           =>  $sql_define_cat_rows['date'],
                'action'             =>  $sql_define_cat_rows['action'],
                'url'            =>  $sql_define_cat_rows['url'],
                'from_url'             =>  $sql_define_cat_rows['from_url'],
                'from_urls'             =>  substr ( $sql_define_cat_rows['from_url'] , 0, 50),
        	));
			}
        }

            // Hien thi phan trang

        $url = './?act='.$act_sbj.$link_order.$links_dir;
        $page = generate_pagination($url.$link_search, $nRows, $nNewsSize, $p);
        $template -> assign_vars(array(
        	'link_page'	                => $page,   
            'txt_sophantu'              => ($couter>0)?$couter:0,
            'txt_other_links_title'     => $link_current_page,
            'txt_oder_fun'              => $link_order.$links_dir.$link_current_page,
        ));
		$template -> assign_vars(array(
			'link_page'	=> $page,
			'checkDel_anyfile'       =>  ($_SESSION['is_admin_xoa'] == '1')?"Question_del()":"Error_law('del')",
		));

$template -> pparse('viewlog');
?>