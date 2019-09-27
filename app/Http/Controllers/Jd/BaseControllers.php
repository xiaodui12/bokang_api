<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/24
 * Time: 8:25
 */

namespace App\Http\Controllers\Jd;


use App\Http\Controllers\Controller;
use App\Model\System;
use Illuminate\Http\Request;

class BaseControllers extends Controller
{
    protected   $url="https://router.jd.com/api";



    /**
     * 发送接口
     * $url 拼多多访问链接
     * $type 访问类型
     * $data  接口参数
     */
    public function send_all($url,$data){



        $url=$url."?".http_build_query($data);//拼接链接
        $data=curlGet($url);//获取链接信息

        return $data;//返回信息
    }

}