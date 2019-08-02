<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'bokang_user';

    /**
     * 判断是否是团长
     * $uid  用户id
     */
    public function checkTuan($uid){
        return $this->where("id",$uid)->value("is_tuan");
    }
    /**
     * 得到邀请码
     * $uid  用户id
     */
    public function getinvitation($uid){
        return $this->where("id",$uid)->value("invitation");
    }
    /**
     * 判断是否是团长
     * $code  用户邀请码
     */
    public function checkTuanByCode($code){
        return $this->where("invitation",$code)->value("is_tuan");
    }

    /**
     * 设置用户信息
     * $data 更新数据
     * $unionid  用户唯一标识
    */
    public function saveuserinfo($data,$unionid)
    {
        $user_uid=$this->where("unionid",$unionid)->first();//根据unionid 得到用户信息
        $set_uid= $user_uid?$user_uid["id"]:"";

        $is_tuan=false;
        $invitation="";
        //用户id不存在,新增用户
        if(empty($set_uid))
        {
            $data["is_tuan"]=0;
            $data["create_time"]=time();
            $data["status"]=1;
            $data["invitation"]=$data["unionid"];
            $invitation= $data["invitation"];
            $set_uid=$this->insertGetId($data);//添加新用户
            empty($set_uid)&&error_return("创建用户失败");//创建失败抛出异常
        }else{
            $data["update_time"]=time();
            $result=$this->where("id",$set_uid)->update($data);//更新用户
            !$result&&error_return("创建用户失败");//更新失败，抛出异常
            $is_tuan=$user_uid["is_tuan"];
            $invitation=$user_uid["invitation"];
        }
        $return_array=array(
            "set_uid"=>$set_uid,
            "is_tuan"=>$is_tuan,
            "invitation"=>$invitation
        );
        return $return_array;// 返回用户id

    }

    /**
     * 利用邀请码得到用户id
     * $code 邀请码
    */
    public static function getidBycode($code){
       $id= self::where("invitation",$code)->value("id");
       return $id?$id:0;
    }
}
