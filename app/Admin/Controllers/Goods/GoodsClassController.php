<?php

namespace App\Admin\Controllers\Goods;

use App\Admin\Actions\Goods\SeeNext;
use App\Admin\Controllers\BaseControllers;
use App\Model\GoodsClass;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Input;

class GoodsClassController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\GoodsClass';



    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {

        return $content
            ->title($this->title())
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GoodsClass);
        $pid=Input::get("pid",null);
        $grid->model()->where("pid",$pid);
        $info_array=[
            array("field"=>"id","title"=>"id","type"=>"value"),//展示昵称
            array("field"=>"parent.title","title"=>"上级","type"=>"default","default"=>"顶级"),//展示昵称
            array("field"=>"title","title"=>"标题","type"=>"value"),//展示昵称
            array("field"=>"desc","title"=>"简介","type"=>"value"),//展示真实姓名
            array("field"=>"icon","title"=>"图标","type"=>"image"),//展示图片
            array("field"=>"updated_at","title"=>"更新时间","type"=>"value"),
        ];
        BaseControllers::setlist_show($grid,$info_array);//拼接列表展示数据

        $grid->actions(function ($actions) use($pid) {

            if(empty($pid)){
                $actions->add(new SeeNext());
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
        $show = new Show(GoodsClass::findOrFail($id));


        //展示数据类型
        $show_array=[
            array("field"=>"id","title"=>"Id","type"=>"value"),
            array("field"=>"title","title"=>"标题","type"=>"value"),
            array("field"=>"desc","title"=>"简介","type"=>"value"),
            array("field"=>"icon","title"=>"图标","type"=>"image"),
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
    protected function form($id="")
    {

        $form = new Form(new GoodsClass);

        $edit_array=[
            array("field"=>"title","title"=>"标题","type"=>"text"),
            array("field"=>"desc","title"=>"简介","type"=>"text"),
            array("field"=>"icon","title"=>"图标","type"=>"image"),
            array("field"=>"pid","title"=>"上级","type"=>"select","array"=>GoodsClass::getselect(0,$id)),
        ];
        BaseControllers::set_form($form,$edit_array);
        return $form;
    }
    /**
     * Edit interface.
     * 重写
     */
    public function edit($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->form($id)->edit($id));
    }
}
