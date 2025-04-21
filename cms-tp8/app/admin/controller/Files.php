<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\AdminController;

class Files extends AdminController
{
    

    protected function initialize() {
        $this->model = new \app\admin\model\Files;
        // $this->field = ["username", "nickname", "id", "role_id", "lastlogintime"];
        // $this->allowField = ['username', 'nickname', 'role_id','password'];
        
    }

    public function del()
    {
        $id = input('id/d');
        $url = $this->model->where('id',$id)->value('url');
        if($url){
            $path = public_path().$url;
            if(file_exists($path)){
                unlink($path);
            }
        }
        return parent::del();
    }
}