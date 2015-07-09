<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	
    public function index(){
    	layout(false);
    	dump($ret);die;
    	$this->display();
    }

    public function test_add(){
    	$save['name']="kuang";
    	$save['create_time']=time();
    	$ret=M('Test')->add($save);
    	dump($ret);die;
    }

    public function test_red(){
    	// $ret=M('Test')->order('id desc')->find();
    	$ret=create_token();
    	$save['token']=$ret;
    	$save['create_time']=time();
    	$save=M('Save_token')->add($save);
    	dump(strlen($ret));
    	dump($ret);die;
    }

    public function createcode(){
        $url="http://www.kuanglitang.com/";
        $part=codeimg($url);
        dump($part);
    }

}