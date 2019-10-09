<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/3
 * Time: 9:18
 */

namespace App\Http\Controllers\Order;


use App\Model\Pay\DouyinPay;
use App\Model\Pay\Wechat;
use App\Model\Remark;
use Illuminate\Http\Request;


class OurBackControllers
{
    public function aliback(Request $request){
        $data=$request->all();
        Remark::add($data);
        (new DouyinPay)->aliBack($data);
    }
    public function wechetback($appid,Request $request){

        (new Wechat())->wxpay_notify($appid,$request);
    }
}