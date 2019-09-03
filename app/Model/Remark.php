<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $table="bokang_remark";
    public static function add($remark){
        $remark_model=new self();
        $remark_model->remark=is_array($remark)?json_encode($remark):$remark;
        $remark_model->created_at=date("Y-m-d H:i:s");
        $remark_model->save();
    }
}
