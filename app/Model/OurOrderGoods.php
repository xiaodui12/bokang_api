<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class OurOrderGoods extends Model
{

    protected $table = 'bokang_our_order_goods';

    protected $guarded=[];
}
