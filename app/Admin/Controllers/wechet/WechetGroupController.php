<?php

namespace App\Admin\Controllers\wechet;

use App\Admin\Controllers\BaseControllers;
use App\Model\WechetGroup;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class WechetGroupController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\WechetGroup';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WechetGroup);
        $grid->model()->OrderBy("created_at","desc");
        $grid->column('id', __('Id'));
        $grid->column('title', '群组名')->modal('最新评论', function ($model) {

            $comments = $model->teamuid()->where("status",1)->OrderBy("is_tuan","desc")->get()->map(function ($comment) {
                return $comment->only(['id', 'name', 'phone',"created_at","is_tuan"]);
            });

            return new Table(['ID', '姓名', '手机号', '创建时间', '是否是团长'], $comments->toArray());
        });
        $grid->column('address', __('群组地址'));
        $grid->column('status', __('状态'));
        $grid->column('updated_at', __('更新时间'));
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
        $show = new Show(WechetGroup::findOrFail($id));
        $show->field('id', __('Id'));
        $show->field('title', __('群组名'));
        $show->field('address', __('群组地址'));
        $show->field('status', __('状态'));
        $show->field('updated_at', __('更新时间'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WechetGroup);

        $form->text('title', __('群组名'));
        $form->text('address', __('地址'));
        $form->map("lat", "lon", __('坐标'));
        $form->switch("status",  __('状态'));

        return $form;
    }
}
