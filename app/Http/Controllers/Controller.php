<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
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

    public function upload(){
        $file = $_FILES["file"]; // file是上传按钮名
        $dir = $_POST['dir'];

        if(!isset($file['tmp_name']) || !$file['tmp_name']) {
            echo json_encode(array('code' => 401, 'msg' => '没有文件上传'));
            return false;
        }
        if($file["error"] > 0) {
            echo json_encode(array('code' => 402, 'msg' => $file["error"]));
            return false;
        }

        $upload_path = $_SERVER['DOCUMENT_ROOT']."/uploads/$dir/";
        $file_path   = 'http://' . $_SERVER['HTTP_HOST']."/uploads/$dir/";

        if(!is_dir($upload_path)){
            mkdir($upload_path);
        }

        if(move_uploaded_file($file["tmp_name"], $upload_path.$file['name'])){
            return json_encode(['code' => 200, 'src' => $file_path.$file['name']]);
        }else{
            return json_encode(array('code' => 404, 'msg' => '上传失败'));
        }

    }



}
