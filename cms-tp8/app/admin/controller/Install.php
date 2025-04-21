<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\facade\Db;
class Install
{
    protected function compare($v1 , $v2)
    {
      if($v1 == $v2){
        return true;
      }

      $v1 = explode('.',$v1);
      $v2 = explode('.',$v2);

      for($i=0;$i<count($v1);$i++){
        if(!isset($v2[$i])){
            break;
        }
        if($v1[$i] < $v2[$i]){
          return true;
        }else if($v1[$i] > $v2[$i]){
          return false;
        }
      }

    }

    protected function testDatabase($database)
    {
      $config = config('database.connections.mysql');
      config(["connections"=>["mysql"=>array_merge($config,$database)]],"database");
      try {
        $connect = Db::connect('mysql');
        $connect->execute('SELECT 1');
        return $connect;
      } catch (\Throwable $th) {
        //throw $th;
        $msg = $th->getMessage();
        if(strpos($msg,'using password') !== false){
            return "请检查数据库密码是否正确";
        }
        return $msg;
      }
      
    //   return config('database');
    }
    public function index()
    {
        $lockFile = app_path().'/view/install/install.lock';
        if(file_exists($lockFile)){
            return "已安装过，禁止重复安装！";
        }
        
        if(request()->isPost()){
            $database = [
                'hostname' => input('hostname'),
                'username' => input('username'),
                'password' => input('password'),
                'hostport' => input('hostport'),
                'type' => 'mysql',
                'database'=>''
            ];

            $connect = $this->testDatabase($database);
            if(!is_object($connect)){
                return error( $connect );
            }
            $database["database"] = input('database');

            $pdo = $connect->getPdo();

            try {
                if($pdo->query("USE `{$database['database']}`")){
                    return error( "数据库{$database['database']} 已存在" );
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            $sql = "CREATE DATABASE IF NOT EXISTS `{$database['database']}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
            $pdo->exec($sql);

            $pdo->query("USE `{$database['database']}`");

            $sqlFile = app_path().'/view/install/cmsms-install.sql';

            $prefix = input('prefix');
            $sqlContent = file_get_contents($sqlFile);
            $sqlContent = str_replace('ms_',$prefix,$sqlContent);

            $sql_arr = explode(';', $sqlContent);
            $success = [];
            $error = [];
            foreach ($sql_arr as $key => $sql) {
                if(trim( $sql ) != ''){
                    try {
                        $pdo->exec($sql);
                        $success[] = $sql;
                    } catch (\Throwable $th) {
                        //throw $th;
                        $error[] = $sql.' --- '.$th->getMessage();
                    }
                }
            }

            $app_debug = input('app_debug',true);
            $app_debug = $app_debug?'true':'false';
            $envConfig = 
"APP_DEBUG = $app_debug

DB_TYPE = mysql
DB_HOST = {$database['hostname']}
DB_NAME = {$database['database']}
DB_USER = {$database['username']}
DB_PASS = {$database['password']}
DB_PORT = {$database['hostport']}
DB_PREFIX = {$prefix}
DB_CHARSET = utf8
            ";
            $envPath = root_path().'.env';
            $result = file_put_contents($envPath,$envConfig);
            if($result){
                $res = Db::name('admin')->update([
                    "id"=>1,
                    "username"=>input('adminname','admin'),
                    "password"=>password_hash(input('adminpwd','123456aA'),PASSWORD_DEFAULT),
                ]);
                if($res){

                    file_put_contents($lockFile,'1');

                    return success('成功', [$success,$error]);
                }
                else{
                    return error('写入管理员信息失败');
                }
            }
            return error('写入配置文件失败');
        }

        $phpversion = phpversion();
        // 8.2.22
        if(!$this->compare('8.0.0',$phpversion)){
            return "请升级php版本到8.0以上";
        }
        
        $phpPdo = extension_loaded("PDO") && extension_loaded('pdo_mysql');
        if(!$phpPdo){
            return "请先安装pdo扩展";
        }
        // dd(extension_loaded("pdo_mysql"));
        return view();
    }
}