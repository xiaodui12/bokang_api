<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 17:26
 */

namespace App\Http\Controllers\Taobao;



use App\Model\System;
use Illuminate\Http\Request;

class IndexControllers extends BaseControllers
{

    /**
     * 前端转接口
    */
    public function getsend(Request $request)
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');

        $data=$request->input();
        if(empty($data["method"])){
            error_return("参数错误");
        }
        $type=$data["method"];
        $return_data=$this->send_all($this->url,$type,$data);
        success_return($return_data);
    }
}