<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name',30)->comment('教师名称');
            $table->json('course')->nullable()->comment('所教课程');
            $table->integer('age')->nullable()->comment('年龄');
            $table->text('introduce')->nullable()->comment('简介');
            $table->string('politics_status')->nullable()->comment('政治面貌');
            $table->text('experience')->nullable()->comment('工作经验');
            //文化程度
            $table->string('degree')->nullable()->comment('文化程度');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('SET NULL');
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
        Schema::dropIfExists('teachers');
    }
};
