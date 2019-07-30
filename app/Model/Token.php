<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'bokang_token';

    /**
     * 根据token得到用户部分信息
     *
    */
    public function get_token($token)
    {
        $info=$this->where("token",$token)->first();
        return $info;
    }

    /**
     * 设置token
     * $openid 当前用户openid
     * $appid  当前公众号appid
     * $uid  当前用户id
    */
    public function set_token($openid,$appid,$uid="")
    {
        $info=$this->where(array("openid"=>$openid,"appid"=>$appid,"expire_time"=>array("gt",time()+4800)))->first();
        if(!empty($info)){
            return array("token"=>$info->token,"expire_time"=>$info->expire_time);
        }
        $token=$this->get_new_token($openid,$appid);//得到生成token
        $save=array();
        $save["token"]=$token;
        $save["appid"]=$appid;
        $save["openid"]=$openid;
        $save["uid"]=$uid?$uid:0;
        $save["create_time"]=time();
        $save["update_time"]=time();
        $save["expire_time"]=time()+7200;

        $result=$this->insertGetId($save);//保存token

        if($result){
            //保存成功返回数据
            return array("token"=>$token,"expire_time"=>$save["expire_time"]);
        }else{
            return $this->set_token($openid,$appid,$uid);
        }
    }

    /**
     * 生成token
     * $openid 当前用户openid
     * $appid  当前公众号appid
    */
    protected function get_new_token($openid,$appid)
    {
        $token_string=$appid.$openid.date("Y-m-d H:i").rand(100,200);
        return md5($token_string);
    }

    //新注册用户刷新信息
    public function refresh_info($token,$uid){
        $this->where("token",$token)->update(array("uid"=>$uid));
    }
}
