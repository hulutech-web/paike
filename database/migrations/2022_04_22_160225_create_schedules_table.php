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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');//课程
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');//老师
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');//教室
            $table->enum('weekday', [1,2,3,4,5,6,7])->comment('星期几');
            $table->date('date')->comment('上课日期');
            $table->datetime('start_time')->comment('开始时间');
            $table->datetime('end_time')->comment('结束时间');
            $table->unique(['classroom_id','start_time','end_time']);//联合唯一索引
            $table->unique(['teacher_id', 'start_time','end_time']);//联合唯一索引
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
        Schema::dropIfExists('schedules');
    }
};
