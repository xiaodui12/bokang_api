<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class TeamApply extends Model
{
    protected $table = 'bokang_team_apply';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function tuanuid() {
        return $this->hasOne('App\Model\Member',"id","uid");
    }

    //成功审核
    public function pass_apply($id,$uid)
    {
        $return=$this->setapply($id,$uid,true);
        return $return;
    }
    //失败审核
    public function nopass_apply($id,$uid,$msg="")
    {
        $return=$this->setapply($id,$uid,false,$msg);
        return $return;
    }
    /**
     * 审核执行
     */
    private function setapply($id,$uid,$status,$msg="")
    {
        DB::beginTransaction();
        try{


            $user_m=new Member();
            $user=$user_m->where("id",$uid)->first();
            if(empty($user)){
                throw new Exception("用户不存在");
            }
            $result=$this->where("id",$id)->update(array("status"=>$status?1:2,"error_msg"=>$msg));
            if($result===false){throw new Exception("审核失败，请重试");}
            if($status){
                $result1=(new Team())->add_one($uid);
                $result2=(new Member())->where("uid",$uid)->update(array("is_tuan"=>1));
                if(!$result1||!$result2){
                    throw new Exception("审核失败，请重试");
                }
            }

            DB::commit();
            return array("status"=>1,"msg"=>"审核成功");
        }catch (Exception $e){
            DB::reback();
            return array("status"=>0,"msg"=>$e->getMessage());
        }
    }


    /**
     * 提交申请
     * uid  用户id
     * phone 手机号
     *realname  真实姓名
     * wechet 微信号
     * lon  经度
     * lat 纬度
     */
    public function addapply($data){
        $data["status"]=0;
        $where=[
            array("uid","=",$data["uid"]),
            array("status","<=",1),
        ];
        $has=$this->where($where)->value("id");
        if($has){
            error_return("你已经申请过，请等待审核");
        }

        foreach ($data as $key=>$value){
            $this->$key=$value;
        }

        $result=$this->save($data);
        if(!$result){
            error_return("申请失败，请重试！");
        }
    }

    /**
     * 得到审核状态
     * $uid 用户id
    */
    public function getapply($uid)
    {

        //状态数组
        $apply_status=array("-1"=>"未申请","0"=>"审核中，请稍后","1"=>"审核成功","2"=>"审核失败");
        //得到申请
        $apply=$this->where("uid",$uid)->orderBy("id","desc")->first();
        $return_array=array();
        $return_array["status"]=empty($apply)?-1:$apply["status"];//申请状态

        $return_array["msg"]=$apply_status[$return_array["status"]];//提示

        if($apply["status"]==2){
            $return_array["error"]=$apply["error_msg"];//错误原因
        }

        return $return_array;
    }
}
