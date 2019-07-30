<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'bokang_team';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function tuanuid() {
        return $this->hasOne('App\Model\Member',"id","uid");
    }

    public function add_one($uid)
    {
        if(empty($uid)){
            return false;
        }
        $this->uid=$uid;
        $this->status=1;
        return $this->save();
    }

}
