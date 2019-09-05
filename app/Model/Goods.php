<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class Goods extends Model
{
    protected $table = 'bokang_goods';

    public $type=array(
        "1"=>"商品类型1",
        "2"=>"商品类型2"
    );


    public function prop() {
        return $this->hasMany('App\Model\GoodsProp',"goods_id");
    }
    public function sku() {
        return $this->hasMany('App\Model\GoodsSku',"goods_id");
    }

    public function addGoods($data)
    {
        if(empty($data["title"])){
            error_return("商品标题不得为空");
        }
        if(empty($data["category_id"])&&$data["category_id"]!=0){
            error_return("请选择分类");
        }
        $goods=[];
        $goods["title"]=$data["title"];
        $goods["category_id"]=$data["category_id"];
        $goods["desc"]=empty($data["desc"])?"":$data["desc"];
        $goods["type"]=empty($data["type"])?"0":$data["type"];
        $goods["store_id"]=empty($data["store_id"])?"0":$data["store_id"];
        $goods["old_price"]=empty($data["old_price"])?"0":$data["old_price"];
        $goods["new_price"]=empty($data["new_price"])?"0":$data["new_price"];
        $goods["basic"]=empty($data["basic"])?"0":$data["basic"];
        $goods["sku"]=empty($data["sku_number"])?"0":$data["sku_number"];
        $goods["sales"]=empty($data["sales"])?"0":$data["sales"];
        $goods["disseminate"]=empty($data["disseminate"])?"0":$data["disseminate"];
        $goods["cover"]=empty($data["pic"][0])?"":$data["pic"][0];
        $goods["pic"]=empty($data["pic"])?"":json_encode($data["pic"]);
        $goods["content"]=empty($data["content"])?"0":$data["content"];
        $goods["category_id"]=empty($data["category_id"])?"0":$data["category_id"];
        $goods["sizesList"]=empty($data["sizesList"])?"0":$data["sizesList"];
        $goods["sizes"]=empty($data["sizes"])?"0":$data["sizes"];
        $goods["selectedArr"]=empty($data["selectedArr"])?"0":$data["selectedArr"];
        $goods["tabledata"]=empty($data["tabledata"])?"0":$data["tabledata"];
        $goods["status"]=1;



        DB::beginTransaction(); //开启事务
        try{
            if(empty($data["id"])){
                $data["created_at"]=date("Y-m-d H:i:s");
                $goods_result=self::insertGetId($goods);
                $goods_id=$goods_result;
            }else{

                $goods_result=self::where("id",$data["id"])->update($goods);
                $goods_id=$data["id"];
            }
            if(!$goods_result)
            {
                throw new Exception("添加出错");
            }

            $sizes=json_decode($data["sizesList"],"1");
            $save_prop=[];
            foreach ($sizes as $key=>$value){
                $save_prop[]=array(
                    "pid"=>0,
                    "title"=>$value["name"],
                    "no"=>$value["id"],
                    "goods_id"=>$goods_id
                );
                foreach ($value["child"] as $key1=>$value1){
                    $save_prop[]=array(
                        "pid"=>$value["id"],
                        "title"=>$value1["name"],
                        "no"=>$value1["id"],
                        "goods_id"=>$goods_id
                    );
                }
            }

            $result2=GoodsProp::where("goods_id",$goods_id)->delete();
            $result=GoodsProp::insert($save_prop);
            if($result===false||$result2===false)
            {
                throw new Exception("添加出错1");
            }



            if(!empty($data["name"])){
                $goods=[];
                $goods["sku"]=0;
                foreach ($data["name"] as $key=>$value)
                {
                    $goods_sku_one["code"]=$key;
                    $goods_sku_one["name"]=$value;
                    $goods_sku_one["price"]=$data["price"][$key];
                    $goods_sku_one["sku"]=$data["sku"][$key];
                    $goods["sku"]+=$data["sku"][$key];
                    $goods_sku_one["goods_id"]=$goods_id;
                    $goods_sku[]=$goods_sku_one;
                }
                self::where("id",$data["id"])->update($goods);
            }

            $result2=GoodsSku::where("goods_id",$goods_id)->delete();
            $result=empty($goods_sku)?true:GoodsSku::insert($goods_sku);


            if($result===false||$result2===false)
            {
                throw new Exception("添加出错2");
            }


            DB::commit();
            return true;
        }catch (Exception $exception){
            DB::rollback();  //回滚
            error_return($exception->getMessage());
        }


    }


    /**
     * 得到商品列表
    */
    public static function getList($where)
    {

        $model= self::where("status",1);
        $model=$model
            ->when(!empty($where["keyword"]),function ($query)use($where){
                $query->where("title","like","%".$where["keyword"]."%");
            })
            ->when(!empty($where["category"]),function ($query)use($where){
                $category=GoodsClass::getCateId($where["category"]);
                $query->whereIn("category_id",$category);
            })
            ->when(!empty($where["limit"]),function ($query)use($where){
                $query->limit($where["limit"]);
            })
            ->select("id","title","type","desc","old_price","new_price","cover","pic","basic","sales","cover_poster")
            ->OrderBy("sort","desc");

        if($where["page"]){
            $list=$model->paginate(15);
        }else{
            $list=$model->get();
        }
            return $list;
    }


    public static function getDetail($id)
    {
        return self::where("id",$id)->first();
    }
    /**
     * 图片链接修改器
     */
    public function getCoverAttribute($value)
    {
        $url=config("filesystems.disks.admin.url");//图片链接前缀
        return strpos($value,"ttp")>0?$value:$url.$value;

    }

    /**
     * 图片链接修改器
     */
    public function getPicAttribute($value)
    {
        $url=config("filesystems.disks.admin.url");//图片链接前缀

        $list=[];
        if(!empty($value)){
            $list1=json_decode($value,1);
            foreach ($list1 as $key=>$value1){
                $list[$key]=strpos($value1,"ttp")>0?$value1:$url.$value1;
            }
        }

        return $list;
    }


    public static function getGoodsOne($id,$code="",$number=0)
    {
        $goods_one=self::getDetail($id);
        if(empty($goods_one)){
            return false;
        }
        $goodsList_one=array(
            "id"=>$goods_one->id,
            "number"=>$number,
            "title"=>$goods_one->title,
            "desc"=>$goods_one->desc,
            "old_price"=>$goods_one->old_price,
            "new_price"=>$goods_one->new_price,
            "cover"=>$goods_one->cover,
            "goods_sku"=>$goods_one->sku,
            "sku"=>$goods_one->sku,
        );
        if(!empty($code)){
            $sku=GoodsSku::where("goods_id",$id)->where("code",$code)->first();
            if(empty($sku)){
                return false;
            }
            $goodsList_one["new_price"]=$sku->price;
            $goodsList_one["code"]=$sku->code;
            $goodsList_one["name"]=$sku->name;
            $goodsList_one["sku"]=$sku->sku;
        }
        return $goodsList_one;
    }


    /**
     * 得到订单
    */
    public static function getAddOrderGoods($goods)
    {
        $goodsList=[];
        foreach ($goods as $key=>$val){
            $val["sku"]=empty($val["sku"])?"":$val["sku"];
            $goodsList_one=self::getGoodsOne($val["id"],$val["sku"],$val["number"]);
            if($goodsList_one){
                $goodsList[]= $goodsList_one;
            }else{
                error_return("商品错误");
            }
        }
        return $goodsList;
    }
}
