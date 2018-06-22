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
use App\Http\Models\GoodImg;
use App\Http\Services\TypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class GoodController extends Controller
{
    public function index(){
        $tot = Good::count();
        $data = Good::paginate(15);
        return view('admin.goods.index',compact('tot','data'));
    }

    public function create(){
        $data = (new TypeService())->data(null);
        return view('admin.goods.add',compact("data"));
    }

    public function edit($id){
        $data = Good::with('imgs')->find($id);
        $types = (new TypeService())->data(null);

        return view('admin.goods.edit',compact("data",'types'));
    }
    public function store(Request $request){
        $data = $request->only('cid','title','file','price','num','text','config','img');
        $id = $request->input('id');

        $rules=[
            'cid' => 'required',
            'img' => 'required',
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
            "file.required"=>"请上传商品组图",
            "img.required"=>"请上传商品封面",
        ];
        $validator = Validator::make($data,$rules,$message);
        if($validator->fails()){
            return err($validator->errors()->first());
        }

        $msg = '';
        $img_arr = [];
        $imgs = $data['file'];
        unset($data['file']);
        if($id){
            Good::where('id',$id)->update($data);
            GoodImg::where('gid',$id)->delete();
            $gid = $id;
            $msg = '修改成功';
        }else{
            $goods = Good::create($data);
            $gid = $goods->id;
            $msg = "创建成功";
        }

        foreach ($imgs as $value){
            array_push($img_arr,
                [
                    'img' => $value,
                    'gid' => $gid
                ]
            );
        }
        GoodImg::insert($img_arr);
        return res('',$msg);
    }


    public function destroy(Request $request){
        $data = $request->only('ids');
        $ids = $data['ids'];
        Good::destroy($ids);
        GoodImg::whereIn('gid',$ids)->delete();
        return res('','删除成功');
    }


}