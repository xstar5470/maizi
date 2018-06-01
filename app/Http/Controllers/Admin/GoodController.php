<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\4 0004
 * Time: 16:35
 */
namespace  App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Models\Good;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class GoodController extends Controller
{
    public function index(){
        $tot = Good::count();
        $data = Good::paginate(15);

        return view('admin.admin.index',compact('tot','data'));
    }


    public function store(Request $request){
        $data = $request->only('cid','title','file','price','num','text','config');
        $id = $request->input('id');

        $rules=[
            'cid' => 'required',
            'title' => 'required',
            'file' => 'required',
            'price' => 'required',
            'num' => 'required'
        ];
        $message=[
            "cid.required"=>"请选择分类",
            "title.required"=>"请输入商品名",
            "price.required"=>"请输入商品价格",
            "num.required"=>"请输入商品库存",
            "file.required"=>"请上传商品封面",
        ];
        $validator = Validator::make($data,$rules,$message);
        if($validator->fails()){
            return err($validator->errors()->first());
        }

        $message = '';
        if($id){
            Admin::where('id',$id)->update($data);
            $message = '修改成功';
        }else{
            $data['dateline'] = time();
            Admin::create($data);
            $message = '创建成功';
        }
        return res('',$message);
    }


    public function destroy(Request $request){
        $data = $request->only('ids');
        $ids = $data['ids'];
        Admin::destroy($ids);
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