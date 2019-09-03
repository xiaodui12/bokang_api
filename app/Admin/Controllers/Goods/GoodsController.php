<?php

namespace App\Admin\Controllers\Goods;

use App\Admin\Controllers\BaseControllers;
use App\Model\Goods;
use App\Model\GoodsClass;
use App\Model\GoodsSku;
use Encore\Admin\Actions\Response;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class GoodsController extends AdminController
{
    protected $request;
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


        $info_array=[
            array("field"=>"id","title"=>"id","type"=>"value"),//展示昵称
            array("field"=>"title","title"=>"标题","type"=>"value"),//展示昵称
            array("field"=>"desc","title"=>"简介","type"=>"value"),//展示真实姓名
            array("field"=>"old_price","title"=>"原价","type"=>"value"),//展示真实姓名
            array("field"=>"new_price","title"=>"现价","type"=>"value"),//展示真实姓名
            array("field"=>"cover","title"=>"封面图","type"=>"image"),//展示图片
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


        return $form;
    }

    protected function get_form_info($value="")
    {


        $goods_class=new GoodsClass();
        $goodsClass=$goods_class->getList();

        $goods_model=new Goods();
        $goodsBase=new GoodsBaseController();
        $goodsBase->setid("id","ID",$value);
        $goodsBase->settext("title","标题",$value);
        $goodsBase->setselect("category_id","分类",$goodsClass,$value);
        $goodsBase->settextarea("desc","简介",$value);
        $goodsBase->setselect("type","类型",$goods_model->type,$value);
        $goodsBase->set_decima("old_price","原价",$value?$value:0);
        $goodsBase->set_decima("new_price","现价",$value?$value:0);
        $goodsBase->set_number("basic","基础销量",$value?$value:0);
        $goodsBase->set_number("sales","销量",$value?$value:0);
        $goodsBase->settext("disseminate","宣传视频",$value?$value:"");
        $goodsBase->set_number("sku_number","库存",["sku_number"=>$value["sku"]]);
        $goodsBase->set_imgs("pic","图片",$value?$value:"/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg");

        $goodsBase->set_sku($value);
        $goodsBase->set_uedit("content","内容",$value?$value:"");

        $form_info=$goodsBase->getform_info();


        return $form_info;
    }

    public function create(Content $content){

        $show_data["title"]=$this->title();
        $show_data["header"]="创建商品";
        $show_data["breadcrumb"]="";
        $show_data["description"]=$this->description['create'] ?? trans('admin.create');
        $show_data["form_info"]=$this->get_form_info("");
        $show_data["detail"]=[];

        return view("admin::Goods.goods",$show_data);
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $detail=Goods::where("id",$id)->first()->toarray();
        $show_data["title"]=$this->title();
        $show_data["header"]="创建商品";
        $show_data["breadcrumb"]="";
        $show_data["description"]=$this->description['create'] ?? trans('admin.create');
        $show_data["form_info"]=$this->get_form_info($detail);
        $show_data["detail"]=$detail;
        $show_data["sku"]=json_encode(GoodsSku::getlist($id));


        return view("admin::Goods.goods",$show_data);
    }

    public function render(Request $request){

        $this->request=$request;
    }


    public function store()
    {
        $request=new Request();
        var_dump($request->post());
    }


}

