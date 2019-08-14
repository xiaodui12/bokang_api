<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

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
}
