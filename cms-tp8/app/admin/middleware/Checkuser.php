<?php
declare (strict_types = 1);

namespace app\admin\middleware;

class Checkuser
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
        //
        $token = $request->header('Authorization');
        if(!$token){
            return error('请求异常');
        }
        $info =  \app\service\JwtService::validateToken($token);
        if ($info) {
            if (config('app.ms.can_login_onlyone')) {
                // 仅能在1处登录
               $can =  cache("{$info["uid"]}") && $info["token"] == cache("{$info["uid"]}");                
            }
            else{
                $can = cache($info["token"]) && $info["uid"] == cache($info["token"]);
            }
            if($can){

                $request->uid = $info["uid"];
                $request->token = $info["token"];
                return $next($request);
            }
            else{
                return error('token已过期或者在他处登录');
            }
        } 
        else {
            return error('token已过期');
        }
    }
}
