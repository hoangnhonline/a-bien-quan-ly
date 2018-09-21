<?php
	$table_set = $DB_FSQL . "tblsetting";
	$table_ad = $DB_FSQL . "tbladmin";
	$table_adg = $DB_FSQL . "tblcat_admin";
	$table_a = $DB_FSQL . "tbladmin";
	$table_od = $DB_FSQL . "tblorder";
	$table_lang = $DB_FSQL . "tbllang";
	$table_catin = $DB_FSQL . "tblcat_quiz";
	$table_menu = $DB_FSQL . "tblmenu";
	$table_menu_info = $DB_FSQL . "tblmenu_info";
	$table_content = $DB_FSQL . "tblcontent";
	$table_content_info =  "demo2_tblcontent_info";
	$table_content_images = $DB_FSQL . "tblcontent_images";
	$table_catcontent = $DB_FSQL . "tblcat_content";
	$table_catcontent_info = $DB_FSQL . "tblcat_content_info";
	$table_content_to_cat = $DB_FSQL . "tblcontent_to_cat";
	$table_content_to_user = $DB_FSQL . "tblcontent_to_user";
	$table_size = $DB_FSQL . "tblcontent_size";
	$table_color = $DB_FSQL . "tblcontent_color";
	$table_slide = $DB_FSQL . "tblcat_slide";
	$table_slide_info = $DB_FSQL . "tblcat_slide_info";
	$table_catpoll =  $DB_FSQL . "tblcat_poll";
	$table_poll =  $DB_FSQL . "tblpoll";
	$table_cattr =  $DB_FSQL . "tblcat_attr";
	$table_attr =  $DB_FSQL . "tblattr";
	$table_proattr =  $DB_FSQL . "tblcontent_attr";
	$table_catmcard =  $DB_FSQL . "tblcat_mcard";
	$table_mcard =  $DB_FSQL . "tblmcard";
	$table_define =  $DB_FSQL . "tbldefine";
	$table_definevalue =  $DB_FSQL . "tbldefine_value";
	$table_contact =  $DB_FSQL . "tblcontact";
	$table_catquiz = $DB_FSQL . "tblcat_quiz";
	$table_quiz = $DB_FSQL . "tblquiz";
	$table_contentquiz = $DB_FSQL . "tblcontent_quiz";
	$table_job = $DB_FSQL . "tbljobtitle";
	
	$table_addfund = $DB_FSQL . "tbladdfund";
	$table_msg = $DB_FSQL . "tblmessage";
	$table_msg_to_user = $DB_FSQL . "tblmessege_to_user";
	$table_album =  $DB_FSQL . "tblalbum";
	$table_catalbum =  $DB_FSQL . "tblcat_album";
	$table_emailsent =  $DB_FSQL . "tblemail_sent";
	$table_rv =  $DB_FSQL . "tblreview";
	$table_ostatus =  $DB_FSQL . "tblorder_status";
	$table_coupon =  $DB_FSQL . "tblcoupon";
	$table_coupon_pro =  $DB_FSQL . "tblcoupon_pro";
	$table_couppon_progroup =  $DB_FSQL . "tblcouppon_progroup";
	$table_couppon_progroup_pro =  $DB_FSQL . "tblcouppon_progroup_pro";
	$table_couppon_zone =  $DB_FSQL . "tblcoupon_zone";
	$table_couppon_user =  $DB_FSQL . "tblcoupon_user";
	$table_couppon_to_group =  $DB_FSQL . "tblcouppon_to_group";
	$table_couppon_memgroup =  $DB_FSQL . "tblcouppon_memgroup";
	$table_couppon_memgroup_user =  $DB_FSQL . "tblcouppon_memgroup_user";
	$table_couppon_to_memgroup =  $DB_FSQL . "tblcouppon_to_memgroup";
	$table_tinh = $DB_FSQL . "tblzone_tinh";
	$table_huyen = $DB_FSQL . "tblzone_huyen";
	$table_xa = $DB_FSQL . "tblzone_xa";
	$table_ship = $DB_FSQL . "tblshipping";
	$table_ship_zone = $DB_FSQL . "tblshipping_zone";
	$table_addcredit_log = $DB_FSQL . "tbladdcredit_log";
	$table_content_files = $DB_FSQL . "tblcontent_files";
	$table_content_files_download = $DB_FSQL . "tblcontent_files_download";
	$table_addcredit_log = $DB_FSQL . "tbladdcredit_log";
	$tbladdcredit_add = $DB_FSQL . "tbladdcredit_add";
	$table_viewpost_log = $DB_FSQL . "tblviewpost_log";
	$table_tuyendung = $DB_FSQL . "tbltuyendung";
	$table_nganhnghe = $DB_FSQL . "tblnganhnghe";
	$table_ungvien = $DB_FSQL . "tblungvien";
	$table_loaihinh = $DB_FSQL . "tblloaihinh";
	$table_kinhnghiem = $DB_FSQL . "tblkinhnghiem";
	$table_action = $DB_FSQL . "tblaction";
	$table_manu = $DB_FSQL . "tblmanufac";
	$table_withdraw = $DB_FSQL . "tblwithdraw";
	$table_mailcontent = $DB_FSQL . "tblmailcontent";
	$table_mailsend = $DB_FSQL . "tblmailsend";	
	$table_log = $DB_FSQL . "tbllog";	
	$table_content_status = $DB_FSQL . "tblcontent_status";	
	$table_u = $DB_FSQL . "tbluser";
	$table_content_note = $DB_FSQL . "tblcontent_note";
	
   function checkExtentFile($file_name, $extent_file) {
    $extent_file = strtolower ( $extent_file );
        if (! preg_match ( "/\\.(" . $extent_file . ")$/", $file_name )) {
            return false;
        } else {
            return true;
        }
    }
    
   //Doi ten file
    function renameFile($file_name) {
        $file_name = strtolower ( $file_name );
        $extent = preg_split ( "/\\./", $file_name );
        $randFilename = uniqid ( "anhquancenter_" );
        $newfile = $randFilename . "." . $extent [count ( $extent ) - 1];
        return $newfile;
    } 

    //Resize hinh
    //imagejpeg ( resize ( $dir_upload . $small_image, 280,240,$dir_upload."add_img.png","b"), $dir_upload. $small_image ); 
    function resize($image,$x,$y=NULL,$wm=NULL,$wml='br'){
        if(!file_exists($image)){
            return false;
        }
        $images = array();
        if($wm !== '' && $wm !== NULL && file_exists($wm)){
            $images['wmimg'] = $wm;
        }
        $images['img'] = $image;
        foreach($images as $key=>$value){
            $type = substr($value,strrpos($value,'.'));
            if(stristr($type,'i')){
                $$key = imagecreatefromgif($value);
            }
            if(stristr($type,'j')){
                $$key = imagecreatefromjpeg($value);
            }
            if(stristr($type,'n')){
                $$key = imagecreatefrompng($value);
            }
        }
        $size = array();
        if($y === '' || $y === NULL){
            $size['x'] = imageSX($img);
            $size['y'] = imageSY($img);
            if($size['x'] >= $size['y']){
                $size['dest_x'] = $x;
                $size['dest_y'] = ceil($size['y'] * ($x / $size['x']));
            }else{
                $size['dest_y'] = $x;
                $size['dest_x'] = ceil($size['x'] * ($x / $size['y']));
            }
            $dest = imageCreatetruecolor($size['dest_x'],$size['dest_y']);
        }else{
            $dest = imagecreatetrueColor($x,$y);
            $size['x'] = imageSX($img);
            $size['y'] = imageSY($img);
            $size['dest_x'] = $x;
            $size['dest_y'] = $y;
        }
        imagecopyresized($dest, $img, 0, 0, 0, 0, $size['dest_x'], $size['dest_y'], $size['x'], $size['y']);
        if(isset($wmimg)){
            $size['wmx'] = imageSX($wmimg);
            $size['wmy'] = imageSY($wmimg);
            $size['wmh'] = strtolower($wml{0}) === 'b' ? ($size['dest_y'] - $size['wmy'] - 0) : 0;
            $size['wmw'] = strtolower($wml{1}) === 'r' ? ($size['dest_x'] - $size['wmx'] - 0) : 0;
            imagecopy($dest, $wmimg, $size['wmw'], $size['wmh'], 0, 0, $size['wmx'], $size['wmy']);
            imagedestroy($wmimg);
        }
        imagedestroy($img);
        return $dest;
    }

function Update_table($dk, $table, &$db)
{//Written Pham Vu Hoang Luyen
    $sql_query = "update `".$table."` set ". $dk;
    $sql_query = $db->sql_query($sql_query) or die(mysql_error());
}

function Add_mailer($strEmail,&$db)
{
    global $DB_FSQL;
	$sql_check = "select * from `" . $DB_FSQL . "tblsend_contact` where `email`='". $strEmail ."'";
    $sql_check = $db->sql_query($sql_check) or die(mysql_error());
    $exits     = $db->sql_fetchfield(0);  
    if(!$exits)
    {
        //Add new email
        $sql_query_add = "Insert into " . $DB_FSQL . "tblsend_contact(email) values('".$strEmail."')";
        $sql_query_add = $db->sql_query($sql_query_add) or die(mysql_error());
    }     
}

function check_select($number, $number_array)
{
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for checking exist of $number in array $number_array
//Return Value: Return true or false follows exists or not exists.

	foreach ($number_array as $authority_id )
	{
		if($authority_id == $number)return true;
	}
	return false;
}

function merstrrever($str, $str1)
{
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for merrging two string to one string
//Return Value: Return compine string

	return $str1.$str;
}

function get_array_link($id, $cat_table =  "tblcat_quiz", $act = "info")
{
$cat_table =  $DB_FSQL . $cat_table;
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for getting url link from child node to root node on tree
//Return Value: Return string of url
	
	if(!isset($id)) $id = 0;
	$select = "SELECT * FROM ".$cat_table." WHERE id = ".$id;
	$select = mysql_query($select) or die(mysql_error());
	//echo $id."-";
	$menu = '';
	while($sql = mysql_fetch_array($select))
	{
		$select1 = "SELECT * FROM ".$cat_table." WHERE id = ".$sql['parent_id'];
		$select1 = mysql_query($select1) or die(mysql_error());
		while($sql1 = mysql_fetch_array($select1))
		{
			$menu = "<a href='./?act=".$act."&id=".$sql1['id']."' class = 'CatMenu'><b>".displayData_DB($sql1['name_vn'])."</b></a>/";
			$menu = merstrrever($menu,get_array_link($sql1['id'], $cat_table, $act));
		}
	}
	return $menu;
}

function get_array_link_menu($id, $cat_table =  "demo1_tblMenu", $act = "menu")
{
$cat_table =  $cat_table;
  //Function echo tour links folder menu
	if(!isset($id)) $id = 0;
	$select = "SELECT * FROM ".$cat_table." WHERE id = ".$id;
	$select = mysql_query($select) or die(mysql_error());
	$menu = '';
	while($sql = mysql_fetch_array($select))
	{
		$select1 = "SELECT * FROM ".$cat_table." WHERE id = ".$sql['parent_id'];
		$select1 = mysql_query($select1) or die(mysql_error());
		while($sql1 = mysql_fetch_array($select1))
		{
			if ($_GET['act']=="cat_content" or $_GET['act']=="content") {
				$menu = "<p></p><a href='./?act=".$act."&id=".$sql1['id']."' title='".displayData_DB($sql1['title'])."' class='path_name_links'>".displayData_DB($sql1['title'])."</a>";
			}
			if ($_GET['act']=="menu") {
				$menu = "<p></p><a href='./?act=".$act."&id=".$sql1['id']."' title='".displayData_DB(makeMenuInfo($sql1['id'],"name"))."' class='path_name_links'>".displayData_DB(makeMenuInfo($sql1['id'],"name"))."</a>";
			}
			
			$menu = merstrrever($menu,get_array_link_menu($sql1['id'], $cat_table, $act));
		}
	}
	return $menu;
}

function get_array_link_info($id, $cat_table =  "tblcat_quiz", $act = "info")
{
  global $table_catcontent_info,$db,$langset;
  //Function echo tour links folder menu
    if(!isset($id)) $id = 0;
    $select = "SELECT * FROM ".$cat_table." WHERE id = ".$id;
    $select = mysql_query($select) or die(mysql_error());

    $menu = '';
    while($sql = mysql_fetch_array($select))
    {
        $select1 = "SELECT * FROM ".$cat_table." WHERE id = ".$sql['parent_id'];
        $select1 = mysql_query($select1) or die(mysql_error());
        while($sql1 = mysql_fetch_array($select1))
        {
            $cat_name=$sql1['title'];
			$menu = "<p></p><a href='./?act=".$act."&cat_id=".$sql1['id']."' title='".displayData_DB($cat_name)."' class='path_name_links'>".displayData_DB($cat_name)."</a>";
            $menu = merstrrever($menu,get_array_link_info($sql1['id'], $cat_table, $act));
        }
    }
    return $menu;
}

function get_array_link_tour($id, $cat_table, $act)
{
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for getting url link from child node to root node on tree
//Return Value: Return string of url
	if(!isset($id)) $id = 0;
	$select = "SELECT * FROM ".$cat_table." WHERE id = ".$id;
	$select = mysql_query($select) or die(mysql_error());
	//echo $id."-";
	$menu = '';
	while($sql = mysql_fetch_array($select))
	{
		$select1 = "SELECT * FROM ".$cat_table." WHERE id = ".$sql['parent_id'];
		$select1 = mysql_query($select1) or die(mysql_error());
		while($sql1 = mysql_fetch_array($select1))
		{
			$menu = "<a href='./?act=".$act."&id=".$sql1['id']."' style='text-decoration: none'><b>".displayData_DB($sql1['name'])."</b></a>/";
			$menu = merstrrever($menu,get_array_link_tour($sql1['id'], $cat_table, $act));
		}
	}
	return $menu;	
}

///Get parent_id 

function get_parent_list($id, $cat_table =  "tblcat_quiz")
{
$cat_table =  $DB_FSQL . $cat_table;
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for getting url link from child node to root node on tree
//Return Value: Return string of url
	if(!isset($id)) $id = 0;
	$select = "SELECT * FROM ".$cat_table." WHERE id = ".$id;
	$select = mysql_query($select) or die(mysql_error());
	//echo $id."-";
	$menu = '';
	while($sql = mysql_fetch_array($select))
	{
		$select1 = "SELECT * FROM ".$cat_table." WHERE id = ".$sql['parent_id'];
		$select1 = mysql_query($select1) or die(mysql_error());
		while($sql1 = mysql_fetch_array($select1))
		{
			$menu .= $sql1['id'].", ";
			$menu .= get_parent_list($sql1['id'], $cat_table);
		}
	}
	return $menu;	
}


/////////////////
function get_root_id($id,$cat_table =  "tblcat_quiz")
{
$cat_table =  $DB_FSQL . $cat_table;
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for getting root id from id of node in tree
//Return Value: Return id of root

	$select = "SELECT * FROM ".$cat_table." WHERE id = ".$id;
	$select = mysql_query($select) or die(mysql_error());
	$menu = 0;
	while($sql = mysql_fetch_array($select))
	{
		$menu = $id;
		if($sql['parent_id'] != '' && $sql['parent_id'] != 0)
			$menu = (int)$sql['parent_id'];
		
		$temp = (int)get_root_id($sql['parent_id'], $cat_table);
		if($temp != '' && $temp != 0)
			$menu = (int)get_root_id($sql['parent_id'], $cat_table);
	}
	return $menu;	
}



function get_array_sub_id($id, $cat_table =  "tblcat_quiz")
{
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for getting array id of sub node from id of node.
//Return Value: Return string of id of sub node

	$select = "SELECT * FROM ".$cat_table." WHERE parent_id = ".$id;
	$select = mysql_query($select) or die(mysql_error());
	$menu = '';
	while($sql = mysql_fetch_array($select))
	{
		$menu .= $sql['id'].", ";
		$menu .= get_array_sub_id($sql['id'], $cat_table);
	}
	return $menu;	
}


 function Tongsobantin($idFolder,$Des_Table='tblquiz')
 {
    //*********************************************************
    //          LAY TONG SO BAN TIN TRONG THU MUC             *
    //*********************************************************
    //Return Value: Total file in forder
    $sql_query    = 'Select * from '. $Des_Table . ' where `cat_id`='.$idFolder;
    $sql_query    = mysql_query($sql_query) or die(mysql_error());  
    $totalFile = 0;
    while($sql_query_rows = mysql_fetch_array($sql_query))
    {
          $totalFile ++;
    }  
    return $totalFile;   
 }


function display_tree($id, $cat_table = "tblcat_quiz", $sub_table = "tblquiz", &$template, &$parent_id, $cat_id_label = "cat_id", $cond = "", $block = "GROUP", $type="")
{
global $langset,$table_catcontent_info,$db;
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for displaying data in tree form.
//Return Value: Return No value.
    //Kiem tra noi dung cua nhom tin
    //if($type=="") 
	        $select = "SELECT * FROM ".$cat_table." WHERE ".$cond." parent_id = ".$id.' '.$type.' ORDER BY priority_order ASC';
	        $select = mysql_query($select) or die(mysql_error());
	        $menu = '';
	        $prex = "";
	        while($sql = mysql_fetch_array($select))
	        {      
		        
                //Xac dinh level de phan cap
                while($sql['level'])
		        {
			        if($sql['level'] > 1)
				        $prex .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			        else
				        $prex .= "|__";
			        $sql['level'] --;	
		        }
                //Kiem tra thu muc co thong tin hay khong de xac dinh icon
                //$itemIMG=(Tongsobantin($sql['id'],$sub_table)==0)?'icon-16-item.png':'icon-16-folder.png';
                //$html_icon_list='<img border="0" src="./images/icon-16/'.$itemIMG.'" width="20" height="20">'; 
		        $template->assign_block_vars($block, array(
			        'group_id'  => $sql['id'],
			        'name' 	=> displayData_Textbox($sql['title']),
			        'group' 	=> $prex.displayData_Textbox($sql['title']),
			        '_selected' => ($sql['id'] == $parent_id)?'selected':''
		        ));
		        display_tree($sql['id'], $cat_table, $sub_table, $template, $parent_id, $cat_id_label, $cond, $block, $type);
		        $prex = "";
	        }
	
}
function display_tree_list($id, $cat_table = "tblcat_quiz", $sub_table = "tblquiz", &$template, &$parent_id, $cat_id_label = "cat_id", $cond = "", $block = "GROUP", $type="")
{
global $langset,$table_catcontent_info,$db;
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for displaying data in tree form.
//Return Value: Return No value.
    //Kiem tra noi dung cua nhom tin
    //if($type=="") 
	        $select = "SELECT * FROM ".$cat_table." WHERE ".$cond." parent_id = ".$id.' '.$type.' ORDER BY priority_order ASC';
	        $select = mysql_query($select) or die(mysql_error());
	        $menu = '';
	        $prex = "";
	        while($sql = mysql_fetch_array($select))
	        {      
		        
                //Xac dinh level de phan cap
                while($sql['level'])
		        {
			        if($sql['level'] > 1)
				        $prex .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			        else
				        $prex .= "|__";
			        $sql['level'] --;	
		        }
                //Kiem tra thu muc co thong tin hay khong de xac dinh icon
                //$itemIMG=(Tongsobantin($sql['id'],$sub_table)==0)?'icon-16-item.png':'icon-16-folder.png';
                //$html_icon_list='<img border="0" src="./images/icon-16/'.$itemIMG.'" width="20" height="20">'; 
		        $template->assign_block_vars($block, array(
			        'group_id'  => $sql['id'],
			        'name' 	=> $sql['title'],
			        'group' 	=> $prex.displayData_Textbox($sql['title']),
			        '_selected' => (in_array($sql['id'],$parent_id))?'selected':''
		        ));
		        display_tree_list($sql['id'], $cat_table, $sub_table, $template, $parent_id, $cat_id_label, $cond, $block, $type);
		        $prex = "";
	        }
	
}

function display_tree_menu($id, $type, $cat_table =  "tblmenu", &$template, &$parent_id, $cond = "", $block = "SUB_CAT_SMALL")
{
$cat_table =  $DB_FSQL . $cat_table;
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for displaying data in tree Menu.
//Return Value: Return No value.
    $select = "SELECT * FROM ".$cat_table." WHERE ".$cond." parent_id = ".$id.' AND type='.$type.' ORDER BY priority_order ASC';
    $select = mysql_query($select) or die(mysql_error());
    $menu = '';
    $prex = "";    
    while($sql = mysql_fetch_array($select))
    {      
        while($sql['level'])
        {
            if($sql['level'] > 1)
                $prex .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            else
                $prex .= "|__";
            $sql['level'] --;    
        } 
        $template->assign_block_vars($block, array(
            'id'  => $sql['id'],
            'name'     => $prex.displayData_Textbox($sql['name_'.$_SESSION['lang']]),
            '_selected' => ($sql['id'] == $parent_id)?'selected':''
        ));
        display_tree_menu($sql['id'], $type, $cat_table, $template, $parent_id, $cond, $block);
        $prex = "";
    }
    
}

function display_tree_pro($id, $cat_table =  "tblcat_product", $sub_table = "tblproduct", &$template, &$parent_id, $cat_id_label = "cat_id", $cond = "", $block = "GROUP", $type="")
{
$cat_table =  $cat_table;
$sub_table  =  $ $sub_table ;
	$select = "SELECT * FROM ".$cat_table." WHERE ".$cond." parent_id = ".$id.' '.$type." ORDER BY id DESC";
	$select = mysql_query($select) or die(mysql_error());
	$menu = '';
	$prex = "";
	while($sql = mysql_fetch_array($select))
	{
		while($sql['level'])
		{
			if($sql['level'] > 1)
				$prex .= "&nbsp;&nbsp;&nbsp;";
			else
				$prex .= "|__";
			$sql['level'] --;	
		}
		$template->assign_block_vars($block, array(
			'group_id'  => $sql['id'],
			'group' 	=> $prex.displayData_Textbox($sql['name']),
			'_selected' => ($sql['id'] == $parent_id)?'selected':''	
		));
		display_tree_pro($sql['id'], $cat_table, $sub_table, $template, $parent_id, $cat_id_label, $cond, $block, $type);
		$prex = "";
	}
	
}

function display_menu($id, $cat_table =  "tblmenu", $type, &$template, &$parent_id, $cat_id_label = "cat_id", $cond = "", $block = "GROUP")
{
global $db;
$cat_table =  $cat_table;
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for displaying menu.
//Return Value: Return No value.

	$select = "SELECT * FROM ".$cat_table." WHERE type = ".$type." AND ".$cond." parent_id = ".$id." ORDER BY priority_order asc";
	$select = mysql_query($select) or die(mysql_error());
	$menu = '';
	$prex = "";
	while($sql = $db->sql_fetchrow($select))
	{
		while($sql['level'])
		{
			if($sql['level'] > 1)
				$prex .= "&nbsp;&nbsp;&nbsp;";
			else
				$prex .= "|__";
			$sql['level'] --;
		}
		$template->assign_block_vars($block, array(
			'group_id'  => $sql['id'],
			'group' 	=> $prex.displayData_Textbox(makeMenuInfo($sql['id'],"name")),
			'_selected' => ($sql['id'] == $parent_id)?'selected':''
		));
		display_menu($sql['id'], $cat_table, $type, $template, $parent_id, $cat_id_label, $cond, $block);
		$prex = "";
	}

}



function display_product_type($id, $cat_table = "tblproduct_type", &$template, &$parent_id, $cat_id_label = "cat_id", $cond = "", $block = "GROUP")
{
	$select = "SELECT * FROM ".$cat_table." WHERE ".$cond." parent_id = ".$id." ORDER BY priority_order DESC, id DESC";
	//echo $select;
	$select = mysql_query($select) or die(mysql_error());
	$menu = '';
	$prex = "";
	while($sql = mysql_fetch_array($select))
	{
		while($sql['level'])
		{
			if($sql['level'] > 1)
				$prex .= "&nbsp;&nbsp;&nbsp;";
			else
				$prex .= "|__";
			$sql['level'] --;	
		}
		$template->assign_block_vars($block, array(
			'group_id'  =>	$sql['id'],
			'group' 	=>	$prex.displayData_Textbox($sql['name_vn']),
			'_selected' =>	($sql['id'] == $parent_id) ? 'selected' : '',
		));
		display_product_type($sql['id'], $cat_table, $template, $parent_id, $cat_id_label, $cond, $block);
		$prex = "";
	}
}

function transform_date($date_)
{
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for Converting data from 'DD-MM-YYYY' form to 'YYYY-MM-DD' form. And check true or false of date
//Return Value: Return string or return false if data is false

	$day = substr($date_, 0,2);
	$mon = substr($date_, 3,2);
	$year = substr($date_, 6,4);
	if(!checkdate($mon, $day, $year))
	{
		return false;
	}
	$date_change = $year."-".$mon."-".$day;
	return $date_change;
}

function transform_date_back($date_)
{
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for Converting data from 'YYYY-MM-DD' form to 'DD-MM-YYYY' form. And check true or false of date
//Return Value: Return string or return false if data is false

	$year = substr($date_, 0,4);
	$mon = substr($date_, 5,2);
	$day = substr($date_, 8,2);
	if(!checkdate($mon, $day, $year))
	{
		return false;
	}
	$date_change = $day."/".$mon."/".$year;
	return $date_change;
}

function transform_time_back($date_)
{
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for Converting data from 'YYYY-MM-DD' form to 'DD-MM-YYYY' form. And check true or false of date
//Return Value: Return string or return false if data is false

    $hour = substr($date_, 11,2);
    $minute = substr($date_, 14,2);
    $second = substr($date_, 17,2);
    if($hour=='' or $minute=='' or $second='')
    {
        return false;
    }
    $time_change = $hour.":".$minute.":".$second;
    return $time_change;
}

//YYYY-MM-DD H:M
function transform_date_time_back($date_)
{
    $year = substr($date_, 0,4);
    $mon = substr($date_, 5,2);
    $day = substr($date_, 8,2);
    $hour = substr($date_, 11,2);
    $minutes = substr($date_, 14,2);
    $gi = substr($date_, 17,2);
    $date_change = $day."-".$mon."-".$year." ".$hour.":".$minutes;
    return $date_change;
}

function transform_date_back_only($date_,$format_output="DD/MM/YYYY")
{
//Author: Written By PHAM VU LUYEN. For reusing, please contact me via phone(0972041135) or mail(pv.hoangluyen@gmail.com)
//Used for: Function for Converting data from 'YYYY-MM-DD' form to 'DD/MM/YYYY' form. And check true or false of date
//Return Value: Return string or return false if data is false

	$year = substr($date_, 0,4);
	$mon = substr($date_, 5,2);
	$day = substr($date_, 8,2);
	if(!checkdate($mon, $day, $year))
	{
		return false;
	}
	
    switch ($format_output)
    {
        case 'DD/MM/YYYY':
            $date_change = $day."/".$mon."/".$year;
            break;    
        case 'MM/DD/YYYY':
            $date_change = $mon."/".$day."/".$year;
            break;
        default:
            $date_change = $day."/".$mon."/".$year;
    }
	return $date_change;
}


function SubString_leng($strInput,$GioihanKytu=0,$beginStr="",$afterStr="")
{
    $strNewedit = $strInput;
    if(strlen($strInput) > $GioihanKytu)
    {
        $strNewedit = substr($strInput,0,$GioihanKytu);
        $strNewedit = $beginStr.Check_strSub($strNewedit).$afterStr;
    }
    return $strNewedit;
}

function Check_strSub($str)
{
    $lenStr = strlen($str);
    $strNew_sub = $str;
    
    $strCheck = substr($strNew_sub,-1,1);
    if($strCheck <> ' ')
    {
        $d=0;
        for($i=$lenStr;$i>0;$i--)
        {
            $strNew_sub =  substr($str,0,$i-1);
            $strCheck   = substr($strNew_sub,-1,1);
            if($strCheck==" ")
            {
                break;
            }
        }        
    }

    return $strNew_sub;
}

function convertHTML($strInput) //Convert to html special code
{//Written Pham Vu Hoang Luyen
	//$strInput = htmlspecialchars($strInput, ENT_QUOTES);
	$strInput = str_replace('"', '&quot;', $strInput);
	$strInput = str_replace("'", "&#039;", $strInput);
	return $strInput;
}

function unconvertHTML($strInput)//Convert html special code to standart form
{//Written Pham Vu Hoang Luyen
	//$strInput = html_entity_decode($strInput);
	$strInput = str_replace('&quot;', '"', $strInput);
	$strInput = str_replace("&#039;", "'", $strInput);
	return $strInput;
}


function insertData($strInput)//Use In inserting or updating data into database
{//Written Pham Vu Hoang Luyen
	$strInput = addslashes(unconvertHTML($strInput));
	return $strInput;
}

function displayData_DB($strInput)
{//Written Pham Vu Hoang Luyen
	$strInput = stripslashes($strInput);
	return $strInput;
}

function displayData_Textbox($strInput)
{//Written Pham Vu Hoang Luyen
	$strInput = convertHTML(stripslashes($strInput));
	return $strInput;
}
function convertcharstoupper($str)
{//Written Pham Vu Hoang Luyen
	return mb_convert_case($str, MB_CASE_UPPER, "UTF-8");
}

function check_exits_code($code, &$db, $table= 'tblcat_quiz', $id = 0)
{
$table =  $DB_FSQL . $table;//Written Pham Vu Hoang Luyen
	if($id) $cond = " AND id <> '".$id."'";
	else $cond = "";
	$sql_check = "SELECT count(*) FROM ".$table." WHERE code = '".$code."'".$cond;
	$sql_check = $db->sql_query($sql_check) or die(mysql_error());
	$exits 	   = $db->sql_fetchfield(0);
	if($exits)return true;
	else return false;
}

function displayData_DB_Content($strInput)
{//Written Pham Vu Hoang Luyen
    $strInput = stripslashes($strInput);
//    $strInput = str_replace(chr(10), '<br>', $strInput);
    return $strInput;
}

function check_exits_field($code,$field, $table, &$db, $id = 0)
{//Written Pham Vu Hoang Luyen
	if($id<>0) $cond = " AND id <> '".$id."'";
	else $cond = "";

	$sql_check = "SELECT count(*) FROM ".$table." WHERE `".$field."` = '".$code."'".$cond;
	$sql_check = $db->sql_query($sql_check) or die(mysql_error());
	$exits 	   = $db->sql_fetchfield(0);
	if($exits)return true;
	else return false;
}

function check_exits_idField($code,$field, $table, &$db)
{//Written Pham Vu Hoang Luyen

	$sql_check = "SELECT * FROM ".$table." WHERE `".$field."` = '".$code."'";
	$sql_check = $db->sql_query($sql_check) or die(mysql_error());
	$exits 	   = $db->sql_fetchfield(0);
	if($exits)return true;
	else return false;
}

function Max_pre_order($max_field, $code,$field, $table, &$db,$type='')
{//Written Pham Vu Hoang Luyen
    $otherSQL=($type=='')?'':' and type='.$type;
	$sql_check = "SELECT max(".$max_field.") as TT FROM ".$table." WHERE `".$field."` = '".$code."'".$otherSQL;
	$sql_check = $db->sql_query($sql_check) or die(mysql_error());
	$exits 	   = $db->sql_fetchfield(0);
	return ($exits+1);
}

function Make_field_values($field, $table, &$db, $where="")
{
    $exits          =   0; //Default 0
    $sql_check      = "SELECT `".$field."` FROM ".$table." ".$where;
    $sql_check      = $db->sql_query($sql_check) or die(mysql_error());
    $exits          = $db->sql_fetchfield($field);
    return $exits;
}
function private_unset()
{
    //Quan ly nguoi su dung

	unset($_SESSION['search_adv']);
	unset($_SESSION['adver_type']);

	unset($_SESSION['catinfolist']);
	unset($_SESSION['url_of_list_pro']);

	unset($_SESSION['catprojectlist']);
	
	unset($_SESSION['search_name']);
	unset($_SESSION['search_code']);
	unset($_SESSION['search_type']);
	
	unset($_SESSION['txtInfo_Search']);		
}
function Check_sub_info($table, &$db, $const="")
{ 
    $exits          =   0; //Default 0
    $sql_check      = "SELECT COUNT(*) FROM " . $table.$const;
    $sql_check      = $db->sql_query($sql_check) or die(mysql_error());
    $exits          = $db->sql_fetchfield(0);
    return $exits;
}
function Make_field_values1($field, $table, &$db, $const="")
{ 
    $exits          =   0;
    $sql_check      = "SELECT `" . $field."` FROM ".$table.$const;
    $sql_check      = $db->sql_query($sql_check) or die(mysql_error());
    while($sql_query_rows = mysql_fetch_array($sql_check))
    {
          $exits ++;
		  $vreturn = displayData_DB($sql_query_rows[$field]);
    }  
    if($exits==0)   return "";
    return $vreturn;
}
function make_vlink($title,$cur_cat)
{ 
    global $db,$table_prj;
	$vlink = Convert_alias($title);
	$check = Check_sub_info($table_prj, $db, "where vlink='".$vlink."' and id<>'".$cur_cat."'");
    if ($check > 0) {
		return "Da co roi";
	} else return $vlink;
}

function randomString($length)
{
$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
$randstring = '';
for ($i = 0; $i < $length; $i++) 
	{
		$randstring = $randstring.$characters[rand(0, strlen($characters))];
	}
return $randstring;
}
function makeVlink($table,$field,$rowid,$title)
{
	global $db;
	$link=Convert_alias(trim($title));
	$nRows      = (int)Check_sub_info($table,$db," WHERE `id`<>'".$rowid."' and `".$field."`='".$link."' ");
	if ($nRows>0){
		for ($i=1; $i<300; $i++)
		{
			$nRows      = (int)Check_sub_info($table,$db," WHERE `id`<>'".$rowid."' and `".$field."`='".$link."-".$i."' ");
			if ($nRows==0){
			$link=$link."-".$i;
			break;
			}
		}
	}
	return $link;
}
function makeContentInfo($id,$type)
{
	global $langset,$db,$table_content_info;
	return displayData_DB(Make_field_values1("info",$table_content_info,$db," where content_id='".$id."' and lang_id='".$langset."' and type='".$type."'"));
}
function makeCatContentInfo($id,$type)
{
	global $langset,$db,$table_catcontent_info;
	return displayData_DB(Make_field_values1("info",$table_catcontent_info,$db," where cat_id='".$id."' and lang_id='".$langset."' and type='".$type."'"));
}
function makeMenuInfo($id,$type)
{
	global $langset,$db,$table_menu_info;
	return displayData_DB(Make_field_values1("info",$table_menu_info,$db," where menu_id='".$id."' and lang_id='".$langset."' and type='".$type."'"));
}
//lay danh sach sub cat info
function get_cat_sub($cat_id,$level=0) {
global $table_catcontent, $db;
$list_info_cat=($level==0)?"(-1":"";
$list_info_cat = $list_info_cat.",".$cat_id;
$subcat_num = Check_sub_info($table_catcontent,$db," WHERE parent_id = '".$cat_id."'");
if ($subcat_num>0) {
	$sql_query = "SELECT * FROM `" . $table_catcontent . "` WHERE parent_id='".$cat_id."' ORDER BY priority_order ASC";
	$sql_query = mysql_query($sql_query);
	while($sql_query_rows = mysql_fetch_array($sql_query)) {
		$list_info_cat = $list_info_cat.get_cat_sub($sql_query_rows['id'],1);
		}
	}
return ($level==0)?$list_info_cat.")":$list_info_cat;
}

function get_cat_list($cat_id) {
	global $table_catcontent,$sql_query_group,$db;
	$sql_query_group = $sql_query_group." cat_list LIKE '%|".$cat_id."|%' OR ";
	$sql_query = "SELECT * FROM `" . $table_catcontent . "` WHERE parent_id='".$cat_id."' ORDER BY priority_order ASC";
	$sql_query = mysql_query($sql_query);
	while($sql_query_rows = mysql_fetch_array($sql_query)) {
		get_cat_list($sql_query_rows['id']);
	}
}

function LANG($subject)
{ 
    global $langset,$db,$DB_FSQL;
	$vreturn          =   "";
    $sql_check      = "SELECT * FROM ".$DB_FSQL."tbldefine where subject='".$subject."'";
    $sql_check      = $db->sql_query($sql_check) or die(mysql_error());
    while($sql_query_rows = mysql_fetch_array($sql_check))
    {
		  $vreturn = Make_field_values("value", $DB_FSQL."tbldefine_value", $db, " where define_id='".$sql_query_rows["id"]."' and lang_id='".$langset."'");
    }  
    return $vreturn;
}
function make_search_string($keyword){
	global $db,$table_content_info;
	$string="(0";
	$sql_query = "SELECT * FROM `" . $table_content_info . "` WHERE info LIKE '%".$keyword."%'";
	$sql_query = mysql_query($sql_query);
	while($sql_query_rows = mysql_fetch_array($sql_query)) {
		$string=$string.",".$sql_query_rows['content_id'];
	}
	$string=$string.")";
	return $string;
}
function get_ds_tinh($block,$default_region=""){
	//region
	global $table_tinh, $template;
	$sql_query = "SELECT * FROM `" . $table_tinh . "` ORDER BY name ASC";
	$sql_query = mysql_query($sql_query);
	while($sql_query_rows = mysql_fetch_array($sql_query)) {
		$template->assign_block_vars($block,array(
			'id'      => $sql_query_rows['id'],
			'name'    => $sql_query_rows['name'],
			'selected'  => ($sql_query_rows['id']==$default_region)?"selected":"",
		));
	}
}
function get_ds_huyen($block,$tinh,$default_region=""){
	//region
	global $table_tinh,$table_huyen, $template;
	$sql_query = "SELECT * FROM `" . $table_huyen . "` WHERE tid='".$tinh."' ORDER BY name ASC";
	$sql_query = mysql_query($sql_query);
	while($sql_query_rows = mysql_fetch_array($sql_query)) {
		$template->assign_block_vars($block,array(
			'id'      => $sql_query_rows['id'],
			'name'    => $sql_query_rows['name'],
			'selected'  => ($sql_query_rows['id']==$default_region)?"selected":"",
		));
	}
}
function makeProInCat($cat_id,$field="cat_list") {
	global $str_catlist;
	$str_catlist="(";
	getCatListLoop($cat_id,$field);
	return $str_catlist." ".$field."='xxx')";
}
function getCatListLoop($cat_id,$field) {
	global $table_catcontent,$str_catlist,$db;
	$str_catlist = $str_catlist." ".$field." LIKE '%|".$cat_id."|%' OR ";
	$sql_query = "SELECT * FROM `" . $table_catcontent . "` WHERE parent_id='".$cat_id."' ORDER BY priority_order ASC";
	$sql_query = mysql_query($sql_query);
	while($sql_query_rows = mysql_fetch_array($sql_query)) {
		getCatListLoop($sql_query_rows['id'],$field);
	}
}
function create_mail_schedule($title,$content,$mail_list) {
	global $db,$table_mailcontent,$table_mailsend;
	$sql_query  = "insert into ".$table_mailcontent."(`title`,`content`,`create_time`) values('".insertData($title)."','". insertData($content)."',NOW())";
	$sql_query = $db -> sql_query($sql_query) or die(mysql_error());
	$last_id = Make_field_values("id", $table_mailcontent, $db," order by id desc limit 1");
	$explosub = explode(",",$mail_list);
	for ($i=0;$i<count($explosub);$i++)
	{
		if (filter_var($explosub[$i], FILTER_VALIDATE_EMAIL))
		{
			$sql_item_insert         = "insert into " . $table_mailsend . " (`mfrom`,`mto`,`mailcontent_id`,`sent`) values ('Admin','".$explosub[$i]."','".$last_id."','0')";
			$sql_item_insert  =   $db->sql_query($sql_item_insert) or die(mysql_error());
		}
	}
}
function Make_sub_string($string, $len, $kytu)
{ 
	if (strlen($string)<=$len) return $string;
	$substr = substr(strip_tags($string),0,$len);
	$explosub=explode($kytu,$substr);
	$substr="";
	for ($i=0;$i<count($explosub)-1;$i++) {$substr=$substr.$explosub[$i]." ";}
    return $substr."...";
}
function get_client_ip() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
	   $ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}
function addLog($log, $cat_id, $content_id,$query="")
{ 
	global $db,$table_log;
	$ip=get_client_ip();
	$sql_item_insert         = "insert into " . $table_log . " (`admin_id`,`ip`,`log`,`query`,`cat_id`,`content_id`,`create_time`) values ('".$_SESSION['login_id']."','".$ip."','".insertData($log)."','".insertData($query)."','".insertData($cat_id)."','".insertData($content_id)."',NOW())";
	$sql_item_insert  =   $db->sql_query($sql_item_insert) or die(mysql_error());
}
function addNote($note, $content_id)
{ 
	global $db,$table_content_note;
	$ip=get_client_ip();
	$sql_item_insert         = "insert into " . $table_content_note . " (`admin_id`,`ip`,`note`,`content_id`,`create_time`) values ('".$_SESSION['login_id']."','".$ip."','".insertData($note)."','".insertData($content_id)."',NOW())";
	$sql_item_insert  =   $db->sql_query($sql_item_insert) or die(mysql_error());
}
function makeBdsList($sql_query,$block)
{ 
	global $template,$db,$table_catcontent,$table_content,$table_ad,$table_u,$table_content_status,$table_content_note;
	$stt=0;
	$sql_query = $db->sql_query($sql_query) or die(mysql_error());
	while($sql_query_rows = mysql_fetch_array($sql_query))
	{
		$stt++;
		$khuvuc_id = $sql_query_rows['cat2_id'];
		$khuvuc = Make_field_values1("title", $table_catcontent, $db," where id='".$khuvuc_id."'");
		if (trim($khuvuc)=="") {
			$khuvuc_id = $sql_query_rows['cat1_id'];
			$khuvuc = Make_field_values1("title", $table_catcontent, $db," where id='".$khuvuc_id."'");
			if (trim($khuvuc)=="") {
				$khuvuc_id=0;
				$khuvuc="Khác";
			}
		}
		//ghi chu
		$content_note="";
		$sql_query1 = "SELECT * FROM `" . $table_content_note . "` where content_id='".$sql_query_rows['id']."' order by id DESC limit 1";
		$sql_query1 = mysql_query($sql_query1);
		while($sql_query_rows1 = mysql_fetch_array($sql_query1))
		{
			$content_note.=transform_date_back($sql_query_rows1['create_time'])."|".Make_field_values1("admin_user", $table_ad, $db," where admin_id='".$sql_query_rows1['admin_id']."'").": ".strip_tags($sql_query_rows1['note']);
		}
		$pre_arr= array("","Đông","Tây","Nam","Bắc","Tây Nam","Tây Bắc","Đông Nam","Đông Bắc");
		$template->assign_block_vars($block,array(
			'stt'     		=>  $stt,
			'id'     		=>  $sql_query_rows['id'],
			'admin'			=>  Make_field_values1("admin_user", $table_ad, $db," where admin_id='".$sql_query_rows['admin_id']."'"),
			'user'			=>  Make_field_values1("name", $table_u, $db," where id='".$sql_query_rows['user_id']."'"),
			'code'			=>  $sql_query_rows['code'],
			'expired'		=>  transform_date_back($sql_query_rows['expired']),
			'status'		=>  Make_field_values1("title", $table_content_status, $db," where id='".$sql_query_rows['status']."'"),
			'status_color'	=>  Make_field_values1("color", $table_content_status, $db," where id='".$sql_query_rows['status']."'"),
			'cat_id'		=>  $khuvuc_id,
			'cat_title'		=>  $khuvuc,
			'note'			=>  $content_note,
			'huong'			=>  $pre_arr[(int)$sql_query_rows['huong']],
			'dt'			=>  ((int)$sql_query_rows['dt'] == $sql_query_rows['dt'])?(int)$sql_query_rows['dt']:$sql_query_rows['dt'],
			'price'			=>  ((int)$sql_query_rows['price'] == $sql_query_rows['price'])?(int)$sql_query_rows['price']:$sql_query_rows['price'],
			'price_dvt'			=>  $sql_query_rows['price_dvt'],
			'ren'			=>  ((int)$sql_query_rows['ren'] == $sql_query_rows['ren'])?(int)$sql_query_rows['ren']:$sql_query_rows['ren'],
			'ren_dvt'			=>  $sql_query_rows['ren_dvt'],
			'show_action'	=>  ($_SESSION['login_id']==$sql_query_rows['admin_id'] OR $_SESSION['is_admin'])?"":"display:none;",
			'show_del'		=>  ($_SESSION['is_admin'])?"":"display:none;",
			'show_flag'		=>  ($sql_query_rows['flag']=="hot")?"":"display:none;",
			'update_time'			=>  checkExpired($sql_query_rows['update_time']),
		));
	}
}

function checkExpired($update_time, $type = 'string'){
	$stringExpired = '';
	$check = false;
	$diff = abs(time() - strtotime($update_time));
	$days = floor($diff/(60*60*24));
	if($days >= 30){
		$stringExpired = '<span style="color:#FFF;background-color:#000;padding:3px">Hết hạn</span>';
		$check = true;
	}

	return $type == 'string' ? $stringExpired : $check;
}
?>