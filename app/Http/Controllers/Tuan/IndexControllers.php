<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 17:26
 */

namespace App\Http\Controllers\Tuan;



use App\Http\Controllers\XcxControllers;
use App\Model\Order;
use App\Model\TeamApply;
use Illuminate\Http\Request;

class IndexControllers extends XcxControllers
{

    /**
     * 团长申请
     *phone 手机号
     * realname 真实姓名
     * wechet  微信号
     * lon 经度
     * lat 纬度
     */
    public function apply(Request $request)
    {
        $save=array();
        $save["phone"]=$request->post("phone","");//手机号
        $save["realname"]=$request->post("realname","");//真实姓名
        $save["wechet"]=$request->post("wechet","");//微信号
        $save["lon"]=$request->post("lon","");//经度
        $save["lat"]=$request->post("lat","");//纬度
        $save["uid"]=$this->uid;

        $tuan_apply=new TeamApply();
        $result=$tuan_apply->addapply($save);//提交申请
        success_return("","申请成功");
    }
    /**
     * 查看申请状态
    */
    public function apply_status(){
        $tuan_apply=new TeamApply();
        success_return($this->uid);
        $result=$tuan_apply->getapply($this->uid);//提交申请
        success_return($result,"");
    }
}