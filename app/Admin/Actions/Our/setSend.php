<?php

namespace App\Admin\Actions\Our;

use App\Model\OurOrder;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class setSend extends RowAction
{
    public $name = '确认发货';

    public function handle(Model $model,Request $request)
    {
        $id=$model->id;
        $uid=$model->user_uid;

        // 获取到表单中的`type`值
        $logistics=$request->get('logistics');

        // 获取表单中的`reason`值
        $logistics_no=$request->get('logistics_no');

        $result=OurOrder::setSend($uid,$id,$logistics,$logistics_no);
        return $result?$this->response()->success('发货成功')->refresh():$this->response()->error('发货失败')->refresh();
    }


    public function form()
    {




        $this->text('logistics', '物流公司')->rules('required');
        $this->text('logistics_no', '物流单号')->rules('required');
    }

}