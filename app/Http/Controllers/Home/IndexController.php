<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\4 0004
 * Time: 16:35
 */
namespace  App\Http\Controllers\Home;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(){

        return view('home.index');
    }
}