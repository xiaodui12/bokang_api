<?php

namespace App\Admin\Controllers\Our;

use App\Admin\Actions\Our\setPay;
use App\Admin\Actions\Our\setSend;
use App\Admin\Controllers\BaseControllers;
use App\Model\OurOrder;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class OurOrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\OurOrder';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $model=new OurOrder();
        $grid = new Grid($model);


        $column_array=[
            array("field"=>"order_no","title"=>"订单号","type"=>"expand","function"=>function ($model) {
                $goods = $model->ourgoods()->get()->map(function ($comment) {
                    return $comment->only(['goods_cover','goods_title', 'goods_price',"goods_quantity"]);
                });
                $table=new Table(['图片', '商品名', '商品单价',"商品数量"]);
                $goods_list=$goods->toArray();

                foreach ($goods_list as $key=>$value){
                    $goods_list[$key]["goods_cover"]="<img src='".$value["goods_cover"]."' style='width:60px;'/>";
                }
                $table->setRows($goods_list);

                $address = $model->ouraddress()->get()->map(function ($comment) {
                    return $comment->only(['name','mobile', 'province',"city","area","zip"]);
                });
                $table1=new Table(['收货人', '手机号', '省',"市","区","邮编"]);
                $address_list=$address->toArray();
                $table1->setRows($address_list);

                return $table.$table1;
            }),
            array("field"=>"type","title"=>"类型","type"=>"array","array"=>$model->type),
            array("field"=>"order_amount","title"=>"订单总金额","type"=>"value"),
            array("field"=>"order_status","title"=>"订单状态","type"=>"array","array"=>$model->status),
            array("field"=>"logistics_no","title"=>"物流单号","type"=>"value"),
        ];

        BaseControllers::setlist_show($grid,$column_array);

        BaseControllers::set_auth($grid,2);

        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();

            // 去掉编辑
            $actions->disableEdit();
//            // 去掉查看
//            $actions->disableView();
            if($actions->row->order_status==0){
                $actions->add(new setPay());
            }
            if($actions->row->order_status==1){
                $actions->add(new setSend());
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
        $show = new Show(OurOrder::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('order_no', __('Order no'));
        $show->field('type', __('Type'));
        $show->field('order_amount', __('Order amount'));
        $show->field('share_id', __('Share id'));
        $show->field('user_uid', __('User uid'));
        $show->field('promotion_amount', __('Promotion amount'));
        $show->field('order_status', __('Order status'));
        $show->field('order_pay_time', __('Order pay time'));
        $show->field('logistics', __('Logistics'));
        $show->field('logistics_no', __('Logistics no'));
        $show->field('share_status', __('Share status'));
        $show->field('updated_at', __('Updated at'));
        $show->field('created_at', __('Created at'));
        $show->field('receive_at', __('Receive at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new OurOrder);

        $form->text('order_no', __('Order no'));
        $form->number('type', __('Type'));
        $form->decimal('order_amount', __('Order amount'));
        $form->number('share_id', __('Share id'));
        $form->number('user_uid', __('User uid'));
        $form->decimal('promotion_amount', __('Promotion amount'));
        $form->number('order_status', __('Order status'));
        $form->datetime('order_pay_time', __('Order pay time'))->default(date('Y-m-d H:i:s'));
        $form->text('logistics', __('Logistics'));
        $form->text('logistics_no', __('Logistics no'));
        $form->number('share_status', __('Share status'));
        $form->datetime('receive_at', __('Receive at'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
