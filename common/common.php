<?php
// 开启严格模式
declare(strict_types=1);

/**
 * 注册 自动加载
 */
spl_autoload_register(function(string $class)
{
    /**
     * 定义加载列表
     */
    static $load_list = [
        CORE_PATH . '/%s.php',
        CONTROLLER_PATH . '/%s.php',
        MODEL_PATH . '/%s.php'
    ];

    // 遍历列表寻找
    foreach ($load_list as $load_tpl) {
        $file_name = sprintf($load_tpl, $class);
        if(file_exists($file_name)) {
            require $file_name;
            return;
        }
    }

    // 报错
    die(sprintf('Autoload Error: File (%s) Not found.', $class));
});

/**
 * 判断是否为Ajax请求
 *
 * @return bool
 */
function isAjax(): bool
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

/**
 * 生成密码(md5)
 *
 * @param string $pass  密码原文
 * @param string $phone 手机哈嘛
 * @return string 密码md5
 */
function genPass(string $pass, string $phone): string
{
    return md5(Core::$config['system']['pass_salt'] . md5($pass) . $phone);
}

/**
 * 验证是否手机号
 *
 * @param string $phone 是否为手机号
 * @return bool
 */
function isPhone(string $phone): bool
{
    return preg_match('#^1[0-9]{10}$#', $phone) > 0;
}
