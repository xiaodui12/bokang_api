<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 8:45
 */

namespace App\Http\Controllers;


use App\Model\Member;
use App\Model\MpConfig;
use App\Model\MpUser;
use App\Model\PutCurl;
use App\Model\Token;
use App\Model\Xcx;
use Illuminate\Http\Request;

class IndexControllers extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {

        if(is_weixin()){
            $code=$request->input("code","");
            $openid=session("openid");
            $token=session("token");

            if(empty($token)&&empty($code))
            {
                PutCurl::get_mp_code("youqu");
                exit;
            }elseif (empty($token)&&!empty($code)){
                $user_info=PutCurl::get_mp_userinfo("youqu",$code);
                $mp_user=new MpUser();
                $token=$mp_user->checkUser($user_info["openid"],$user_info["appid"]);//判断用户

                $mp_user->change_userinfo($user_info["appid"],$user_info["openid"],$user_info["user_info"],$token["token"]);//更新用户信息数据
            }
        }

//        echo 123456;
        return view("master");
    }

    /**
     * 得到用户信息
    */
    public function getuser_info(){
        $token=session("token");
        empty($token)&&error_return("用户未登录");

        $token_info=(new Token())->get_token($token);

        $return_array=array();
        $member=new Member();
        $return_array["is_tuan"]=$member->checkTuan($token_info["uid"]);
        $return_array["invitation"]=$member->getinvitation($token_info["uid"]);

        success_return($return_array);

    }
}