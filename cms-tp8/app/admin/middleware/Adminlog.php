<?php
declare (strict_types = 1);

namespace app\admin\middleware;

class Adminlog
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
        // trace('前置 管理员日志中间件'.$request->method(),'error');
        $response = $next($request);
        if($request->isPost() && !str_ends_with($request->url(),'/list') && !str_ends_with($request->url(),'/install')){
            $model = new \app\admin\model\Adminlog;
            $adminId = $request->uid ?? 0;
            $rulesObj = (new \app\admin\model\Role)->ruleListObject();
            // trace( $rulesObj,'error');
            $path = '/'.$request->pathinfo();
            $title = $rulesObj[$path] ?? $path;
            $data = $request->param();
            $data = is_scalar($data)?$data:json_encode($data);
            $model->create([
                "admin_id"=>$adminId,
                "url"=>substr($request->url(),0,255),
                "title"=>$title,
                "data"=>$data,
                "ip"=>$request->ip(),
                "useragent"=>substr($request->server("HTTP_USER_AGENT"),0,255),
            ]);
        }
        return $response;
    }
}
