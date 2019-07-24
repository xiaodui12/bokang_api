<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 8:53
 */

namespace App\Http\Controllers\Web;



class IndexControllers extends WebControllers
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        echo 111;
    }
}