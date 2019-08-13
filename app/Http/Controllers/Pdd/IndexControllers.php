<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 17:26
 */

namespace App\Http\Controllers\Pdd;



use App\Model\MpConfig;
use App\Model\System;
use App\Model\Xcx;
use Illuminate\Http\Request;

class IndexControllers extends BaseControllers
{



    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    /**
     * 得到商品分类
    */
    public function get_class(Request $request){
       $info= '[
       {"level": 0,"opt_id": 0,"opt_name": "首页","parent_opt_id": -1},
       {"level": 1,"opt_id": 15,"opt_name": "百货","parent_opt_id": 0},
       {"level": 1,"opt_id": 1281,"opt_name": "鞋包","parent_opt_id": 0},
       {"level": 1,"opt_id": 16,"opt_name": "美妆","parent_opt_id": 0},
       {"level": 1,"opt_id": 13,"opt_name": "水果","parent_opt_id": 0},
       {"level": 1,"opt_id": 14,"opt_name": "女装","parent_opt_id": 0},
       {"level": 1,"opt_id": 1,"opt_name": "食品","parent_opt_id": 0},
       {"level": 1,"opt_id": 4,"opt_name": "母婴","parent_opt_id": 0},
       {"level": 1,"opt_id": 743,"opt_name": "男装","parent_opt_id": 0},
       {"level": 1,"opt_id": 18,"opt_name": "电器","parent_opt_id": 0},
       {"level": 1,"opt_id": 1282,"opt_name": "内衣","parent_opt_id": 0},
       {"level": 1,"opt_id": 818,"opt_name": "家纺","parent_opt_id": 0},
       {"level": 1,"opt_id": 2478,"opt_name": "文具","parent_opt_id": 0},
       {"level": 1,"opt_id": 2048,"opt_name": "汽车","parent_opt_id": 0},
       {"level": 1,"opt_id": 1451,"opt_name": "运动","parent_opt_id": 0},
       {"level": 1,"opt_id": 1917,"opt_name": "家装","parent_opt_id": 0},
       {"level": 1,"opt_id": 590,"opt_name": "虚拟","parent_opt_id": 0}
       ]';
       $info_array=json_decode($info,1);
       success_return($info_array);
    }



    /**
     * 得到拼多多配置
    */
    public function get_config()
    {
       $pdd_config=System::getpdd();
       success_return($pdd_config);
    }

    /**
     * 得到小程序码
     * page
     * scene
     * width
     */
    public function  get_scene(Request $request)
    {
        $pic=Xcx::get_scene($request);
        header( "Content-type: image/jpeg");
        echo $pic;

    }



}