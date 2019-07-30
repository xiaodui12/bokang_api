<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Adv extends Model
{
    protected $table = 'bokang_adv';
    public $type=["首页"];
    public $platform=array("1"=>"拼多多","2"=>"淘宝");
    public $status=array("1"=>"启用","0"=>"禁用");
}
