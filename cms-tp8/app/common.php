<?php
// 应用公共文件
if (!function_exists('success')) {

    function success($msg = 'success', $data = [], $code = 1,$total=0)
    {
        return json([
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'total' => $total,
        ]);
    }
}
if (!function_exists('error')) {
    function error($msg = 'error', $data = [], $code = 0)
    {
        return json([
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ]);
    }
}

if(!function_exists('buildTree')){
    function buildTree($array,$pid=0){
        $tree = [];
    
        foreach ($array as $key => $value) {
            if($value["pid"] == $pid){
                $children = buildTree($array,$value["id"]);
                if(!empty($children)){
                    $value["children"] = $children;
                }
                $tree[] = $value;
            }
        }
    
        return $tree;
    }
}
