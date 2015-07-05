<?php
require_once('./ThinkPHP/Library/Org/Crypt/Crypt.class.php');
//设跳转
function set_session_redirect($session_key='show_success',$session_value,$url = null) {
  session($session_key,$session_value);
  if(!$url) {
    $url = I('server.HTTP_REFERER');
  }
  redirect($url);
  exit;
}
//加盐
function encryption(){
  $num = encryption_box().substr(time(),0,4).encryption_box().substr(time(),4);
  return md5($num);
}

function encryption_box(){
  $array = array('A','B','C','D','E','F','G','H','I','J');
  return $array[array_rand($array)];
}



/*****
 *php可逆加密方法 此方法为加密
 *@param $data 加密内容
 *@param $key 密钥
 */
function encrypt($id, $prefix="JHC", $clear=false){
  $crypt = new \Crypt();
    $x = $prefix . $crypt->en(intval($id));
    if(!$clear) return $x;

    if(strpos($x, '=')!==false || strpos($x, '-')!==false) {
      // PLog::write("Not a problem: Try again for no '= or -' in encrypt string", "INFO");
      return encrypt_id($id, $prefix, $clear);
    } else {
      return $x;
    }
}
/*****
 *php可逆加密方法 解密
 *@param $data 加密内容
 *@param $key 密钥
 */
function decrypt($eid, $prefix="JHC"){
  // 默认ID都加密了，不允许ID直接访问
    if($_GET['id'] && is_numeric($_GET['id'])) {
      return 0;
    }
    if(strpos($eid, $prefix) === 0) {
      $eid = substr($eid, 3);
      return intval(Crypt::de($eid));
    }
    return $eid;
}

//openid解密
function openidjiema($open){
  $str4 = substr($open,0,10);
  $str5 = substr($open,11,7);
  $str6 = substr($open,19,11);
  return $d = $str4.$str5.$str6;
}

/*openid加密*/
function openidjiami($openid){
  $str1 = substr($openid,0,10);
$str2 = substr($openid,10,7);
$str3 = substr($openid,17,11);
$open = $str1."M".$str2."E".$str3;
return $open;
}

/*调用网络api借口*/
 function http_get($url){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }

//二维数组去掉重复值
function array_unique_fb($array2D,$name){  
     foreach ($array2D as $key => $value){
      $temp[$key]=$value[$name];
     }
     $temp = array_unique($temp);
     foreach ($temp as $key => $value) {
      $temp2[$key]['name']=$value;
      $temp2[$key]['type_id']=$array2D[$key]['type_id'];
     }
    return $temp2;
}

//字符串加密
function charEncrypt($data, $key = "klt") {
  $key = md5($key);
  $x  = 0;
  $len = strlen($data);
  $l  = strlen($key);
  for ($i = 0; $i < $len; $i++){
    if ($x == $l) {
         $x = 0;
    }
    $char .= $key{$x};
    $x++;
  }
  for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
  }
  return base64_encode($str);
}
//字符串解密
function charDecrypt($data, $key = "klt") {
  $key = md5($key);
  $x = 0;
  $data = base64_decode($data);
  $len = strlen($data);
  $l = strlen($key);
  for ($i = 0; $i < $len; $i++) {
    if ($x == $l) {
         $x = 0;
    }
    $char .= substr($key, $x, 1);
    $x++;
  }
  for ($i = 0; $i < $len; $i++) {
    if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
      $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
    } else {
      $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
    }
  }
  return $str;
}

 /**
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 */
function get_randomstr($lenth = 6, $type = 'all') {
    if ($type == 'num') {
        $str = '0123456789';
    } else if ($type == 'string') {
        $str = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
    } else {
        $str = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
    }
    return get_random($lenth, $str);
}


/**
* 产生随机字符串
*
* @param    int        $length  输出长度
* @param    string     $chars   可选的 ，默认为 0123456789
* @return   string     字符串
*/
function get_random($length, $chars = '0123456789') {
    $hash = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

//分页类功能
function getpage($count, $pagesize = 10) {
    $p = new Think\Page($count, $pagesize);
    //$p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
    $p->setConfig('prev', '上一页');
    $p->setConfig('next', '下一页');
    $p->setConfig('last', '末页');
    $p->setConfig('first', '首页');
    $p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
    $p->lastSuffix = false;//最后一页不显示为总页数
    return $p;
}


/**
* 生成二维码
*
* @param    string     $url   要转为二维码的地址
* @return   string     图片地址位置
* @param    string     $level   表示容错率，也就是有被覆盖的区域还能识别，分别是 L（QR_ECLEVEL_L，7%），M（QR_ECLEVEL_M，15%），Q（QR_ECLEVEL_Q，25%），H（QR_ECLEVEL_H，30%）
* @return   string     $size    图表示生成图片大小，默认是3
* @return   string     $margin  二维码周围边框空白区域间距值
*   
*/
  function codeimg($url){
    vendor("phpqrcode.phpqrcode");
    $QRcode = new \QRcode ();
    $level = 'L';
    $size = 4;
    $margin= 0;
    $path="/Uploads/code/".md5(microtime()).".jpg";
    $filename ='.'.$path;
    $QRcode::png($url, $filename, $level, $size, $margin);
    // $path=code_tie($path);
    return $path;
  }

/*二维码外链到贴图库*/
    function code_tie($file){
    include_once('./Public/uploadify/tietuku_sdk.php');
    define('MY_ACCESSKEY', '754efe46b0adb4ffc407a78cd52081c3613227ed');//获取地址:http://open.tietuku.com/manager
    define('MY_SECRETKEY', 'da39a3ee5e6b4b0d3255bfef95601890afd80709');//获取地址:http://open.tietuku.com/manager
    $ttk=new TTKClient(MY_ACCESSKEY,MY_SECRETKEY);
    $files='http://'.$_SERVER['HTTP_HOST'].$file;
    $res=$ttk->uploadFromWeb('1051794',$files);
    $ret=json_decode($res,true);
    return $ret['s_url'];
    }

/*数据时间转换预处理*/
  function datatime($data,$create_time){
   for ($i=0;$i<count($data);$i++){
    $data[$i][$create_time]=date('Y-m-d H:i:s',$data[$i][$create_time]);
   }
   return $data;
  }

/* 二维数组按指定的键值排序 
* $array 数组
* $key排序键值
* $type排序方式
*/
    function array_sort($arr, $keys, $type = 'desc') {
    $keysvalue = $new_array = array();
    foreach ($arr as $k => $v) {
        $keysvalue[$k] = $v[$keys];
    }
    if ($type == 'asc') {
        asort($keysvalue);
    } else {
        arsort($keysvalue);
    }
    reset($keysvalue);
    foreach ($keysvalue as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
    }


/**
 * 删除静态缓存文件
 * @param string $str 缓存路径
 * @param boolean $isdir 是否是目录
 * @param string $rules 缓存规则名
 * @return mixed
 */
function del_cache_html($str, $isdir = false, $rules = ''){
    //为空，且不是目录
    $delflag = true;
    if (empty($str) && !$isdir) {
        return;
    }
    $str_array = array();

    //更新静态缓存
    $html_cache_rules = get_meta_value('HTML_CACHE_RULES_COMMON');
    if (get_meta_value('HOME_HTML_CACHE_ON')) {
        $str_array[] = HTML_PATH.'Home/'. $str;
    }

    if (get_meta_value('MOBILE_HTML_CACHE_ON')) {
        $str_array[] = HTML_PATH.'Mobile/'. $str;
    }

    if (!empty($rules) && !isset($html_cache_rules[$rules])) {
        $delflag = false;//指定规则，如不存在则不用清除
    }else {
        $delflag = true;
    }

    if ($delflag) {
        foreach ($str_array as $v) {
            if ($isdir && is_dir($v)){
                del_dir_file($v, false);
            }else {
                $list = glob($v.'*');
                for ($i=0; $i < count($list) ; $i++) { 
                    if (is_file($list[$i])) {                 
                        unlink($list[$i]);
                    }
                }
            }

        }

    }

    
}

/**
 * 检测验证码
 */
function check_verify($code, $id = 1){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}


//生成微信的token
function create_token(){
  $AppId =C('WEIXIN_APPID');
  $AppSecret = C('WEIXIN_APPSECRET');
  $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$AppId.'&secret='.$AppSecret;
  $new_token = http_get('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$AppId.'&secret='.$AppSecret);
  $arr = json_decode($new_token, true);
  $access_token = $arr['access_token'];
  return $access_token;
}

//测试
function test(){
  return "1";
}