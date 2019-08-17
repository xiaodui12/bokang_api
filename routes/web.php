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
Route::get('/getuserinfo',  'IndexControllers@getuser_info');//仅在网页端使用



/**--------   公共接口 (开始) --------------*/

Route::post('/xcxlogin',  'Base\LoginControllers@xcx_login');//小程序登陆 参数（code:登录code（必传），parent_code：分享人编码）
Route::post('/setuserinfo',  'Base\LoginControllers@setuserinfo');//设置用户信息参数
Route::post('/getadv',  'Base\AdvControllers@getadv');//


/**--------   公共接口 （结束） --------------*/


/****---------拼多多接口（开始）---------------------**/

Route::post('/pdd/getclass',  'Pdd\IndexControllers@get_class');
Route::post('/pdd/config',  'Pdd\IndexControllers@get_config');
Route::get('/pdd/getscene',  'Pdd\IndexControllers@get_scene');


//拼多多拉取订单数据
Route::get('/pdd/refresh/order',  'Pdd\RefreshControllers@order_get');


//淘宝拉取订单数据
Route::get('/taobao/refresh/order',  'Taobao\RefreshControllers@order_get');
Route::get('/taobao/getutil',  'Taobao\IndexControllers@getsend');


/****---------拼多多接口（结束）---------------------**/



/**--------   订单接口  --------------*/


Route::post('/order/getlist',  'Order\IndexControllers@order_list');
Route::post('/order/getdetail',  'Order\IndexControllers@order_detail');
Route::post('/order/getdetailtuan',  'Order\IndexControllers@order_detail_by_tuan');//根据团长得到订单信息

Route::get('/order/getshareimg',  'Web\IndexControllers@get_order_img');//根据团长得到订单信息

Route::post('/order/checkconfirm',  'Order\IndexControllers@order_detail_confirm');//根据团长得到订单信息

/**--------   订单接口  --------------*/


/**--------   团长接口  --------------*/


Route::post('/tuan/apply',  'Tuan\IndexControllers@apply');
Route::post('/tuan/getapply',  'Tuan\IndexControllers@apply_status');



/**--------   团长接口  --------------*/


Route::post('/member/supplier',  'Member\SupplierControllers@supplierApply');
Route::post('/member/checksupplier',  'Member\SupplierControllers@checkApply');





/**--------   前端接口  --------------*/

Route::get('/getopenid',  'Web\IndexControllers@index');


Route::get('/getbanner',  'Base\SystemControllers@getBanner');
Route::get('/getword',  'Base\SystemControllers@getWord');
Route::get('/getsearch',  'Base\SystemControllers@getSearch');
