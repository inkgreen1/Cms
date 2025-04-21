<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\AdminController;

class Admin extends AdminController
{
    

    protected function initialize() {
        $this->model = new \app\admin\model\Admin;
        $this->field = ["username", "nickname", "id", "role_id", "lastlogintime"];
        $this->allowField = ['username', 'nickname', 'role_id','password'];
        
    }

    /**
     * 新增管理员
     */
    public function add()
    {
        $role_id = input('role_id');
        if ($role_id == 1) {
            return error('禁止添加超级管理员');
        }

        $password = input('post.password','123456');

        $this->modifyDatas = [
            "password"=>password_hash($password,PASSWORD_DEFAULT)
        ];

        return parent::add();
    }

    /**
     * 修改管理员
     *
     * @return void
     */
    public function edit()
    {
        $role_id = input('role_id');
        if ($role_id == 1) {
            return error('禁止修改超级管理员');
        }
        $password = input('post.password','');
        if( !empty($password) ){
            $this->modifyDatas = [
                "password"=>password_hash($password,PASSWORD_DEFAULT)
            ];
        }
        return parent::edit();
    }

    public function del() {
        $id = input('id');
        $role_id = $this->model->where('id',$id)->value('role_id');
        if ($role_id == 1) {
            return error('超级管理员不能删除');
        }
        return parent::del();
    }
    
}
