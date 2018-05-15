<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * API请求成功返回的Json数据.
     *
     * @param mixed $content
     * @param int $status
     * @return json
     */
    public function res($content = null, $message = null, $status = 200)
    {
        return response()->json([
            'code' => 0,
            'data' => $content,
            'message' => $message,
        ], $status);
    }

    /**
     * API请求成功返回的Json数据.
     *
     * @param mixed $content
     * @param int $status
     * @return json
     */
    public function err($content = null, $message = null, $status = 200)
    {
        return response()->json([
            'code' => 1,
            'data' => $content,
            'message' => $message,
        ], $status);
    }

}
