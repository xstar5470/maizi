<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\17 0017
 * Time: 18:20
 */

namespace App\Http\Services;

class TokenService
{
    public function generateToken(){
        $rand_char = getRandChar(32);
        $salt = config('secure.token_salt');
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        return md5($rand_char.$salt.$timestamp);
    }

}