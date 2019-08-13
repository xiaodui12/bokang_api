<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Xcx extends Model
{

    protected static $appid_array=array(
        "pdd"=>"wxc38a0fa6e87b9fd7",
        "youqu"=>"wxcb1ae450a2189056"
    );

    /**
     * 得到小程序二维码
     * $request  请求参数
    */
    public static function get_scene($request)
    {

        $type= $request->input("type","pdd");//得到类型
        $appid=self::$appid_array[$type];//appid
        $wx_info=(new MpConfig())->gettoken($appid);
        $data["scene"]=$request->input("scene","1");
         !empty($request->input("page",""))&&($data["page"]=$request->input("page",""));
         !empty($request->input("width",""))&&($data["width"]=$request->input("width",""));
         !empty($request->input("auto_color",""))&&($data["auto_color"]=$request->input("auto_color",""));
         !empty($request->input("line_color",""))&&($data["line_color"]=$request->input("line_color",""));
         !empty($request->input("is_hyaline",""))&&($data["is_hyaline"]=$request->input("is_hyaline",""));


         $info=PutCurl::get_scene($wx_info["token"],$data);
        return $info;

    }

    public static function get_appid($type){
        return self::$appid_array[$type];
    }
    /**
     * 根据type得到公众号信息
    */
    public static  function get_info_by_type($type){
        $app_info=(new MpConfig())->get_one(self::$appid_array[$type]);
        return $app_info;
    }
}
