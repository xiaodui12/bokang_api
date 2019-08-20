<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsSku extends Model
{
    protected $table = 'bokang_goods_sku';

    public static function getlist($id){
        return self::where("goods_id",$id)->get()->toarray();
    }
}
