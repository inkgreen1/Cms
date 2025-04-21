<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\common\AdminController;

class Upload extends AdminController
{
    public function file($category = 'default'){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        if($file){
            try {
                $fileSize = 1024*1024*10;
                validate([
                    'file' => 'fileSize:'. $fileSize . '|fileExt:jpg,png|fileMime:image/jpeg,image/png'
                ])
                ->check([
                    'file'=> $file
                ]);
                
            } catch (\think\exception\ValidateException $e) {
                return error($e->getMessage());
            }
    
            // 上传到本地服务器
            $savename = \think\facade\Filesystem::disk('public')->putFile( "$category", $file);
            
            $domain = request()->domain();
            $url = \think\facade\Filesystem::getDiskConfig('public', 'url') .DIRECTORY_SEPARATOR. $savename;

            // createtime,category,admin_id,url,mimetype,storage,sha1
            \app\admin\model\Files::create([
                "category"=> $category,
                "admin_id"=> $this->userid,
                "url"=> $url,
                "mimetype"=> $file->getMime(),
                "name"=> $file->getOriginalName(),
                "storage"=> 'local',
                "sha1"=> $file->hash('sha1')
            ]);
            return success('成功', ["url"=> $domain . $url,"localUrl"=> $url]);
        }
    }

    public function files($category = 'default')
    {
        // 获取表单上传文件 例如上传了001.jpg
        $files = request()->file();
        if ($files) {
            try {
                $fileSize = 1024 * 1024 * 10;
                validate([
                    'files' => 'fileSize:' . $fileSize . '|fileExt:jpg,png|fileMime:image/jpeg,image/png'
                ])
                    ->check($files);
            } catch (\think\exception\ValidateException $e) {
                return error($e->getMessage());
            }

            $domain = request()->domain();
            $publicUrl = \think\facade\Filesystem::getDiskConfig('public', 'url') . DIRECTORY_SEPARATOR;


            $result = [];
            $saveDatas = [];
            foreach ($files["files"] as $file) {
                # code...
                // 上传到本地服务器
                $savename = \think\facade\Filesystem::disk('public')->putFile("$category", $file);
                $url = $publicUrl. $savename;
                $result[]=[
                    "url"=>
                    $domain.$url,
                    "localUrl"=> $url,
                    "name"
                    => $file->getOriginalName(),
                ];


                $saveDatas[] = [
                    "category" => $category,
                    "admin_id" => $this->userid,
                    "url" => $url,
                    "mimetype" => $file->getMime(),
                    "name" => $file->getOriginalName(),
                    "storage" => 'local',
                    "sha1" => $file->hash('sha1')
                ];
            }

            

           

            // createtime,category,admin_id,url,mimetype,storage,sha1
            (new \app\admin\model\Files)->saveAll($saveDatas);
            return success('成功', $result);
        }
    }
}
?>