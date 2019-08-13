<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PutCurl extends Model
{


    /**
     * 得到小程序token
     */
    public static function get_token($appid,$appsecret)
    {
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        return self::wx_get($url,"获取token错误");
    }


    /**
     * 获得openid
     * $appid
     * $appsercert
     * $code 登陆code
     */
    public static function get_openid($appid,$appsecret,$code)
    {
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$code."&grant_type=authorization_code";
        return self::wx_get($url,"登陆失败，请联系管理员");
    }

    /**
     * 得到公众号用户信息
     * $type 公众号类型
     * $code code
    */
    public static function get_mp_userinfo($type,$code)
    {
        $app_info=Xcx::get_info_by_type($type);//得到公众号信息
        $openid_array=self::get_mp_openid($app_info["appid"],$app_info["appsecret"],$code);//得到openid
        $user_info=self::get_userinfo($openid_array["access_token"],$openid_array["openid"],$app_info);//得到用户信息

        return array("appid"=>$app_info["appid"],"openid"=>$openid_array["openid"],"user_info"=>$user_info);//返回用户信息，公众号信息
    }
    /**
     * 得到公众号openid
     * $appid appid
     * $appsecret
     * $code  授权code
    */
    public static function get_mp_openid($appid,$appsecret,$code){
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        return self::wx_get($url,"登陆失败，请联系管理员");
    }
    /**接口得到微信用户信息
     *
    */
    public static function get_userinfo($token,$openid){
        $url="https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
        return self::wx_get($url,"登陆失败，请联系管理员");
    }

    /**
     * 获取验证码
     * $token 小程序token，
     * $data 请求数据
     */
    public static function get_scene($token,$data)
    {
        $url="https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$token;
        $info=curlPost($url,$data,'img');
        !empty($info["errcode"])&&error_return("获取二维码失败：".$info["errcode"]);
        return $info;
    }
    /**
     * 公众号跳转授权
     */
    public static function get_mp_code($type){
        $redirect_uri = urlencode ( 'https://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"] );
        $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".Xcx::get_appid($type)."&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
        header("location:".$url);
        exit;
    }

    /**
     * 微信get提交，并验证返回
     * $url 链接
     * $msg  提示语
    */
    public static function wx_get($url,$msg){
        $info=curlGet($url);
        !empty($info["errcode"])&&error_return($msg."。错误码：".$info["errcode"]);
        return $info;
    }


}
