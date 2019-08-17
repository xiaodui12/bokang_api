<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    //
    public static function log($uid,$remark){
        return self::insert(array("uid"=>$uid,"remark"=>$remark,"created_at"=>date("Y-m-d H:i:s")));
    }
}
