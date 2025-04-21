<?php

// This file is auto-generated, don't edit it. Thanks.
namespace app\service;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use \Exception;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;

use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;

class SmsService {

    /**
     * 使用AK&SK初始化账号Client
     * @return Dysmsapi Client
     */
    public static function createClient(){
        // 工程代码泄露可能会导致 AccessKey 泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考。
        // 建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html。
        $config = new Config([
            // 必填，请确保代码运行环境设置了环境变量 ALIBABA_CLOUD_ACCESS_KEY_ID。
            "accessKeyId" => config('app.ms.aliyun_key_id'),
            // 必填，请确保代码运行环境设置了环境变量 ALIBABA_CLOUD_ACCESS_KEY_SECRET。
            "accessKeySecret" => config('app.ms.aliyun_key_secret')
        ]);
        // Endpoint 请参考 https://api.aliyun.com/product/Dysmsapi
        $config->endpoint = "dysmsapi.aliyuncs.com";
        return new Dysmsapi($config);
    }

    /**
     * @param string[] $args
     * @return void
     */
    public static function sendSmsCode($phone,$code,$templateCode="SMS_154950909"){
        $client = self::createClient();
        $sendSmsRequest = new SendSmsRequest([
            "signName" => "阿里云短信测试",
            "templateCode" => $templateCode,
            "phoneNumbers" => $phone,
            "templateParam" => json_encode([
                "code"=>$code
            ])
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $res = $client->sendSmsWithOptions($sendSmsRequest, $runtime);
            if($res->statusCode == 200){
                if($res->body->code == 'OK'){
                    return [
                        "code"=>1,
                        "msg"=>"发送成功"
                    ];
                }
                else{
                    return [
                        "code"=>0,
                        "msg"=>$res->body->message
                    ];
                }
                
            }
            else{
                return [
                    "code"=>0,
                    "msg"=>"发送失败"
                ];
            }
        }
        catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }

            return [
                "code"=>0,
                "msg"=>$error->message
            ];
            // 此处仅做打印展示，请谨慎对待异常处理，在工程项目中切勿直接忽略异常。
            // 错误 message
            // var_dump($error->message);
            // // 诊断地址
            // var_dump($error->data["Recommend"]);
            // Utils::assertAsString($error->message);
        }
    }
}
// $path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
// if (file_exists($path)) {
//     require_once $path;
// }
// Sample::main(array_slice($argv, 1));