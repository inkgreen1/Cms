<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\AdminController;

class Content extends AdminController
{
    

    protected function initialize() {
        $this->model = new \app\admin\model\Content;
        $this->allowField = ['title', 'subtitle', 'coverimage', 'category_id', 'tag', 'author', 'clicknum', 'desc', 'content', 'status'];
        
        $this->withoutField = ['content'];
    }

    /**
     * 查看列表
     *
     * @return void
     */
    public function list()
    {

        $this->model = $this->model->with(['category']);
        
        return parent::list();
    }

    /**
     * 添加
     *
     * @return void
     */
    public function add()
    {
        array_push($this->allowField, 'admin_id');
        return parent::add();
    }

    /**
     * 修改状态
     *
     * @param [type] $id
     * @return void
     */
    public function changestatus($id = null)
    {
      if($id){
        $status = $this->model->where('id',$id)->value('status');
        $status = $status == 1 ? 0 : 1;
        $res = $this->model->where('id',$id)->update(['status'=>$status]);
        if($res){
            return success('修改成功');
        }else{
            return error('修改失败');
        }
      }
    }

    /**
     * 审核内容
     *
     */
    public function changeaudit($id = null, $audit=0)
    {
      if($id){
        $saveData = [
            "audit"=> $audit
        ];
        if($audit == 2){
            $reason = input('post.reason');
            if(empty($reason)){
                return error("请填写拒绝原因");
            }

            $saveData["reason"] = $reason;
        }
        $res = $this->model->where('id',$id)->update($saveData);
        if($res){
            return success('审核成功');
        }else{
            return error('审核失败');
        }
      }
    }

    /**
     * 获取内容
     *
     * @param [type] $id
     * @return void
     */
    public function getcontent($id = null){
        $content = $this->model->where('id',$id)->value('content');
        return success('', ["content"=> $content ?? '']);
    }

}
