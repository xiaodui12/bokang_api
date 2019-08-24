<?php

namespace App\Model\Pay;

use App\Model\MpConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class DouyinPay extends Model
{
    protected $pay_url="https://tp-pay.snssdk.com/gateway";

    protected $appid="800148268568";
    protected $secret="mqqh0jxr1yv8r1dpk93n6mn3rwkqebrzkwrq9ji8";


    public function build_base($data){

        $data["merchant_id"]="1900014826";
        $data["currency"]="CNY";
        $data["trade_time"]=time();
        $data["notify_url"]="https://pingoufan.com/douyin/notify";




        $public["app_id"]=$this->appid;
        $public["method"]="tp.trade.create";
        $public["format"]="JSON";
        $public["charset"]="utf-8";
        $public["sign_type"]="MD5";
        $public["timestamp"]=time();
        $public["version"]="1.0";
        $public["biz_content"]=(json_encode($data));
        ksort($public);

        $var = '';

        foreach($public as $key => $value){

            $var .= $key.'='.$value.'&';

        }
        $var = trim($var,'&');

        $c = $var.$this->secret;

        $public['sign'] = MD5($c);


        return $public;
    }
    public function pay($openid){


        $biz_content = array(
            'out_order_no' => "123",
            'uid' => $openid,
            'total_amount' =>1,
            'subject' => "测试订单" ,
            'body' => "测试订单",
            'valid_time' => '60',
            'risk_info' => $_SERVER['SERVER_ADDR'],
        );

        $data=$this->build_base($biz_content);


        $vars = 'app_id='.$data['app_id'].'&biz_content='.$data['biz_content'].'&charset='.$data['charset'].'&method='.$data['method'].'&sign='.$data['sign'].'&sign_type='.$data['sign_type'].'&timestamp='.$data['timestamp'].'&version='.$data['version'];

        $url=$this->pay_url;



        $data= curlPostPay($url,$vars);
        var_dump($data);
    }



}
