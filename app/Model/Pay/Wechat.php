<?php

namespace App\Model\Pay;


use App\Model\MpConfig;
use EasyWeChat\Factory;
use EasyWeChat\Work\Application;
use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    public function pay($body, $detail, $out_trade_no, $total_fee,  $openid='',$appid)
    {

        $config=MpConfig::getpayconfig($appid);




        $app = Factory::payment($config);



//        //创建订单

        $result = $app->order->unify([
            'body' => $body,
            'out_trade_no' => $out_trade_no,
            'total_fee' => $total_fee*100,
             'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => $openid,
        ]);


        if( $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){

            $config = $app->jssdk->bridgeConfig($result['prepay_id'], false); // 生成支付 JS 配置
            return $config;

        }else{
            Log::error('微信支付签名失败:'.var_export($result,1));
            return false;
        }
    }

    public function wxpay_notify(Request $request)
    {
        $app = Factory::payment(get_weixin_config());
        $response = $app->handlePaidNotify(function ($notify, $fail) {
            $out_trade_no = $notify['out_trade_no']; // 商户订单号
            $trade_no = $notify['transaction_id'];  // 微信支付订单号
//            $order = "";
            if (empty($order)) {
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            if ($notify['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($notify, 'result_code') === 'SUCCESS') {
                    //加入自己支付完成后该做的事
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }
            return true;
        });
        return $response;
    }


}
