<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamUser extends Model
{
    use SoftDeletes;
    protected $table = 'bokang_team_user';

    public function teamuid() {
        return $this->hasOne('App\Model\Member',"id","uid");
    }
    public function team() {
        return $this->hasOne('App\Model\WechetGroup',"id","tuan_id");
    }


    public function getTeam($uid){
        return $this->where("uid",$uid)->first();
    }

    public function AddTeam($uid,$info){
        $team=$this->getTeam($uid);
        if(!empty($team)&&$team!=-1){
            error_return("您已经申请成为团员");
        }
        if(empty($team)){
            $team=new self();
        }
        $info["created_at"]=date("Y-m-d H:i:s");
        $info["uid"]=$uid;

        foreach ($info as $key=> $item) {
            $team->$key=$item;
        }
        return $team->save();

    }

    public static function getDetail($id){
        return self::where("id",$id)->first();
    }
    public static function setexamine($id,$status){
        $teamUser=self::getDetail($id);
        $teamUser->status=$status;
        return $teamUser->save();
    }
}
