<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\4 0004
 * Time: 16:35
 */
namespace  App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function index(){
        return view('admin.admin.index');
    }

    public function create(Request $request){

    }

    public function edit(){

    }

    public function store(Request $request){
        $data = $request->only('name','pass','repass','status');

        $rules=[
            'name' => 'required|unique:admin|between:6,12',
            'pass' => 'required|same:repass|between:6,12',
        ];
        $message=[
            "name.required"=>"请输入用户名",
            "pass.required"=>"请输入密码",
            "name.unique"=>"用户名已存在",
            "pass.same"=>"两次密码不一致",
            "pass.between"=>"密码长度不在6-12位之间",
            "name.between"=>"用户名长度不在6-12位之间",
        ];
        $validator = Validator::make($data,$rules,$message);
        dd($validator->errors());
    }

    public function update(){

    }

    public function destroy(){

    }

}