<?php
if(!function_exists('modifyEnv')){
    function modifyEnv(array $data)
    {
        $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';
        $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));
        $contentArray->transform(function ($item) use ($data){
            foreach ($data as $key => $value){
                if(str_contains($item, $key)){
                    return $key . '=' . $value;
                }
            }

            return $item;
        });
        $content = implode($contentArray->toArray(), "\n");
        \File::put($envPath, $content);
    }
}

/**
 * API请求成功返回的Json数据.
 *
 * @param mixed $content
 * @param int $status
 * @return json
 */
if(!function_exists('res')){
    function res($content = null, $message = null, $status = 200)
    {
        return response()->json([
            'code' => 0,
            'data' => $content,
            'message' => $message,
        ], $status);
    }
}


/**
 * API请求成功返回的Json数据.
 *
 * @param mixed $content
 * @param int $status
 * @return json
 */
if(!function_exists('err')){
    function err($content = null, $message = null, $status = 200)
    {
        return response()->json([
            'code' => 1,
            'data' => $content,
            'message' => $message,
        ], $status);
    }
}


/**
 * @param string $url post请求地址
 * @param array $params
 * @return mixed
 */
if(!function_exists('curl_post')) {
    function curl_post($url, array $params = array())
    {
        $data_string = json_encode($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json'
            )
        );
        $data = curl_exec($ch);
        curl_close($ch);
        return ($data);
    }
}
if(!function_exists('curl_post_raw')) {
    function curl_post_raw($url, $rawData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER,
            array(
                'Content-Type: text'
            )
        );
        $data = curl_exec($ch);
        curl_close($ch);
        return ($data);
    }
}


/**
 * @param string $url get请求地址
 * @param int $httpCode 返回状态码
 * @return mixed
 */
if(!function_exists('curl_get')) {
    function curl_get($url, &$httpCode = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //不做证书校验,部署在linux环境下请改为true
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $file_contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $file_contents;
    }
}

if(!function_exists('getRandChar')) {
    function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0;
             $i < $length;
             $i++) {
            $str .= $strPol[rand(0, $max)];
        }

        return $str;
    }
}



if(!function_exists('fromArrayToModel')){
    function fromArrayToModel($m , $array)
    {
        foreach ($array as $key => $value)
        {
            $m[$key] = $value;
        }
        return $m;
    }
}



