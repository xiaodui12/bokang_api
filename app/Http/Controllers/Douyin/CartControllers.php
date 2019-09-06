<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2019/7/23
 * Time: 13:17
 */

namespace App\Http\Controllers\Douyin;


use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\XcxControllers;
use App\Model\Cart;
use App\Model\Member;
use App\Model\MpConfig;
use App\Model\MpUser;
use App\Model\PutCurl;
use App\Model\Token;
use Illuminate\Http\Request;

class CartControllers extends XcxControllers
{

    protected $cart;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        if(empty($this->uid)){
            error_return("请授权用户信息登录");
        }
        $this->cart=new Cart();
        $this->cart->setUid($this->uid);
    }

    public function getList(){
        success_return($this->cart->getList());
    }

    /**
     * 新增购物车
    */
    public function setDetail(Request $request)
    {
        $goods_id=$request->post("goods_id","");
        $code=$request->post("code","");
        $number=$request->post("number",1);
        $result=$this->cart->setDetail($goods_id,$number,$code);
        $result?success_return("","购物车添加成功"):error_return("购物车添加失败");
    }

    /**
     * 修改购物车数量
    */
    public function setNumber(Request $request)
    {
        $cart_id=$request->post("cart_id","");
        $number=$request->post("number",1);
        $result=$this->cart->setNumber($cart_id,$number);
        $result?success_return("","更新成功"):error_return("更新失败");
    }
    /**
     * 删除购物车
    */
    public function delCart(Request $request){
        $id=$request->post("id","");
        $result=$this->cart->deleteCart($id);
        $result?success_return("","删除成功"):error_return("删除失败");
    }
}