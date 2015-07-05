<?php

    include_once('tietuku_sdk.php');
    define('MY_ACCESSKEY', '754efe46b0adb4ffc407a78cd52081c3613227ed');//获取地址:http://open.tietuku.com/manager
    define('MY_SECRETKEY', 'da39a3ee5e6b4b0d3255bfef95601890afd80709');//获取地址:http://open.tietuku.com/manager
    $ttk=new TTKClient(MY_ACCESSKEY,MY_SECRETKEY);
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $res=$ttk->uploadFile('1051794',$tempFile);
    $ret=json_decode($res,true);
    echo $ret['s_url'];
?>