<?php

namespace app\index\controller;

use app\common\IndexController;

class Index extends IndexController
{
    public function index()
    {
        // return view();
        return '前台页面 猫叔'.$this->test;
        // return '<style>*{ padding: 0; margin: 0; }</style><iframe src="https://www.thinkphp.cn/welcome?version=' . \think\facade\App::version() . '" width="100%" height="100%" frameborder="0" scrolling="auto"></iframe>';
    }

    public function hello($name = 'ThinkPHP8')
    {
        return 'hello,' . $name;
    }
}
