<?php
//定义项目名称和路径
define('APP_NAME', 'Service');
define('APP_PATH', './');
define('RUNTIME_PATH','./Cache/'.APP_NAME.'/Runtime/' );
define('APP_DEBUG', false); //调试模式开关

// 加载框架入口文件
require("../ThinkPHP/ThinkPHP.php");