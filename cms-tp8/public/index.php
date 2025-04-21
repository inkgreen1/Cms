<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

require __DIR__ . '/../vendor/autoload.php';

if($_SERVER["REQUEST_URI"] == '/'){
    $DS = DIRECTORY_SEPARATOR;
    $appPath = $_SERVER["DOCUMENT_ROOT"].$DS.'..'.$DS.'app';
    $filePath = "$appPath{$DS}admin{$DS}view{$DS}install{$DS}install.lock";
    if(!file_exists($filePath)){
        header("Location: /admin/install");
        die;
    }
}
// 执行HTTP应用并响应
$http = (new App())->http;

$response = $http->run();

$response->send();

$http->end($response);
