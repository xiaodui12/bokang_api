<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('users', UserController::class);
    $router->resource('members', Member\MemberController::class);
    $router->resource('orders', Order\OrderController::class);
    $router->resource('systems', Base\SystemController::class);
    $router->resource('mp-configs', Base\MpController::class);
    $router->resource('team-applies', Member\TeamApplyController::class);
    $router->resource('teams', Member\TeamController::class);
    $router->resource('advs', Base\AdvController::class);
    $router->resource('goods', Goods\GoodsController::class);
    $router->resource('goodsclass', Goods\GoodsClassController::class);
    $router->resource('words', System\WordController::class);
    $router->resource('banners', System\BannerController::class);
    $router->resource('search', System\SearchController::class);
    $router->resource('supplierapply', System\SupplierApplyController::class);



    $router->post('goodscreate', "Goods\GoodsInfoController@create");








});

