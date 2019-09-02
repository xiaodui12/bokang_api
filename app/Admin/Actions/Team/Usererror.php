<?php

namespace App\Admin\Actions\Team;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Usererror extends RowAction
{
    public $name = '审核失败';

    public function handle(Model $model)
    {
        // $model ...
        $id=$model->id;
        $result=TeamUser::setexamine($id,2);
        if($result){
            return $this->response()->success('审核成功')->refresh();
        }else{
            return $this->response()->error('审核失败，请重试');
        }

    }
    public function dialog()
    {
        $this->confirm('确定审核失败吗？');
    }
}