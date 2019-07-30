<?php

namespace App\Admin\Controllers\Member;

use App\Admin\Actions\Member\SeeOrder;
use App\Admin\Actions\Member\SeeUser;
use App\Admin\Controllers\BaseControllers;
use App\Model\Team;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TeamController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\Team';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Team);

        $info_array=[
            array("field"=>"tuanuid.nickname","title"=>"昵称","type"=>"value"),//展示昵称
            array("field"=>"tuanuid.head","title"=>"头像","type"=>"image"),//展示真实姓名
            array("field"=>"tuanuid.phone","title"=>"手机号","type"=>"value"),//手机号
            array("field"=>"commission","title"=>"佣金","type"=>"value"),//手机号
            array("field"=>"points","title"=>"积分","type"=>"value"),//手机号
            array("field"=>"order_number","title"=>"分享订单数","type"=>"value"),//手机号
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>array("1"=>"启用",2=>"禁用")),
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
            $actions->add(new SeeOrder());
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
        $show = new Show(Team::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uid', __('Uid'));
        $show->field('commission', __('Commission'));
        $show->field('points', __('Points'));
        $show->field('order_number', __('Order number'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('status', __('Status'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Team);

        $form->number('uid', __('Uid'));
        $form->decimal('commission', __('Commission'))->default(0.00);
        $form->decimal('points', __('Points'))->default(0.00);
        $form->number('order_number', __('Order number'));
        $form->number('status', __('Status'));

        return $form;
    }
}
