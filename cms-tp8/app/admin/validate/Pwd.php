<?php
declare (strict_types = 1);

namespace app\admin\validate;

use think\Validate;

class Pwd extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'newpwd'=>'require|length:6,30',
        'oldpwd'=>'require|length:6,30',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'newpwd.require' => '新密码不能为空',
        'oldpwd.require' => '旧密码不能为空',
    ];
}
