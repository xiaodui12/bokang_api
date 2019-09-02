<?php

namespace App\Admin\Controllers\Team;

use App\Admin\Actions\Team\Usererror;
use App\Admin\Actions\Team\Usersuccess;
use App\Admin\Controllers\BaseControllers;
use App\Model\TeamUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TeamUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\TeamUser';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TeamUser);
        $grid->model()->with("teamuid")->with("team")
            ->OrderBy("status","asc")
        ->OrderBy("created_at","desc");

        $status=[0=>"申请中","1"=>"审核成功","2"=>"审核失败"];

        $list_array=[
            array("field"=>"name","title"=>"申请人","type"=>"value"),
            array("field"=>"teamuid.head","title"=>"头像","type"=>"image"),
            array("field"=>"phone","title"=>"手机号","type"=>"value"),
            array("field"=>"wechet","title"=>"微信号","type"=>"value"),
            array("field"=>"lon","title"=>"经度","type"=>"value"),
            array("field"=>"lat","title"=>"纬度","type"=>"value"),
            array("field"=>"team.title","title"=>"团队","type"=>"value"),
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>$status),

            array("field"=>"created_at","title"=>"申请时间","type"=>"value")
        ];
        BaseControllers::setlist_show($grid,$list_array);

        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();

            // 去掉编辑
            $actions->disableEdit();
//            // 去掉查看
//            $actions->disableView();
            if($actions->row->status==0){
                $actions->add(new Usersuccess());
                $actions->add(new Usererror());
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
        $show = new Show(TeamUser::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uid', __('Uid'));
        $show->field('name', __('Name'));
        $show->field('phone', __('Phone'));
        $show->field('wechet', __('Wechet'));
        $show->field('lon', __('Lon'));
        $show->field('lat', __('Lat'));
        $show->field('tuan_id', __('Tuan id'));
        $show->field('remark', __('Remark'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('is_tuan', __('Is tuan'));
        $show->field('deleted_at', __('Deleted at'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TeamUser);

        $form->number('uid', __('Uid'));
        $form->text('name', __('Name'));
        $form->mobile('phone', __('Phone'));
        $form->text('wechet', __('Wechet'));
        $form->text('lon', __('Lon'));
        $form->text('lat', __('Lat'));
        $form->number('tuan_id', __('Tuan id'));
        $form->text('remark', __('Remark'));
        $form->number('status', __('Status'));
        $form->number('is_tuan', __('Is tuan'));

        return $form;
    }
}
