<?php

namespace App\Admin\Controllers\Goods;

use App\Model\Goods;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class GoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\Goods';
    protected $form_info = [];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Goods);

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('desc', __('Desc'));
        $grid->column('type', __('Type'));
        $grid->column('store_id', __('Store id'));
        $grid->column('old_price', __('Old price'));
        $grid->column('new_price', __('New price'));
        $grid->column('basic', __('Basic'));
        $grid->column('sales', __('Sales'));
        $grid->column('disseminate', __('Disseminate'));
        $grid->column('cover', __('Cover'));
        $grid->column('pic', __('Pic'));
        $grid->column('content', __('Content'));
        $grid->column('cover_poster', __('Cover poster'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Goods::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('desc', __('Desc'));
        $show->field('type', __('Type'));
        $show->field('store_id', __('Store id'));
        $show->field('old_price', __('Old price'));
        $show->field('new_price', __('New price'));
        $show->field('basic', __('Basic'));
        $show->field('sales', __('Sales'));
        $show->field('disseminate', __('Disseminate'));
        $show->field('cover', __('Cover'));
        $show->field('pic', __('Pic'));
        $show->field('content', __('Content'));
        $show->field('cover_poster', __('Cover poster'));
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
        $form = new Form(new Goods);

        $form->text('title', __('Title'));
        $form->text('desc', __('Desc'));
        $form->number('type', __('Type'));
        $form->number('store_id', __('Store id'));
        $form->decimal('old_price', __('Old price'));
        $form->decimal('new_price', __('New price'));
        $form->number('basic', __('Basic'));
        $form->number('sales', __('Sales'));
        $form->text('disseminate', __('Disseminate'));
        $form->image('cover', __('Cover'));
        $form->multipleImage('pic', __('Pic'));
        $form->textarea('content', __('Content'));
        $form->text('cover_poster', __('Cover poster'));


        return $form;
    }

    protected function get_form_info($value="")
    {
        $goods_model=new Goods();
        $goodsBase=new GoodsBaseController();
        $goodsBase->setid("id","ID",$value);
        $goodsBase->settext(" title","标题",$value);
        $goodsBase->settextarea("desc","简介",$value);
        $goodsBase->setselect("type","类型",$goods_model->type,$value);
        $goodsBase->set_decima("old_price","原价",$value?$value:0);
        $goodsBase->set_decima("new_price","现价",$value?$value:0);
        $goodsBase->set_number("basic","基础销量",$value?$value:0);
        $goodsBase->set_number("sales","销量",$value?$value:0);
        $goodsBase->settext("disseminate","宣传视频",$value?$value:"");
        $goodsBase->set_imgs("pic","图片",$value?$value:"http://127.0.0.1/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg");
        $goodsBase->set_sku($value);
        $form_info=$goodsBase->getform_info();

        return $form_info;
    }

    public function create(Content $content){


        $show_data["title"]=$this->title();
        $show_data["header"]="创建商品";
        $show_data["breadcrumb"]="";
        $show_data["description"]=$this->description['create'] ?? trans('admin.create');
        $show_data["form_info"]=$this->get_form_info();


        return view("admin::Goods.goods",$show_data);
    }


}

