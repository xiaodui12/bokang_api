<?php

namespace App\Admin\Actions\Member;

use App\Model\TeamApply;
use App\Model\WechetGroup;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Mockery\Exception;

class Pass extends RowAction
{
    public $name = '审核通过';

    public function handle(Model $model,Request $request)
    {

        $group_name=$request->get("group_name");
        $group_address=$request->get("group_address");

        $id=$model->id;//得到需要审核id
        $uid=$model->uid;//得到需要审核用户id
        try{



            $wetch_info=array(
                "title"=>$group_name,
                "lat"=>$model->lat,
                "lon"=>$model->lon,
                "address"=>$group_address,
                "status"=>1,
                "created_at"=>date("Y-m-d H:i:s"),
            );
            $other_info=array(
                "wetch_info"=>$wetch_info,
                "model"=>$model->toarray()
            );

            $team=new TeamApply();
            $return=$team->pass_apply($id,$uid,$other_info);//审核方法





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

        $this->text('group_name', '微信群名称')->rules('required');
        $this->text('group_address', '微信群地址')->rules('required');
    }

}