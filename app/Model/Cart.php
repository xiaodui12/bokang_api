<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class Cart extends Model
{
    protected $table = 'bokang_cart';

    protected $uid;

    public function setUid($uid){
        $this->uid=$uid;
    }

    public function getList($cart_id=[])
    {
        $list=self::where("uid",$this->uid)
            ->paginate(30);
        $list->each(function ($item,$key){
            $item->goods=Goods::getGoodsOne($item->goods_id,$item->code,$item->number);
        });
        return $list;
    }



    public function getCartList($cart_id=[])
    {
        $list=self::where("uid",$this->uid)
            ->whereIn("id",$cart_id)
            ->get();
        $list->each(function ($item,$key){
            $item->goods=Goods::getGoodsOne($item->goods_id,$item->code,$item->number);
        });
        $goods_list=[];
        foreach ($list as $key=>$value){
            if($value->goods){
                $goods_list[]=$value->goods;
            }
        }
        return $goods_list;
    }
    /**
     * 设置购物车
    */
    public function setDetail($goods_id,$number=0,$code="")
    {
        $goods_info=Goods::getGoodsOne($goods_id,$code,$number);
        if(!$goods_info){
            error_return("商品信息错误");
        }
        var_dump($this->uid);
        exit;
        $Cart=self::where("uid",$this->uid)
            ->where("goods_id",$goods_id)
            ->where("code",$code)
            ->first();
        if(empty($Cart)){
            $Cart=new self();
            $Cart->uid=$this->uid;
            $Cart->goods_id=$goods_id;
            $Cart->number=0;
            $Cart->code=$code;
            $Cart->created_at=date("Y-m-d H:i:s");
        }
        $Cart->number+=$number;
        if($goods_info["sku"]<$Cart->number||$goods_info["goods_sku"]<$Cart->number)
        {
            error_return("当前数量大于库存");
        }
        return $Cart->save();
    }
    /**
     * 设置购物车数量
    */
    public function setNumber($cart_id,$number)
    {
        $Cart=self::where("uid",$this->uid)
            ->where("id",$cart_id)
            ->first();
        if(empty($Cart)){
            error_return("购物车信息错误");
        }
        $Cart->number=$number;
        return $Cart->save();

    }
    /**
     * 删除购物车
    */
    public function deleteCart($id){
        $model=self::where("uid",$this->uid);
        if(is_array($id)){
            $model=$model->whereIn("id",$id);
        }else{
            $model=$model->where("id",$id);
        }
        return $model->delete();
    }
}
