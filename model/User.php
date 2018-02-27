<?php
class User extends Db
{
    /**
     * 表名
     *
     * @var string
     */
    public $table_name = 'user';

    /**
     * 保存用户信息
     *
     * @param string $phone 手机号
     * @param int    $sex   性别
     * @param string $pass  密码
     * @return bool 是否成功
     */
    public function save(string $phone, int $sex, string $pass): bool
    {
        $stmt = $this->prepare("INSERT INTO `@` (`phone`, `sex`, `pass`, `add_time`) VALUES (?, ?, ?, now());");
        $stmt->bind_param('sis', $_phone, $_sex, $_pass);
        $_phone = $phone;
        $_sex   = $sex;
        $_pass  = $pass;
        return $stmt->execute();
    }

    /**
     * 获取账号的密码
     *
     * @param string $phone
     * @return string
     */
    public function getPass(string $phone): string
    {
        $stmt = $this->prepare("SELECT `pass` FROM `@` WHERE `phone` = ?");
        $stmt->bind_param('s', $_phone);
        $_phone = $phone;
        $stmt->execute();
        $stmt->bind_result($pass);
        $stmt->fetch();
        $pass = is_null($pass) ? '' : $pass;
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
        $time = date('Y-m-d H:i:s', $time);
        $stmt = $this->prepare("UPDATE `@` SET `login_time` = ? WHERE `phone` = ?;");
        $stmt->bind_param('ss', $_time, $_phone);
        $_time  = $time;
        $_phone = $phone;
        return $stmt->execute();
    }


}
