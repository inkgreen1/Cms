<?php
declare (strict_types = 1);

namespace app\admin\middleware;

class Checkrole
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
       
        $role_id = (new \app\admin\model\Admin)->where('id',$request->uid)->value('role_id');
        $adminRules = (new \app\admin\model\Role)->where('id',$role_id)->value('rules');
        if($adminRules){
            $rules = explode(',',$adminRules);
        }
        else{
            $rules = (new \app\admin\model\Role)->ruleListArray();
        }

        $path = '/'.$request->pathinfo();

        if(in_array($path,$rules)){
            $request->rules = $rules;
            return $next($request);
        }
        
        return error('无权限',$path,$rules);
    }
}
