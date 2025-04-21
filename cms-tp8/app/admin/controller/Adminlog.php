<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\AdminController;

class Adminlog extends AdminController
{
    

    protected function initialize() {
        $this->model = new \app\admin\model\Adminlog;
        // $this->field = ["username", "nickname", "id", "role_id", "lastlogintime"];
        // $this->allowField = ['username', 'nickname', 'role_id','password'];
        
    }

     /**
     * 查看列表
     *
     * @return void
     */
    public function list()
    {

        $this->model = $this->model->with(['admin']);
        
        return parent::list();
    }
}