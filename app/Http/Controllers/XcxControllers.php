<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 17:27
 */

namespace App\Http\Controllers;


use App\Model\Token;
use Illuminate\Http\Request;

class XcxControllers extends Controller
{
    protected $appid;
    protected $uid;
    protected $openid;
    public function __construct(Request $request)
    {
        $Referer=$request->header("Referer");//得到hender数据Referer
        if(!empty($Referer)){
            $Referer_array=(explode("/", $Referer));//Referer转成数组
            $this->appid=$Referer_array[3];//从数组中提取出appid
        }

        $token=$request->input("token","");
//        empty($token)&&error_return("参数错误");//判断参数是否为空

        $token_m=new Token();
        $user_info=$token_m->get_token($token);//得到token保存数据

//        empty($user_info)&&error_return("token验证错误");

        $this->openid=$user_info["openid"];
        $this->uid=$user_info["uid"];
//        $this->uid=1;
    }
}