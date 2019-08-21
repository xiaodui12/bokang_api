<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 17:26
 */

namespace App\Http\Controllers\Order;



use App\Http\Controllers\XcxControllers;
use App\Model\Goods;
use App\Model\GoodsSku;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OurControllers extends XcxControllers
{
    public function getAddOrder(Request $request){
        $type=$request->post("type","goods");
        $goodsList=[];
        if($type=="goods"){
            $goods=$request->post("goods");
            $goods=json_decode($goods,1);
            foreach ($goods as $key=>$val){
                $goods_one=Goods::getDetail($val["id"]);
                $goodsList_one=array(
                    "id"=>$goods_one->id,
                    "number"=>$val['number'],
                    "title"=>$goods_one->title,
                    "desc"=>$goods_one->desc,
                    "old_price"=>$goods_one->old_price,
                    "new_price"=>$goods_one->new_price,
                    "cover"=>$goods_one->cover,
                    "sku"=>$goods_one->sku,
                );
                if(!empty($val["sku"])){
                    $sku=GoodsSku::where("goods_id",$val["id"])->where("code",$val["sku"])->first();
                    $goodsList_one["new_price"]=$sku->price;
                    $goodsList_one["code"]=$sku->code;
                    $goodsList_one["name"]=$sku->name;
                    $goodsList_one["sku"]=$sku->sku;
                }
                $goodsList[]=$goodsList_one;
            }
        }elseif ($type=="cart")
        {

        }
        $return_array["goods"]=$goodsList;
        success_return($return_array);
    }


    public function addSubmit(Request $request)
    {

    }
}