<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MpUser extends Model
{
    protected $table = 'bokang_mp_user';


    /**
     * 判断用户
     * $openid  当前用户openid
     * $appid  当前程序appid
     **/
    public function checkUser($openid,$appid)
    {
        $return_array=array();
        //得到用户信息
        $mp_user=$this->where("openid",$openid)->where("appid",$appid)->first();

        $return_array["is_tuan"]=false;//默认不是团长
        //当用户不存在，添加当前用户
        if(empty($mp_user))
        {
            $this->add_user($openid,$appid);//添加用户
        }
        elseif(!empty($mp_user["uid"])){
            $userM=new Member();
            $is_tuan=$userM->checkTuan($mp_user["uid"]);//得到用户是否是团长
            $return_array["is_tuan"]=$is_tuan?true:false;
        }

        //设置token
        $token=new Token();
        $token_info=$token->set_token($openid,$appid,empty($mp_user)?"":$mp_user["uid"]);
        $return_array["token"]=$token_info;

        return $return_array;
    }

    /****
     * 新增当前用户
     * $openid  当前用户openid
     * $appid  当前程序appid
     */
    private function add_user($openid,$appid)
    {
        $add_array=array();
        $add_array["openid"]=$openid;//用户openid
        $add_array["appid"]=$appid;//用户appid
        $add_array["create_time"]=time();
        $mp_id=$this->insertGetId($add_array);
        //用户创建失败
        !$mp_id&&error_return("用户创建失败");

        return $mp_id;
    }



    public function saveuserinfo($appid,$sessionKey,$encryptedData,$iv,$token)
    {
        $info=$this->Decrypt($appid,$sessionKey,$encryptedData,$iv);
        $openid=$info["openid"];


        $save["nickname"]= $info["nickName"];//昵称
        $save["sex"]= $info["gender"];//性别
        $save["head"]= $info["avatarUrl"];//头像
        $save["country"]= $info["country"];//国家
        $save["province"]= $info["province"];//省份
        $save["city"]= $info["city"];//城市
        $save["language"]= $info["language"];//显示 country，province，city 所用的语言
        if(!empty($info["unionId"])){
            $save["unionid"]= $info["unionId"];
        }
        $save["nickname"]=filterEmoji($save["nickname"]);


        $first=$this->where("openid",$openid)->where("appid",$appid)->first();//得到用户信息
        if(empty($first)){
            error_return("用户不存在，或用户信息错误");
        }

        $result=$this->where("openid",$openid)->where("appid",$appid)->Updates($save);//保存更新信息
        if(!$result){
            error_return("更新失败，请重试");
        }

        if(!empty($save["unionid"])){
            $userM=new Member();
            $return_info=$userM->saveuserinfo($save,$first["unionid"]);

            if(empty($first["uid"]))
            {
                $result=$this->where("id",$first["id"])->Updates(array("uid"=>$return_info["set_uid"]));
                !$result&&error_return("信息错误");
                $token_m=new Token();
                $token_m->refresh_info($token,$return_info["set_uid"]);
            }
        }
    }
    private  function Decrypt($appid,$sessionKey,$encryptedData,$iv){
        //解析加密数据
        $pc = new \WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );
        //手机号正确
        if ($errCode == 0) {
            $data=json_decode($data,1);
            return $data;
            //新增手机号
        }else{
            error_return("加密信息解析错误");
        }
    }


}
