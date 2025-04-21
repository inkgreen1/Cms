<?php

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username' => 'require|length:3,20',
        'password' => 'require|length:6,30',
        'captcha' => 'require|captcha',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'username.require' => '用户名不能为空',
        'password.require' => '密码不能为空',
        'username.length' => '用户名长度为3-20位',
        'password.length' => '密码长度为6-30位',
        'captcha.require' => '验证码不能为空',
        'captcha.captcha' => '验证码错误',
    ];
}
