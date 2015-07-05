<?php
return array(
	//'配置项'=>'配置值'
	// 允许访问的模块列表
	'MODULE_ALLOW_LIST'    =>    array('Home','Admin','Business'),
	'DEFAULT_MODULE'       =>    'Home',  // 默认模块
	//禁止访问的模块
	'MODULE_DENY_LIST'   => array('Common'),
	/* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'klt_home',
    'COOKIE_PREFIX'  => 'klt_home',
    'SESSION_OPTIONS' => array(
		'expire' => '86400',
		),
    //'COOKIE_EXPIRE'  =>  3600,//604800,    // Cookie有效期
	// 加载扩展配置文件
	'LOAD_EXT_CONFIG' => 'db', 
	//启用模板布局
	'LAYOUT_ON'      =>  true, // 是否启用布局
	'LAYOUT_NAME'    =>  'layout', // 当前布局名称 默认为layout
	//自定义用户id加密密钥
	'USER_ENCRYPT_KEY' => 'tang',
    'SHOW_PAGE_TRACE'=>true,//调试模式
    //'URL_HTML_SUFFIX'=>'',//伪静态的设置
	 /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => __ROOT__ . '/Public',
    ),
    //url访问方式 去掉index.php
   'URL_MODEL' => '2',
	//微信公众平台的appid和appsecret，这个是公众平台的，
	'WEIXIN_APPID' => 'wx8ebd8e856298a043',
    'WEIXIN_APPSECRET' => 'f7f149e33a9ccdf35422dbfe63286d2d',
    'token'=>'kuanglitang'

);