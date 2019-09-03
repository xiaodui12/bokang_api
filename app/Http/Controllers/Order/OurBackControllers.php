<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/3
 * Time: 9:18
 */

namespace App\Http\Controllers\Order;


use App\Model\Remark;
use Illuminate\Http\Request;


class OurBackControllers
{
    public function aliback(Request $request){
        $data=$request->all();
        $post=$request->post();
        Remark::add("get");
        Remark::add($data);
        Remark::add("post");
        Remark::add($post);

    }
}