<?php

namespace App\Admin\Actions\Team;

use App\Model\TeamUser;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Usersuccess extends RowAction
{
    public $name = '审核成功';

    public function handle(Model $model)
    {
        // $model ...
        $id=$model->id;

        $result=TeamUser::setexamine($id,1);
        if($result){
            return $this->response()->success('审核成功')->refresh();
        }else{
            return $this->response()->error('审核失败，请重试');
        }
        return $this->response()->success('Success message.')->refresh();
    }
    public function dialog()
    {
        $this->confirm('确定审核通过吗？');
    }

}