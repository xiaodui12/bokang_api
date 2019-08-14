<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Words extends Model
{
    protected $table="bokang_words";
    public $status=array("0"=>"隐藏","1"=>"显示");
    public $type=array("0"=>"拼多多首页","1"=>"其他");


    public static function getWorks($type=0)
    {
        $datatime=date("Y-m-d H:i:s");
        $works=self::where("type",$type)
            ->where("status",1)
            ->where("start_time","<",$datatime)
            ->where("end_time",">",$datatime)
            ->OrderBy("sort","desc")
            ->select("id","title","color","icon","content","opentype")
            ->get()->toArray();
        return $works;
    }
}
