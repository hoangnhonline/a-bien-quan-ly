<?php
$template -> set_filenames(array(
    'under'    => $dir_under. 'under.html')
);
$template -> assign_vars(array(
	'txt_site_title'		=>  (isset($site_title))? $site_title ." - " . $setting_site_name:$setting_site_name,
));
$template -> pparse('under');
?>