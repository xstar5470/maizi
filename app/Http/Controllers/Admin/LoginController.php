<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\4 0004
 * Time: 16:35
 */
namespace  App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Providers\code\Code;
class LoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function yzm(){
        $code = new Code();
        return $code->make();
    }
}