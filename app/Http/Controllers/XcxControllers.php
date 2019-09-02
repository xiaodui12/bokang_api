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

        $url="toutiao";
        if(!empty($Referer)&&!strpos($Referer,"toutiao")){
            $Referer_array=(explode("/", $Referer));//Referer转成数组
            $this->appid=$Referer_array[3];//从数组中提取出appid
        }
        if(!empty($Referer)&&strpos($Referer,"toutiao")>0){
            $arr = parse_url($Referer);
            $arr_query = $this->convertUrlQuery($arr['query']);
            $this->appid=$arr_query["appid"];//从数组中提取出appid
        }

        $token=$request->post("token","");

        empty($token)&&error_return("参数错误");//判断参数是否为空

        $token_m=new Token();
        $user_info=$token_m->get_token($token);//得到token保存数据

        empty($user_info)&&error_return("token验证错误");

        $this->openid=$user_info["openid"];
        $this->uid=$user_info["uid"];
//        $this->uid=1;
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
}