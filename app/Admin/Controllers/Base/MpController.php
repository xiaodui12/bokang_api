<?php

namespace App\Admin\Controllers\Base;

use App\Admin\Controllers\BaseControllers;
use App\Model\MpConfig;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MpController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\MpConfig';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MpConfig);


        $info_array=[
            array("field"=>"id","title"=>"id","type"=>"value"),
            array("field"=>"appid","title"=>"公众号Appid","type"=>"value"),
            array("field"=>"appsecret","title"=>"公众号Appsecret","type"=>"value"),
            array("field"=>"mchid","title"=>"商户号Mchid","type"=>"value"),
            array("field"=>"mchkey","title"=>"商户号Mchkey","type"=>"value"),
            array("field"=>"updated_at","title"=>"更新时间","type"=>"value"),
        ];

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('appid', '公众号Appid');

        });

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
        $show = new Show(MpConfig::findOrFail($id));


        $show_array=[
            array("field"=>"id","title"=>"id","type"=>"value"),
            array("field"=>"appid","title"=>"公众号Appid","type"=>"value"),
            array("field"=>"appsecret","title"=>"公众号Appsecret","type"=>"value"),
            array("field"=>"mchid","title"=>"商户号Mchid","type"=>"value"),
            array("field"=>"mchkey","title"=>"商户号Mchkey","type"=>"value"),
            array("field"=>"updated_at","title"=>"更新时间","type"=>"value"),
        ];
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
        $form = new Form(new MpConfig);
        $edit_array=[
            array("field"=>"id","title"=>"id","type"=>"display"),
            array("field"=>"appid","title"=>"公众号Appid","type"=>"text"),
            array("field"=>"appsecret","title"=>"公众号Appsecret","type"=>"text"),
            array("field"=>"mchid","title"=>"商户号Mchid","type"=>"text"),
            array("field"=>"mchkey","title"=>"商户号Mchkey","type"=>"text"),
        ];
        BaseControllers::set_form($form,$edit_array);
        return $form;
    }
}
