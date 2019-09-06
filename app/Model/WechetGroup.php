<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class WechetGroup extends Model
{

    protected $table = 'bokang_wechet_group';

    public function teamuid() {
        return $this->hasMany('App\Model\TeamUser',"tuan_id","id");
    }


    public function getListByDistance($lon,$lat)
    {


        $select="ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN( 
        (".$lat." * PI() / 180 - lat * PI() / 180) / 2),
        2) + 
        COS(".$lat." * PI() / 180) * COS(lat * PI() / 180) * 
        POW(
        SIN(
        (".$lon." * PI() / 180 - lon * PI() / 180 )
         / 2),2 ))) ) AS juli";

        return $this->where("status",1)->select("*",DB::raw($select))->get();

    }


    public function getDetail($id)
    {

        return $this->find($id);
    }

    public function addWechet($other_info,$uid)
    {
        $team_user=(new TeamUser());
        $team_info=(new TeamUser())->where("uid",$uid)->where("is_tuan",1)->where("status",1)->first();
        if(!empty($team_info)){
            return array("status"=>false,"msg"=>"此人已经是团长");
        }

        $id=$this->insertGetId($other_info["wetch_info"]);
        if(empty($id)){
            return array("status"=>false,"msg"=>"创建群组表失败");
        }


        $team_user_info=array(
            "uid"=>$uid,
            "name"=>$other_info["model"]["realname"],
            "phone"=>$other_info["model"]["phone"],
            "wechet"=>$other_info["model"]["wechet"],
            "lon"=>$other_info["model"]["lon"],
            "lat"=>$other_info["model"]["lat"],
            "tuan_id"=>$id,
            "remark"=>$other_info["model"]["remark"],
            "is_tuan"=>1,
            "created_at"=>date("Y-m-d H:i:s"),
        );


        $result=$team_user->where("uid",$uid)->delete();
        if($result===false){
            return array("status"=>false,"msg"=>"团长信息更新失败");
        }
        $result=$team_user->insertGetId($team_user_info);
        if(empty($result)){
            return array("status"=>false,"msg"=>"团长创建失败");
        }else{
            return array("status"=>true);
        }

    }
}
