<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class Address extends Model
{
    use SoftDeletes;
    protected $table = 'bokang_user_address';


    public  function getList($uid,$type="douyin")
    {
        $list=$this->where("type",$type)->where("uid",$uid)->paginate(15);
        return $list;
    }
    public function getDetail($uid,$id)
    {
        $detail=$this->where("address_id",$id)->where("uid",$uid)->first();
        return $detail;
    }
    public function getDefault($uid,$id)
    {
        $detail=$this->where("uid",$uid)
            ->when(!empty($id),function ($query)use($id){
                $query->where("address_id",$id);
            })
            ->OrderBy("is_default","dese")->first();
        return $detail;
    }

    public function setDefault($uid,$id)
    {
        DB::beginTransaction(); //开启事务
        try{

            $default=$this->where("uid",$uid)->where("is_default",1)->update(["is_default"=>0]);
            $save=$this->where("uid",$uid)->where("address_id",$id)->update(["is_default"=>1]);
            if($default===false||$save===false){
                throw new Exception("设置失败");
            }
            DB::commit();
            return true;
        }
        catch (Exception $exception){
            DB::rollback();  //回滚
           return false;
        }

    }

    public function saveDetail($detail)
    {
        if(empty($detail["id"])){
            unset($detail["id"]);
            $detail["type"]="douyin";
            $detail["created_at"]=date("Y-m-d H:i:s");
            $result=$this->insert($detail);

        }else{
            $id=$detail["id"];
            $detail["updated_at"]=date("Y-m-d H:i:s");
            $result=$this->where("address_id",$id)->update($detail);
        }
        if($result){
            success_return("更新成功");
        }else{
            error_return("更新失败");
        }

    }
    public function deleteAddress($uid,$id){
        return $this->where("uid",$uid)->where("address_id",$id)->delete();



    }


}
