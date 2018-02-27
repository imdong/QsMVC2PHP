<?php
/**
 * 配置文件
 */

return [
    // 数据库配置
    'db' => [
        'host'   => 'localhost',
        'user'   => 'demo',
        'pass'   => '8a6GnzdrXMKc',
        'name'   => 'demo',
        'prefix' => 'demo_machine1_'
    ],
    // Redis 配置
    'redis' => [
        'host'   => 'localhost',
        'port'   => 6379,
        'index'  => 1,
        'prefix' => 'demo_machine1::'
    ],
    // 系统配置
    'system' => [
        'pass_salt'        => 'CnhoF0TJ3T', // 密码加盐
        'redis_cache_time' => 60 * 10, // Redis过期时间
    ]
];
