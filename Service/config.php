<?php
if(!defined('THINK_PATH')) exit();
return array(
    'DB_TYPE'       =>    'mysql',// 数据库类型    
    'DB_HOST'       =>    'localhost',// 数据库服务器地址
    'DB_NAME'       =>    'xpcms',// 数据库名称
    'DB_USER'       =>    'root',// 数据库用户名
    'DB_PWD'        =>    '',// 数据库密码
    'DB_PREFIX'     =>    'xp_',// 数据表前缀
    'DB_CHARSET'    =>    'utf8',// 网站编码
    'DB_PORT'       =>    '3306',// 数据库端口
    'APP_DEBUG'     =>  false,// 开启调试模式
    'XPCMS_URL'     =>  'http://www.xpcms.net',// 网站地址
    
    //网站系统设置
    'SITE_NAME'          =>  '',
    'SITE_KEYWORDS'      =>  '',
    'SITE_DESCRIPTION'   =>  '',
    'EMAIL'              => 'xp_zhu@qq.com',
    'OFFLINEMESSAGE'     =>    '本站正在维护中，暂不能访问。<br /> 请稍后再访问本站。',
    'ICP_NUM'            =>    '沪ICP备13032873号',
    'XPCMS_VERSION'      =>    '3.0'
);