<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/24
 * Time: 8:24
 */

namespace App\Http\Controllers\Taobao;


use App\Model\Member;
use App\Model\Order;
use App\Model\System;
use Illuminate\Http\Request;
use Tests\Models\User;

class RefreshControllers extends BaseControllers
{





    public function __construct(Request $request)
    {
        parent::__construct($request);

    }

    /**
     * 得到拼多多刷新订单
     */
    public function order_get(Request $request)
    {



//        $type="taobao.tbk.dg.newuser.order.get";
        $type="taobao.tbk.order.details.get";

     $data["start_time"]=date("Y-m-d H:i:s",time()-1000);//搜索开始时间
     $data["end_time"]=date("Y-m-d H:i:s");//搜索开始时间



        $order_data=$this->send_all($this->url,$type,$data);//得到接口返回
        var_dump($order_data);
        exit;

        $this->change_order($order_data["order_list_get_response"]["order_list"]);

    }


    /**
     * 编辑订单
    */
    private function change_order($order_list)
    {
        $order_m=new Order();
        foreach ($order_list as $key=>$value)
        {
            $order_id=$value["order_id"];

            $order=$this->build_order($value);

            $has_order=$order_m->check_orderByorderid($order_id);
            if(!$has_order){
                $order_m->add_order($order);
            }else{
                $order_m->change_order($order,$order_id);
            }

        }
        echo "success";
    }

    /**
     * 编辑订单数据
    */
    private function build_order($order_data)
    {
        $type=1;

        $user_uid=0;
        $team_uid=0;
        $custom_array=json_decode($order_data["custom_parameters"],1);
        $my_code=$custom_array["my_code"];
        $parent_code=$custom_array["parent_code"];
        if(!empty($my_code)){
            $user_uid=Member::getidBycode($my_code);
        }
        if(!empty($parent_code)){
            $team_uid=Member::getidBycode($parent_code);
        }

        $order_info=array(
            "order_no"=>$order_data["order_sn"],//订单时间
            "refresh_time"=>time(),//刷新时间
            "type"=>$type,
            "order_id"=>$order_data["order_id"],//订单id
            "order_amount"=>$order_data["order_amount"]/100,//订单总金额
            "p_id"=>$order_data["p_id"],//推广位
            "promotion_rate"=>$order_data["promotion_rate"],//
            "promotion_amount"=>$order_data["promotion_amount"]/100,//佣金总金额
            "order_status"=>$order_data["order_status"],
            "order_status_desc"=>$order_data["order_status_desc"],
            "order_create_time"=>$order_data["order_create_time"],
            "order_pay_time"=>$order_data["order_pay_time"]?$order_data["order_pay_time"]:"0",
            "order_group_success_time"=>$order_data["order_group_success_time"]?$order_data["order_group_success_time"]:"0",
            "order_verify_time"=>$order_data["order_verify_time"]?$order_data["order_verify_time"]:"0",
            "order_modify_at"=>$order_data["order_modify_at"]?$order_data["order_modify_at"]:"0",
            "custom_parameters"=>$order_data["custom_parameters"]?$order_data["custom_parameters"]:"0",
            "cpa_new"=>$order_data["cpa_new"]?$order_data["cpa_new"]:"0",
            "team_price"=>$order_data["promotion_amount"]*config("team_ratio")/100/100,
            "user_price"=>$order_data["promotion_amount"]*config("user_ratio")/100/100,
            "team_id"=>$team_uid,
            "user_uid"=>$user_uid,
        );
        $order_goods=array(
            "goods_price"=>$order_data["goods_price"]/100,
            "goods_id"=>$order_data["goods_id"],
            "goods_name"=>$order_data["goods_name"],
            "type"=>$type,
            "goods_thumbnail_url"=>$order_data["goods_thumbnail_url"],
            "goods_quantity"=>$order_data["goods_quantity"],

        );
        return array("order"=>$order_info,"order_goods"=>[$order_goods]);
    }

}