<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\17 0017
 * Time: 18:20
 */

namespace App\Http\Services;

use App\Http\Models\User;

class UserService extends TokenService
{
    private $wx_appid;
    private $wx_app_secret;
    private $wx_login_url;
    public function __construct($code)
    {
        $this->wx_appid = config('wx.appid');
        $this->wx_app_secret = config('wx.secret');
        $this->wx_login_url = sprintf(config('wx.login_url'),$this->wx_appid,$this->wx_app_secret,$code);
    }

    public function getToken(){
          $result = curl_get($this->wx_login_url);
          $wx_result = json_decode($result,true);
          if(!$wx_result){
              return err('','微信连接无响应');
          }
          $login_fail = array_key_exists('errcode',$wx_result);
          if($login_fail){
              $msg = $wx_result['errmsg'];
              return err('',$msg);
          }else{
              return $this->grantToken($wx_result);
          }

    }

    public function grantToken($wx_result){
        $openid = $wx_result['openid'];
        $user = User::getByOpenID($openid);
        if($user){
            $uid = $user->id;
        }else{
            $uid = $this->newUser($openid);
        }

        $cache_value = $this->prepareCacheData($uid,$wx_result);
        $token = $this->saveToCache($cache_value);
        return $token;

    }


    public function newUser($openid){
        $user = User::create([
            'openid' => $openid
        ]);
        return $user->id;
    }

    public function prepareCacheData($uid,$wx_result){
         $wx_result['uid'] = $uid;
         $wx_result['scope'] = config('secure.scope_user');
         $cache_value = $wx_result;
         return $cache_value;
    }

    public function saveToCache($cache_value){
         $key = self::generateToken();
         $value = json_encode($cache_value);
         $expire_in = config('wx.expire_in');
         cache([$key => $value], $expire_in);

         return $key;
    }


}