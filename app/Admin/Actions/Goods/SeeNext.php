<?php

namespace App\Admin\Actions\Goods;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class SeeNext extends RowAction
{

    public $name = '查看下级';

    /**
     * @return string
     */
    public function href()
    {

        $pid=$this->getRow()->id;
        return "/admin/goodsclass?pid=".$pid;
    }



}