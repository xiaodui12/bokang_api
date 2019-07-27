<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class Order extends Model
{
    protected $table = 'bokang_order';

    protected $fillable = ['order_no',"type","refresh_time","order_id","order_amount","p_id","promotion_rate","promotion_amount",
        "order_status","order_status_desc","order_create_time","order_pay_time","order_group_success_time","order_verify_time",
        "order_modify_at","custom_parameters","cpa_new","team_price","user_price","team_uid","user_uid"];

    public function ordergoods() {
         return $this->hasMany('App\Model\OrderGoods', 'bokang_order_id');
    }

    public function tuanuid() {
        return $this->hasOne('App\Model\Member',"id","team_uid");
    }
    public function buy_uid() {
         return $this->hasOne('App\Model\Member', "id",'user_uid');
    }

    /**
     * 得到最后更新时间
    */
    public static function getlastrefresh_time(){
       $refresh_time= self::max("refresh_time");
       return $refresh_time?$refresh_time:time()-24*60*60;//有刷新时间使用刷新时间，没有刷新时间，则使用90天时间戳
    }
    /**
     * 根据订单号查询订单是否存在
    */
    public function check_orderByorderid($order_id)
    {
        $id=self::where("order_id",$order_id)->value("id");
        return empty($id)?false:true;
    }

    /**
     * 创建订单
     * $order_data  订单信息
    */
    public function add_order($order_data,$number=1)
    {
        $order=$order_data["order"];
        $order_goods=$order_data["order_goods"];

        DB::beginTransaction();

        try{
            $order_m=self::create($order);
            $order_m->ordergoods()->createMany($order_goods);
            DB::commit();
        }catch (Exception $exception){
            DB::reback();
            if($number<10){
                $this->add_order($order_data,++$number);
            }
        }

    }
}