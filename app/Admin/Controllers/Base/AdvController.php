<?php

namespace App\Admin\Controllers\Base;

use App\Admin\Controllers\BaseControllers;
use App\Model\Adv;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AdvController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\Adv';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $Adv=new Adv();
        $grid = new Grid($Adv);

        $platform= $Adv->platform;
        $type= $Adv->type;
        $status= $Adv->status;

        $list_array=[
            array("field"=>"title","title"=>"标题","type"=>"value"),
            array("field"=>"platform","title"=>"平台","type"=>"array","array"=>$platform),
            array("field"=>"type","title"=>"类型","type"=>"array","array"=>$type),
            array("field"=>"image","title"=>"图片","type"=>"image"),
            array("field"=>"start_time","title"=>"活动开始时间","type"=>"value"),
            array("field"=>"end_time","title"=>"活动结束时间","type"=>"value"),
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>$status),
            array("field"=>"created_at","title"=>"创建时间","type"=>"value")
        ];
        BaseControllers::setlist_show($grid,$list_array);

        $grid->filter(function($filter) use($platform,$type){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->in('platform', "平台")->multipleSelect($platform);
            $filter->in('type', "类型")->multipleSelect($type);
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
        $show = new Show(Adv::findOrFail($id));
        $Adv=new Adv();
        $platform= $Adv->platform;
        $type= $Adv->type;
        $status= $Adv->status;
        $list_array=[
            array("field"=>"title","title"=>"标题","type"=>"value"),
            array("field"=>"platform","title"=>"平台","type"=>"array","array"=>$platform),
            array("field"=>"type","title"=>"类型","type"=>"array","array"=>$type),
            array("field"=>"image","title"=>"图片","type"=>"image"),
            array("field"=>"start_time","title"=>"活动开始时间","type"=>"value"),
            array("field"=>"end_time","title"=>"活动结束时间","type"=>"value"),
            array("field"=>"font1","title"=>"字段1","type"=>"value"),
            array("field"=>"font2","title"=>"字段2","type"=>"value"),
            array("field"=>"font3","title"=>"字段3","type"=>"value"),
            array("field"=>"font4","title"=>"字段4","type"=>"value"),
            array("field"=>"font5","title"=>"字段5","type"=>"value"),
            array("field"=>"status","title"=>"状态","type"=>"array","array"=>$status),
            array("field"=>"created_at","title"=>"创建时间","type"=>"value")
        ];
        BaseControllers::setdetail($show,$list_array);

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $Adv=new Adv();
        $form = new Form($Adv);
        $platform= $Adv->platform;
        $type= $Adv->type;
        $status= $Adv->status;
        $list_array=[
            array("field"=>"title","title"=>"标题","type"=>"text"),
            array("field"=>"platform","title"=>"平台","type"=>"select","array"=>$platform),
            array("field"=>"type","title"=>"类型","type"=>"select","array"=>$type),
            array("field"=>"image","title"=>"图片","type"=>"image"),
            array("field"=>["start_time","end_time"],"title"=>"活动时间","type"=>"datetimeRange"),
            array("field"=>"font1","title"=>"字段1","type"=>"text"),
            array("field"=>"font2","title"=>"字段2","type"=>"text"),
            array("field"=>"font3","title"=>"字段3","type"=>"text"),
            array("field"=>"font4","title"=>"字段4","type"=>"text"),
            array("field"=>"font5","title"=>"字段5","type"=>"text"),
            array("field"=>"status","title"=>"状态","type"=>"switch","array"=>$status),
            array("field"=>"created_at","title"=>"创建时间","type"=>"value")
        ];
        BaseControllers::set_form($form,$list_array);
        return $form;
    }
}
