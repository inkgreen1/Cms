<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\common\AdminController;
use app\service\SmsService;

class Sms extends AdminController
{
    public function bindphone()
    {
        $phone = input('post.phone');
        if(cache('sms'.$phone)){
            return error('请稍后再试');
        }
        $code = rand(100000,999999);
        cache('bindphone'.$phone,$code,5*60);
        $res = SmsService::sendSmsCode($phone,$code);
        if($res["code"] == 1){
            return success('验证码已发送,请在5分钟内填写');
        }
        else{
            return error($res["msg"]);
        }
    }

    /**
     * 重置密码
     *
     * @return void
     */
    public function pwd()
    {
        $phone = input('post.phone');
        if(cache('sms'.$phone)){
            return error('请稍后再试');
        }
        if(!\app\admin\model\Admin::where('phone',$phone)->find()){
            return error('发送异常');
        }

        cache('sms'.$phone,$phone,60);
        $code = rand(100000,999999);
        cache('pwd'.$phone,$code,5*60);
        $res = SmsService::sendSmsCode($phone,$code);
        if($res["code"] == 1){
            return success('验证码已发送,请在5分钟内填写');
        }
        else{
            return error($res["msg"]);
        }
    }
}