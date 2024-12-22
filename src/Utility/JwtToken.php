<?php

namespace App\Utility;

use Cake\Core\Configure;
use Firebase\JWT\JWT;

class JwtToken
{

    private static $key =  Configure::read('Security.jwtKey');

    public static function generateToken($user): string
    {

        $payload = [
            'sub' => $user['id'],
            'email' => $user['email'],
            'iat' => time(),
            'exp' => time() + 3600, // 1 hour expiration
        ];

        return JWT::encode($payload, self::$key, 'HS256');

    }
}
