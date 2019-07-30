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
use App\Model\Adv;
use App\Model\Member;
use App\Model\MpConfig;
use App\Model\MpUser;
use Illuminate\Http\Request;

class AdvControllers extends Controller
{
    /**
     * 得到广告位
     * platform  平台
     * type  类型
    */
    public function getadv(Request $request){
        $platform=$request->post("platform",1);//得到平台参数
        $type=$request->post("type",1);//得到类型

        $adv=new Adv();
        $info=$adv->getadv($platform,$type);   //得到数据
        success_return($info);//返回数据
    }
}