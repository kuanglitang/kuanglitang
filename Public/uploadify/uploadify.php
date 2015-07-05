<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/Uploads'; // Relative to the root
$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
    $year = date('Y'); $day = date('md');
    $relative_path = "/{$year}/{$day}/";
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder . $relative_path;
    recursiveMkdir( $targetPath );
    $file_extension =  pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION);
    $new_file_name = md5($_FILES['Filedata']['name'] . time()) . ".$file_extension";
    $targetFile = rtrim($targetPath,'/') . '/' . $new_file_name;
    $reletiveTargetFile = $targetFolder . str_replace('//','/',$relative_path) . $new_file_name;
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array($fileParts['extension'],$fileTypes)) {
        move_uploaded_file($tempFile,iconv("UTF-8","gb2312", $targetFile)); 
		echo $reletiveTargetFile;
	} else {
		echo 'Invalid file type.';
	}
}
function recursiveMkdir($path) {
  if (!file_exists($path)) {
    recursiveMkdir(dirname($path));
    @mkdir($path, 0777);
  }
}
?>