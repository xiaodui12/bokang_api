<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 2019/7/23
 * Time: 13:17
 */

namespace App\Http\Controllers\Base;


use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\XcxControllers;
use App\Model\Address;
use App\Model\Adv;
use App\Model\Banner;
use App\Model\HotSearch;
use App\Model\Member;
use App\Model\MpConfig;
use App\Model\MpUser;
use App\Model\Words;
use Illuminate\Http\Request;

class AddressControllers extends XcxControllers
{
    public function getList(Request $request)
    {
        success_return((new Address())->getList($this->uid));
    }
    public function getDetail(Request $request)
    {
        $id=$request->post("id","");
        success_return((new Address())->getDetail($this->uid,$id));
    }
    public function getDefault(Request $request){
        $id=$request->post("id","");
        success_return((new Address())->getDefault($this->uid,$id));
    }

    public function setDefault(Request $request){
        $id=$request->post("id");
        success_return((new Address())->setDefault($this->uid,$id));
    }

    public function delete(Request $request){
        $id=$request->post("id");
        $success=(new Address())->deleteAddress($this->uid,$id);
        $success?success_return("删除成功"):error_return("删除失败");
    }

    public function saveDetail(Request $request){
        $detail["id"]=$request->post("id","");
        $detail["name"]=$request->post("name","");
        $detail["mobile"]=$request->post("mobile","");
        $detail["phone"]=$request->post("phone","");
        $detail["province_id"]=$request->post("province_id","");
        $detail["province"]=$request->post("province","");
        $detail["city_id"]=$request->post("city_id","");
        $detail["city"]=$request->post("city","");
        $detail["area_id"]=$request->post("area_id","");
        $detail["area"]=$request->post("area","");
        $detail["address"]=$request->post("address","");
        $detail["zip"]=$request->post("zip","");
        (new Address())->saveDetail($detail);
    }
}