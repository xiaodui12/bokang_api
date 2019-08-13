<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'bokang_goods';

    public $type=array(
        "1"=>"商品类型1",
        "2"=>"商品类型2"
    );
}
