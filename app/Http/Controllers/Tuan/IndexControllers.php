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
use App\Model\TeamUser;
use App\Model\WechetGroup;
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
        $save["remark"]=$request->post("remark","");//纬度

        $tuan_apply=new TeamApply();
        $result=$tuan_apply->addapply($save);//提交申请
        success_return("","申请成功");
    }
    /**
     * 查看申请状态
    */
    public function apply_status(){
        $tuan_apply=new TeamApply();
        $result=$tuan_apply->getapply($this->uid);//提交申请
        success_return($result,"");
    }



    public function tuanList(Request $request){

        $lon=$request->post("lon","0");
        $lat=$request->post("lat","0");

        $list=(new WechetGroup())->getListByDistance($lon,$lat);

        success_return($list);

    }

    /**
     * 团队信息
    */
    public function userTeam(){
        $team_status=(new TeamUser())->getTeam($this->uid);
        $team_info=[];
        if(!empty($team_status)&&$team_status->status=1)
        {
            $team_info=(new WechetGroup())->getDetail($team_status->tuan_id);
        }
        success_return(array("team_status"=>$team_status,"team_info"=>$team_info));

    }

    public function joinApply(Request $request)
    {
        $save["name"]=$request->post("name","");
        $save["phone"]=$request->post("phone","");
        $save["wechet"]=$request->post("wechet","");
        $save["lon"]=$request->post("lon","");
        $save["lat"]=$request->post("lat","");
        $save["tuan_id"]=$request->post("tuan_id","");
        $save["remark"]=$request->post("remark","");
        $result=(new TeamUser())->AddTeam($this->uid,$save);
        $result?success_return("申请成功"):error_return("申请失败，请重试");

    }

}