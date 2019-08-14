<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SupplierApply extends Model
{
    protected $table="bokang_supplier_apply";

    public  $status=array("0"=>"申请中","1"=>"审核成功","2"=>"审核失败");


    /**
     * 判断是否已经申请
    */
    public static function checkApply($uid)
    {
        $info=self::where("uid",$uid)->first();
        $return_array=array(
            "status"=>-1,
            "status_label"=>"未申请"
        );
        if(!empty($info)){
            $return_array["status"]=$info["status"];
            $return_array["status_label"]=(new self)->status[$info["status"]];
        }
        ($info["status"]==2)&&($return_array["error_msg"]=$info["error_msg"]);
        return $return_array;
    }


    /**
     * 保存申请
     *
    */
    public static function saveApply($uid,$request){
        $status=self::checkApply($uid)["status"];

        if($status!=-1&&$status!=2){
            error_return("您已申请，请不要重复提交");
        }
        $save["uid"]=$uid;
        $save["name"]=$request->input("name","");
        $save["phone"]=$request->input("phone","");
        $save["remark"]=$request->input("remark","");
        if(empty($save["phone"])||empty(  $save["name"])){
            error_return("请输入姓名和手机号");
        }
        $save["status"]=0;
        $save["created_at"]=date("Y-m-d H:i:s");
        if($status==-1){
            //新增数据
            self::insert($save);
        }else{
            //更新数据
            self::where("uid",$uid)->update($save);
        }
    }
}
