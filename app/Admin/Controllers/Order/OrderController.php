<?php

namespace App\Admin\Controllers\Order;

use App\Admin\Controllers\BaseControllers;
use App\Model\Order;
use  Encore\Admin\Widgets\Table;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends AdminController
{
    protected $type=['1' => '拼多多', '3' => '京东',"2"=>"淘宝"];
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);
        $type=$this->type;

        $column_array=[
            array("field"=>"order_no","title"=>"订单号","type"=>"expand","function"=>function ($model) {
                $goods = $model->ordergoods()->get()->map(function ($comment) {
                    return $comment->only(['goods_thumbnail_url','goods_name', 'goods_price',"goods_quantity"]);
                });
                $table=new Table(['商品名', '图片', '商品单价',"商品数量"]);
                $goods_list=$goods->toArray();
                foreach ($goods_list as $key=>$value){
                    $goods_list[$key]["goods_thumbnail_url"]="<img src='".$value["goods_thumbnail_url"]."' style='width:60px;'/>";
                }
                $table->setRows($goods_list);
                return $table;
            }),
            array("field"=>"refresh_time","title"=>"最后刷新时间","type"=>"datetime"),
            array("field"=>"type","title"=>"类型","type"=>"array","array"=>$type),
            array("field"=>"order_amount","title"=>"订单总金额","type"=>"value"),
            array("field"=>"p_id","title"=>"推广位","type"=>"value"),
            array("field"=>"promotion_amount","title"=>"分销总金额","type"=>"value"),
            array("field"=>"order_status_desc","title"=>"订单状态","type"=>"value"),
            array("field"=>"order_create_time","title"=>"创建时间","type"=>"datetime"),
            array("field"=>"order_verify_time","title"=>"确认时间","type"=>"datetime"),

        ];
        BaseControllers::setlist_show($grid,$column_array);

        $grid->filter(function($filter) use($type){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('order_no', '订单号');
            $filter->equal('team_uid', '团长id');
            $filter->in('type', "类型")->multipleSelect($type);
        });


        BaseControllers::set_auth($grid,2);

        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();

            // 去掉编辑
            $actions->disableEdit();
//            // 去掉查看
//            $actions->disableView();
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
        $type=$this->type;
        $show = new Show(Order::findOrFail($id));

        $detail_array=[
            array("field"=>"order_no","title"=>"订单号","type"=>"value"),
            array("field"=>"refresh_time","title"=>"刷新时间","type"=>"datetime"),
            array("field"=>"type","title"=>"类型","type"=>"array","array"=>$type),
            array("field"=>"order_id","title"=>"订单id","type"=>"value"),
            array("field"=>"order_amount","title"=>"订单总金额","type"=>"value"),
            array("field"=>"p_id","title"=>"推广位","type"=>"value"),
            array("field"=>"promotion_rate","title"=>"佣金比例","type"=>"value"),
            array("field"=>"promotion_amount","title"=>"佣金金额","type"=>"value"),
            array("field"=>"order_status_desc","title"=>"订单状态","type"=>"value"),
            array("field"=>"order_create_time","title"=>"创建时间","type"=>"datetime"),
            array("field"=>"order_pay_time","title"=>"订单支付时间","type"=>"datetime"),
            array("field"=>"order_group_success_time","title"=>"订单收货时间","type"=>"datetime"),
            array("field"=>"order_verify_time","title"=>"订单审核时间","type"=>"datetime"),
            array("field"=>"order_modify_at","title"=>"order_modify_at","type"=>"value"),
            array("field"=>"custom_parameters","title"=>"自定义参数","type"=>"value"),
            array("field"=>"cpa_new","title"=>"是否是新用户","type"=>"boolean"),
        ];



        BaseControllers::setdetail($show,$detail_array);

        BaseControllers::set_auth($show,5);

        $model=$show->getModel();

        $team_uid=$model->team_uid;
        $team_price=$model->team_price;
        if(!empty($team_uid)){
            $show->tuanuid('团长收益', function ($tuanuid) use($team_price) {
                $detail_array=[
                    array("field"=>"head","title"=>"头像","type"=>"image"),
                    array("field"=>"nickname","title"=>"昵称","type"=>"value"),
                    array("field"=>"sex","title"=>"性别","type"=>"array","array"=>['0' => '保密', '1' => '男',"2"=>"女"]),
                    array("field"=>"","title"=>"团长可收益","type"=>"use","detail"=>$team_price),
                ];
                BaseControllers::setdetail($tuanuid,$detail_array);
                BaseControllers::set_auth($tuanuid,4);

            });
        }


        $user_id=$model->user_uid;
        $user_price=$model->user_price;
        if(!empty($user_id)) {
            $show->buy_uid('用户收益', function ($tuanuid) use ($user_price) {

                $detail_array=[
                    array("field"=>"head","title"=>"头像","type"=>"image"),
                    array("field"=>"nickname","title"=>"昵称","type"=>"value"),
                    array("field"=>"sex","title"=>"性别","type"=>"array","array"=>['0' => '保密', '1' => '男',"2"=>"女"]),
                    array("field"=>"","title"=>"用户可收益","type"=>"use","detail"=>$user_price),
                ];
                BaseControllers::setdetail($tuanuid,$detail_array);
                BaseControllers::set_auth($tuanuid,4);

            });
        }



        $show->ordergoods("商品",function ($ordergoods){
            $ordergoods->column('goods_thumbnail_url', __('商品图'))->image("",60,60);
            $ordergoods->column('goods_name', __('商品名'));
            $ordergoods->column('goods_price', __('商品单价'));
            $ordergoods->column('goods_quantity', __('商品数量'));
            BaseControllers::set_auth($ordergoods,3);
        });




        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);

        $form->text('order_no', __('Order no'));
        $form->number('refresh_time', __('Refresh time'));
        $form->number('type', __('Type'));
        $form->text('order_id', __('Order id'));
        $form->decimal('order_amount', __('Order amount'));
        $form->text('p_id', __('P id'));
        $form->number('promotion_rate', __('Promotion rate'));
        $form->decimal('promotion_amount', __('Promotion amount'));
        $form->number('order_status', __('Order status'));
        $form->text('order_status_desc', __('Order status desc'));
        $form->number('order_create_time', __('Order create time'));
        $form->number('order_pay_time', __('Order pay time'));
        $form->number('order_group_success_time', __('Order group success time'));
        $form->number('order_verify_time', __('Order verify time'));
        $form->number('order_modify_at', __('Order modify at'));
        $form->text('custom_parameters', __('Custom parameters'));
        $form->number('cpa_new', __('Cpa new'));
        $form->decimal('team_price', __('Team price'));
        $form->decimal('user_price', __('User price'));
        $form->number('team_uid', __('Team uid'));
        $form->number('user_uid', __('User uid'));

        return $form;
    }






}
