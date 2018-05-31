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
use App\Http\Models\Type;
use App\Http\Services\TypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TypeController extends Controller
{
    public function index(){
        $tot = Type::count();
        $types = (new TypeService())->data(null);
        return view('admin.types.index',compact('types','tot'));
    }

    public function create(){
        return view('admin.types.add');
    }

    public function store(Request $request){
        $data = $request->only('name','pid','path','title','keywords','description','sort','is_lou');
        $id = $request->input('id');
        $rules=[
            'name' => 'required|unique:types',
            'sort' => 'integer'
        ];
        $message=[
            "name.required"=>"请输入分类名",
            "name.unique"=>"该分类名已存在",
            "sort.integer" => "排序必须是数字"
        ];
        $validator = Validator::make($data,$rules,$message);
        if($validator->fails()){
            return err('',$validator->errors()->first());
        }

        if($id){
            Type::where('id',$id)->update($data);
            $message = '修改成功';
        }else{
            Type::create($data);
            $message = '创建成功';
        }
        return res('',$message);
    }


    public function destroy(Request $request){
        $data = $request->only('ids');
        $ids = $data['ids'];

        foreach ($ids as $id){
            Type::where('id',$id)->orWhere('path','like',"%,$id,%")->delete();
        }
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