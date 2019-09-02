<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class Order extends Model
{
    private static $point_rate=100;
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
        return $refresh_time&&$refresh_time>time()-24*60*60?$refresh_time:time()-24*60*60;//有刷新时间使用刷新时间，没有刷新时间，则使用90天时间戳
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
            DB::rollBack();
            if($number<10){
                $this->add_order($order_data,++$number);
            }
        }

    }



    public function change_order($order_data,$order_id,$number=0){
        $order=$order_data["order"];
        DB::beginTransaction();
        try{
            $order_m=self::where("order_id",$order_id)->first();
            $order_m->order_status=$order["order_status"];
            $order_m->order_status_desc=$order["order_status_desc"];
            $order_m->refresh_time=$order["refresh_time"];
            $result=$order_m->save();
            if($result){
                DB::commit();
            }else{
                throw new Exception(" ");
            }
        }catch (Exception $exception) {
            DB::rollBack();
            if ($number < 10) {
                $this->add_order($order_data,$order_id, ++$number);
            }
        }

    }

    /**
     * 得到订单列表
     * $uid 用户id
     * $type  类型
     * $page 页码
     * $status 状态
     */
    public function get_list($uid,$type=0,$page=1,$status=-2)
    {
        $where=[
            array("user_uid","=",$uid),
        ];
        $type!=0&&array_push($where,array("type","=",$type));
        $status!=-2&&array_push($where,array("order_status","=",$status));

        $order_list=$this
            ->where($where)
            ->with("ordergoods")
            ->orderBy('id', 'desc')
            ->paginate($page);

        return $order_list;
    }

    /**
     * 得到订单详情
     * $uid 用户id
     * $id 订单本地id
     */
    public function get_detail($uid,$id){
        $where=[
            array("user_uid","=",$uid),
            array("id","=",$id),
        ];
        $order_list=$this
            ->where($where)
            ->with("ordergoods")
            ->first();
        return $order_list;
    }
    /**
     * 根据团长得到订单信息
     * $uid 团长id
     * $id 订单本地id
     */
    public function get_detail_tuan($uid,$id){
        $where=[
            array("team_uid","=",$uid),
            array("id","=",$id),
        ];

        $order_list=$this
            ->where($where)
            ->with("ordergoods")
            ->first();
        return $order_list;
    }

    /**
     * 根据团长得到确认订单
     * $uid 团长id
     * $id 订单本地id
     */
    public function check_tuan_confirm($uid,$id){
        $order_info=$this->get_detail_tuan($uid,$id);
        ($order_info->share_status==1)&&error_return("订单已经确认过");
        empty($order_info)&&error_return("订单信息错误");
        $point=self::get_point($order_info);


        DB::beginTransaction();
        try{
            $order_info->share_status=1;
            $result=$order_info->save();
            if(!$result){
                throw new Exception("更新错误");
            }
           $member= new Member();
            $result=$member->addPoint($order_info["user_uid"],$point,$id);
            if(!$result){
                throw new Exception("更新错误");
            }
            DB::commit();
            success_return("更新成功");
        }catch (Exception $e){
            DB::rollBack();
            error_return($e->getMessage());
        }
    }

    /**
     * 得到积分
    */
    private static function get_point($order_info){
        $point=$order_info->promotion_amount*100;
        return $point?$point:0;
    }


    /*********修改器*****************/
    //创建时间 时间戳转时间
    public function getOrderCreateTimeAttribute($value)
    {
        return getdatatime($value);
    }
    //创建时间 时间戳转时间
    public function getOrderPayTimeAttribute($value)
    {
        return getdatatime($value);
    }
    //创建时间 时间戳转时间
    public function getOrderGroupSuccessTimeAttribute($value)
    {
        return getdatatime($value);
    }
    //创建时间 时间戳转时间
    public function getOrderModifyAtAttribute($value)
    {
        return getdatatime($value);
    }
    /*********修改器*****************/

    public static function getorder_share($order_id)
    {
        $order_info=self::where("id",$order_id)->select("order_amount","promotion_amount")->first();
        return array($order_info["order_amount"]?$order_info["order_amount"]:0,self::get_point($order_info));
    }


    public static function getorderinfo($order_id)
    {
        $order_info=self::where("id",$order_id)->first();
        return $order_info;
    }





}
