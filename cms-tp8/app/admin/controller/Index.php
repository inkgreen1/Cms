<?php

namespace app\admin\controller;

use app\common\AdminController;

class Index extends AdminController
{
    public function index()
    {
        // return view();
        return '后台admin 猫叔';
        // return '<style>*{ padding: 0; margin: 0; }</style><iframe src="https://www.thinkphp.cn/welcome?version=' . \think\facade\App::version() . '" width="100%" height="100%" frameborder="0" scrolling="auto"></iframe>';
    }

    public function hello($name = 'ThinkPHP8')
    {
        return 'hello,' . $name;
    }
}
