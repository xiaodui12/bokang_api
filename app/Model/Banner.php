<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table="bokang_banners";

    public $status=array("0"=>"隐藏","1"=>"显示");
    public $turn_type=array("0"=>"不跳转","1"=>"商品列表","2"=>"订单列表");
    public $type_array=array("0"=>"其他","1"=>"抖音banner");



    public static function getBanner($type=0)
    {
        $datatime=date("Y-m-d H:i:s");
        return self::where("status",1)
            ->where("start_time","<",$datatime)
            ->where("end_time",">",$datatime)
            ->where("type","=",$type)
            ->OrderBy("sort","desc")
            ->select("id","title","desc","icon","turn_type")
            ->get()->toArray();

    }
    /**
     * 图片链接修改器
     */
    public function getIconAttribute($value)
    {
        $url=config("filesystems.disks.admin.url");//图片链接前缀
        return $url.$value;
    }
}
