<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2019/7/23
 * Time: 13:17
 */

namespace App\Http\Controllers\Douyin;


use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Model\Member;
use App\Model\MpConfig;
use App\Model\MpUser;
use App\Model\PutCurl;
use App\Model\Token;
use Illuminate\Http\Request;

class LoginControllers extends Controller
{
    private $appid;
    protected $openid;

    public function __construct(Request $request)
    {

        $Referer=$request->header("Referer");//得到hender数据Referer

        if(!empty($Referer)){
            $arr = parse_url($Referer);
            $arr_query = $this->convertUrlQuery($arr['query']);
            $this->appid=$arr_query["appid"];//从数组中提取出appid
        }
        $token=$request->input("token","");
        if(!empty($token)){

            $token_m=new Token();
            $user_info=$token_m->get_token($token);//得到token保存数据
            $this->openid=$user_info["openid"];
            $this->uid=$user_info["uid"];
        }




    }
    /**
     * 将字符串参数变为数组
     * @param $query
     * @return array array (size=10)
    'm' => string 'content' (length=7)
    'c' => string 'index' (length=5)
    'a' => string 'lists' (length=5)
    'catid' => string '6' (length=1)
    'area' => string '0' (length=1)
    'author' => string '0' (length=1)
    'h' => string '0' (length=1)
    'region' => string '0' (length=1)
    's' => string '1' (length=1)
    'page' => string '1' (length=1)
     */
    function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }
    /**
     * 将参数变为字符串
     * @param $array_query
     * @return string string 'm=content&c=index&a=lists&catid=6&area=0&author=0&h=0®ion=0&s=1&page=1' (length=73)
     */
    public function getUrlQuery($array_query)
    {
        $tmp = array();
        foreach($array_query as $k=>$param)
        {
            $tmp[] = $k.'='.$param;
        }
        $params = implode('&',$tmp);
        return $params;
    }

    /**
     * 小程序登陆
     *
     */
    public function xcx_login(Request $request)
    {
        $code=$request->post("code");
        $anonymous_code=$request->post("anonymous_code","");
        $parent_code=$request->post("parent_code","");//上级编码
        $appid= $this->appid;
        $mp_config=new MpConfig();

        $config=$mp_config->get_one($appid);//根据appid 得到配置信息
        //授权得到openid
        $info=PutCurl::get_openid($config->appid,$config->appsecret,$code,$anonymous_code);
        $openid=$info["openid"];
        $session_key=$info["session_key"];
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
        $token=$request->post("token","");
        $save["headimgurl"]=$request->post("avatarUrl","");
        $save["nickname"]= $request->post("nickName","");//昵称
        $save["sex"]= $request->post("gender","");//性别
        $save["country"]= $request->post("country","");//国家
        $save["province"]= $request->post("province","");//省份
        $save["city"]= $request->post("city","");//城市
        $save["language"]= $request->post("language","");//显示 country，province，city 所用的语言
        $save["unionid"]=$this->openid;
        $data= (new MpUser())->change_userinfo($this->appid,$this->openid,$save,$token);
        success_return($data,"更新成功");
    }
}