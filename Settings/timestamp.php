<?php

// timestamp files
function mcms_file_timestamp($file){
	$file_path = $_SERVER['DOCUMENT_ROOT'] . $file;
	if(file_exists($file_path)){
		$timestamp_string = '?t=' . date('YmdHis',filemtime($file_path));
		echo $file . $timestamp_string;
	} else {
		echo $file;
	}
}

?>

<link rel="stylesheet" href="<?php mcms_file_timestamp('/_css/styles.css'); ?>" />