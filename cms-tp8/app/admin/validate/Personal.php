<?php
declare (strict_types = 1);

namespace app\admin\validate;

use think\Validate;

class Personal extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username'=>'require|length:3,20',
        'nickname'=>'require',
        'avatar'=>'require|url',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'username.require' => '用户名不能为空',
        'nickname.require' => '昵称不能为空',
        'avatar.require' => '头像不能为空',
        'avatar.url' => '头像的格式不正确',
    ];
}
