<?php
declare (strict_types = 1);

namespace app\service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private const SECRET_KEY = 'aB9ZkLmNpQrStUvWxYz01G2H3J4K5M6O7P8'; // 更改为你自己的密钥
    private const EXP = 60 * 60;
    /**
     * 生成 JWT token
     *
     * @param array $payload
     * @return string
     */
    public static function createToken(array $payload): string
    {
        $payload['exp'] = time() + (self::EXP); // 设置过期时间为一小时
        return JWT::encode($payload, self::SECRET_KEY, 'HS256');
    }

    /**
     * 验证 JWT token
     *
     * @param string $token
     * @return mixed
     */
    public static function validateToken(string $token)
    {
        try {
            $decoded = JWT::decode($token, new Key(self::SECRET_KEY, 'HS256'));
            return (array)$decoded;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function setToken($uid,$token)
    {
        $jwtToken = self::createToken([
            "uid" => $uid,
            "token" => $token
        ]);
        if(config('app.ms.can_login_onlyone')){
            // 仅能在一处登录
            cache("$uid",$token, self::EXP);
        }
        else{
            cache($token, $uid, self::EXP);
        }
        return $jwtToken;
    }

    public static function delToken($uid,$token)
    {
        if(config('app.ms.can_login_onlyone')){
            // 仅能在一处登录
            cache("$uid",NULL);
        }
        else{
            cache($token, NULL);
        }
    }

}
