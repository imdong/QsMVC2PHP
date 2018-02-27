<?php
/**
 * 状态类
 */
class Status extends RedisDb
{
    /**
     * 保存状态
     *
     * @param string $phone 手机号码
     * @return bool  状态
     */
    public function save(string $phone, int $sex, string $pass): bool
    {
        // 获取Key名
        $key = $this->getKey($phone);

        // 保存数据
        $ret = $this->hMSet($key, [
            'pass' => $pass,
            'login_time' => date('Y-m-d H:i:s')
        ]);

        // 是否保存成功
        if(!$ret) {
            return false;
        }

        // 设置过期时间
        if(!$this->expire($key, Core::$config['system']['redis_cache_time'])) {
            return false;
        }

        return true;
    }

    /**
     * 获取账号的密码
     *
     * @param string $phone
     * @return string
     */
    public function getPass(string $phone): string
    {
        // 获取Key名
        $key = $this->getKey($phone);
        $pass = $this->hGet($key, 'pass');
        return $pass;
    }

    /**
     * 更新登录时间
     *
     * @param string $phone
     * @param int    $time
     * @return bool
     */
    public function updateLogin(string $phone, int $time): bool
    {
        // 获取Key名
        $key = $this->getKey($phone);

        $time = date('Y-m-d H:i:s', $time);

        return $this->hSet($key, 'login_time', $time);
    }



}
