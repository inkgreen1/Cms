<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\AdminController;
use app\admin\validate\Personal as PersonalValidate;
use app\admin\validate\Pwd as PwdValidate;

class Personal extends AdminController
{
    

    protected function initialize() {
        $this->model = new \app\admin\model\Admin;
    }
    
    /**
     * 修改个人信息
     *
     * @return void
     */
    public function saveinfo()
    {
      $datas = input('post.');
      
      try {        
        validate(PersonalValidate::class)->check($datas);
      } catch (\Throwable $th) {
        return error($th->getMessage());
      }


      $res = $this->model->update($datas,["id"=>$this->userid],["nickname","username","avatar"]);
      if($res){
        return success('修改成功');
      }
      else{
        return error("修改失败");
      }
    }
    
    /**
     * 修改密码
     *
     * @return void
     */
    public function resetpwd()
    {
      $datas = input('post.');
      
      try {        
        validate(PwdValidate::class)->check($datas);
      } catch (\Throwable $th) {
        return error($th->getMessage());
      }

      $user = $this->getUser();
      if (!password_verify($datas["oldpwd"], $user->password)) {
        return error("旧密码错误");
      }
      $newPasword = password_hash($datas["newpwd"],PASSWORD_DEFAULT);   
      $res = $this->model->update([
        "password"=>$newPasword
      ],["id"=>$this->userid]);
      if($res){
        return success('修改成功');
      }
      else{
        return error("修改失败");
      }
    }

    public function bindphone()
    {
      $phone = input('phone');
      $code = input('code');
      if(cache('bindphone'.$phone) && $code == cache('bindphone'.$phone)){
        $res = $this->model->update([
          "phone"=>$phone
        ],["id"=>$this->userid]);

        if($res){
          return success('绑定成功');
        }
        else{
          return error("绑定失败");
        }
      }
      else{

        return error("验证码错误");
      }
    }
}
