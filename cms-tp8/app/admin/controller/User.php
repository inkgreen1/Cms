<?php

namespace app\admin\controller;

use app\common\AdminController;
use app\admin\model\Admin;
use app\admin\validate\User as UserValidate;
use think\captcha\facade\Captcha;

class User extends AdminController
{
    /**
     * 管理员登录接口
     *
     * @return void
     */
    public function login()
    {
        $datas = input('post.');

        try {
            validate(UserValidate::class)->check($datas);
        } catch (\Throwable $th) {
            // throw $th;
            return error($th->getMessage());
        }

        if ($user = Admin::where('username', $datas["username"])->find()) {

            if (password_verify($datas["password"], $user->password)) {
                $token =(String)\Ramsey\Uuid\Uuid::uuid4();
                $jwtToken = \app\service\JwtService::setToken($user->id, $token);

                // operate,ip,ua,createtime,admin_id
                \app\admin\model\Loginlog::create([
                    "operate" => "登录",
                    "ip"=>request()->ip(),
                    "ua"=>request()->header('user-agent'),
                    "admin_id"=>$user->id
                ]);

                return success('登录成功', ["token" => $jwtToken]);
            } else {
                return error('用户名或密码错误');
            }
        } else {
            return error('用户名或密码错误');
        }
    }

    public function logout()
    {
        \app\service\JwtService::delToken($this->userid,$this->token);
        \app\admin\model\Loginlog::create([
            "operate" => "退出",
            "ip"=>request()->ip(),
            "ua"=>request()->header('user-agent'),
            "admin_id"=>$this->userid
        ]);
        return success('退出成功');
    }

    /**
     * 获取管理员信息
     *
     * @return void
     */
    public function userinfo()
    {

        $uid = $this->userid;
        $token = $this->token;
        $jwtToken = \app\service\JwtService::setToken($uid, $token);

        $user = Admin::where('id', $uid)->find();
        return success('获取成功', [
            "username" => $user["username"],
            "nickname" => $user["nickname"],
            "phone" => $user["phone"],
            "userid" => $user["id"],
            "avatar" => $user["avatar"],
            "role_id" => $user["role_id"],
            "token" => $jwtToken,
        ]);
        
    }

    /**
     * 生产验证码图片
     *
     * @return String
     */
    public function captcha()
    {
        // return captcha_img();
        return Captcha::create();
    }

    /**
     * 用验证码重置密码
     *
     * @return void
     */
    public function resetpwd()
    {
        $phone = input('phone');
        $code = input('code');
        if(cache('pwd'.$phone) && $code == cache('pwd'.$phone)){
            if($user = Admin::where('phone',$phone)->find()){

                $password = input('password');
                $res = Admin::update([
                "password"=>password_hash($password,PASSWORD_DEFAULT)
                ],["id"=>$user["id"]]);
    
                if($res){
                    return success('重置成功');
                }
                else{
                    return error("重置失败");
                }
            }
            else{
                return error("用户不存在");
            }
        }
        else{

            return error("验证码错误");
        }
    }
}
