<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Adv extends Model
{
    protected $table = 'bokang_adv';
    public $type=["首页"];
    public $platform=array("1"=>"拼多多","2"=>"淘宝");
    public $status=array("1"=>"启用","0"=>"禁用");

    /**
     * 得到广告位
     * $platform_key 平台
     * $type_key  类型
    */
    public function getadv($platform_key,$type_key)
    {
        $time=date("Y-m-d H:i:s");//当前时间
        //查询条件
        $where=[
            array("platform","=",$platform_key),//平台
            array("type","=",$type_key),//类型
            array("status","=",1),//类型
            array("start_time","<=",$time),//开始时间
            array("end_time",">=",$time),//结束时间
        ];

        $info=$this->where($where)->select("title","image","font1","font2","font3","font4","font5")->get();//得到列表

        return $info;
    }

    /**
     * 图片链接修改器
    */
    public function getImageAttribute($value)
    {
        $url=config("filesystems.disks.admin.url");//图片链接前缀
        return $url.$value;
    }
}
