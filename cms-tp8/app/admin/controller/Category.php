<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\AdminController;

class Category extends AdminController
{
    

    protected function initialize() {
        $this->model = new \app\admin\model\Category;
        $this->allowField = ['pid', 'name', 'desc'];
    }
    
    

    /**
     * 获取父分类列表
     *
     * @return void
     */
    public function pidlist()
    {        
        $list = $this->model->where("pid",0)->select();
        return success('', $list);
    }

}
