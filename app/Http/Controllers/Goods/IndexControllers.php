<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 17:26
 */

namespace App\Http\Controllers\Goods;



use App\Http\Controllers\Goods\BaseControllers;
use App\Http\Controllers\XcxControllers;
use App\Model\Goods;
use App\Model\GoodsClass;
use App\Model\GoodsProp;
use App\Model\Order;
use Illuminate\Http\Request;

class IndexControllers extends BaseControllers
{

    public function get_list(Request $request)
    {

        $where["keyword"]=$request->post("keyword","");
        $where["category"]=$request->post("category","");
        $where["limit"]=$request->post("limit","");
        $where["page"]=$request->get("page","");
        $list=Goods::getList($where)->toarray();
        success_return($list);
    }

    /**
     * 得到分类class
    */
    public function getClass()
    {
        $list=(new GoodsClass())->getNextInfo()->toarray();
        success_return($list);
    }


    /**
     * 得到商品详情
     * id
    */
    public function getDetail(Request $request){
        $id=$request->post("id","");
        $detail=Goods::where("id",$id)->with("sku")->first();
        $prop=GoodsProp::where("goods_id",$id)->where("pid","0")->get();
        foreach ($prop as $key=>$value){
            $prop[$key]->child=GoodsProp::where("goods_id",$id)->where("pid",$value->no)->get();
        }
        $detail->prop=$prop;
        success_return($detail);
    }

}