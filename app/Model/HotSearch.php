<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HotSearch extends Model
{
    protected $table="bokang_hot_searches";
    public $status=array("0"=>"隐藏","1"=>"显示");
    public static function getSearch()
    {
        return self::where("status",1)
            ->inRandomOrder()
            ->select("id","title")
            ->take(5)
            ->get()->toArray();

    }
}
