<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/23
 * Time: 8:45
 */

namespace App\Http\Controllers;


class IndexControllers extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
//        echo 123456;
        return view("master");
    }
}