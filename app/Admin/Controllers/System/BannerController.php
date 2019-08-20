<?php

namespace App\Admin\Controllers\System;

use App\Admin\Controllers\BaseControllers;
use App\Model\Banner;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BannerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\Banner';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $banner=new Banner();
        $grid = new Grid($banner);

        $status= $banner->status;
        $turn_type= $banner->turn_type;

        $grid->model()->OrderBy("sort","desc");

        $list_array=[
            array("field"=>"title","title"=>"标题","type"=>"value"),
            array("field"=>"desc","title"=>"简介","type"=>"value"),
            array("field"=>"icon","title"=>"图片","type"=>"image"),
            array("field"=>"start_time","title"=>"活动开始时间","type"=>"value"),
            array("field"=>"end_time","title"=>"活动结束时间","type"=>"value"),
            array("field"=>"turn_type","title"=>"跳转类型","type"=>"array","array"=>$turn_type),
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>$status),
            array("field"=>"sort","title"=>"排序","type"=>"value"),
            array("field"=>"created_at","title"=>"创建时间","type"=>"value")
        ];
        BaseControllers::setlist_show($grid,$list_array);
        $grid->actions(function ($actions) {

//            // 去掉查看
            $actions->disableView();
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
        $show = new Show(Banner::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('desc', __('Desc'));
        $show->field('icon', __('Icon'));
        $show->field('turn_type', __('Turn type'));
        $show->field('status', __('Status'));
        $show->field('sort', __('Sort'));
        $show->field('start_time', __('Start time'));
        $show->field('end_time', __('End time'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $banner=new Banner();
        $form = new Form($banner);


        $status= $banner->status;
        $turn_type= $banner->turn_type;
        $type_array= $banner->type_array;


        $list_array=[
            array("field"=>"title","title"=>"标题","type"=>"text"),
            array("field"=>"desc","title"=>"简介","type"=>"text"),
            array("field"=>"icon","title"=>"图片","type"=>"image"),
            array("field"=>["start_time","end_time"],"title"=>"活动时间","type"=>"datetimeRange"),
            array("field"=>"turn_type","title"=>"跳转类型","type"=>"select","array"=>$turn_type),
            array("field"=>"sort","title"=>"排序","type"=>"number"),
            array("field"=>"type","title"=>"类型","type"=>"select","array"=>$type_array),
            array("field"=>"status","title"=>"状态","type"=>"switch","array"=>$status),
            array("field"=>"created_at","title"=>"创建时间","type"=>"value")
        ];



        BaseControllers::set_form($form,$list_array);


        return $form;
    }
}
