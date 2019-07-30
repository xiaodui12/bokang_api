<?php

namespace App\Admin\Actions\Member;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class SeeUser extends RowAction
{
    public $name = '查看用户';
    /**
     * @return string
     */
    public function href()
    {
        $uid=$this->getRow()->uid;
        return "/admin/members/".$uid;
    }
}