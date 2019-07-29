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
                if(!(new Team())->add_one($uid)){
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
}
