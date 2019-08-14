<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bokang_supplier_apply', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->comment("用户id");
            $table->string('name')->comment("姓名");
            $table->string('phone',20)->comment("手机号");
            $table->string('remark',255)->comment("备注")->nullable();
            $table->tinyInteger('status')->comment("状态");
            $table->string('error_msg',255)->comment("失败原因")->nullable();
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
        Schema::dropIfExists('supplier_applies');
    }
}
