<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * Crypt 加密实现类
 * @category   ORG
 * @package  ORG
 * @subpackage  Crypt
 * @author    liu21st <liu21st@gmail.com>
 */
class Crypt {

    /**
     * 加密字符串
     * @access static
     * @param string $str 字符串
     * @param string $key 加密key
     * @return string
     */
  //   function encrypt($str,$key,$toBase64=false){
  //       $r = md5($key);
  //       $c=0;
  //       $v = "";
		// $len = strlen($str);
		// $l = strlen($r);
  //       for ($i=0;$i<$len;$i++){
  //        if ($c== $l) $c=0;
  //        $v.= substr($r,$c,1) .
  //            (substr($str,$i,1) ^ substr($r,$c,1));
  //        $c++;
  //       }
  //       if($toBase64) {
  //           return base64_encode(self::ed($v,$key));
  //       }else {
  //           return self::ed($v,$key);
  //       }
  //   }

    /**
     * 解密字符串
     * @access static
     * @param string $str 字符串
     * @param string $key 加密key
     * @return string
     */
  //   function decrypt($str,$key,$toBase64=false) {
  //       if($toBase64) {
  //           $str = self::ed(base64_decode($str),$key);
  //       }else {
  //           $str = self::ed($str,$key);
  //       }
  //       $v = "";
		// $len = strlen($str);
  //       for ($i=0;$i<$len;$i++){
  //        $md5 = substr($str,$i,1);
  //        $i++;
  //        $v.= (substr($str,$i,1) ^ $md5);
  //       }
  //       return $v;
  //   }

   // function ed($str,$key) {
   //    $r = md5($key);
   //    $c=0;
   //    $v = "";
	  // $len = strlen($str);
	  // $l = strlen($r);
   //    for ($i=0;$i<$len;$i++) {
   //       if ($c==$l) $c=0;
   //       $v.= substr($str,$i,1) ^ substr($r,$c,1);
   //       $c++;
   //    }
   //    return $v;
   // }


   //密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,-
   static $lockstream = 'st=lDEFABCNOPyzghi_jQRpqr89LMmGH012345uvST-UwxkVWXYZabcdefIJK67no';
   //加密
   public function en($txtStream,$password){
       //随机找一个数字，并从密锁串中找到一个密锁值
       $lockLen = strlen(self::$lockstream);
       $lockCount = rand(0,$lockLen-1);
       $randomLock = self::$lockstream[$lockCount];
       //结合随机密锁值生成MD5后的密码
       $password = md5($password.$randomLock);
       //开始对字符串加密
       $txtStream = base64_encode($txtStream);
       $tmpStream = '';
       $i=0;$j=0;$k = 0;
       for ($i=0; $i<strlen($txtStream); $i++) {
           $k = $k == strlen($password) ? 0 : $k;
           $j = (strpos(self::$lockstream,$txtStream[$i])+$lockCount+ord($password[$k]))%($lockLen);
           $tmpStream .= self::$lockstream[$j];
           $k++;
       }
       return $tmpStream.$randomLock;
   }

   public function de($txtStream,$password){
       $lockLen = strlen(self::$lockstream);
       //获得字符串长度
       $txtLen = strlen($txtStream);
       //截取随机密锁值
       $randomLock = $txtStream[$txtLen - 1];
       //获得随机密码值的位置
       $lockCount = strpos(self::$lockstream,$randomLock);
       //结合随机密锁值生成MD5后的密码
       $password = md5($password.$randomLock);
       //开始对字符串解密
       $txtStream = substr($txtStream,0,$txtLen-1);
       $tmpStream = '';
       $i=0;$j=0;$k = 0;
       for ($i=0; $i<strlen($txtStream); $i++) {
           $k = $k == strlen($password) ? 0 : $k;
           $j = strpos(self::$lockstream,$txtStream[$i]) - $lockCount - ord($password[$k]);
           while($j < 0){
               $j = $j + ($lockLen);
           }
           $tmpStream .= self::$lockstream[$j];
           $k++;
       }
       return base64_decode($tmpStream);
   }

}