<?php
$config = require './config.php';
$home_config = array(
    "DEFAULT_THEME"         => "default",    //默认模板主题名称
    'TMPL_CACHE_ON'         => false,        //开启模板缓存
    'URL_CASE_INSENSITIVE'  => true,         //URL不区分大小写
    //'URL_MODEL'           => 2,            //服务器开启Rewrite模块时，可去除URL中的index.php

);
return array_merge($config, $home_config);