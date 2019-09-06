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

    protected $ourOrder;
    public function __construct(Request $request)
    {
        parent::__construct($request);

        if(empty($this->uid)){
            error_return("请授权用户信息登录");
        }
        $this->ourOrder=new OurOrder();
    }

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
        $this->ourOrder->addOurOrder($this->uid,$goodsList,$address_id,$share_code,$cart);
    }



    public function pay(Request $request){

        $type=$request->post("type","ali");
        $order_no=$request->post("order_no","");

         $order_info=OurOrder::getDetailByOrderno($order_no);
        $result=(new DouyinPay())->pay($this->openid,$order_info,$type);
        success_return($result);
    }


    /**
     * 得到订单列表
     */
    public function getOrderList(Request $request)
    {
        $status=$request->post("status",-1);
        $list=OurOrder::getList($this->uid,$status);
        success_return($list);
    }

    /**
     * 得到订单信息
     */
    public function getOrderDetail(Request $request)
    {
        $id=$request->post("id","");
        $info=OurOrder::getDetail($this->uid,$id);
        success_return($info);
    }


    /**
     * 设置收货
     */
    public function setReceiving(Request $request){
        $id=$request->post("id","");
        $result=OurOrder::setReceiving($this->uid,$id);
        $result?success_return("收货成功"):error_return("收货失败，请重试");
    }

    /**
     * 物流信息
    */
    public function getLogistics(Request $request){
        $id=$request->post("id","");
        $result=OurOrder::getLogistics($this->uid,$id);
        success_return($result);
    }

}