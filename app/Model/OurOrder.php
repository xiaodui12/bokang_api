<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class OurOrder extends Model
{

    protected $table = 'bokang_our_order';

    public $type=["普通订单"];
    public $status=["未付款","已付款","已发货","已收货"];
    protected $guarded=[];
    public function ourgoods(){
        return $this->hasMany('App\Model\OurOrderGoods',"order_id");
    }
    public function ouraddress(){

        return $this->hasOne('App\Model\OurOrderAddress',"order_id");
    }

    /**
     * 添加订单
    */
    public function addOurOrder($uid,$goods,$address_id,$share_code="",$cart_list=[])
    {
        $order_info=array();

        if(!empty($share_code)){
            $order_info["share_uid"]=Member::getidBycode($share_code);
        }

        $order_info["type"]=0;
        $order_info["user_uid"]=$uid;
        $order_info["order_status"]=0;
        $order_info["created_at"]=date("Y-m-d H:i:s");
        $order_info["order_no"]=time()."_".$uid."_".rand(100,999);


        $order_amount=0;
        DB::beginTransaction(); //开启事务
        try{
            $order_info_goods=[];

            foreach ($goods as $key=>$good_one){
                $order_info_goods_one=array(
                    "goods_id"=>$good_one['id'],
                    "goods_title"=>$good_one['title'],
                    "goods_price"=>$good_one['new_price'],
                    "goods_cover"=>$good_one['cover'],
                    "goods_quantity"=>$good_one['number'],
                    "sku_name"=>$good_one['name'],
                    "sku_code"=>$good_one['code'],
                    "created_at"=>date("Y-m-d H:i:s")
                );
                $order_amount+=floatval($good_one['new_price']*$good_one['number']);
                if($good_one["goods_sku"]<$good_one['number']||$good_one["sku"]<$good_one['number']){
                    throw new Exception("库存不足");
                }
                $result1=Goods::where("id",$good_one['id'])->decrement('sku',$good_one['number']);
                if(!empty($good_one['code'])){
                    $result2=GoodsSku::where("goods_id",$good_one['id'])->where("code",$good_one['code'])->decrement('sku',$good_one['number']);
                }else{
                    $result2=true;
                }
                if(!$result1||!$result2){
                    throw new Exception("库存修改错误");
                }
                $order_info_goods[]=$order_info_goods_one;
            }
            $order_info["order_amount"]=$order_amount;
            $order_info["promotion_amount"]=$order_amount*1/100;

            $address_info=(new Address())->getDetail($uid,$address_id)->toarray();

            $address_info["created_at"]=date("Y-m-d H:i:s");

            unset($address_info["updated_at"]);
            unset($address_info["deleted_at"]);
            unset($address_info["is_default"]);

            $order_m=self::create($order_info);
            $order_m->ourgoods()->createMany($order_info_goods);
            $order_m->ouraddress()->create($address_info);

            $cart=new Cart();
            $cart->setUid($uid);
            $cart->deleteCart($cart_list);

            DB::commit();
            success_return(array("order_no"=>$order_info["order_no"]),"创建成功");
        }catch (Exception $exception){
            DB::rollback();  //回滚
            error_return($exception->getMessage());
        }
    }


    /**
     * 得到列表
    */
    public static function getList($uid,$status)
    {
        $list=self::where("user_uid",$uid)
            ->when($status!=-1,function ($query)use($status){
                return $query->where("order_status",$status);
            })
            ->with("ourgoods")
            ->paginate(15);
        return $list;

    }

    /**
     * 得到列表
     */
    public static function getDetail($uid,$id)
    {
        $list=self::where("user_uid",$uid)
            ->where("id",$id)
            ->with("ourgoods","ouraddress")
            ->first();
        return $list;
    }

    /**
     * 得到列表
     */
    public static function getDetailByOrderno($order_no)
    {
        $info=self::where("order_no",$order_no)
            ->first();
        return $info;
    }


    public static function checkOrder($uid,$id,$status=""){
        $order=self::getDetail($uid,$id);
        if(empty($order->id)){
            error_return("订单不存在");
        }
        if($status!=""&&$order->order_status!=$status){
            error_return("订单状态不正确");
        }
        return $order;
    }

    /**
     * 设置订单收货
    */
    public static function setReceiving($uid,$id)
    {
        $order=self::checkOrder($uid,$id,2);
        $order->order_status=3;
        $order->receive_at=date("Y-m-d H:i:s");
        $result=$order->save();

        if($result){
            CommissonLog::sendCommisson($order->order_no);
        }
        return $result;
    }

    /**
     * 设置发货
    */
    public static function setSend($uid,$id,$logistics,$logistics_no)
    {
        $order=self::checkOrder($uid,$id,1);
        $order->logistics=$logistics;
        $order->logistics_no=$logistics_no;
        $order->order_status=2;
        $order->send_at=date("Y-m-d H:i:s");
        return $order->save();
    }

    public static function setPay($uid,$id){
        $order=self::checkOrder($uid,$id,0);
        $result=self::setpaysend($order);
        return $result;
    }

    public static function getLogistics($uid,$id){
        $order=self::checkOrder($uid,$id,2);
        $url="https://wuliu.market.alicloudapi.com/kdi?no=".$order->logistics_no;
        $headers = array();
        $appcode="354c97818b494856b4cf05860f4f05a6";
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $info=curlGet($url,$headers);

        $return_array=array(
            "logistics"=>$info,
            "order"=>$order,
        );
       return $return_array;
    }
    public static function checkOrderPay($order_no,$price)
    {
        $info=self::getDetailByOrderno($order_no);
        $result=self::setpaysend($info);
        return $result;

    }
    protected static function setpaysend($info){
        if($info->order_status!=0){
            return false;
        }
        $info->order_status=1;
        $info->order_pay_time=date("Y-m-d H:i:s");
        $info->save();
        CommissonLog::addLog(0,$info->order_no,$info->order_amount,$info->share_id,$info->promotion_amount,$info->buy_id);

    }
}
