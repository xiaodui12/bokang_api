<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/3
 * Time: 9:18
 */

namespace App\Http\Controllers\Order;


use App\Model\Pay\DouyinPay;
use App\Model\Remark;
use Illuminate\Http\Request;


class OurBackControllers
{
    public function aliback(Request $request){
        $data=$request->all();

        Remark::add($data);

        $data='{"gmt_create":"2019-09-03 09:48:48",
        "charset":"UTF-8",
        "seller_email":"44136977@qq.com",
        "subject":"\u6d4b\u8bd5\u8ba2\u5355",
        "sign":"Lv9t3Andc\/QmINMr8+n4RR7Qr7UJF9n4he4BaVH5IeBHWB4WvLXuFUb9u4FUE0ohxr6A2SiuwNwzsF6EnnHXLa5IvZ1kd3bHGfVmwX2617+vLuJ4UZ4WrcOsRGc4VynpydJpHiccLjhKd\/yB9wt9FQLMG7+PBrl0AQ6b7cj\/hkajjQyxE9sbGF2YEGQiEw2pu1olqteXwNlMQyOlo9eh3ZrTfaRiXXCLxabG1ZWDO2PVVzUBYtEV\/nL\/gLaa8VByETy7Aicmlm2rrsamBJDCHq6YhiK8R8y2W\/gjXax2SFJsJobMjdp3LUJAtdVaQLqdUYwfsqgU4GnU1tpvn+T37g==",
        "body":"1566545013_10_219_408",
        "buyer_id":"2088702177415565",
        "invoice_amount":"0.01",
        "notify_id":"2019090300222094849015560534159287",
        "fund_bill_list":"[{\"amount\":\"0.01\",\"fundChannel\":\"ALIPAYACCOUNT\"}]",
        "notify_type":"trade_status_sync",
        "trade_status":"TRADE_SUCCESS",
        "receipt_amount":"0.01",
        "app_id":"2019090266833344",
        "buyer_pay_amount":"0.01",
        "sign_type":"RSA2",
        "seller_id":"2088002690258965",
        "gmt_payment":"2019-09-03 09:48:48",
        "notify_time":"2019-09-03 09:48:49",
        "version":"1.0",
        "out_trade_no":"1566545013_10_219_408",
        "total_amount":"0.01",
        "trade_no":"2019090322001415560565785392",
        "auth_app_id":"2019090266833344",
        "buyer_logon_id":"952***@qq.com",
        "point_amount":"0.00"
        }';
        $data=json_decode($data,1);

        (new DouyinPay)->aliBack($data);




    }
}