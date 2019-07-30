<?php

namespace App\Admin\Actions\Member;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class SeeOrder extends RowAction
{
    public $name = '查看分享订单';

    /**
     * @return string
     */
    public function href()
    {
        $uid=$this->getRow()->uid;
        return "/admin/orders?team_uid=".$uid;
    }

}