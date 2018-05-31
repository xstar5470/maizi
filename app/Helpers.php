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
