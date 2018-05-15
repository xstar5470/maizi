<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\4 0004
 * Time: 16:35
 */
namespace  App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function index(){
        $tot = Admin::count();
        $admins = Admin::paginate(15);
        return view('admin.admin.index',compact('tot','admins'));
    }

    public function edit(){

    }

    public function store(Request $request){
        $data = $request->only('name','pass','repass','status');
        $rules=[
            'name' => 'required|unique:admins|between:6,12',
            'pass' => 'required|between:6,12',
            'repass' => 'required|same:pass'
        ];
        $message=[
            "name.required"=>"请输入用户名",
            "pass.required"=>"请输入密码",
            "repass.required"=>"请输入确认密码",
            "name.unique"=>"用户名已存在",
            "repass.same"=>"两次密码不一致",
            "pass.between"=>"密码长度不在6-12位之间",
            "name.between"=>"用户名长度不在6-12位之间",
        ];
        $validator = Validator::make($data,$rules,$message);
        if($validator->fails()){
            return $this->err($validator->errors());
        }
        unset($data['repass']);
        $data['dateline'] = time();
        Admin::create($data);
        return $this->res('','添加成功');
    }

    public function update(){

    }

    public function destroy(Request $request){
        $data = $request->only('ids');
        $ids = $data['ids'];
        Admin::destroy($ids);
        return $this->res('','删除成功');
    }

}