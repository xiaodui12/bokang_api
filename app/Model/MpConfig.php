<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MpConfig extends Model
{


    protected $table = 'bokang_mp_config';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    //
    public function get_one($appid){
        $mp_info=$this->where("appid",$appid)->first();
        return $mp_info;
    }


    public static function getpayconfig($appid){
       $self= new self();
        $info=$self->get_one($appid);


        $config = [
            // 必要配置
            'app_id'             => $info["appid"],
            'mch_id'             => $info["mchid"],
            'key'                =>$info["mchkey"],   // API 密钥

            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            'cert_path'          => '', // XXX: 绝对路径！！！！
            'key_path'           => '',      // XXX: 绝对路径！！！！

            'notify_url'         => "https://".$_SERVER['SERVER_NAME']."/ourwechetback/appid/".$appid,     // 你也可以在下单时单独设置来想覆盖它
        ];


        return $config;
    }



    /**
     * 根据appid得到appsecret和token
    */
    public function gettoken($appid)
    {
        $wx_info=$this->get_one($appid);//得到微信公众号信息
        empty($wx_info)&&error_return("小程序信息错误");
        $appsecret=$wx_info->appsecret;
        $token=$wx_info->token;
        //token 是否已过期 过期，重新获取
        if($wx_info->token_expire<time()){
            //得到token
            $info=PutCurl::get_token($appid,$appsecret);
            $token=$info["access_token"];

            //重新赋值。赋值不成功返回错误
            $wx_info->token=$token;
            $wx_info->token_expire=time()+3600;
            !$wx_info->save()&&error_return("token更新错误");
        }
        return array("appsecret"=>$appsecret,"token"=>$token);
    }
}
