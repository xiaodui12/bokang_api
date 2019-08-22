<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class OurOrder extends Model
{

    protected $table = 'bokang_our_order';

    public function ourgoods(){
        return $this->hasMany('App\Model\OurOrderGoods',"order_id");
    }
    public function ouraddress(){
        return $this->hasOne('App\Model\OurOrderAddress',"order_id");
    }

    /**
     * 添加订单
    */
    public function addOurOrder($uid,$goods,$address_id,$share_code="",$cart=[])
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


            $order_m=self::create($order_info);
            $order_m->ourgoods()->createMany($order_info_goods);
            $order_m->ouraddress()->createMany($address_info);

            $cart=new Cart();
            $cart->setUid($uid);
            $cart->deleteCart($cart);

            DB::commit();
            success_return(array("order_no"=>$order_info["order_no"]),"创建成功");
        }catch (Exception $exception){
            DB::rollback();  //回滚
            error_return($exception->getMessage());
        }

    }

}
