<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//
////    return view('welcome');
//});

Route::get('/',  'IndexControllers@index');
Route::get('/init',  'IndexControllers@index');




/**--------   公共接口 (开始) --------------*/

Route::post('/xcxlogin',  'Base\LoginControllers@xcx_login');//小程序登陆 参数（code:登录code（必传），parent_code：分享人编码）
Route::post('/setuserinfo',  'Base\LoginControllers@setuserinfo');//设置用户信息参数

/**--------   公共接口 （结束） --------------*/


/****---------拼多多接口（开始）---------------------**/

Route::post('/pdd/getclass',  'Pdd\IndexControllers@get_class');
Route::post('/pdd/config',  'Pdd\IndexControllers@get_config');


//拼多多拉取订单数据
Route::get('/pdd/refresh/order',  'Pdd\RefreshControllers@order_get');


/****---------拼多多接口（结束）---------------------**/







/**--------   前端接口  --------------*/


Route::get('/getopenid',  'Web\IndexControllers@index');
