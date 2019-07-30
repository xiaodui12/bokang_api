<?php

namespace App\Admin\Actions\Member;

use App\Model\TeamApply;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class NoPass extends RowAction
{
    public $name = '审核不通过';

    public function handle(Model $model,Request $request)
    {
        $msg=$request->get("reason");

        $id=$model->id;//得到需要审核id
        $uid=$model->uid;//得到需要审核用户id
        try{
            $team=new TeamApply();
            $return=$team->nopass_apply($id,$uid,$msg);//审核方法

            if(!$return["status"]){
                throw new Exception($return["msg"]);//错误时，抛出异常
            }else{
                //成功返回
                return $this->response()->success("审核成功")->refresh();
            }

        }catch (Exception $e){
            //错误时，抛出异常
            return $this->response()->error($e->getMessage())->refresh();
        }

    }
    public function form()
    {

        $this->textarea('reason', '请示如审核失败原因')->rules('required');
    }

}