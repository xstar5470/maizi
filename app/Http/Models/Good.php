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
    protected $table = 'Goods';
    protected $guarded = [];
    protected $primaryKey = 'id';
}
