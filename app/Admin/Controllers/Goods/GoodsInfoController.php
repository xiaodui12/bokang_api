<?php

namespace App\Admin\Controllers\Goods;



use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Http\Request;

class GoodsInfoController extends Controller
{


    public function create(Request $request){
        $data=$request->post();

        $goods=new Goods();
        $goods->addGoods($data);
        success_return("新增成功");
    }

}

