<?php
return [
   'appid' => 'wx395c16c2e7db6c3e',
   'secret' => 'e0a828a0576fd807596d62df1e3781d5',
   'expire_in' => 7200,
    // 微信使用code换取用户openid及session_key的url地址
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s",
];