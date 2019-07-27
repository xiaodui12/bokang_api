<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    protected $table = 'bokang_order_goods';
    protected $fillable = ['goods_price',"goods_id","goods_name","type","goods_thumbnail_url","goods_quantity"];
}
