<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\AdminController;

class Loginlog extends AdminController
{

    protected function initialize() {
        $this->model = new \app\admin\model\Loginlog;
        $this->adminLimit = 'personal';   
    }

    
}