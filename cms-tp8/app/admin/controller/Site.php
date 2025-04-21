<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\AdminController;
use think\facade\Db;

class Site extends AdminController
{
    public function getinfo()
    {
      $data = Db::name('site')->where('id',1)->find();
      if($data){
        $data["status"] = (int)$data["status"] ;
      }
      return success('',$data);
    }

    public function save()
    {
        $datas = input('post.');
        $fileds = 'name,title,keywords,desc,record,psrecord,forbidip,status,favicon,logo';
        $datas = array_filter($datas,function($key)use($fileds){
            $arr = explode(',',$fileds );
            return in_array($key,$arr);
        },ARRAY_FILTER_USE_KEY);

        $rules = $this->request->rules;
        if(!in_array('/system/site/logo',$rules)){
          unset($datas['logo']);
        }
        if(!in_array('/system/site/status',$rules)){
          unset($datas['status']);
        }

        $res = Db::name('site')->where('id',1)->update($datas);
        if( $res){
            return success('更新成功');
        }
        return error('更新失败');
    }
}