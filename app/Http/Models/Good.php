<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\15 0015
 * Time: 14:38
 */

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    public $timestamps = false;
    protected $table = 'goods';
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function imgs(){
        return $this->hasMany('App\Http\Models\GoodImg','gid','id');
    }
}
