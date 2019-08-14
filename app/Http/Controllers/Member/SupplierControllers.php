<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/14
 * Time: 13:39
 */

namespace App\Http\Controllers\Member;


use App\Http\Controllers\XcxControllers;
use App\Model\SupplierApply;
use Illuminate\Http\Request;


class SupplierControllers extends XcxControllers
{



    /**
     * 判断当前申请状态
    */
    public function checkApply(){
        success_return(SupplierApply::checkApply($this->uid));
    }
    /**
    */
    public function supplierApply(Request $request)
    {
        SupplierApply::saveApply(1,$request);
        success_return("","提交成功");

    }
}