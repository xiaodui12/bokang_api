<?php

namespace App\Admin\Controllers\System;

use App\Admin\Controllers\BaseControllers;
use App\Model\Words;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\Words';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
       $work= new Words();
        $grid = new Grid($work);

        $grid->model()->OrderBy("sort","desc");

        $status= $work->status;
        $type= $work->type;

        $grid->model()->OrderBy("sort","desc");

        $list_array=[
            array("field"=>"type","title"=>"类型","type"=>"array","array"=>$type),
            array("field"=>"title","title"=>"标题","type"=>"value"),
            array("field"=>"color","title"=>"color","type"=>"value"),
            array("field"=>"icon","title"=>"图标","type"=>"value"),
            array("field"=>"content","title"=>"内容","type"=>"value"),
            array("field"=>"opentype","title"=>"打开方式","type"=>"value"),
            array("field"=>"start_time","title"=>"活动开始时间","type"=>"value"),
            array("field"=>"end_time","title"=>"活动结束时间","type"=>"value"),
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
        $show = new Show(Words::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', __('Type'));
        $show->field('title', __('Title'));
        $show->field('color', __('Color'));
        $show->field('icon', __('Icon'));
        $show->field('content', __('Content'));
        $show->field('opentype', __('Opentype'));
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
        $work= new Words();

        $form = new Form($work);

        $status= $work->status;
        $type= $work->type;




        $list_array=[
            array("field"=>"type","title"=>"类型","type"=>"select","array"=>$type),
            array("field"=>"title","title"=>"标题","type"=>"text"),
            array("field"=>"color","title"=>"color","type"=>"text"),
            array("field"=>"content","title"=>"内容","type"=>"text"),
            array("field"=>"icon","title"=>"图标","type"=>"text"),
            array("field"=>"opentype","title"=>"打开方式","type"=>"text"),
            array("field"=>["start_time","end_time"],"title"=>"活动时间","type"=>"datetimeRange"),
            array("field"=>"sort","title"=>"排序","type"=>"number"),
            array("field"=>"status","title"=>"状态","type"=>"switch","array"=>$status),
        ];

        BaseControllers::set_form($form,$list_array);

        return $form;
    }
}
