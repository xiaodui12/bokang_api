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



Route::get('/jd/getutil',  'Jd\IndexControllers@getsend');


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

Route::post('/tuan/gettuanlist',  'Tuan\IndexControllers@tuanList');
Route::post('/tuan/userteam',  'Tuan\IndexControllers@userTeam');

Route::post('/tuan/joinapply',  'Tuan\IndexControllers@joinApply');




/**--------   团长接口  --------------*/


Route::post('/member/supplier',  'Member\SupplierControllers@supplierApply');
Route::post('/member/checksupplier',  'Member\SupplierControllers@checkApply');





/**--------   前端接口  --------------*/

Route::get('/getopenid',  'Web\IndexControllers@index');


Route::get('/getbanner',  'Base\SystemControllers@getBanner');
Route::get('/getword',  'Base\SystemControllers@getWord');
Route::get('/getsearch',  'Base\SystemControllers@getSearch');



Route::post('/getgoods',  'Goods\IndexControllers@get_list');
Route::post('/getgoodsclass',  'Goods\IndexControllers@getClass');
Route::post('/getgoodsdetail',  'Goods\IndexControllers@getDetail');



Route::post('/douyin/login',  'Douyin\LoginControllers@xcx_login');
Route::post('/douyin/setuserinfo',  'Douyin\LoginControllers@setuserinfo');



Route::post('/address/getlist',  'Base\AddressControllers@getList');
Route::post('/address/getdetail',  'Base\AddressControllers@getDetail');
Route::post('/address/savedetail',  'Base\AddressControllers@saveDetail');

Route::post('/address/getdefault',  'Base\AddressControllers@getDefault');
Route::post('/address/setdefault',  'Base\AddressControllers@setDefault');

Route::post('/address/delete',  'Base\AddressControllers@delete');


Route::post('/Order/our/getadd',  'Order\OurControllers@getAddOrder');


Route::post('/Order/our/addorder',  'Order\OurControllers@addSubmit');


Route::post('/cart/getlist',  'Douyin\CartControllers@getList');
Route::post('/cart/setdetail',  'Douyin\CartControllers@setDetail');
Route::post('/cart/setnumber',  'Douyin\CartControllers@setNumber');
Route::post('/cart/del',  'Douyin\CartControllers@delCart');



Route::post('/Order/douyin/pay',  'Order\OurControllers@pay');
Route::post('/Order/wechet/pay',  'Order\OurControllers@wechetPay');
Route::get('/Order/wechet/pay',  'Order\OurControllers@wechetPay');

Route::post('/Order/our/getlist',  'Order\OurControllers@getOrderList');
Route::post('/Order/our/getdetail',  'Order\OurControllers@getOrderDetail');
Route::post('/Order/our/setreceive',  'Order\OurControllers@setReceiving');
Route::post('/Order/our/getlogistics',  'Order\OurControllers@getLogistics');
Route::post('/ourback',  'Order\OurBackControllers@aliback');
Route::post('/ourwechetback',  'Order\OurBackControllers@wechetback');





