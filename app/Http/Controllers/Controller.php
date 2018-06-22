<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Providers\alioss\OSS;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function upload(Request $request){
        $file = $_FILES["file"]; // file是上传按钮名

        if(!isset($file['tmp_name']) || !$file['tmp_name']) {
            echo json_encode(array('code' => 401, 'msg' => '没有文件上传'));
            return false;
        }
        if($file["error"] > 0) {
            echo json_encode(array('code' => 402, 'msg' => $file["error"]));
            return false;
        }

        $extarr = explode(".",$file['name']);
        $ext = $extarr[1];
        $new_file=time().rand().'.'.$ext;


        $result = OSS::upload($new_file, $file['tmp_name'],['ContentType'=>'image/'.$ext]);

        if($result){
            $file_path = OSS::getUrl($new_file);
            return json_encode(['code' => 200, 'src' => $file_path]);
        }else{
            return json_encode(array('code' => 404, 'msg' => '上传失败'));
        }

    }



}
