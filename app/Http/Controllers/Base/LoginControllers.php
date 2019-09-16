<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2019/7/23
 * Time: 13:17
 */

namespace App\Http\Controllers\Base;


use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Model\Member;
use App\Model\MpConfig;
use App\Model\MpUser;
use App\Model\PutCurl;
use Illuminate\Http\Request;

class LoginControllers extends Controller
{
    private $appid;

    public function __construct(Request $request)
    {

        $Referer=$request->header("Referer");//得到hender数据Referer
        if(!empty($Referer)){
            $Referer_array=(explode("/", $Referer));//Referer转成数组
            $this->appid=$Referer_array[3];//从数组中提取出appid
        }

    }

    /**
     * 小程序登陆
     *
    */
    public function xcx_login(Request $request)
    {
        $code=$request->input("code");
        $parent_code=$request->input("parent_code","");//上级编码
        $appid= $this->appid;
        $mp_config=new MpConfig();
        $config=$mp_config->get_one($appid);//根据appid 得到配置信息

        //授权得到openid
        $info=PutCurl::get_openid($config->appid,$config->appsecret,$code);
        $openid=$info["openid"];
        $session_key=$info["session_key"];
//        $openid=1;
//        $session_key="session_key";
        $mp_user=new MpUser();
        $check_info=$mp_user->checkUser($openid,$appid);//判断用户信息

        $check_info["parent_tuan"]=false;
        $check_info["sessionKey"]=$session_key;//sessionkey
        if(!empty($parent_code)){
            $user_m=new Member();
            $user_m->checkTuan();
        }
        success_return($check_info);
    }

    /**
     * 设置用户信息
     * sessionKey
     * encryptedData
     * iv
     * token
    */
    public function setuserinfo(Request $request)
    {
        $sessionKey=$request->input("sessionKey");
        $encryptedData=$request->input("encryptedData");
        $iv=$request->input("iv");
        $token=$request->input("token");
        $mpuser=new MpUser();
        $data=$mpuser->saveuserinfo($this->appid,$sessionKey,$encryptedData,$iv,$token);//解析用户信息
        success_return($data,"更新成功");
    }
}