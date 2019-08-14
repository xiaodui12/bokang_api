<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bokang_words', function (Blueprint $table) {
            $table->increments('id');
            $table->string("type")->comment("类型");
            $table->string("title")->comment("标题");
            $table->string("color",30)->comment("颜色")->nullable();
            $table->string("icon",30)->comment("图标")->nullable();
            $table->string("content",255)->comment("介绍")->nullable();
            $table->string("opentype",30)->comment("打开方式")->nullable();
            $table->dateTime("start_time")->comment("开始时间");
            $table->dateTime("end_time")->comment("结束时间");
            $table->tinyInteger("sort")->comment("排序")->default(0)->nullable();
            $table->tinyInteger("status")->comment("状态")->default(1)->nullable();
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
        Schema::dropIfExists('words');
    }
}
