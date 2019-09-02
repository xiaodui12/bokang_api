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
    protected $sign_type="RSA2";
    protected $merchant_id="1900014826";

    protected $privateKey="MIIEpQIBAAKCAQEAjFs4N+3MkyUmwCEydME2hlRL4b3tbGet+jZIPIRWYvl0sXixwR/jRwO/RzIwOKSmZTqcP6v8WRiBMEkweqDbQatrzMULSheS3IRxmO7QYi8GiwOD6OwVd52IOXcFzu/AloHuRybaziUpSHNJ3ApAoqZPSqqQowcMXKiPZHyGY5nZO97JpIc5iMJrFOXzoxRZ7JduOeoResVK/hRPs8xC6+P3apxIL63Jkw0MwT5qXeyu3XTCaMhcczT35Tjepa24HauMnxTjJ6FQBpiFW4FJKatG0Ank/ZP65J6eGI0H9u5tk1N2pQV0OfWYxQGzDDrzoG3Ox3BDyAL6djfBXpZf2wIDAQABAoIBABoUsUOjSoplMugswwVzCcC4VUljU4T7VxbRk2a7aJoHpKl9tfofBMqjZZ3DM7ay0cCpvXMPcFrV9NuWHg4LafKv+d4ZF1nzO3UCn2E9rzcvadXXF2HmzK5ndXLILSog3vaYukA6dhosSZmO4sCinxQaN022mB3TJ3boU4zmnspO+jcVgoIcmrlf5aJCO/JhrSgJCsruTRtfACvfOGBDxNV3OsoHVoNcyZ4kmM0pi81Mlab5bInuAfgcSwWsrSuNEgwVBNoFODT6fCcPuHFbKbUAk5SnsivZQEzuTpGBzrte9/8EPvEd9SDS8wZ9Jaj5Wgk+wcuWkv9KOQtNrT5CRrECgYEA61JDb7YMr4cCWAi0YQKS2EsQPJGiBx12qHGdfowBY43tPDsC/LMBzzGqfcaJn6xhVJi1dYvM3ikwdTsnJZFv2TVPYv12wwTqW6A77P8gz5IhdAiM40KQ1CEiVV71mroqkjxO8/ozaqpQv/s2V5yv9Amz377IDsn0UMUpZJsuzq8CgYEAmLCk8hfeHxeD+UWgj+GYron61kGhoiWOTDdMOOLsRg1dsHBCINc0g2ELTKP20jOTR1vDpBL0Q5g2Tr3rfPPn0S1qDyoWfWzHqf5EDW2Uq4kclVQYbCanlB0bw4lcOaAz/7Ua1g1O8SjjnsfbVJSFAc30RIACa0XXU8QAmlDOLJUCgYEAoCweOqtvdwouTj2eiWl3CkINiyyVXMJxQbYTvU8OovS3xYdlQRuW37Cum23HvydWGH7ZBGljyNPAaAsbWjbkKrRelMJxU8zEuBkYsPf3HVIZ8yDexNFKQxlKhVFdWzPcRi1GkEp9NN04mXQkSP4dxb3U8TaqdWaBJXkN86ys74ECgYEAj1TCgb+F8wnQCR8jKe1LtgwwOxBA+kTm3wTJuFzMDrZdTFMUwF9EHE/sm3UPLSLdDg9GB68DPLCVyjTd6d3LrsBC3xlTI0oJ47mbiD9lX+DFxCe9BUkD5jWs6lD3EeEg7tjC6Ex13kvT4Ckb6rnAYYFD20mO+8QD7c4AAtv3rkECgYEA3OowPVPRh7WrD8EhBc0bIr2GkcFYe+yfK2z7dm6wqZ2dOxot9CK4XSiyg6XgkZOuowUaX3k1px2xEDFnERJAs8Nqx8MzSDggbrfMAFFWJS2VnLNlQJuWkOdUDikcJ6dts4NKVTkxEsbnVLObFnSvIwYGcYkiBLtf9oqvh+E37TQ=";


    public function build_base($data){


        ksort($data);
        $var = '';
        foreach($data as $key => $value){
            $var .= $key.'='.$value.'&';
        }
        $var = trim($var,'&');

        $c = $var.$this->secret;

        $data['sign'] = MD5($c);

        return $data;
    }
    public function pay($openid){



        $order_id="123";
        $price=1;
        $biz_content = array(
            'body' => "测试订单",
            'subject' => "测试订单" ,
            'out_trade_no' => $order_id,
            'timeout_express' => "7c",
            'merchant_id'=>"1900014826",
            'total_amount' =>$price,
            "product_code"=>"QUICK_MSECURITY_PAY"
        );

        $data=$this->buildalipay($biz_content);

        $pay_info=[
            "app_id"=>$this->appid,
            "sign_type"=>"MD5",
            "timestamp"=>time()."",
            "trade_no"=>$order_id,
            "merchant_id"=>$this->merchant_id,
            "uid"=>$openid,
            "total_amount"=>$price*100,
            "params"=>json_encode(["url"=>$data])
        ];
        $pay_info=$this->build_base($pay_info);

        $pay_info["method"]="tp.trade.confirm";
        $pay_info["pay_channel"]="tp.trade.confirm";
        $pay_info["pay_type"]="ALIPAY_APP";
        $pay_info["risk_info"]=json_encode(["ip"=>$_SERVER['SERVER_ADDR']]);


        success_return($pay_info);
    }



    public function buildalipay($data)
    {

        $alipay_info=array(
            "app_id"=>"2019083166763325",
            "method"=>"alipay.trade.app.pay",
            "charset"=>"utf-8",
            "sign_type"=>$this->sign_type,
            "timestamp"=>date("Y-m-d H:i:s"),
            "version"=>"1.0",
            "notify_url"=>"1.0",
            "biz_content"=>json_encode($data),
        );
        return $this->buildGetUrl($alipay_info);
    }
    function trimall($str){
        $qian=array(" ","　","\t","\n","\r");
        return str_replace($qian, '', $str);
    }


    public function buildGetUrl( $query = array() ){

        if( ! is_array( $query ) ){
            //exit;
        }
        //排序参数，
        $data = $this -> buildQuery( $query );


        // 私钥密码
        $passphrase = '';
        $key_width = 64;

        //私钥
        $privateKey = $this -> privateKey;
        $p_key = array();
        //如果私钥是 1行
        if( ! stripos( $privateKey, "\n" )  ){
            $i = 0;
            while( $key_str = substr( $privateKey , $i * $key_width , $key_width) ){
                $p_key[] = $key_str;
                $i ++ ;
            }
        }else{
            //echo '一行？';
        }
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" . implode("\n", $p_key) ;
        $privateKey = $privateKey ."\n-----END RSA PRIVATE KEY-----";

//		echo "\n\n私钥:\n";
//		echo( $privateKey );
//		echo "\n\n\n";

        //私钥
        $private_id = openssl_pkey_get_private( $privateKey , $passphrase);


        // 签名
        $signature = '';

        if("RSA2"==$this->sign_type){

            openssl_sign($data, $signature, $private_id, OPENSSL_ALGO_SHA256 );
        }else{

            openssl_sign($data, $signature, $private_id, OPENSSL_ALGO_SHA1 );
        }

        openssl_free_key( $private_id );

        //加密后的内容通常含有特殊字符，需要编码转换下
        $signature = base64_encode($signature);

        $signature = urlencode( $signature );

        //$signature = 'XjUN6YM1Mc9HXebKMv7GTLy7gmyhktyOgKk2/Jf+cz4DtP6udkzTdpkjW2j/Z4ZSD7xD6CNYI1Spz4yS93HPT0a5X9LgFWYY8SaADqe+ArXg+FBSiTwUz49SE//Xd9+LEiIRsSFkbpkuiGoO6mqJmB7vXjlD5lx6qCM3nb41wb8=';

        $out = $data .'&sign='. $signature;

        return $out ;
    }
    /*
     * 查询参数排序 a-z
     * */
    public function buildQuery( $query ){
        if ( !$query ) {
            return null;
        }

//将要 参数 排序
        ksort( $query );

        //重新组装参数
        $params = array();
        foreach($query as $key => $value){
            $params[] = $key .'='. $value ;
        }
        $data = implode('&', $params);

        return $data;

    }



}
