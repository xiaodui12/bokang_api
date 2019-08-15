<?php

namespace App\Admin\Controllers\System;

use App\Admin\Actions\Member\SupplierNoPass;
use App\Admin\Actions\Member\SupplierPass;
use App\Admin\Controllers\BaseControllers;
use App\Model\SupplierApply;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SupplierApplyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\SupplierApply';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $supplier=new SupplierApply();
        $grid = new Grid(new SupplierApply);

        $status= $supplier->status;


        $list_array=[
            array("field"=>"id","title"=>"Id","type"=>"text"),
            array("field"=>"applymember.nickname","title"=>"申请人昵称","type"=>"text"),
            array("field"=>"applymember.head","title"=>"申请人头像","type"=>"image"),
            array("field"=>"name","title"=>"申请人姓名","type"=>"text"),
            array("field"=>"phone","title"=>"电话","type"=>"text"),
            array("field"=>"remark","title"=>"备注","type"=>"text"),
            array("field"=>"error_msg","title"=>"失败原因","type"=>"text"),
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>$status),
            array("field"=>"created_at","title"=>"申请时间","type"=>"value")
        ];
        BaseControllers::setlist_show($grid,$list_array);
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();

            // 去掉编辑
            $actions->disableEdit();

            if($actions->row->toArray()["status"]==0){
                $actions->add(new SupplierPass());
                $actions->add(new SupplierNoPass());
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
        $show = new Show(SupplierApply::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uid', __('Uid'));
        $show->field('name', __('Name'));
        $show->field('phone', __('Phone'));
        $show->field('remark', __('Remark'));
        $show->field('status', __('Status'));
        $show->field('error_msg', __('Error msg'));
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
        $form = new Form(new SupplierApply);

        $form->number('uid', __('Uid'));
        $form->text('name', __('Name'));
        $form->mobile('phone', __('Phone'));
        $form->text('remark', __('Remark'));
        $form->switch('status', __('Status'));
        $form->text('error_msg', __('Error msg'));

        return $form;
    }
}
