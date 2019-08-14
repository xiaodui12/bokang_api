<?php

namespace App\Admin\Controllers\Base;

use App\Admin\Controllers\BaseControllers;
use App\Model\System;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SystemController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\System';


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new System);

        $info_array=[
            array("field"=>"key","title"=>"键值名","type"=>"value"),
            array("field"=>"title","title"=>"标题","type"=>"value"),
            array("field"=>"value","title"=>"内容","type"=>"value"),
            array("field"=>"desc","title"=>"简介","type"=>"value"),
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>array(0=>"禁用",1=>"启用")),
            array("field"=>"updated_at","title"=>"更新时间","type"=>"value"),
        ];
        BaseControllers::setlist_show($grid,$info_array);//拼接列表展示数据
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
        $show = new Show(System::findOrFail($id));


        $show_array=[
            array("field"=>"key","title"=>"键值名","type"=>"value"),
            array("field"=>"title","title"=>"标题","type"=>"value"),
            array("field"=>"value","title"=>"内容","type"=>"value"),
            array("field"=>"desc","title"=>"简介","type"=>"value"),
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>array(0=>"禁用",1=>"启用")),
            array("field"=>"updated_at","title"=>"更新时间","type"=>"value"),
        ];
        //展示数据
        BaseControllers::setdetail($show,$show_array);



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new System);

        $edit_array=[
            array("field"=>"id","title"=>"ID","type"=>"display"),
            array("field"=>"key","title"=>"键值名","type"=>"text"),
            array("field"=>"title","title"=>"标题","type"=>"text"),
            array("field"=>"value","title"=>"内容","type"=>"text"),
            array("field"=>"desc","title"=>"简介","type"=>"textarea"),
            array("field"=>"status","title"=>"状态","type"=>"switch"),
        ];
        BaseControllers::set_form($form,$edit_array);



        return $form;
    }
}
