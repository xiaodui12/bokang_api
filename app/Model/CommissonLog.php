<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class CommissonLog extends Model
{
    protected $table="bokang_commisson_log";


    public static function getDetail($order_no){
        return self::where("order_no",$order_no)->first();
    }


    public static function addLog($type,$order_no,$order_amount=0,$share_id=0,$promotion_amount=0,$buy_id=0)
    {

        $log=self::getDetail($order_no);
        if(!$log){
            $log=new self();
            $log->type=$type;
            $log->order_no=$order_no;
            $log->all_price=$order_amount;
            $log->share_id=$share_id;
            $log->buy_id=$buy_id;
            $log->share_money=$promotion_amount;
            $result=$log->save();
            return $result;
        }
    }
    public static function sendCommisson($order_no){
        $log=self::getDetail($order_no);

        if(empty($log)||$log->status==0)
        {
            return true;
        }

        DB::beginTransaction(); //开启事务
        try{
            if(!empty($log["share_id"])&&$log["share_money"]>0)
            {
                $share_uid=$log["share_id"];
                $share_money=$log["share_money"];
                $share=Member::addCommon($share_uid,$share_money);
            }else
            {
                $share=true;
            }
            if(!$share){
                throw new Exception("佣金更新失败");
            }
            $log->status=1;
            $result=$log->save();
            if(!$result){
                throw new Exception("佣金更新失败");
            }
        }catch (Exception $e){
            DB::rollback();
            return false;
        }

    }
}
