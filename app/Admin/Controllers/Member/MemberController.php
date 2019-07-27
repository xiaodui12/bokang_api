<?php

namespace App\Admin\Controllers\Member;

use App\Admin\Controllers\BaseControllers;
use App\Model\Member;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MemberController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\Member';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Member);
        $info_array=[
            array("field"=>"nickname","title"=>"昵称","type"=>"value"),
            array("field"=>"realname","title"=>"真实姓名","type"=>"value"),
            array("field"=>"head","title"=>"头像","type"=>"image"),
            array("field"=>"sex","title"=>"性别","type"=>"array","array"=>['0' => '保密', '1' => '男',"2"=>"女"]),
            array("field"=>"city","title"=>"城市","type"=>"value"),
            array("field"=>"create_time","title"=>"注册时间","type"=>"datetime"),
            array("field"=>"last_login","title"=>"最后登录","type"=>"datetime"),
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>[0=>"禁用",1=>"正常"]),
            array("field"=>"invitation","title"=>"邀请码","type"=>"value"),
            array("field"=>"is_tuan","title"=>"是否是团长","type"=>"boolean"),
        ];

        BaseControllers::setlist($grid,$info_array);
        BaseControllers::set_auth($grid,2);
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
        $show = new Show(Member::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('mobile', __('Mobile'));
        $show->field('password', __('Password'));
        $show->field('last_login', __('Last login'));
        $show->field('nickname', __('Nickname'));
        $show->field('head', __('Head'));
        $show->field('sex', __('Sex'));
        $show->field('birthday', __('Birthday'));
        $show->field('city', __('City'));
        $show->field('city_code', __('City code'));
        $show->field('create_time', __('Create time'));
        $show->field('update_time', __('Update time'));
        $show->field('longitude', __('Longitude'));
        $show->field('latitude', __('Latitude'));
        $show->field('realname', __('Realname'));
        $show->field('level', __('Level'));
        $show->field('status', __('Status'));
        $show->field('invitation', __('Invitation'));
        $show->field('unionid', __('Unionid'));
        $show->field('is_tuan', __('Is tuan'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Member);

        $form->mobile('mobile', __('Mobile'));
        $form->password('password', __('Password'));
        $form->number('last_login', __('Last login'));
        $form->text('nickname', __('Nickname'));
        $form->text('head', __('Head'));
        $form->number('sex', __('Sex'));
        $form->date('birthday', __('Birthday'))->default(date('Y-m-d'));
        $form->text('city', __('City'));
        $form->number('city_code', __('City code'));
        $form->number('create_time', __('Create time'));
        $form->number('update_time', __('Update time'));
        $form->text('longitude', __('Longitude'));
        $form->text('latitude', __('Latitude'));
        $form->text('realname', __('Realname'));
        $form->number('level', __('Level'));
        $form->number('status', __('Status'));
        $form->text('invitation', __('Invitation'));
        $form->text('unionid', __('Unionid'));
        $form->number('is_tuan', __('Is tuan'));

        return $form;
    }
}
