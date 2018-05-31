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
use App\Http\Models\Slider;
use Illuminate\Support\Facades\Validator;


class SliderController extends Controller
{
    public function index(){
        $tot = Slider::count();
        $data = Slider::OrderBy('sort','desc')->paginate(5);
        return view('admin.system.slider.index',compact('tot','data'));
    }


    public function store(Request $request){
        $data = $request->only('title','link','sort','file');
        $id = $request->input('id');

        $rules=[
            'title' => 'required',
            'link' => 'required',
            'file' => 'required',
        ];
        $message=[
            "title.required"=>"请输入标题",
            "link.required"=>"请输入链接",
            "file.required"=>"请选择图片",
        ];
        $validator = Validator::make($data,$rules,$message);
        if($validator->fails()){
            return err('',$validator->errors()->first());
        }
        $data['img'] = $data['file'][0];
        unset($data['file']);

        $msg = '';
        if($id){
            Slider::where('id',$id)->update($data);
            $msg = '修改成功';
        }else{
            Slider::create($data);
            $msg = '创建成功';
        }
        return res('',$msg);
    }


    public function destroy(Request $request){
        $data = $request->only('ids');
        $ids = $data['ids'];
        Slider::destroy($ids);
        return res('','删除成功');
    }

    public function status(Request $request){
        $data = $request->only('id','status');
        $result = Admin::where('id',$data['id'])->update(['status' => $data['status'] ]);
        if($result){
            return res('','变更成功');
        }
    }

}