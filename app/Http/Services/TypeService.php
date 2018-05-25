<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\17 0017
 * Time: 18:20
 */

namespace App\Http\Services;


use App\Http\Models\Type;

class TypeService
{
    private $types;
    private $data = [];
    public function __construct()
    {
        $this->types = $this->render();

    }

    public function data($cates){
        $types = $cates ?? $this->types;
        foreach($types as $type){
            array_push($this->data,$type);
            if(!$type->children->isEmpty()){
                 $this->data($type->children);
            }
        }
        return $this->data;
    }
    public function render($pid = 0){
        $types = Type::where('pid',$pid)->get();
        if(!$types->isEmpty()){
           foreach ($types as $type){
               $type->repeat = count(explode(',',$type->path))-2;
               $type->children = self::render($type->id);
           }
        }
        return $types;
    }
}