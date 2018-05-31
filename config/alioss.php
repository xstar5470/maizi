<?php

return [
    'ossNetWorkType' => env('ALIOSS_NETWORKTYPE', null),            //网络类型
    'ossCity' => env('ALIOSS_CITY', null),                           //城市
    'ossServer' => env('ALIOSS_SERVER', null),                      // 外网
    'ossServerInternal' => env('ALIOSS_SERVERINTERNAL', null),      // 内网
    'AccessKeyId' => env('ALIOSS_KEYID', null),                     // key
    'AccessKeySecret' => env('ALIOSS_KEYSECRET', null),             // secret
    'BucketName' => env('ALIOSS_BUCKETNAME', null)                  // bucket
];
