<?php

//Hàm phân trang đã zen giống Joomla
function generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = TRUE, $sort_cond="")
{
		if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en')
		{
			$pre            = 'Prev';
			$nex            = 'Next';
            $start          = 'Start';
            $end            = 'Last';
            $page_active    = 'Page ';
		}
		else
		{
			$pre            = 'Prev';
			$nex            = 'Next';
            $start          = 'Start';
            $end            = 'Last';
            $page_active    = 'Page ';
		}
    //Hàm ceil tính nguyên lần trang tức là làm tròn đến 1.1=2
	$total_pages = ceil($num_items/$per_page);
	if ( $total_pages == 1 or  $total_pages == 0)
	{
		return '<div id="example_paginate" class="dataTables_paginate paging_full_numbers"><a id="example_first" tabindex="0" class="first paginate_button paginate_button_disabled">'.$start.'</a><a id="example_previous" tabindex="0" class="previous paginate_button paginate_button_disabled">'.$pre.'</a><a tabindex="0" class="paginate_active">1</a><a id="example_next" tabindex="0" class="next paginate_button">'.$nex.'</a><a id="example_last" tabindex="0" class="last paginate_button">'.$end.'</a></div>';
	}

    //Lấy trang hiện thời đang mở
	$on_page = floor($start_item / $per_page) + 1;
    //echo $on_page;

	$page_string = '';
	if ( $total_pages > 10 )
	{
		$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
		
		for($i = 1; $i < $init_page_max + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<a class="paginate_active">'. $i .'</a>':
            '<a class="paginate_button" title="'.$page_active.$i.'" href="' . $base_url .  "&p=" . ( ( $i - 1 ) * $per_page ) . '" >'. $i.'</a>';
			if ( $i <  $init_page_max )
			{
				$page_string .= "";
			}
		}

		if ( $total_pages > 3 )
		{
			if ( $on_page > 1  && $on_page < $total_pages )
			{
				$page_string .= ( $on_page > 5 ) ? '<a  class="paginate_button">...</a>' : '';

				$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
				$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

				for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
				{
					$page_string .= ($i == $on_page) ? '<a class="paginate_active">'. $i .'</a>' : '<a class="paginate_button" title="'.$page_active.$i.'" href="' . $base_url .  "&p=" . ( ( $i - 1 ) * $per_page ) . '" >'. $i.'</a>';
					if ( $i <  $init_page_max + 1 )
					{
						$page_string .= ' ';
					}
				}

				$page_string .= ( $on_page < $total_pages - 4 ) ? '<a  class="paginate_button">...</a>' : ' ';
			}
			else
			{
				$page_string .= '<a  class="paginate_button">...</a>';
			}

			for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
			{
				$page_string .= ( $i == $on_page ) ? '<a class="paginate_active">'. $i .'</a>'  : '<a  class="paginate_button" title="'.$page_active.$i.'" href="' . $base_url .  "&p=" . ( ( $i - 1 ) * $per_page ) . '" >'. $i.'</a>';
				if( $i <  $total_pages )
				{
					$page_string .= " ";
				}
			}
		}
        $page_string ='<span>'.$page_string.'</span>';
	}
	else
	{
        //Lấy danh sách các trang nếu tổng số trang <=10

		for($i = 1; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<a class="paginate_active">'. $i.'</a>' : '<a class="paginate_button" title="'.$page_active.$i.'" href="' . $base_url .  "&p=" . ( ( $i - 1 ) * $per_page ) . '" >'. $i.'</a>';
			if ( $i <  $total_pages )
			{
				$page_string .= ' ';
			}
		}
        $page_string ='<span>'.$page_string.'</span>';
        //echo $page_string;
	}

	if ( $add_prevnext_text )
	{
        //Lựa chọn kiểu hiển thị
    	switch ($on_page)
    	{
         //Nếu chỉ có 1 trang
         case ($on_page==1 && $total_pages==$on_page):
               break;
         //Nếu có nhiều trang nhưng ở trang đầu
         case ($on_page==1 && $total_pages>$on_page):
            $page_bg    = '<a class="first paginate_button paginate_button_disabled">'.$start.'</a>';
            $page_en    = '<a class="paginate_button" title="'. $page_active.$end. '" href="'. $base_url. '&p='.(($total_pages - 1 ) * $per_page ).'">'. $end. '</a>' ;

			$page_string = $page_bg.'<a class="previous paginate_button paginate_button_disabled">'.$pre.'</a>'.$page_string.'<a class="paginate_button" title="'.$page_active. $nex .'" href="' . $base_url . '&p=' . ( $on_page * $per_page ) . '">'. $nex . '</a>'.$page_en.'<a class="paginate_button">'.$page_active.$on_page.'/'.$total_pages.'</a>';
            break;
         //Nếu có nhiều trang nhưng ở trang  1>i<n
         case ($on_page>1 && $total_pages>$on_page):
            $page_bg    = '<a class="paginate_button" title="'. $page_active.$start. '" href="'. $base_url. '&p=0">'. $start. '</a>';
            $page_en    = '<a class="paginate_button" title="'. $page_active.$end. '" href="'. $base_url. '&p='.(($total_pages - 1 ) * $per_page ).'">'. $end. '</a>' ;
			$page_string = $page_bg.'<a class="paginate_button" title="'.$page_active. $pre .'" href="' . $base_url .  "&p=" . ( ( $on_page - 2 ) * $per_page ).'"/>' .$pre. '</a>'.$page_string.'<a class="paginate_button" title="'.$page_active. $nex .'" href="' . $base_url . '&p=' . ( $on_page * $per_page ) . '">'. $nex . '</a>'.$page_en.'<a class="paginate_button">'.$page_active.$on_page.'/'.$total_pages.'</a>';
            break;
         //Nếu có nhiều trang nhưng ở trang cuối cùng
         case ($on_page>1 && $total_pages==$on_page):
            $page_bg    = '<a class="paginate_button" title="'. $page_active.$start. '" href="'. $base_url. '&p=0">'. $start. '</a>';
            $page_en    = '<a class="paginate_button">'.$page_active.$end.'</a>';

			$page_string = $page_bg.'<a class="paginate_button" title="'.$page_active. $pre .'" href="' . $base_url .  "&p=" . ( ( $on_page - 2 ) * $per_page ).'"/>' .$pre. '</a>'.$page_string.'<a las="next paginate_button">'.$nex.'</a>'.$page_en.'<a class="paginate_button">'.$page_active.$on_page.'/'.$total_pages.'</a>';
            break;
        }
	}
	return $page_string;
}


function Paging($sListName, $nCurrentPage, $sQuery, $nRowsPerPage){
	$sListbox = "\n" . '<Select onChange="submit()" name = "' . $sListName . '" >';
	$hDBHandle = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
	mysql_select_db(DB_NAME,$hDBHandle); 
	$hResult = mysql_query($sQuery);
	if($hResult!='') $nRecordCount = mysql_num_rows($hResult);
	else $nRecordCount = 0;
	
	if ($nRecordCount < $nRowsPerPage)
		$nPages=1;	//so trang
	else{
		$temp=$nRecordCount%$nRowsPerPage;
		if($temp==0) 
			$nPages=$nRecordCount/$nRowsPerPage;
		else 
			$nPages=$nRecordCount/$nRowsPerPage+1;
	}
	
	for ($i = 1; $i <= $nPages; $i++){			
		$bSelected = ($i == $nCurrentPage ? 'selected' : '');
		$sListbox .= '<option value="' .$i. '"'. $bSelected .' >' .$i. '</option>'. "\n";
	}
	mysql_close($hDBHandle);
	return $sListbox."\n".'</select>'."\n";
}

//////
function gettime(){
$str_search = array ( 
                "Mon",  
                "Tue",  
                "Wed",  
                "Thu",  
                "Fri",  
                "Sat",  
                "Sun", 
                "am",  
                "pm", 
                ":" 
            ); 
$str_replace = array ( 
                "Thứ hai",  
                "Thứ ba",  
                "Thứ tư", 
                "Thứ năm",  
                "Thứ sáu",   
                "Thứ bảy",  
                "Chủ nhật",  
                " phút, sáng",  
                " phút, chiều", 
                " giờ " 
            ); 
$timenow  = gmdate("D, d/m/Y - g:i a.", time() + 7*3600); 
$timenow  = str_replace( $str_search, $str_replace, $timenow); 
return $timenow;
}

function checkNewInformation(&$bOK, &$strMsg)
{
	//Under construction
}

// Kiem tra form them moi administrator
function checkNewUser(&$bOK, &$strMsg)
{
	global $strUsername;
	if ( !empty($strUsername) )
	{
		$bOK = true;
	}
	else
	{
		$bOK = false;
		$strMsg = 'Tên đăng nhập không được để trống.';
	}
}

// Upload file
function upload_data(&$file_name, &$file_type, $file_tmp, $dir_upload)
{
	//$date = getdate();	
	$time_update = transform_date_back(date(c));
	$len = strlen($file_name);
	$file_name = substr($file_name, 0, $len-4);
	$file_name .= $time_update;
	switch ($file_type) {
		//-----------------------------
		//file van ban
		//-----------------------------
		case 'text/plain':
			$file_type = '.txt';
		break;
		
		case 'application/pdf':
			$file_type = '.pdf';
		break;
		
		case 'application/msword':
			$file_type = '.doc';
		break;
		
		case 'application/vnd.ms-excel':
			$file_type = '.xls';
		break;
		//-----------------------------
		//file hinh anh
		//-----------------------------
		case 'jpeg':
		case '/jpeg':
		case 'pjpeg':
		case 'jpg':
			$file_type = '.jpg';
		break;
		
		case 'e/gif':
			$file_type = '.gif';
		break;
		
		case 'e/pgn':
			$file_type = '.pgn';
		break;
		
		case 'e/bmp':
			$file_type = '.bmp';
		break;	
		//-----------------------------
		//file media
		//-----------------------------	
		case 'video/mpeg':
			$file_type = '.mpg';
		break;
		
		case 'video/x-ms-wmv':
			$file_type = '.wmv';
		break;
		//-----------------------------
		//file nen
		//-----------------------------
		case 'application/x-zip-compressed':
			$file_type = '.zip';
		break;	
			
		case 'application/octet-stream':
			$file_type = '.rar';
		break;
	}
	/*
	if ( !is_dir($dir_upload) )
	{
		//echo 'Can not found the folder: <b>'.$dir_upload.'</b>';		
		return false;
	}
	*/
	if ($file_name == '' or !$file_name or $file_name == 'none')
	{
		//echo 'Can not found the file';
		//exit;
		return false;
	}

	// Copy file can upload len 1 thu muc tren SERVER
	//chmod($dir_upload, 0777);
	if (!move_uploaded_file($file_tmp, $dir_upload . $file_name . $file_type) )
	{
		//echo 'document uploading is not success';
		//exit;
		return false;
	}
	else
	{
		//@chmod($dir_upload . '/' . $file_name . $file_type , 0777);
		return true;
	}
	//chmod($dir_upload, 0755);
}

// Upload cac loai file len server
function upload_files_doc(&$file_name, &$file_type, $file_tmp, $dir_upload)
{
	//$date = getdate();	

	$time_update = time();
	$len = strlen($file_name);
	$file_name = substr($file_name, 0, $len-4);
	$file_name .= $time_update;
	//$file_type = substr($file_type, -strpos($file_type, '/'));

	switch ($file_type) {
		case 'text/plain':
			$file_type = '.txt';
		break;
		
		case 'application/pdf':
			$file_type = '.pdf';
		break;
		
		case 'application/msword':
			$file_type = '.doc';
		break;
		
		case 'application/vnd.ms-excel':
			$file_type = '.xls';
		break;
		
		case 'application/x-zip-compressed':
			$file_type = '.zip';
		break;		
		case 'application/octet-stream':
			$file_type = '.rar';
		break;		
	}
	/*
	if ( !is_dir($dir_upload) )
	{
		//echo 'Can not found the folder: <b>'.$dir_upload.'</b>';		
		return false;
	}
	*/
	if ( $file_name == '' or !$file_name or $file_name == 'none')
	{
		//echo 'Can not found the file';
		//exit;
		return false;
	}

	// Copy file can upload len 1 thu muc tren SERVER
	//chmod($dir_upload, 0777);
	if ( !move_uploaded_file($file_tmp, $dir_upload . $file_name . $file_type) )
	{
		//echo 'document uploading is not success';
		//exit;
		return false;
	}
	else
	{
		//@chmod($dir_upload . '/' . $file_name . $file_type , 0777);
		return true;
	}
	//chmod($dir_upload, 0755);
}

// UpLoad file anh len Server
function upload_files(&$file_name, &$file_type, $file_tmp, $dir_upload)
{
	$time_update = time();
	$len = strlen($file_name);
	$file_name = substr($file_name, 0, $len-4);
	$file_name .= $time_update;
	$file_type = substr($file_type, -strpos($file_type, '/'));
	
	switch ($file_type) {
		case 'jpeg':
		case '/jpeg':
		case 'pjpeg':
		case 'jpg':
			$file_type = '.jpg';
		break;
		
		case 'e/gif':
			$file_type = '.gif';
		break;
		
		case 'e/png':
			$file_type = '.png';
		break;
		
		case 'e/bmp':
			$file_type = '.bmp';
		break;		
	}
	
	if ( !is_dir($dir_upload) )
	{
		return false;
	}
	
	if ( $file_name == '' or !$file_name or $file_name == 'none')
	{
		return false;
	}
	
	// Copy file can upload len 1 thu muc tren SERVER
	//chmod($dir_upload, 0777);
	
	if ( !move_uploaded_file($file_tmp, $dir_upload .  $file_name . $file_type) )
	{
		return false;
	}
	else
	{
		//@chmod($dir_upload . '/' . $file_name . $file_type , 0777);
		return true;
	}
	//chmod($dir_upload, 0755);
}
//------------------------------------------------------
//-----------------UPLOAD VIDEO FILE--------------------
//------------------------------------------------------
function upload_video_files(&$file_name, &$file_type, $file_tmp, $dir_upload)
{
	//$time_update = time();
	$len = strlen($file_name);
	$file_name = substr($file_name, 0, $len-4);
	//$file_name .= $time_update;
	//$file_type = substr($file_type, -$position);
	
	switch ($file_type) {
		case 'video/mpeg':
			$file_type = '.mpg';
		break;
		
		case 'video/x-ms-wmv':
			$file_type = '.wmv';
		break;
	}
	if ( !is_dir($dir_upload) )
	{
		return false;
	}
	
	if ( $file_name == '' or !$file_name or $file_name == 'none')
	{
		return false;
	}
	
	// Copy file can upload len 1 thu muc tren SERVER
	//chmod($dir_upload, 0777);
	
	if ( !move_uploaded_file($file_tmp, $dir_upload .  $file_name . $file_type) )
	{
		return false;
	}
	else
	{
		//@chmod($dir_upload . '/' . $file_name . $file_type , 0777);
		return true;
	}
	//chmod($dir_upload, 0755);
}

// Xoa file anh tren server
function delete_files($file_name, $dir_upload) {
	if ( file_exists( $dir_upload . '/' . $file_name) ) {
		unlink( $dir_upload . '/' . $file_name);
	}
	return;
}

// Kiem tra cau truc email nhap vao
function is_email($EmailAddr)
{
	if ( ! preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is', $EmailAddr))
		return false;
	else return true;
}
function stripUnicode($str){
	if(!$str) return false;
	   $unicode = array(
		  'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
		  'd'=>'đ',
		  'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		  'i'=>'í|ì|ỉ|ĩ|ị',
		  'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		  'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		  'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
	   );
	foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
	return $str;
}
function str_split_unicode($str, $l = 0) {
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}
function Convert_alias($value)
{
	$alias_link="";
	$lowtitle = mb_strtolower($value, 'UTF-8');
	$unicode_arr = str_split_unicode($lowtitle);
	for ($i=0;$i<count($unicode_arr);$i++) {
		switch ($unicode_arr[$i])
			{
			case 'á':
			case 'a':
			case 'à':
			case 'ạ':
			case 'ã':
			case 'ả':
			case 'ă':
			case 'ắ':
			case 'ằ':
			case 'ẳ':
			case 'ẵ':
			case 'ặ':
			case 'â':
			case 'ấ':
			case 'ầ':
			case 'ẩ':
			case 'ẫ':
			case 'ậ':
				$alias_link = $alias_link."a";
				break;
			case 'b':
				$alias_link = $alias_link."b";
				break;
			case 'c':
				$alias_link = $alias_link."c";
				break;
			case 'd':
			case 'đ':
				$alias_link = $alias_link."d";
				break;
			case 'e':
			case 'é':
			case 'ẻ':
			case 'ẹ':
			case 'è':
			case 'ẽ':
			
			case 'ê':
			case 'ế':
			case 'ề':
			case 'ể':
			case 'ệ':
			case 'ễ':
				$alias_link = $alias_link."e";
				break;				
			case 'g':
				$alias_link = $alias_link."g";
				break;
			case 'h':
				$alias_link = $alias_link."h";
				break;
			case 'i':
			case 'ì':
			case 'í':
			case 'ỉ':
			case 'ĩ':
			case 'ị':
				$alias_link = $alias_link."i";
				break;
			case 'k':
				$alias_link = $alias_link."k";
				break;
			case 'l':
				$alias_link = $alias_link."l";
				break;
			case 'm':
				$alias_link = $alias_link."m";
				break;
			case 'n':
				$alias_link = $alias_link."n";
				break;
			case 'o':
			case 'ó':
			case 'ò':
			case 'ỏ':
			case 'õ':
			case 'ọ':
			
			case 'ô':
			case 'ố':
			case 'ồ':
			case 'ổ':
			case 'ỗ':
			case 'ộ':
			
			case 'ơ':
			case 'ớ':
			case 'ờ':
			case 'ở':
			case 'ỡ':
			case 'ợ':
				$alias_link = $alias_link."o";
				break;				
			case 'p':
				$alias_link = $alias_link."p";
				break;
			case 'q':
				$alias_link = $alias_link."q";
				break;
			case 'r':
				$alias_link = $alias_link."r";
				break;
			case 's':
				$alias_link = $alias_link."s";
				break;
			case 't':
				$alias_link = $alias_link."t";
				break;
			case 'u':
			case 'ú':
			case 'ù':
			case 'ủ':
			case 'ũ':
			case 'ụ':
			
			case 'ư':
			case 'ứ':
			case 'ừ':
			case 'ử':
			case 'ử':
			case 'ữ':
			case 'ự':
				$alias_link = $alias_link."u";
				break;
			case 'v':
				$alias_link = $alias_link."v";
				break;
			case 'x':
				$alias_link = $alias_link."x";
				break;
			case 'y':
			case 'ý':
			case 'ỳ':
			case 'ỷ':
			case 'ỹ':
			case 'ỵ':
				$alias_link = $alias_link."y";
				break;
			case 'f':
				$alias_link = $alias_link."f";
				break;
			case 'j':
				$alias_link = $alias_link."j";
				break;
			case 'w':
				$alias_link = $alias_link."w";
				break;
			case 'z':
				$alias_link = $alias_link."z";
				break;
			case '0':
				$alias_link = $alias_link."0";
				break;
			case '1':
				$alias_link = $alias_link."1";
				break;
			case '2':
				$alias_link = $alias_link."2";
				break;
			case '3':
				$alias_link = $alias_link."3";
				break;
			case '4':
				$alias_link = $alias_link."4";
				break;
			case '5':
				$alias_link = $alias_link."5";
				break;
			case '6':
				$alias_link = $alias_link."6";
				break;
			case '7':
				$alias_link = $alias_link."7";
				break;
			case '8':
				$alias_link = $alias_link."8";
				break;
			case '9':
				$alias_link = $alias_link."9";
				break;
			case ' ':
			case '_':
			case '-':
			case '&':
			case '@':
			case '+':
				$alias_link = $alias_link."-";
				break;
			Default:
				$alias_link = $alias_link."";
				break;
			}
	}
	$alias_link = str_replace("----","-", $alias_link);
	$alias_link = str_replace("---","-", $alias_link);
	$alias_link = str_replace("--","-", $alias_link);
	return $alias_link;
}
function Convert_alias1($value)
{
    $value = trim($value);
	$value = str_replace("–","", $value);
	$value = str_replace("”","", $value);
	$value = str_replace("”","", $value);
	$value = str_replace("+","", $value);
	$value = str_replace(":","", $value);
	$value = str_replace("[","", $value);
	$value = str_replace("]","", $value);
	$value = str_replace("'","", $value);
	$value = str_replace("&","", $value);
	$value = str_replace("%","", $value);
	$value = str_replace("$","", $value);
	$value = str_replace("#","", $value);
	$value = str_replace("@","", $value);
	$value = str_replace("|","-", $value);
	$value = str_replace("/","", $value);
	$value = str_replace("\\","", $value);
	$value = str_replace("(","", $value);
	$value = str_replace(")","", $value);
	$value = str_replace("\"","", $value);
    $value = str_replace(".","", $value);
    $value = str_replace(",","", $value);
    $value = str_replace("&","", $value);
    $value = str_replace(" ","-", $value);
    $value = str_replace("?","", $value);
    #---------------------------------a^
    $value = str_replace("ấ", "a", $value);
    $value = str_replace("ầ", "a", $value);
    $value = str_replace("ẩ", "a", $value);
    $value = str_replace("ẫ", "a", $value);
    $value = str_replace("ậ", "a", $value);
    #---------------------------------A^
    $value = str_replace("Ấ", "a", $value);
    $value = str_replace("Ầ", "a", $value);
    $value = str_replace("Ẩ", "a", $value);
    $value = str_replace("Ẫ", "a", $value);
    $value = str_replace("Ậ", "a", $value);
    #---------------------------------a(
    $value = str_replace("ắ", "a", $value);
    $value = str_replace("ằ", "a", $value);
    $value = str_replace("ẳ", "a", $value);
    $value = str_replace("ẵ", "a", $value);
    $value = str_replace("ặ", "a", $value);
    #---------------------------------A(
    $value = str_replace("Ắ", "a", $value);
    $value = str_replace("Ằ", "a", $value);
    $value = str_replace("Ẳ", "a", $value);
    $value = str_replace("Ẵ", "a", $value);
    $value = str_replace("Ặ", "a", $value);
    #---------------------------------a
    $value = str_replace("á", "a", $value);
    $value = str_replace("à", "a", $value);
    $value = str_replace("ả", "a", $value);
    $value = str_replace("ã", "a", $value);
    $value = str_replace("ạ", "a", $value);
    $value = str_replace("â", "a", $value);
    $value = str_replace("ă", "a", $value);
    #---------------------------------A
    $value = str_replace("Á", "a", $value);
    $value = str_replace("À", "a", $value);
    $value = str_replace("Ả", "a", $value);
    $value = str_replace("Ã", "a", $value);
    $value = str_replace("Ạ", "a", $value);
    $value = str_replace("Â", "a", $value);
    $value = str_replace("Ă", "a", $value);
    #---------------------------------e^
    $value = str_replace("ế", "e", $value);
    $value = str_replace("ề", "e", $value);
    $value = str_replace("ể", "e", $value);
    $value = str_replace("ễ", "e", $value);
    $value = str_replace("ệ", "e", $value);
    #---------------------------------E^
    $value = str_replace("Ế", "e", $value);
    $value = str_replace("Ề", "e", $value);
    $value = str_replace("Ể", "e", $value);
    $value = str_replace("Ễ", "e", $value);
    $value = str_replace("Ệ", "e", $value);
    #---------------------------------e
    $value = str_replace("é", "e", $value);
    $value = str_replace("è", "e", $value);
    $value = str_replace("ẻ", "e", $value);
    $value = str_replace("ẽ", "e", $value);
    $value = str_replace("ẹ", "e", $value);
    $value = str_replace("ê", "e", $value);
    #---------------------------------E
    $value = str_replace("É", "e", $value);
    $value = str_replace("È", "e", $value);
    $value = str_replace("Ẻ", "e", $value);
    $value = str_replace("Ẽ", "e", $value);
    $value = str_replace("Ẹ", "e", $value);
    $value = str_replace("Ê", "e", $value);
    #---------------------------------i
    $value = str_replace("í", "i", $value);
    $value = str_replace("ì", "i", $value);
    $value = str_replace("ỉ", "i", $value);
    $value = str_replace("ĩ", "i", $value);
    $value = str_replace("ị", "i", $value);
    #---------------------------------I
    $value = str_replace("Í", "i", $value);
    $value = str_replace("Ì", "i", $value);
    $value = str_replace("Ỉ", "i", $value);
    $value = str_replace("Ĩ", "i", $value);
    $value = str_replace("Ị", "i", $value);
    #---------------------------------o^
    $value = str_replace("ố", "o", $value);
    $value = str_replace("ồ", "o", $value);
    $value = str_replace("ổ", "o", $value);
    $value = str_replace("ỗ", "o", $value);
    $value = str_replace("ộ", "o", $value);
    #---------------------------------O^
    $value = str_replace("Ố", "o", $value);
    $value = str_replace("Ồ", "o", $value);
    $value = str_replace("Ổ", "o", $value);
    $value = str_replace("Ô", "o", $value);
    $value = str_replace("Ộ", "o", $value);
    #---------------------------------o*
    $value = str_replace("ớ", "o", $value);
    $value = str_replace("ờ", "o", $value);
    $value = str_replace("ở", "o", $value);
    $value = str_replace("ỡ", "o", $value);
    $value = str_replace("ợ", "o", $value);
    #---------------------------------O*
    $value = str_replace("Ớ", "o", $value);
    $value = str_replace("Ờ", "o", $value);
    $value = str_replace("Ở", "o", $value);
    $value = str_replace("Ỡ", "o", $value);
    $value = str_replace("Ợ", "o", $value);
    #---------------------------------u*
    $value = str_replace("ứ", "u", $value);
    $value = str_replace("ừ", "u", $value);
    $value = str_replace("ử", "u", $value);
    $value = str_replace("ữ", "u", $value);
    $value = str_replace("ự", "u", $value);
    #---------------------------------U*
    $value = str_replace("Ứ", "u", $value);
    $value = str_replace("Ừ", "u", $value);
    $value = str_replace("Ử", "u", $value);
    $value = str_replace("Ữ", "u", $value);
    $value = str_replace("Ự", "u", $value);
    #---------------------------------y
    $value = str_replace("ý", "y", $value);
    $value = str_replace("ỳ", "y", $value);
    $value = str_replace("ỷ", "y", $value);
    $value = str_replace("ỹ", "y", $value);
    $value = str_replace("ỵ", "y", $value);
    #---------------------------------Y
    $value = str_replace("Ý", "y", $value);
    $value = str_replace("Ỳ", "y", $value);
    $value = str_replace("Ỷ", "y", $value);
    $value = str_replace("Ỹ", "y", $value);
    $value = str_replace("Ỵ", "y", $value);
    #---------------------------------DD
    $value = str_replace("Đ", "d", $value);
    $value = str_replace("Đ", "d", $value);
    $value = str_replace("đ", "d", $value);
    #---------------------------------o
    $value = str_replace("ó", "o", $value);
    $value = str_replace("ò", "o", $value);
    $value = str_replace("ỏ", "o", $value);
    $value = str_replace("õ", "o", $value);
    $value = str_replace("ọ", "o", $value);
    $value = str_replace("ô", "o", $value);
    $value = str_replace("ơ", "o", $value);
    #---------------------------------O
    $value = str_replace("Ó", "o", $value);
    $value = str_replace("Ò", "o", $value);
    $value = str_replace("Ỏ", "o", $value);
    $value = str_replace("Õ", "o", $value);
    $value = str_replace("Ọ", "o", $value);
    $value = str_replace("Ô", "o", $value);
    $value = str_replace("Ơ", "o", $value);
    #---------------------------------u
    $value = str_replace("ú", "u", $value);
    $value = str_replace("ù", "u", $value);
    $value = str_replace("ủ", "u", $value);
    $value = str_replace("ũ", "u", $value);
    $value = str_replace("ụ", "u", $value);
    $value = str_replace("ư", "u", $value);
    #---------------------------------U
    $value = str_replace("Ú", "u", $value);
    $value = str_replace("Ù", "u", $value);
    $value = str_replace("Ủ", "u", $value);
    $value = str_replace("Ũ", "u", $value);
    $value = str_replace("Ụ", "u", $value);
    $value = str_replace("Ư", "u", $value);
    #---------------------------------
	$value = str_replace("-----", "-", $value);
	$value = str_replace("----", "-", $value);
	$value = str_replace("---", "-", $value);
	$value = str_replace("--", "-", $value);
    return $value;
}

?>