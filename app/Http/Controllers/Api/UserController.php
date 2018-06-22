<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\4 0004
 * Time: 16:35
 */
namespace  App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getToken(Request $request){
        $code = $request->input('code');
        if(!$code){
            return err('','code缺失');
        }
        $user = new UserService($code);
        $token = $user->getToken();
        return $token;
    }
}