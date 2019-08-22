<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 17:26
 */

namespace App\Http\Controllers\Order;



use App\Http\Controllers\XcxControllers;
use App\Model\Cart;
use App\Model\Goods;
use App\Model\GoodsSku;
use App\Model\Order;
use App\Model\OurOrder;
use App\Model\Pay\DouyinPay;
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
            $goodsList=Goods::getAddOrderGoods($goods);
        }elseif ($type=="cart")
        {
            $cart=$request->post("cart","");
            $cartList=explode(",",$cart);
            $cart=new Cart();
            $cart->setUid($this->uid);
            $goodsList=$cart->getCartList($cartList);
        }
        $return_array["goods"]=$goodsList;
        success_return($return_array);
    }

    public function addSubmit(Request $request)
    {

        $type=$request->post("type","goods");
        $share_code=$request->post("share_code","");
        $address_id=$request->post("address_id","");
        $goodsList=[];
        $cart=$request->post("cart","");
        if($type=="goods"){
            $goods=$request->post("goods");
            $goods=json_decode($goods,1);
            $goodsList=Goods::getAddOrderGoods($goods);
        }elseif ($type=="cart")
        {

            $cartList=explode(",",$cart);
            $cart=new Cart();
            $cart->setUid($this->uid);
            $goodsList=$cart->getCartList($cartList);
        }
        OurOrder::addOurOrder($this->uid,$goodsList,$address_id,$share_code,$cart);
    }



    public function pay(){
        (new DouyinPay())->pay();
    }
}