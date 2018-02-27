<?php
/**
 * 用户控制器
 */
class UserController extends Controller
{
    /**
     * 注册用户
     *
     * @return array
     */
    public function register(): array
    {
        // 获取输入变量
        $phone = $_REQUEST['phone'] ?? '';
        $sex   = $_REQUEST['sex'] ?? '';
        $pass  = $_REQUEST['pass'] ?? '';

        // 验证数据
        if(!isPhone($phone)) {
            return [
                'status' => 0,
                'msg'    => '手机号码不正确'
            ];
        }
        if($sex != intval($sex) || !in_array($sex, [0, 1, 2])) {
            return [
                'status' => 0,
                'msg'    => '性别有误'
            ];
        }
        if(strlen($pass) < 6 || strlen($pass) > 16) {
            return [
                'status' => 0,
                'msg'    => '密码长度有误'
            ];
        }

        // 处理数据
        $pass = genPass($pass, $phone);
        $sex = intval($sex);

        // 写到数据库
        $user = new User();
        if(!$user->save($phone, $sex, $pass)){
            return [
                'status' => 0,
                'msg'    => '保存账号失败'
            ];
        }

        // 保存成功则修改Redis
        $status = new Status();
        if(!$status->save($phone, $sex, $pass)) {
            return [
                'status' => 0,
                'msg'    => '更新缓存失败'
            ];
        }

        return ['status' => 1, 'msg' => '注册成功'];
    }

    /**
     * 登录用户
     *
     * @return array
     */
    public function login(): array
    {

        // 获取输入变量
        $phone = $_REQUEST['phone'] ?? '';
        $pass  = $_REQUEST['pass'] ?? '';

        // 验证数据
        if(!isPhone($phone)) {
            return [
                'status' => 0,
                'msg'    => '手机号码不正确'
            ];
        }
        // 处理数据
        $pass = genPass($pass, $phone);

        // 先从Redis验证账号密码
        $status = new Status();
        $spass = $status->getPass($phone);
        if(!isset($spass['0'])) {
            $user = new User();
            $spass = $user->getPass($phone);
        }

        if($pass != $spass) {
            return [
                'status' => 0,
                'msg' => '密码错误或账号不存在'
            ];
        }

        // 更新登录时间
        $login_time = time();
        $status = $status ?? new Status();
        $r = $status->updateLogin($phone, $login_time);
        $user = $user ?? new User();
        $u = $user->updateLogin($phone, $login_time);

        // 设置过期时间
        $key = $status->getKey($phone);
        if(!$status->expire($key, core::$config['system']['redis_cache_time'])) {
            return false;
        }

        return [
                'status' => 1,
                'msg' => '登录成功'
            ];
    }

}
