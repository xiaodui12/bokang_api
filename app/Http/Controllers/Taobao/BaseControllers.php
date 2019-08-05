<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/24
 * Time: 8:25
 */

namespace App\Http\Controllers\Taobao;


use App\Http\Controllers\Controller;
use App\Model\System;
use Illuminate\Http\Request;

class BaseControllers extends Controller
{
    protected   $url="http://gw.api.taobao.com/router/rest";



    /**
     * 发送接口
     * $url 拼多多访问链接
     * $type 访问类型
     * $data  接口参数
     */
    public function send_all($url,$type,$data){


        $data["method"]=$type;
        $data["app_key"]="27720626";
        $data["sign_method"]="md5";
        $data["timestamp"]=time();
        $data["format"]="json";
        $data["v"]="2.0";



        $pdd_client_secret="bb6a8db3cd997ad744c73d21db4fed66";//拼多多secret

        //-------拼接签名字符串
        $string=$pdd_client_secret;
        ksort($data);//info排序
        foreach ($data as $key=>$value){
            $string.=$key.$value;
        }
        $string.=$pdd_client_secret;
        //-------拼接签名字符串

        $data["sign"]=strtoupper(md5($string));//生成签名并转大写
        $url=$url."?".http_build_query($data);//拼接链接
        $data=curlGet($url);//获取链接信息

        return $data;//返回信息
    }

}