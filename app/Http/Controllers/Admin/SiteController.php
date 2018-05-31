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
class SiteController extends Controller
{
    public function index(){
        return view('admin.system.config.site');
    }

    public function store(Request $request){

         $data = $request->only('WEBSITE_TITLE','WEBSITE_KEYWORDS','WEBSITE_STATISTICS','WEBSITE_DESCRIPTION','file');

         if($data['file']){
             $data['WEBSITE_LOGO'] = $data['file'][0];
         }else{
             $data['WEBSITE_LOGO'] = '';
         }

         unset($data['file']);
         modifyEnv($data);
         return res('','保存成功');
    }
}