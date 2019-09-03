<?php

namespace App\Model\Pay;

use App\Lib\alipay\Aop\AopClient;
use App\Model\MpConfig;
use App\Model\Order;
use App\Model\OurOrder;
use EasyWeChat\Factory;
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

     protected $privateKey="MIIEogIBAAKCAQEAp5zBRnxEUm+C4Q2Sf0jgkpKD3Gr/AkFnc6v8hQ/uv+Y0zgOzGMQ89M1S90Pq2SLI8PKVR9wZ0PkeM5qqsB28VFtmmudoa3juPCtyBCs4Gxm5AQBGvLyapMkRXb6RcTChh3r1wOEwXEpyVG0iiL4MtkahBVeaPqssRo8BVokrKtfoyVJXTQgkkfwHabkQPL3jTn0TAsN7WPdyRkeSV1BNP2fHQv5f9RAqEwHTSfHKh62SiMg+WiU/71KiHrcg9HArqHLo2mYJ7SaOG1I54+mTlifXr4nW6v5kakdM4Xe/xSenP9wbKqodyVkwLIuOixDU8SAeE3C0hgQOi6WcjdaZGQIDAQABAoIBAGAaoDNTAzWlHIz/5DS5S5KfEZ4rd0YKzE9lmKeO6Bz92N8a/fDAbBcNN3nxZlHUARUucmu+hsrsW+XI0/+hPR+9PIqrDpM4xpiXbIt5YHUhfZNWXjjPh3feleeDYg9di/CLjydltv3j7cP8w2VWWyGUQ7U1copmST+3tVOx2J96ORxS0q1CKB8msMiznZ/FZc7LOsQn/l4xXSeAW2Ddp8fiRFiLydmZbeKhw9cl5fdMzLRy4H68tDyM68Xb/RjNy9EzlizCKdbn2crd4yQLssptnlYsQILu1sNzwk7kO98LYz9h/VRLvV8ZwK6FZEmWr1dsqwSmdz8/PZqIVXrw34UCgYEA1qkZOPlwvFx7IkeGB+Lhv1mrMXkJaf0QgZHZbZvqYDr/3JMJtMiAySHa0hfQtkCSJtATir3phniV/7hiv9q5HflWDETWh41pE4lfycDHMr5QhbGo2iTXwK5b+R1oYPthSLLrakwkUch9TYj7nAhbEVQSS3yaWCHmjfNjwLN9uZMCgYEAx+QmPZNi8Ka2Bw7cu/Uz1E0a5vxKW1RscikE2Pk5FJThzr/zdAsRKeilTTuSyDMBJqxe9uUZsEIWYCXeotZfWYCZjvASTwGEH/ofMoDe+0kiFY7Qh7XkvF3hWuavaJN7nl+PMJdkGMpGYDHYNe+QLBeLvsFdl9/gujmIwhzdHiMCgYB0vFDzIvOj+8caxTqmX0PVA7aNmPz9npmzXNWZPgkfe/ZYxb2pisA+oSKWzky6UDMq2E1ITi8I6droziUloJS7MDUTRvxDiytxbGujFCs/9S9lBVCGETMjna52sv9ofkxRdLuBexblQtqhp7TtDb44lje8xW5KL2VqHMpKqVHd8QKBgBePACLJuCN8wn9adRGB+LXQ0JbgrTLOZGmgA/4+gUe3tFVVsi+/DirOTI0ptEb8G+qe7iJTJg/r+g8i53ZxpZM64N5D1SSSnSvXos2k+qLLH8VCq7kS6v54YhMAlTPSDgPAZ3Pmo9l4HYtA1KamsWtA6yt0Rr+blzTbiw61sCnZAoGASeFsgYL26bcCHA+Qb8JxReqcs+/GF/ryg+VtMaAXO5r2q4nWm/nrdi7Qo44/rluOQ4pgOMpGdxPeTho0DJDdmza8xZo3w51KMYokFIzrWItPiHadz3F7+TE9/28iC2yK1XP3UbS5btM1G+fkzyjHXVCwN3dI4vWWqku3hJXRyPo=";
     protected $alipayrsaPublicKey="MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlFEK5RhIqrEl0kBMXWBOwhZIWVLTY28ctewVYemJ8VOeedBoOE56hUEYcoeLnn68omn3KzNZz8bBXyTfc0vPuK3dC8ucDKx6JJOEZa20LFs1kiXltef3ZtXg48fue/56DupwFwvQObFLH6hNcSw6apPhNYiGI5+bmtHs+wdRQS/i0hl1eK65uLsttDh4kxZdxLr/GpOQ3nQbw7ZdOTbGVPjdsIdZUNE6v+4Y6o2cEkI9Te/bEKF4FiHmqmMvldXh9OPVYn1d7t8hnuDVFYKN8U+GuZJlvCeDFyzq/C6maHMqqtODnmKdus5Bt0yNI+yOgFLqwjpZUdUE+zwZsYIOMwIDAQAB";
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



    public function buildWxPay($order_info,$openid)
    {
        $config = [
            // 必要配置
            'app_id'             => 'wxcb1ae450a2189056',
            'mch_id'             => '1511681811',
            'key'                => '29c47844e4cd2eef0060bf844cc17053',   // API 密钥


            'notify_url'         => 'https://pingoufan.com',     // 你也可以在下单时单独设置来想覆盖它
        ];
        $app =Factory::payment($config);


        $isContract = true;

        $result = $app->order->unify([
            'body' => '腾讯充值中心-QQ会员充值',
            'out_trade_no' => '20150806125346',
            'total_fee' => 88,
            'spbill_create_ip' => '123.12.12.123', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
            'notify_url' => 'https://pay.weixin.qq.com/wxpay/pay.action', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
        ]);


        var_dump(123);
        var_dump($result);
        exit;

    }



    public function pay($openid,$order_info,$type){



        if($type=="wx"){
            $pay_info=$this->buildWxPay($order_info,$openid);
        }else{
            $pay_info=$this->buildAliPay($order_info,$openid);
        }

        return $pay_info;
    }

    /**
     * 得到支付宝支付基础数据
    */
    public function getalipaybase($order_info){

      $aopclient=new \AopClient();
        $aopclient->gatewayUrl="https://openapi.alipay.com/gateway.do";
        $aopclient->appId ="2019090266833344";
        $aopclient->rsaPrivateKey  =$this->privateKey;
        $aopclient->alipayrsaPublicKey   =$this->alipayrsaPublicKey;
        $aopclient->apiVersion   ="1.0";
        $aopclient->signType    =$this->sign_type;
        $aopclient->postCharset = 'UTF-8';
        $aopclient->format = "json";



        $appRequest = new \AlipayTradeAppPayRequest();


        $biz_content = array(
            'body' => $order_info->order_no,
            'subject' => "测试订单" ,
            'out_trade_no' => $order_info->order_no,
            'timeout_express' => "7c",
            'total_amount' => $order_info->order_amount,
            "product_code"=>"QUICK_MSECURITY_PAY"
        );

        $url="https://pingoufan.com/ourback";
        $appRequest->setNotifyUrl($url);
        $appRequest->setBizContent(json_encode($biz_content));
        $response = $aopclient->sdkExecute($appRequest);


        $return["url"]=$response;

        $return["trade_no"]=$order_info->order_no;
        $return["price"]=$order_info->order_amount;
        return $return;
    }
    public function buildalipay($order_info,$openid)
    {


        $data=$this->getalipaybase($order_info);

        $pay_info=[
            "app_id"=>$this->appid,
            "sign_type"=>"MD5",
            "timestamp"=>time()."",
            "trade_no"=>$data["trade_no"],
            "merchant_id"=>$this->merchant_id,
            "uid"=>$openid,
            "total_amount"=>$data["price"]*100,
            "params"=>json_encode(["url"=>$data["url"]])
        ];
        $pay_info=$this->build_base($pay_info);

        $pay_info["method"]="tp.trade.confirm";
        $pay_info["pay_channel"]="ALIPAY_NO_SIGN";
        $pay_info["pay_type"]="ALIPAY_APP";
        $pay_info["risk_info"]=json_encode(["ip"=>$_SERVER['SERVER_ADDR']]);


        success_return($pay_info);
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
