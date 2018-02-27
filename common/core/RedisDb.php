<?php
/**
 * Redis 基类
 */
class RedisDb extends Redis
{
    /**
     * 是否已连接
     *
     * @var bool
     */
    private $is_connect = false;

    /**
     * 构造函数
     */
    public function __construct()
    {
        // 连接到数据库
        if(!$this->is_connect) {
            if(!$this->connect(Core::$config['redis']['host'], Core::$config['redis']['port'])) {
                die('RedisDb Connect Error.');
            }
            $this->is_connect = true;

            // 选择库ID
            $this->select(Core::$config['redis']['index']);
        }
    }

    /**
     * 获取储存键名
     *
     * @param string $key
     * @return string
     */
    public function getKey(string $key): string
    {
        return sprintf('%s%s', Core::$config['redis']['prefix'], $key);
    }

}
