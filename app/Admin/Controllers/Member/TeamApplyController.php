<?php

namespace App\Admin\Controllers\Member;

use App\Admin\Actions\Member\NoPass;
use App\Admin\Actions\Member\Pass;
use App\Admin\Actions\Member\SeeMsg;
use App\Admin\Actions\Member\SeeUser;
use App\Admin\Controllers\BaseControllers;
use App\Model\TeamApply;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TeamApplyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\TeamApply';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TeamApply);



        $info_array=[
            array("field"=>"tuanuid.nickname","title"=>"昵称","type"=>"value"),//展示昵称
            array("field"=>"tuanuid.head","title"=>"头像","type"=>"image"),//展示真实姓名
            array("field"=>"phone","title"=>"手机号","type"=>"value"),//展示图片
            array("field"=>"city","title"=>"城市","type"=>"value"),
            array("field"=>"realname","title"=>"真实姓名","type"=>"value"),
            array("field"=>"wechet","title"=>"微信号","type"=>"value"),
            array("field"=>"lon","title"=>"经度","type"=>"value"),
            array("field"=>"lat","title"=>"纬度","type"=>"value"),
            array("field"=>"remark","title"=>"备注","type"=>"value"),
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>array(0=>"申请中","1"=>"审核成功",2=>"审核失败")),
            array("field"=>"created_at","title"=>"申请时间","type"=>"value"),
        ];

        BaseControllers::setlist_show($grid,$info_array);//拼接列表展示数据
        BaseControllers::set_auth($grid,2);//设置版面权限

        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();
            $actions->add(new SeeUser());
           if($actions->row->status==0){
               $actions->add(new Pass());
               $actions->add(new NoPass());
           }
            if($actions->row->status==2){
                $actions->add(new SeeMsg());
            }

        });



        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(TeamApply::findOrFail($id));

        $show->tuanuid('申请人', function ($tuanuid) {
            $detail_array=[
                array("field"=>"head","title"=>"头像","type"=>"image"),
                array("field"=>"nickname","title"=>"昵称","type"=>"value"),
                array("field"=>"sex","title"=>"性别","type"=>"array","array"=>['0' => '保密', '1' => '男',"2"=>"女"]),
            ];
            BaseControllers::setdetail($tuanuid,$detail_array);
            BaseControllers::set_auth($tuanuid,4);

        });

        $info_array=[
            array("field"=>"phone","title"=>"手机号","type"=>"value"),//展示图片
            array("field"=>"city","title"=>"城市","type"=>"value"),
            array("field"=>"realname","title"=>"真实姓名","type"=>"value"),
            array("field"=>"wechet","title"=>"微信号","type"=>"value"),
            array("field"=>"lon","title"=>"经度","type"=>"value"),
            array("field"=>"lat","title"=>"纬度","type"=>"value"),
            array("field"=>"remark","title"=>"备注","type"=>"value"),
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>array(0=>"申请中","1"=>"审核成功",2=>"审核失败")),

            array("field"=>"created_at","title"=>"申请时间","type"=>"value"),
            array("field"=>"updated_at","title"=>"更新时间","type"=>"value"),
            array("field"=>"error_msg","title"=>"失败原因","type"=>"value"),
        ];

        BaseControllers::setdetail($show,$info_array);//拼接列表展示数据
        BaseControllers::set_auth($show,5);
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TeamApply);

        $form->number('uid', __('Uid'));
        $form->mobile('phone', __('Phone'));
        $form->text('realname', __('Realname'));
        $form->text('wechet', __('Wechet'));
        $form->text('city', __('City'));
        $form->text('lon', __('Lon'));
        $form->text('lat', __('Lat'));
        $form->number('status', __('Status'));
        $form->text('error_msg', __('Error msg'));

        return $form;
    }
}
