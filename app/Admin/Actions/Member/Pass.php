<?php

namespace App\Admin\Actions\Member;

use App\Model\TeamApply;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

class Pass extends RowAction
{
    public $name = '审核通过';

    public function handle(Model $model)
    {

        $id=$model->id;//得到需要审核id
        $uid=$model->uid;//得到需要审核用户id
        try{
            $team=new TeamApply();
            $return=$team->pass_apply($id,$uid);//审核方法

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
    public function dialog()
    {
        $this->confirm('确定审核通过吗？');
    }

}