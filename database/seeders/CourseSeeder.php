<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $arr = [
            '电子技术',
            '离散数学',
            '程序设计',
            '数据结构',
            '操作系统',
            '计算机组成原理',
            '微机系统',
            '计算机系统结构',
            '编译原理',
            '计算机网络',
            '数据库系统',
            '软件工程',
            '人工智能',
            '计算机图形学',
            '数字图像处理',
            '计算机通讯原理',
            '多媒体信息处理技术',
            '数字信号处理',
            '计算机控制',
            '网络计算',
            '算法设计与分析',
            '信息安全',
            '应用密码学基础',
            '信息对抗',
            '移动计算',
            '数论与有限域基础',
            '人机界面设计',
            '面向对象程序设计',
            'C语言',
            '数据结构',
            '离散数学',
            '数据库',
            '编译原理',
            '操作系统',
            '计算机组成原理',
            '计算机网络',
        ];
        Course::factory(36)->create()->each(function ($course, $key) use ($arr) {
            $course->title = $arr[$key];
            $course->save();
        });
    }
}
