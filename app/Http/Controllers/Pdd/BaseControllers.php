<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/24
 * Time: 8:25
 */

namespace App\Http\Controllers\Pdd;


use App\Http\Controllers\Controller;
use App\Model\System;
use Illuminate\Http\Request;

class BaseControllers extends Controller
{
    protected  $url="http://gw-api.pinduoduo.com/api/router";
    public function __construct(Request $request)
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');
        System::getpdd();
    }
    /**
     * 发送接口
     * $url 拼多多访问链接
     * $type 访问类型
     * $data  接口参数
     */
    public function send_all($url,$type,$data){

        $pdd_client_secret=config("pdd_client_secret");//拼多多secret
        //拼多多接口公共参数
        $info=array(
            "type"=>$type,//访问类型
            "timestamp"=>time(),//时间戳
            "client_id"=>config("pdd_client_id"),//拼多多配置client_id
        );

        $info=array_merge($info,$data);//公共参数  接口参数合并

        //-------拼接签名字符串
        $string=$pdd_client_secret;
        ksort($info);//info排序
        foreach ($info as $key=>$value){
            $string.=$key.$value;
        }
        $string.=$pdd_client_secret;
        //-------拼接签名字符串

        $info["sign"]=strtoupper(md5($string));//生成签名并转大写
        $url=$url."?".http_build_query($info);//拼接链接
        $data=curlGet($url);//获取链接信息
        return $data;//返回信息
    }

}