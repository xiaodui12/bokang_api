<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TeamApply extends Model
{
    protected $table = 'bokang_team_apply';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function tuanuid() {
        return $this->hasOne('App\Model\Member',"id","uid");
    }
}
