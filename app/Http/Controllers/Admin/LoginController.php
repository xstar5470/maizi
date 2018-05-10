<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\4 0004
 * Time: 16:35
 */
namespace  App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
class LoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function yzm(){
        require_once('../resources/code/Code.class.php');
        $code = new \Code();
        return $code->make();
    }
}