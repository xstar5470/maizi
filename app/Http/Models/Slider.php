<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\5\15 0015
 * Time: 14:38
 */

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $timestamps = false;
    protected $table = 'sliders';
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function setSortAttribute($value){
         if($value == '' ){
            return $this->attributes['sort'] = 0;
         }else{
            return $this->attributes['sort'] = $value;
         }
    }
}
