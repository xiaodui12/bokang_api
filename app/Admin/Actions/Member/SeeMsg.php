<?php

namespace App\Admin\Actions\Member;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class SeeMsg extends RowAction
{
    public $name = '查看失败原因';

    public function handle(Model $model)
    {
        // $model ...
        return $this->response()->info($model->error_msg);
    }


}