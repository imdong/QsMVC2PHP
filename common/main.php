<?php
// 开启严格模式
declare(strict_types=1);

// 公共目录
define('COMMON_PATH', __DIR__);

// 核心目录
define('CORE_PATH', COMMON_PATH . '/core');

// 控制器目录
define('CONTROLLER_PATH', ROOT_PATH . '/controller');

// 模型目录
define('MODEL_PATH', ROOT_PATH . '/model');

// 视图目录
define('VIEW_PATH', ROOT_PATH . '/view');

// 引入核心文件
require COMMON_PATH . '/common.php';

// 启动对象
Core::start();
