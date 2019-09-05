<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GoodsClass extends Model
{

//指定表名
    protected $table = 'bokang_goods_class';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function parent() {
        return $this->hasOne('App\Model\GoodsClass', "id",'pid');
    }

    public function hasnext() {
        return $this->hasMany('App\Model\GoodsClass', 'id',"pid");
    }

    public function getList($class_id=null,$left=""){

        $list=self::where("pid",$class_id)->get();

        $list_array=array();
        foreach ($list as $key=>$value)
        {
            $list_array[$value->id]=$value["title"];
            $next_list=$this->getList($value["id"],$left."--");
           array_merge($list_array,$next_list);
        }
     
        return $list_array;
    }
    public function getNextInfo($class_id=null){
        return self::where("pid",$class_id)->get();

    }

    /**
     * 得到下拉选项
     */
    public static function getselect($pid,$no_id=0)
    {
        empty($pid)&&($pid=null);
        $select=self::where("pid",$pid);
        !empty($no_id)&&($select=$select->where("id","!=",$no_id));
        $list=$select->select("id","title")->get();

        $list_return=array();
        foreach ($list as $key=>$value){
            $list_return[$value["id"]]=$value["title"];
        }
        return $list_return;
    }

    /**
     * 得到分类id
    */
    public static function getCateId($category)
    {
        $returnList=[$category];
        $list=self::where("pid",$category)->get();
        foreach ($list as $key=>$value){
            $returnList[]=$value->id;
            $returnList=array_merge(self::getCateId($value->id),$returnList);
        }
        return $returnList;
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
