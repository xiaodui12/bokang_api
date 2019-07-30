<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 17:26
 */

namespace App\Http\Controllers\Order;



use App\Http\Controllers\XcxControllers;
use App\Model\Order;
use Illuminate\Http\Request;

class IndexControllers extends XcxControllers
{

    /**
     * 得到订单列表
     * type  订单类型：1：拼多多，2：淘宝，3：京东,0:全部
     * page  页码
     * status  状态：-1 未支付; 0-已支付；1:已成团；2-确认收货；3-审核成功；4-审核失败（不可提现）；5-已经结算   （主要  -1，0，2,3,4,5）
    */
    public function order_list(Request $request)
    {
        $type=$request->post("type",0);//订单类型：1：拼多多，2：淘宝，3：京东,0:全部
        $page=$request->post("page",1);//页码
        $status=$request->post("status",-2);//状态：-1 未支付; 0-已支付；1:已成团；2-确认收货；3-审核成功；4-审核失败（不可提现）；5-已经结算
        //主要  -1，0，2,3,4,5

        $order=new Order();
        $order_list=$order->get_list($this->uid,$type,$page,$status);
        success_return($order_list);
    }

    /**
     * 得到订单详情
     * id 订单本地id
    */
    public function order_detail(Request $request){
        $id=$request->post("id",0);
        empty($id)&&error_return("参数错误");
        $order=new Order();
        $order_list=$order->get_detail($this->uid,$id);//得到订单数据
        success_return($order_list);

    }

}