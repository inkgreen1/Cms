<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\Request;
use app\common\AdminController;

class Role extends AdminController
{
    protected function initialize() {
        $this->model = new \app\admin\model\Role;
        $this->allowField = ['pid', 'name', 'rules'];       
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function getrulelistbyid()
    {
        //
        $rules = $this->model->ruleListArray();
        $id = input('id/d');
        if($id){
            $adminRules = $this->model->where('id',$id)->value('rules');
            if($adminRules){
                $rules = explode(',',$adminRules);
            }
        }

        // 如果只返回子路由，那么就进行过滤
        $onlychildren = input('onlychildren/d',1);
        if($onlychildren === 1){
            $rules = array_filter($rules,function($item){
                $arr = explode('/',$item);
                return count($arr)>2;
            });
            $rules = array_values($rules);
        }
        else{
            //  /  content  / list
            if(isset($adminRules)){
                $rules0 = [];
                foreach ($rules as $key => $value) {
                    $arr = explode('/',$value);
                    $str = '/'.$arr[1];
                    if(!in_array($str,$rules0)){
                        $rules0[] = $str;
                    }
                }

                $rules = array_merge($rules,$rules0);
            }
        }

        return success('',[
            "rules" => $rules
        ]);
    }

    public function list()
    {
        // $str = '[{
        //     "name": "超级管理组",
        //     "id": 1,
        //     "pid": 0,
        //     "edit": false,
        //     "del": false,
        //     "children": [{
        //         "name": "二级管理组1",
        //         "id": 2,
        //         "pid": 1,
        //         "children": [{
        //             "name": "三级管理组1",
        //             "id": 21,
        //             "pid": 2
        //         }, {
        //             "name": "三级管理组2",
        //             "id": 22,
        //             "pid": 2
        //         }]
        //     }, {
        //         "name": "二级管理组2",
        //         "id": 3,
        //         "pid": 1,
        //         "children": [{
        //             "name": "三级管理组3",
        //             "id": 31,
        //             "pid": 3
        //         }]
        //     }]
        // }]';
        $list = $this->model->select();
        $data = buildTree($list);
        if(isset($data[0])){
            $data[0]["edit"] =false;
            $data[0]["del"] =false;
        }

        return success('', $data);
    }

    public function add()
    {
        $pid = input('pid/d');
        if($pid == 0){
            return error('参数错误');
        }
        return parent::add();

    }

    public function edit()
    {
        $pid = input('pid/d');
        if($pid == 0){
            return error('参数错误');
        }
        return parent::edit();

    }

    public function del()
    {
        $id = input('id/d');
        if($this->model->where('id',$id)->value('pid') == 0){
            return error('参数错误');
        }
        if($this->model->where('pid',$id)->find()){
            return error('请先删除子级');
        }
        return parent::del();

    }

    public function getrulelist()
    {
        $data = $this->model->ruleListTree();
        $pid = input('get.pid/d');
        if( $pid ){
           $adminRules = $this->model->where('id',$pid)->value('rules');
           if($adminRules){
               $adminRulesArr = explode(',', $adminRules);
               foreach ( $data as $key => &$value) {
                if($value["children"]){
                    foreach ($value["children"] as $k => &$v) {
                        if(!in_array($v["rule"],$adminRulesArr)){
                            $v["disabled"] = true;
                        }
                    }
                }
               }
           }
        }
        return success('',$data);
    }
}
