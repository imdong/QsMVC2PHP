<?php

/**
 * 核心功能类
 */
class Core
{
    /**
     * 保存实例
     *
     * @var Core
     */
    private static $_instance = NULL;

    /**
     * 配置数据
     *
     * @var array
     */
    public static $config = [];

    /**
     * 访问路由信息
     *
     * @var array
     */
    public static $route = [
        'controller' => 'index',
        'action'     => 'index'
    ];

    /**
     * 私有化构造函数
     */
    private function __construct()
    {
    }

    /**
     * 禁止克隆
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * 初始化实例
     *
     * @return void
     */
    public static function init()
    {
        if(!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 获取路由
     *
     * @return array
     */
    public static function getRoute(): bool
    {
        /**
         * 获取路由
         */
        $controller = strtolower($_GET['c'] ?? self::$route['controller']);
        $action     = strtolower($_GET['a'] ?? self::$route['action']);

        /**
         * 校验路由
         */
        $pattern = '#^[a-z]([a-z0-9_]+)?$#';
        if(!preg_match($pattern, $controller)) {
            return false;
        }
        if(!preg_match($pattern, $action) || preg_match('#_$#', $action)) {
            return false;
        }

        // 处理路由规则
        $controller = preg_replace_callback('#(?:(?<s>^[a-z])|(?<c>_[a-z0-9]))#', function (array $matches): string
        {
            if(isset($matches['c'])) {
                return strtoupper($matches['c']['1']);
            } else if ($matches['s']) {
                return strtoupper($matches['s']);
            }
        }, $controller);

        // 再次验证路由
        if(!preg_match('#^[A-Z]([A-Za-z0-9_]+)?#', $controller)) {
            return false;
        }

        // 保存到全局
        self::$route['controller'] = $controller;
        self::$route['controller_class'] = $controller . 'Controller';
        self::$route['action']     = $action;

        return true;
    }

    /**
     * 启动项目
     *
     * @return void
     */
    public static function start()
    {
        // 先初始化
        self::init();

        // 加载配置
        self::$config = require COMMON_PATH . '/config.php';

        // 获取路由
        self::$route['controller'] = $_GET['c'] ?? self::$route['controller'];
        self::$route['action']     = $_GET['a'] ?? self::$route['action'];

        // 处理路由
        if(!self::getRoute())
            die('Route Error!');

        // 创建控制器类
        $controller = new self::$route['controller_class'];

        // 判断方法是否存在
        if(!method_exists($controller, self::$route['action'])) {
            die(sprintf('Action (%s) Not found!', self::$route['action']));
        }

        // 调用方法
        $return_obj = call_user_func([$controller, self::$route['action']]);

        // 是否Ajax
        if(isAjax()){
            header('Content-type: application/json');
            echo json_encode($return_obj);
        } else {
            echo $return_obj;
        }
        exit;
    }




}
