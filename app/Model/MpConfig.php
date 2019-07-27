<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MpConfig extends Model
{


    protected $table = 'bokang_mp_config';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    //
    public function get_one($appid){
        $mp_info=$this->where("appid",$appid)->first();
        return $mp_info;
    }
}
