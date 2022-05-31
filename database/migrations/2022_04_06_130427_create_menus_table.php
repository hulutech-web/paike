<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('pid')->default(0)->nullable();
            $table->string('path')->comment('路径');
            $table->string('name')->comment('名称');
            $table->string('title')->comment('标题');
            $table->string('icon')->comment('图标');
            $table->string('redirect')->default('notfound')->comment('重定向');
            $table->string('hidden')->default('false')->comment('隐藏');
            $table->string('always_show')->default('true')->comment('总是显示');
            $table->string('rank')->comment('排序');
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
        Schema::dropIfExists('menus');
    }
};
