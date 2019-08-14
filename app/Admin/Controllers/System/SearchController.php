<?php

namespace App\Admin\Controllers\System;

use App\Admin\Controllers\BaseControllers;
use App\Model\HotSearch;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SearchController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\HotSearch';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $hot=new HotSearch();
        $grid = new Grid(new HotSearch);



        $status= $hot->status;


        $list_array=[
            array("field"=>"id","title"=>"Id","type"=>"text"),
            array("field"=>"title","title"=>"标题","type"=>"text"),
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>$status),
            array("field"=>"updated_at","title"=>"更新时间","type"=>"value")
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
        $show = new Show(HotSearch::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('status', __('Status'));
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
        $form = new Form(new HotSearch);

        $form->text('title', __('标题'));
        $form->switch('status', __('Status'))->default(1);
        return $form;
    }
}
