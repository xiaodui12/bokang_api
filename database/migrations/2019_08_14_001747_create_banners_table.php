<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bokang_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title")->comment("标题");
            $table->string("desc")->comment("简介")->nullable();
            $table->string("icon")->comment("图标")->nullable();
            $table->tinyInteger("turn_type")->comment("跳转类型")->nullable();
            $table->tinyInteger("status")->comment("状态")->default(1)->nullable();
            $table->tinyInteger("sort")->comment("排序")->nullable();
            $table->dateTime("start_time")->comment("开始时间");
            $table->dateTime("end_time")->comment("结束时间");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
