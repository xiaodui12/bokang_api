<?php

namespace App\Admin\Actions\Our;

use App\Model\OurOrder;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class setPay extends RowAction
{
    public $name = '确认支付';

    public function handle(Model $model)
    {
        // $model ...
        $id=$model->id;
        $user_uid=$model->user_uid;
        $result=OurOrder::setPay($user_uid,$id);
        return $result?$this->response()->success('已确认支付')->refresh():$this->response()->error('确认支付失败')->refresh();

    }

    public function dialog()
    {
        $this->confirm('确定直接确认支付吗？');
    }

}