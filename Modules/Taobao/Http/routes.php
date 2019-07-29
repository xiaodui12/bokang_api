<?php

Route::group(['middleware' => 'web', 'prefix' => 'taobao', 'namespace' => 'Modules\Taobao\Http\Controllers'], function()
{
    Route::get('/', 'TaobaoController@index');
});
