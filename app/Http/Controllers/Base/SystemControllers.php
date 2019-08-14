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
use App\Model\Banner;
use App\Model\HotSearch;
use App\Model\Member;
use App\Model\MpConfig;
use App\Model\MpUser;
use App\Model\Words;
use Illuminate\Http\Request;

class SystemControllers extends Controller
{
    /**
     * 得到banner
    */
    public function getBanner()
    {
        $banner=Banner::getbanner();
        success_return($banner);
    }
    /**
     * 得到首页文字
     * type ：类型
     */
    public function getWord(Request $request)
    {
        $type=$request->input("type",0);
        $works=Words::getWorks($type);
        success_return($works);
    }
    /**
     * 得到热门搜索
    */
    public function getSearch()
    {
        $search=HotSearch::getSearch();
        success_return($search);
    }
}